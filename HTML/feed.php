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
        <div class="topright-off">
                <a href="signup.html">Sign up</a>
                <a> | </a>
                <a href="login.html">Sign in</a>
        </div>
    </div>
    <div class="topnav">
        <a href="index.html">Home</a>
        <a href="news.html">News</a>
        <a class="active" href="feed.html">Feed</a>
        <a href="aboutus.html">About us</a>
    </div>
    <main class="content">
        <div class="emptybox"></div>
        <ul class="feed">
            <?php
            $_SESSION['id']=1;
            require_once('functions.php');
            $con = conn();
            get_feed($con);
            ?>
            </ul>
        <div class="emptybox"></div>
    </main>
</body>

</html>