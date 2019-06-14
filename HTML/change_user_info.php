<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
include "template.php";
?>

<!DOCTYPE html>
<html lang="en-US">
<?php
// $_SESSION['id']= 2;
session_start();
require_once('functions.php');
$con = conn();
$rez = get_userinfo($con,$_SESSION['id'])->fetch_assoc();
$subs = get_subs($con,$_SESSION['id']);
?>
<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>

<header>
    <?php
    applyTemplate($connection, "change_user_info");
    ?>
</header>
<div class="emptybox"></div>
<body>
    <main class = 'content'>
    <div class="emptybox"></div>
    <div class = "info">
        <h2>
            Your Info:
        </h2>
        <h3>
            You have:
            <?php
        echo $subs[1];
        ?>
        Subscribers.
        </h3>
        <h3>
            And you are subscribed to:
            <?php
            echo $subs[0];
            ?>
            people.
        </h3>
        <form action="change.php" method="GET">
        <h3>
            Name:
        </h3>
        <input type="text" name = "n" placeholder="
        <?php
        echo 
        $rez['username'];
        ?>
        ">
        <br>
        <h3>
            Email:
        </h3>
        <?php
        echo '<h4>' . $rez['email'] . '</h4>';
        ?>
        <br>
        <h3>
            Password:
        </h3>
        <input type="text" name = "p" placeholder="Parola ta">
        <button type="submit">Commit changes</button>
        </form>    
    </div>
    <div class="emptybox"></div>
    <nav style = 'flex-grow : 1'>
    <h3>
        Your contributions:
    </h3>
    <ol>
        <?php
        get_news($con,$_SESSION['id']);
        ?>
    </ol>
    </nav>
    <div class="emptybox"></div>
</main>

</body>

</html>