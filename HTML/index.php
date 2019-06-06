<?php
session_start();
?>

<?php
if(!isset($_GET['login'])){
    if(!isset($_SESSION['id']))
        $_SESSION['id'] = -1;
}
else if($_GET['login'] == "failed")
    $_SESSION['id'] = -1;
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="toprow">
        <input type="text" placeholder="Search poem...">
        <h1 class="title">
                <a href="index.html"><img class="resize" src="http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png"></a>
                <span style="font-size: 82px; margin: 21px 0;"><a href="index.html" style="text-decoration:none; color: #f3f1e0">Potter</a></span>
        </h1>

        <?php
            if(!isset($_SESSION['id']) || $_SESSION['id'] == -1){
                $_SESSION['id'] = -1;
                echo '<div class="topright-off">
                        <a href="signup.php">Sign up</a>
                        <a> | </a>
                        <a href="Login.php">Sign in</a>
                        </div>';
            } else {
                echo '<div class="topright-on">
                    <a href="user_info.html">User info</a>
                    <a href="index.php?login=failed">Log Out</a>
                    </div>';
            }
        ?>
    </div>

    <?php
    
    if(isset($_SESSION['id']) && $_SESSION['id'] != -1){
        echo '<div class="topnav">
        <a class="active" href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="feed-on.html">Feed</a>
        <a href="add_poem.html">Add your poem</a>
        <a href="my_poems.html">My poems</a>
        <a href="aboutus-on.html">About us</a>
    </div>';
    } else {
        echo '<div class="topnav">
            <a class="active" href="index.html">Home</a>
            <a href="news.php">News</a>
            <a href="feed.html">Feed</a>
            <a href="aboutus.html">About us</a>
        </div>';
    }

    ?>

    <main class="content">
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