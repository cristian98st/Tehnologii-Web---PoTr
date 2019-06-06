<?php
date_default_timezone_set('Europe/Bucharest');
include "dba.inc.php";
include "comments.inc.php";
include "translated_poem.inc.php";
session_start();
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="toprow">
        <input type="text" placeholder="Search poem...">
        <h1 class="title">
                <a href="index.html"><img class="resize" src="http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png"></a>
                <span style="font-size: 82px; margin: 21px 0;"><a href="index.html" style="text-decoration:none; color: #f3f1e0">Potter</a></span>
        </h1>
        <div class="topright-off">
                <a href="signup.html">Sign up</a>
                <a> | </a>
                <a href="login.html">Sign in</a>
        </div>
    </div>
    <div class="topnav">
        <a href="index.html">Home</a>
        <a href="news.html">News</a>
        <a href="feed.html">Feed</a>
        <a href="aboutus.html">About us</a>
    </div>
    <main class="content">
        <div class="emptybox"></div>
        <div class="items">
            <!-- body -->
            <div class="poem_box">
                <?php
                getPoem($connection);
                ?>
            </div>
            <?php
            if($_SESSION['translated'] == true){
                setCommentBox($connection);
                getComments($connection);
            }
            ?>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>