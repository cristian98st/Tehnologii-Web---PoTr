
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
    applyTemplate($connection, "feed");
    ?>
    <main class="content">
        <div class="emptybox"></div>
        <ul class="row-article">
            <?php
            require_once('functions.php');
            $con = conn();
            get_feed($con,$_SESSION['id']);
            ?>
            </ul>
        <div class="emptybox"></div>
    </main>
</body>

</html>