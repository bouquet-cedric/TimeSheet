<?php
    require_once('BDD.php');
    if (isset($_POST['deleteTask']) && isset($_POST['id'])){
        if ($_POST['deleteTask']!="" && $_POST['id']!=""){
            $db=new BDD();
            $db->deleteTask($_POST['id']);
        }
    }
    header('Location: index.php');
?>