<?php
    require_once('BDD.php');

    function addLink($page,$icon,$name,$title="Click me"){
        echo "
            <div class='flexibus'>
                <form action='$page' method='post'>
                    <input type='submit' title=\"$title\" value=\"$icon\"/>
                </form>
                <span title=\"$title\">$name</span>
            </div>
            ";
    }

    function addNavBar(){
        echo "<div class='navbar'>";
        addLink('index.php','&#127969;','TimeSheet',"Affiche toutes les saisies");
        addLink('planning.php','&#128197;','Tâches par mois',"Affiche le détail par année");
        addLink('detail-day.php','&#128198;','Tâches par jour',"Affiche le détail d'une journée");
        addLink('detail-task.php','&#128396;','Tâches par Jira',"Affiche le détail d'une tâche");
        $db = new BDD();
        $db->addSave();
        $db->loadSave();
        echo "</div>";
    }

    addNavBar();

?>