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
            "</p>";
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

?>