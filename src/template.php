<?php
    require_once('BDD.php');

    function addLink($page,$name,$title="Click me"){
        echo "
            <form action='$page' method='post'>
                <input type='submit' title=\"$title\" value='$name'/>
            </form>";
    }

    function addNavBar(){
        echo "<div class='navbar'>";
        addLink('index.php','&#127968;',"Affiche toutes les saisies");
        addLink('planning.php','&#128197;',"Affiche le détail par année");
        addLink('detail-day.php','&#128195;',"Affiche le détail d'une journée");
        addLink('detail-task.php','&#128203;',"Affiche le détail d'une tâche");
        $db = new BDD();
        $db->addSave();
        $db->loadSave();
        echo "</div>";
    }

    addNavBar();

?>