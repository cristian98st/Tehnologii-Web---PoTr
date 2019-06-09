<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
</head>
<body>
<?php
    if(!isset($_SESSION['id'])){
        $_SESSION['id']=2;
    }
    require_once('functions.php');
    if($_POST['translated']==0){
        add_poem($_POST['title'],$_POST['author'],$_POST['text'],$_SESSION['id']);
    }
    header('Location: http://localhost/index.php')
?>
   
</body>
</html>
