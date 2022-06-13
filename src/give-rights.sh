echo "Gestion des droits"
echo -n "Propriétaire du dossier timesheet: "
chown -R www-data /app/timesheet
echo "www-data"
echo -en "\nPropriétaire de la base de données: "
chown -R www-data /app/timesheet/database.sqlite
echo "www-data"
echo "Attribution des droits d'écriture, de lecture et d'exécution: "
echo -en "\t/app: "
chmod -R ugo+rwx /app
echo "done"
echo -en "\t/app/timesheet: "
chmod -R ugo+rwx /app/timesheet
echo "done"
echo -en "\t/app/timesheet/database.sqlite: "
chmod -R ugo+rwx /app/timesheet/database.sqlite
echo "done"