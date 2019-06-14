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
    applyTemplate($connection, "view_poem");
    ?>
    <main>
        <div class="emptybox"></div>
        <div class="items">
            <div class = "row-article">
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


