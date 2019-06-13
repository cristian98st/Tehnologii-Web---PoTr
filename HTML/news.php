<?php
session_start();
include "news.inc.php";
include "dba.inc.php";
include "user.inc.php";
include "translated_poem.inc.php";
include "notification.inc.php";
include "template.php";
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <?php
    applyTemplate($connection, "news");
    ?>

    <main>
        <div class="emptybox"></div>
        <div class="items_news">
            <?php
                getNewTranslations($connection);
                getNewOriginalPoems($connection);
                getNewComments($connection);
                getTopCommentedPoems($connection);
                getTopActiveUsers($connection);
                getTopSubscribitions($connection);
            ?>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>