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
    <main>
        <div class="emptybox"></div>
        <div class="items">
            <!-- body -->
            <div class="poem_box">
                <?php
                $poem_id = $_POST['poem_id'];
                $userid = $_POST['userid'];
                $date = $_POST['date'];
                $message = $_POST['message'];


                if(strstr($message, "<br><br>"))
                    $message = substr($message, 0, strrpos($message, "\n")); 

                echo "<br><br><form method = 'POST' action='".editPoem($connection, )."'>
                    <input type='hidden' name='userid' value='".$userid."'>
                    <input type='hidden' name='poem_id' value='".$poem_id."'>
                    <input type='hidden' name='date' value='".date("Y-m-d H:i:s")."'>
                    <textarea class='poemEditTextarea' name='message'>".$message."</textarea> <br>
                    <button class='poemSubmit' name='poemEdit' type='submit'>Edit</button>
                    </form>";
                editPoem($connection);
                ?>
            </div>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>