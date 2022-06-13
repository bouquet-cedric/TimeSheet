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
    $db=new BDD();
    echo "<div class='center teletravail'>";
    echo "<h2>TimeSheet - Télétravail</h2>";
    echo "<h3>Vue par mois</h3>";
    $db->addCalendar(true);
    echo "</div>";

?>

</body>
</html>