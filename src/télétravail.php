<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet - Télétravail</title>
    <link rel="stylesheet" href="style.css">
    <script src="./teletravail.js"></script>
</head>
<body>
    <?php

    include('./template.php');
    echo "<div class='center teletravail'>
            <h2>TimeSheet - Télétravail</h2>
            <div class='submenus'>";
    addButtonLink("vue-télétravail.php","&#128187;","Vue télétravail","Planning des jours de télétravail par mois");
    addButtonLink("déclaration-télétravail.php",'&#128220;',"Déclaration des jours de télétravail");
    echo "</div>
    </div>";

?>

</body>
</html>