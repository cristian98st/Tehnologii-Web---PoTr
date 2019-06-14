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
    applyTemplate($connection, "editComment");
    ?>
    <main>
        <div class="emptybox"></div>
        <div class="items">
            <!-- body -->
            <div class="poem_box">
                <?php
                $comment_id = $_POST['comment_id'];
                $userid = $_POST['userid'];
                $date = $_POST['date'];
                $message = $_POST['message'];


                if(strstr($message, "<br><br>"))
                    $message = substr($message, 0, strrpos($message, "\n")); 


                echo "<br><br><form method = 'POST' action='".editComment($connection)."'>
                <input type='hidden' name='userid' value='".$userid."'>
                <input type='hidden' name='comment_id' value='".$comment_id."'>
                <input type='hidden' name='date' value='".date("Y-m-d H:i:s")."'>
                <textarea name='message'>".$message."</textarea> <br>
                <button class='commentSubmit' name='commentEdit' type='submit'>Edit</button>
            </form>";
                editComment($connection);
                ?>
            </div>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>