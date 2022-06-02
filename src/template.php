<?php
    require_once('BDD.php');

    function addNavBar(){
        echo "<div class='navbar'>";
        addLink('index.php','&#128346;','TimeSheet',"Affiche toutes les saisies");
        addLink('planning.php','&#128197;','Tâches par mois',"Affiche le détail par année");
        addLink('detail-day.php','&#128198;','Tâches par jour',"Affiche le détail d'une journée");
        addLink('detail-task.php','&#128396;','Tâches par Jira',"Affiche le détail d'une tâche");
        addLink('télétravail.php','&#127969;','Télétravail',"Affiche le jour de télétravail");
        $db = new BDD();
        $db->addSave();
        $db->loadSave();
        echo "</div>";
    }

    addNavBar();

?>