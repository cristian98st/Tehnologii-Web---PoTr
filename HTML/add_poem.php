<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
</head>
<body>
<?php
    session_start();
    require_once('functions.php');
    if(isset($_POST['originalPoem'])){
        header('Location: add_opoem.php');
    } else if(isset($_POST['translatedPoem'])){
        header("Location: add_tpoem.php");
    }
?>
   
</body>
</html>
