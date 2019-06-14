<?php
    include "user.inc.php";
    include "dba.inc.php";
    include "notification.inc.php";
    include "template.php";
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
    <?php
    applyTemplate($connection, "feed");
    ?>
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
    <footer>
        <a href="aboutus.php"> About us</a> |
        <a href="rss.php">RSS Feed</a>
    </footer>
</body>

</html>