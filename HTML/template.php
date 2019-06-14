<?php

function applyTemplate($connection, $page_name){
    if(!isset($_GET['login'])){
        if(!isset($_SESSION['id']))
            $_SESSION['id'] = -1;
    }
    else if($_GET['login'] == "failed")
        $_SESSION['id'] = -1;
    
    if(isset($_GET['last']))
        if(isset($_GET['id'])){
            $sql = "UPDATE users SET last_loggin='".$_GET['last']."' WHERE id = ".$_GET['id'];
            $result = $connection->query($sql);
        }
    
    echo '    <div class="toprow">
    <form class = "searchForm" action="search_result.php" method="POST" type="hiddens">
        <input class="searchInput" type="text" name="searchInput" placeholder="Search poem...">
        <button type="submit" name="searchSubmit" class="searchSubmit"></button>
    </form>
    <h1 class="title">
            <a href="index.php"><img class="resize" src="http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png"></a>
            <span style="font-size: 82px; margin: 21px 0;"><a href="index.php" style="text-decoration:none; color: #f3f1e0">Potter</a></span>
    </h1>';

        if(!isset($_SESSION['id']) || $_SESSION['id'] == -1){
            $_SESSION['id'] = -1;
            echo '<div class="topright-off">
                    <a href="signup.html">Sign up</a>
                    <a> | </a>
                    <a href="Login.php">Sign in</a>
                    </div>';
        } else {
            $user = getUser($connection, $_SESSION['id']);
            echo '<div class="topright-on">';
            initNotificationBox($connection, $user);
            $logoutPath = "index.php?login=failed&last=".date("Y-m-d")."&id=".$_SESSION['id'];
            echo '<a href="change_user_info.php">'.$user["username"].'\'s info</a>
                <a href="'.$logoutPath.'">Log Out</a>
                </div>';
        }        

    echo '</div>';

    if(isset($_SESSION['id']) && $_SESSION['id'] != -1){
        echo '<div class="topnav">';
        if($page_name == "index")
            echo '<a class="active" href="index.php">Home</a>';
        else
            echo '<a href="index.php">Home</a>';

        if($page_name == "news")
            echo '<a class="active" href="news.php">News</a>';
        else
            echo '<a href="news.php">News</a>';

        if($page_name == "feed")
            echo '<a class="active" href="feed.php">Feed</a>';
        else
            echo '<a href="feed.php">Feed</a>';

        if($page_name == "add_poem")
            echo '<a class="active" href="add_poem.html">Add your poem</a>';
        else
            echo '<a href="add_poem.php">Add your poem</a>';

        if($page_name == "aboutus")
            echo '<a class="active" href="aboutus.html">About us</a>';
        else
            echo '<a href="aboutus.php">About us</a>';
    echo '</div>';
    } else {
        echo '<div class="topnav">';
        if($page_name == "index")
            echo '<a class="active" href="index.php">Home</a>';
        else
            echo '<a href="index.php">Home</a>';

        if($page_name == "news")
            echo '<a class="active" href="news.php">News</a>';
        else
            echo '<a href="news.php">News</a>';

        if($page_name == "aboutus")
            echo '<a class="active" href="aboutus.html">About us</a>';
        else
            echo '<a href="aboutus.php  ">About us</a>';
    echo '</div>';
    }
}

?>