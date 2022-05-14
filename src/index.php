<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>TimeSheet</h2>
<?php
    require_once('BDD.php');

    $mydb=new BDD();
    $mydb->getDB();
    $mydb->getTasks();
    echo "<br>";
    $mydb->getDates();
    echo "<div class='save'>";
    $mydb->addButtonSave();
    $mydb->loadSave();
    echo "</div>";

    $mydb->showCalendar(2022);
    
?>

</body>
</html>
<style>

</style>