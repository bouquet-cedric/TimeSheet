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
    $db=new BDD();
    echo "<div class='center teletravail'>";
    echo "<h2>TimeSheet - Télétravail</h2>";
    echo "<h3>Vue par mois</h3>";
    $db->addCalendar(true);
    echo "</div>";

?>

</body>
</html>