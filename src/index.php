<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet</title>
    <link rel="stylesheet" href="style.css">
    <script src="./script.js"></script>
</head>
<body>
    <?php
    require_once('BDD.php');
    include('./template.php');
    $mydb=new BDD();
    echo "<div class='center'>";
    echo "<h2>TimeSheet</h2>";
    $mydb->getTasks();
    echo "</div>";
    
?>

</body>
</html>