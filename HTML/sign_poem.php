<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Potter</title>
</head>
<body>
<?php
    session_start();
    // if(!isset($_SESSION['id'])){
    //     $_SESSION['id']=2;
    // }
    require_once('functions.php');
    $conn = conn();
    if(isset($_POST['ortitle'])){
        add_tpoem($_POST['title'],$_POST['author'],$_POST['ortitle'],$_POST['text'],$_POST['lang'],$_SESSION['id'],$conn);
    }
    else{
        add_poem($_POST['title'],$_POST['author'],$_POST['text'],$_SESSION['id'],$conn);
    }
    end_conn($conn);
    header('Location: index.php')
?>
   
</body>
</html>
