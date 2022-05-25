<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet - Détail</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./script.js"></script>
</head>
<body>
    <?php
    include('./template.php');
    $db=new BDD();
    echo "<div class='center'>";
    echo "<h2>TimeSheet - Task</h2>";
    $db->getByTask();
    echo "</div>";
?>

</body>
</html>