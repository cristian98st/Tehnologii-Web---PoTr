<?php
    session_start();
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
    <div class="toprow">
        <input type="text" placeholder="Search poem...">
        <h1 href="title">
                <a href="index.html"><img class="resize" src="http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png"></a>
                <span style="font-size: 82px; margin: 21px 0;">Potter</span>
        </h1>
        <div class="topright-on">
                <a href="user_info.html">User info</a>
                <a href="index.html">Log Out</a>
        </div>
    </div>
    <div class="topnav">
        <a href="index_loggedin.html">Home</a>
        <a href="news-on.html">News</a>
        <a href="feed-on.html">Feed</a>
        <a href="add_poem.html">Add your poem</a>
        <a href="my_poems.html">My poems</a>
        <a href="aboutus-on.html">About us</a>
    </div>
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