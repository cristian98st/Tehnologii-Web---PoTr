<!DOCTYPE html>
<html lang="en-US">

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
    <main class = 'content'>
    <div class="emptybox"></div>
    <div class = "items">
        <h2>
            Your Info:
        </h2>
        <form>
        <h3>
            Name:
        </h3>
        <?php
        $_SESSION['id']= 1;
        require_once('functions.php');
        $rez = get_userinfo()->fetch_assoc();
        echo 
        '<input type="text" name = "n" placeholder="'. $rez['username'] . '">
        ';
        ?>
        </form>    
    </div>

    <nav>

    <div class="emptybox"></div>
</main>

</body>

</html>