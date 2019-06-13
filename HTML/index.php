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
                Welcome to the Homepage.
            </h2>
            <p>This is the homepage.
            <br>
            <!-- test -->
            <a href = "view_poem.php?poem_name=Drowsy%20birds&id=2">Bau</a>;
            <!-- finish test -->
            </p>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>