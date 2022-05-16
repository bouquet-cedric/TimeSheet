#!/bin/bash

# docker rm $(docker ps -aq -f "name=timesheet")
docker build -t php-apache2 .
docker run --name time-sheet -it --rm -v "$(pwd)/src:/app/timesheet"  -p 15000:80 php-apache2
