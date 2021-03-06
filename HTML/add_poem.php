<?php
session_start();
include "dba.inc.php";
include "user.inc.php";
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

<header>
    <?php
    applyTemplate($connection, "add_poem");
    ?>
</header>

<body>
    <main>
        <div class = 'emptybox'></div>
        <div class='items'>
            <h2>
                What type of poem do you want to add?
            </h2>
            <br><br>
            <?php
                echo '<form action = "'.redirect().'" method = "post">
                    <button type="submit" name="originalPoem" class="addPoem">Add a poem</button>
                    <button type="submit" name="translatedPoem" class="addPoem">Add a translation</button>
                </form>';
            ?>
        </div>
        <div class = 'emptybox'></div>
    </main>
    <footer>
        <a href="aboutus.php"> About us</a> |
        <a href="rss.php">RSS Feed</a>
    </footer>
</body>
</html>

<?php
function redirect(){
    require_once('functions.php');
    if(isset($_POST['originalPoem'])){
        header('Location: add_opoem.php');
    } else if(isset($_POST['translatedPoem'])){
        header("Location: add_tpoem.php");
    }
}
?>