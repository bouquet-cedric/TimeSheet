<?php
    require_once('BDD.php');
    if (isset($_POST['loadSave'])){
        $db=new BDD();
        $db->reinitDatabase();
        $db->getDB();
        $db->createTasks();
        $db->loadSinceSave();
        header('Location: index.php');
        }
?>