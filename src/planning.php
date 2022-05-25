<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet - Planning</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js"></script>
</head>
<body>
    <?php

    include('./template.php');
    $db=new BDD();
    echo "<div class='center planning'>";
    echo "<h2>TimeSheet - Planning</h2>";
    $db->addCalendar();
    echo "</div>";

?>

</body>
</html>