<?php

function getPoem($conn){
    $isTranslated = FALSE;
    $title = $_GET['poem_name'];
    $uploaderID = $_GET['id'];

    
    $sql_poem= "SELECT * FROM poems WHERE title = '$title' AND uploader_id = '$uploaderID'";
    $sql_translatedPoem = "SELECT * FROM translated_poems WHERE title = '$title' AND uploader_id = '$uploaderID'";
    $result_poem = $conn->query($sql_poem);

    $username = getUploader($conn, $uploaderID);

    if($result_poem->num_rows < 1){
        $result_poem = $conn->query($sql_translatedPoem);
        $isTranslated = TRUE;
    }
    
    $row = $result_poem->fetch_assoc();
    if($isTranslated == FALSE){
        $_SESSION['translated'] = false;
        $_SESSION['poem_id'] = $row['poem_id'];
        echo "
            <p class='uploader'> Uploader:"
                .$username.
            "</p></p>
            <h2 class='poem_title'>"
                .$row['title'].
            "</h2>
            <p class='poem_author'>"
                .$row['author'].
            "</p>
            <br>
            <p class='poem_body'>"
                .nl2br($row['body']).
            "</p>";
    } else {
        $_SESSION['translated'] = true;
        $_SESSION['poem_id'] = $row['poem_id'];
        echo "
            <p class='uploader'> Uploader: "
                .$username.
            "</p>
            <h2 class='poem_title'>"
                .$row['title'].
            "</h2>
            <p class='language'>-"
                .$row['language'].
            "-</p>
            <p class='poem_author'>"
                .$row['author'].
            "</p>
            <br>
            <p class='poem_body'>"
                .nl2br($row['body']).
            "</p>
            <form class='upvote' method='POST' action='".upvotePoem($conn, $row)."'>
                <input type='hidden' name='poem_id' value='".$row['poem_id']."'>
                <input type='hidden' name='upvotes' value='".$row['upvotes']."'>
                <button class='upvotePoem' name='upvotePoem' type='submit'></button>
            </form>
            <form class='upvote' method='POST' action='".downvotePoem($conn, $row)."'>
            <input type='hidden' name='poem_id' value='".$row['poem_id']."'>
            <input type='hidden' name='downvotes' value='".$row['downvotes']."'>
            <button class='downvotePoem' name='downvotePoem' type='submit'></button>
            </form>";
            getPoemUpvotes($conn, $row);
            getPoemDownvotes($conn, $row);
    }
}

function getUploader($conn, $id){
    $sql = "SELECT username FROM users WHERE id = '$id'";

    $result = $conn->query($sql);

    $rtnValaue = $result->fetch_assoc();
    return $rtnValaue['username'];
}

function getPoemByID($conn, $id){
    $sql = "SELECT * FROM translated_poems WHERE poem_id = '$id'";
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function upvotePoem($conn, $poem){
    if($_SESSION['id'] != -1 && $_SESSION['id']!=-2){
        if(isset($_POST['upvotePoem'])){
            $upvotes = $_POST['upvotes'];
            $poem_id = $_POST['poem_id'];

            if($upvotes==NULL)
                $sql = "UPDATE translated_poems SET upvotes = 1 WHERE poem_id = $poem_id";
            else
                $sql = "UPDATE translated_poems SET upvotes = $upvotes+1 WHERE poem_id = $poem_id";

            $result = $conn->query($sql);

            // echo mysqli_error($conn);
            header("Location: view_poem.php?poem_name=".$poem['title']."&id=".$poem['uploader_id']);
        }
    }
}

function downvotePoem($conn, $poem){
    if($_SESSION['id'] != -1 && $_SESSION['id']!=-2){
        if(isset($_POST['downvotePoem'])){
            $downvotes = $_POST['downvotes'];
            $poem_id = $_POST['poem_id'];

            if($downvotes==NULL)
                $sql = "UPDATE translated_poems SET downvotes = 1 WHERE poem_id = $poem_id";
            else
                $sql = "UPDATE translated_poems SET downvotes = $downvotes+1 WHERE poem_id = $poem_id";

            $result = $conn->query($sql);

            // echo mysqli_error($conn);
            header("Location: view_poem.php?poem_name=".$poem['title']."&id=".$poem['uploader_id']);
        }
    }
}

function getPoemUpvotes($conn, $poem){
    echo "<p class='upvotesNoPoem'>".$poem['upvotes']."</p>";
}

function getPoemDownvotes($conn, $poem){
    echo "<p class='downvotesNoPoem'>".$poem['downvotes']."</p>";
}

?>