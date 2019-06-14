<?php
date_default_timezone_set('Europe/Bucharest');
include "dba.inc.php";
include "comments.inc.php";
include "translated_poem.inc.php";
include "template.php";
include "notification.inc.php";
include "user.inc.php";
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
    <?php
    applyTemplate($connection, "editPoem");
    ?>
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

                // $message = mysqli_real_escape_string($connection, $message);

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
    <footer>
        <a href="aboutus.php"> About us</a> |
        <a href="rss.php">RSS Feed</a>
    </footer>
</body>

</html>