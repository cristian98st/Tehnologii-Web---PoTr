<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
include "template.php";
date_default_timezone_set('Europe/Bucharest');
session_start();
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <?php
    applyTemplate($connection, "index");
    ?>

    <main>
        <div class="emptybox"></div>
        <div class="items">
            <h2>
                <?php
                $username = getUser($connection, $_SESSION['id'])['username'];
                if($username == "Anonymous")
                    $username = "Guest";
                echo "Welcome to Potter, ".$username."!";
                ?>
            </h2>
        </div>
        <div class="emptybox"></div>
    </main>
    <footer>
        <a href="aboutus.php"> About us</a> |
        <a href="rss.php">RSS Feed</a>
    </footer>
</body>

</html>