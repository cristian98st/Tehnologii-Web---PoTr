<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
date_default_timezone_set('Europe/Bucharest');
session_start();
?>

<?php
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
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
    <div class="toprow">
        <input type="text" placeholder="Search poem...">
        <h1 class="title">
                <a href="index.php"><img class="resize" src="http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png"></a>
                <span style="font-size: 82px; margin: 21px 0;"><a href="index.php" style="text-decoration:none; color: #f3f1e0">Potter</a></span>
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
                $user = getUser($connection, $_SESSION['id']);
                echo '<div class="topright-on">';
                initNotificationBox($connection, $user);
                $logoutPath = "index.php?login=failed&last=".date("Y-m-d")."&id=".$_SESSION['id'];
                echo '<a href="user_info.php">'.$user["username"].'\'s info</a>
                    <a href="'.$logoutPath.'">Log Out</a>
                    </div>';
            }
        ?>
    </div>

    <?php
    
    if(isset($_SESSION['id']) && $_SESSION['id'] != -1){
        echo '<div class="topnav">
        <a class="active" href="index.php">Home</a>
        <a href="news.php">News</a>
        <a href="feed.php">Feed</a>
        <a href="add_poem.php">Add your poem</a>
        <a href="my_poems.php">My poems</a>
        <a href="aboutus.html">About us</a>
    </div>';
    } else {
        echo '<div class="topnav">
            <a class="active" href="index.php">Home</a>
            <a href="news.php">News</a>
            <a href="feed.php">Feed</a>
            <a href="aboutus.html">About us</a>
        </div>';
    }

    ?>

    <main>
        <div class="emptybox"></div>
        <div class="items">
            <?php

                if(isset($_POST['searchSubmit'])){
                    $search = mysqli_real_escape_string($connection, $_POST['searchInput']);

                    $sql_poem = "SELECT * FROM poems WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR body LIKE '%$search%'";
                    $result_poem = $connection->query($sql_poem);

                    if(mysqli_num_rows($result_poem)>0){
                        while($row = $result_poem->fetch_assoc()){
                            echo "<div class='searchResult'>
                                    <a style='text-size:50px !important; text-decoration:underline;' href='view_poem.php?poem_name=".$row['title']."&id=".$row['uploader_id']."'>".$row['title']."</a>
                                    - ".$row['author']."
                                    </div><br><br>";
                        }
                    }

                    $sql_translation = "SELECT * FROM translated_poems WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR body LIKE '%$search%' OR language LIKE '%$search%'";
                    $result_translation = $connection->query($sql_translation);

                    if(mysqli_num_rows($result_translation)>0){
                        while($row = $result_translation->fetch_assoc()){
                            echo "<div class='searchResult'>
                                    <a style='text-size:50px !important; text-decoration:underline;' href='view_poem.php?poem_name=".$row['title']."&id=".$row['uploader_id']."'>".$row['title']."</a>
                                    - ".$row['author'].",
                                     Language: ".$row['language']."
                                    </div><br><br>";
                        }
                    }

                    $sql_user = "SELECT * FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
                    $result_user = $connection->query($sql_user);

                    if(mysqli_num_rows($result_user)>0){
                        while($row = $result_user->fetch_assoc()){
                            if($row['id']!=-2 && $row['id']!=-1)
                                echo "<div class='searchResult'>
                                        <a style='text-size:50px !important; text-decoration:underline;' href='user_info.php?uid=".$row['id']."'>".$row['username']."</a>, E-mail: "
                                        .$row['email']."</a>
                                        </div><br><br>";
                        }
                    }

                }

            ?>
        </div>
        <div class="emptybox"></div>
    </main>
</body>

</html>