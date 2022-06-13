<?php
    require_once('BDD.php');
    if (isset($_POST['addTask']) && isset($_POST['jira']) && isset($_POST['date']) && isset($_POST['time']) && 
        !empty($_POST['addTask']) && !empty($_POST['jira']) && !empty($_POST['date']) && !empty($_POST['time'])){
            $db=new BDD();
            $db->addTask($_POST['jira'],$_POST['date'],$_POST['time'],$_POST['com']);
    }
    $redirect='index.php';
    if (isset($_POST['redirect']) && $_POST['redirect'] != ""){
        $redirect=$_POST['redirect'];
    }
    header('Location: '.$redirect);
?>
