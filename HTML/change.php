<?php
require_once('functions.php');
echo '
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>
<h1>';
$con = conn();
session_start();
if(isset($_GET['n']) or isset($_GET['p'])){
    echo update_user($_GET['n'],$_GET['p'],$con,$_SESSION['id']);
}
echo'</h1>';
?>