FROM php:8.0-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /

RUN if [ ! -d app ];then mkdir app;fi

#VOLUME ./src /app
WORKDIR /app

RUN apt-get update -qq && \
    apt-get install -qy \
    git \
    gnupg \
    unzip \
    zip && \ 
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
	apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
COPY conf/php.ini /usr/local/etc/php/conf.d/app.ini

# Apache
COPY errors /errors
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY conf/apache.conf /etc/apache2/conf-available/z-app.conf

RUN a2enmod rewrite remoteip && \
    a2enconf z-app

RUN chown -R www-data /app
RUN chmod -R ugo+rwx /app
