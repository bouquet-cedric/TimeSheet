<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet - Télétravail</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/e436041ab3.js" integrity="sha512-ZreHqndbQULz7vlWcNP43WUBs5tfxYaOb2ug2mdcQX7N4hbcdwev8Z4+aLZzyCXwjOJV7mJtkGY+51P4Og9W7w==" crossorigin="anonymous"></script>
    <script src="./teletravail.js"></script>
</head>
<body>
    <?php

    include('./template.php');
    echo "<div class='center teletravail'>
            <h2>TimeSheet - Télétravail</h2>
            <div class='submenus'>";
    addButtonLink("vue-teletravail.php","&#128187;","Vue télétravail","Planning des jours de télétravail par mois");
    addButtonLink("declaration-teletravail.php",'&#128220;',"Déclaration des jours de télétravail");
    echo "</div>
    </div>";

?>

</body>
</html>