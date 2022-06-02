<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet - Télétravail</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php

    include('./template.php');
    $db=new BDD();
    echo "<div class='center teletravail'>
            <h2>TimeSheet - Télétravail</h2>
            <h3>Déclaration de télétravail</h3>";
    $db->addDayTT();
    echo "</div>";
?>

</body>
</html>