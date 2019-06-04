<?php
function getPoem($conn){
    $isTranslated = FALSE;
    $title = $_GET['poem_name'];
    
    $sql_poem= "SELECT * FROM poems WHERE title = '$title'";
    $sql_translatedPoem = "SELECT * FROM translated_poems WHERE title = '$title'";
    $result_poem = $conn->query($sql_poem);

    if($result_poem == NULL){
        $result_poem = $conn->query($sql_translatedPoem);
        $isTranslated = TRUE;
    }
    
    $row = $result_poem->fetch_assoc();
    echo "
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
}
?>