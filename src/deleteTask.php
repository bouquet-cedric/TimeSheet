<?php
    require_once('BDD.php');
    if (isset($_POST['deleteTask']) && isset($_POST['id'])){
        if ($_POST['deleteTask']!="" && $_POST['id']!=""){
            $db=new BDD();
            $db->deleteTask($_POST['id']);
        }
    }
    else {
        die();
    }
    $redirect='index.php';
    if (isset($_POST['redirect'])) $redirect=$_POST['redirect'];
    header('Location: '.$redirect);
?>