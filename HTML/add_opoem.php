<?php
include "user.inc.php";
include "dba.inc.php";
include "notification.inc.php";
include "template.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Potter</title>
    <link rel="stylesheet" href="index.css">
</head>

<header>
    <?php
    applyTemplate($connection, "add_poem");
    ?>
</header>

<body>
    <main class = 'content'>
        <div class = 'emptybox'></div>
        <form action = 'sign_poem.php' method = 'post'>
            <h2>Required info:</h2>
            <hr />
            <h3>Title:</h3>
            <input type = 'text' name = 'title' placeholder="Insert title here.." required>
            <h3>Author:</h3>
            <input type = 'text' name = 'author' placeholder="Name.." required>
            <h3>Text:</h3>
            <textarea placeholder="Insert text here.." over cols = 60 rows = 30 name = 'text' required ></textarea>
            <h3>Language:</h3>
            <h4><input type = 'radio' name = 'lang' value = 'English'>English</h4>
            <h4><input type = 'radio' name = 'lang' value = 'German'>German</h4>
            <h4><input type = 'radio' name = 'lang' value = 'Italian'>Spanish</h4>
            <h4><input type = 'radio' name = 'lang' value = 'Romanian'>Romanian</h4>
            <h4><input type = 'radio' name = 'lang' value = 'Russian'>Russian</h4>
            <button type="submit">Finish</button>
        </form>
        <div class = 'emptybox'></div>
    </main>
</body>
</html>