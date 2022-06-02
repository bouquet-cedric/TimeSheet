<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeSheet</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="./script.js"></script>
    <script src="./dimension.js"></script>
    <link rel="stylesheet" href="scrollbar.css">
</head>
<body>
    <?php
    require_once('BDD.php');
    include('./template.php');
    $db=new BDD();
    assert($db->getDB()!=null);
    if ($db->getDB()!=null){
        echo "<div class='center timesheet'><h2>TimeSheet</h2>";
        $db->getTasks(100);
        echo "</div>";
    }
    
?>

</body>
</html>