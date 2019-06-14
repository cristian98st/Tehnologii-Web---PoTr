<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
include "template.php";
date_default_timezone_set('Europe/Bucharest');
session_start();
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>
   <?php
    applyTemplate($connection, "search_results");
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
    <footer>
        <a href="aboutus.php"> About us</a> |
        <a href="rss.php">RSS Feed</a>
    </footer>
</body>

</html>