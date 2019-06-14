<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
include "template.php";
session_start();
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
    applyTemplate($connection, "aboutus");
    ?>
    <main class="content">
        <div class="emptybox"></div>
        <div class="info">
            <h2>
                Welcome to the About us page.
            </h2>
            <h3>
                Who are we?
            </h3>
            <p>Cristian Tugui & Putanu Alexandru</p>
            <h3>
                What do we do?
            </h3>
            <p> Computer science students</p>
            <h3>
                How did we create this website?
            </h3>
            <p>
                Using the mvc model, with practices and 
                abilities gained from many different sources.
                Technologies we used are php,html,css and mysql.
                Also,lots of hours of work :D.
            </p>
            <h3>
                Where can you find us?
            </h3>
            <p>
                You can find us in Iasi, but to contact us you can use
                our public email addresses <address>alexandruputanu@yahoo.com</address>
                <address>cristian7tugui@gmail.com</address>
            </p>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>