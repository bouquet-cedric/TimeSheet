<?php
    require_once('BDD.php');

    function addLink($page,$name){
        echo "
            <form action='$page' method='post'>
                <input type='submit' value='$name'/>
            </form>";
    }

    function addNavBar(){
        echo "<div class='navbar'>";
        addLink('index.php','&#127968;');
        addLink('planning.php','&#128197;');
        addLink('detail-day.php','&#128195;');
        $db = new BDD();
        $db->addButtonSave();
        $db->loadSave();
        echo "</div>";
    }

    addNavBar();

?>