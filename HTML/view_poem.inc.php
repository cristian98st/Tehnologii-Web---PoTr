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
                <input type='hidden' name='userid' value='".$_SESSION['id']."'>
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
             "</p>";
        if($_SESSION['id'] == $row['user_id'] || $_SESSION['id'] == -2){
            echo "<form class='deleteForm' method='POST' action='".deleteComment($conn)."'>
                    <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
                    <button name='commentDelete' type='submit'>Delete</button>
                </form>
                <form class='editForm' method='POST' action='editComment.php'>
                    <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
                    <input type='hidden' name='userid' value='".$row['user_id']."'>
                    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
                    <input type='hidden' name='message' value='".$row['body']."'>
                    <button>Edit</button>
                </form>
                </div>";
        }
        else {
            echo "</div>";
        }
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

function editComment($conn){
    if(isset($_POST['commentEdit'])){
        $comment_id = $_POST['comment_id'];
        $userid = $_POST['userid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $message = $message."\n<br><br><i> Edited by: ".getUploader($conn,$_SESSION['id'])." on ".date('Y-m-d H:i:s').". </i>";

        $sql = "UPDATE comments SET body = '$message', updated_at='".date('Y-m-d')."' WHERE comment_id = $comment_id";
        $result = $conn->query($sql);
        echo mysqli_error($conn);


        $poem = getPoemByID($conn, $_SESSION['poem_id']);

        header("Location: view_poem.php?poem_name=".$poem['title']."&id=".$poem['uploader_id']);
    }
}

function getPoemByID($conn, $id){
    $sql = "SELECT * FROM translated_poems WHERE poem_id = '$id'";
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    return $row;
}

function deleteComment($conn){
    if(isset($_POST['commentDelete'])){
        $comment_id = $_POST['comment_id'];

        $sql = "DELETE FROM comments WHERE comment_id = $comment_id";
        $result = $conn->query($sql);
        echo mysqli_error($conn);


        $poem = getPoemByID($conn, $_SESSION['poem_id']);

        header("Location: view_poem.php?poem_name=".$poem['title']."&id=".$poem['uploader_id']);
    }
}
?>