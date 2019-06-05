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

function setCommentBox($conn) {
    echo "<br><br><form method = 'POST' action='".setComments($conn)."'>
                <input type='hidden' name='userid' value='1'>
                <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                <textarea name='message'></textarea> <br>
                <button class='commentSubmit' name='commentSubmit' type='submit'>Comment</button>
            </form>";
}

function setComments($conn) {
    if(isset($_POST['commentSubmit'])){
        $userid = $_POST['userid'];
        $date = $_POST['date'];
        $poemID = $_SESSION['poem_id'];
        $message = $_POST['message'];
        $message = $conn->real_escape_string($message);

        $sql = "INSERT INTO comments(user_id, poem_id, body, created_at, updated_at) VALUES('$userid', '$poemID', '$message', '$date', '$date')";
        $result = $conn->query($sql);

    }
}

function getComments($conn){

    $results_per_page = 5;

    $sql = "SELECT * FROM comments WHERE poem_id = '".$_SESSION['poem_id']."'";
    $result = $conn->query($sql);
    $number_of_results = mysqli_num_rows($result);

    $number_of_pages = ceil($number_of_results/$results_per_page);

    if(!isset($_GET['page'])){
        $page=1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page-1)*$results_per_page;


    $sql = "SELECT * FROM comments WHERE poem_id = '".$_SESSION['poem_id']."' LIMIT ".$this_page_first_result.",".$results_per_page;
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()){
        echo "<div class='comments_box'><p>"
                .getUploader($conn, $row['user_id']).
             "<br>"
                .$row['created_at'].
             "<br><br>"
                .nl2br($row['body']).
             "</p></div>";
    }
    
    // links to the page

    $pagination = "<p class='pagination'>";
    for($page=1;$page<=$number_of_pages;$page++){
        $pagination .= "<a href = 'view_poem.php?poem_name=".$_GET['poem_name']."&id=".$_GET['id']."&page=".$page."'>".$page."</a>";
        $pagination .= ">";
    }
    $pagination = substr($pagination, 0, -1);
    $pagination .= "</p>";
    
    echo $pagination;
}
?>