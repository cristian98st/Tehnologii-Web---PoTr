<?php
include "subscribers.inc.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en-US">
<?php
require_once('functions.php');
$id = $_GET['uid'];
// $_SESSION['id']=2;
$con = conn();
$rez = get_userinfo($con, $id)->fetch_assoc();
$subs = get_subs($con, $id);
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

<body>
    <main class='content'>
        <div class="emptybox" style="flex-grow:3"></div>
        <div class="info">
            <h2>
                <?php
                echo
                    $rez['username'];
                ?>
                's Info:
            </h2>
            <p>
                <?php
                echo
                    $rez['username'];
                ?> has:
                <?php
                echo $subs[1];
                ?>
                Subscribers.
            </p>
            <p>
                And is subscribed to:
                <?php
                echo $subs[0];
                ?>
                people.
            </p>
            <form>
                <h3>
                    Name:
                </h3>
                <p>
                    <?php
                    echo
                        $rez['username'];
                    ?>
                </p>
                <br>
                <h3>
                    Email:
                </h3>
                <?php
                echo '<p>' . $rez['email'] . '</p>';
                ?>
                <br>
                <?php
                if (isset($_SESSION['id']))
                    if ($_SESSION['id'] == $id)
                        echo '<a href = "change_user_info.php"><button type = "button"> Change credentials</button></a>';
                ?>
            </form>
            <?php
            if (isset($_SESSION['id']))
                if ($_SESSION['id'] != $id)
                    if (!isSubscribed($con, $_SESSION['id'], $id))
                        echo '<form method="POST" action="' . setSubscriber($con, $_SESSION['id'], $id) . '">
                                <button name="subscribeSubmit" type="submit">Subscribe</button>
                            </form>';
            ?>
        </div>
        <div class="emptybox"></div>
        <nav>
            <h3>
                <?php
                echo
                    $rez['username'];
                ?>'s contributions:
            </h3>
            <ol>
                <?php
                get_news($con, $id);
                ?>
            </ol>
        </nav>
        <div class="emptybox" style="flex-grow:3"></div>
    </main>

</body>

</html>