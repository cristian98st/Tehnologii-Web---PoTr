<?php
function conn(){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }
    return $mysql;
}

function add_user($name,$mail,$pass,$conn){
    $sql = 'INSERT INTO users VALUES (0,\'' . $name . '\',\'' . $mail . '\',\'' . $pass . '\',sysdate(),sysdate()) ';
    // echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo '<p>Registration succesful</p>';
    }
    else{
       die("Error");
    }
}

function add_tpoem($title,$author,$text,$translated,$language,$conn){

}

function get_news($conn){

}

function get_news_comm($comment_id,$conn){
    $sql = 'SELECT * FROM COMMENTS WHERE ID == ' .$comment_id . ' ORDER BY CREATED_AT';
}

function get_news_poem($poem_id,$translated,$conn){
    if($translated==true){
        $sql = 'SELECT * FROM poems';

    }
    
}

function get_subs($conn){
    $sql = 'SELECT COUNT(*) FROM subscribers where subscriber_id = ' . $_SESSION['id'];
    $sub_to = $conn->query($sql);
    $sql = 'SELECT COUNT(*) FROM subscribers where user_id = ' . $_SESSION['id'];
    $sub_from = $conn->query($sql);
    $sub_to = $sub_to->fetch_row();
    $sub_from = $sub_from->fetch_row();
    $rez = array($sub_to[0],$sub_from[0]);
    return $rez;
}

function get_userinfo($conn){
    $sql = 'SELECT * FROM users where id = ' . $_SESSION['id'];
    $inf = $conn->query($sql);
    return $inf;
}

function add_poem($title,$author,$text,$id,$conn){
    $sql = 'INSERT INTO poems VALUES (0,\'' . $title . '\',\'' . $author . '\',\'' . $text . '\',\'' . $id . '\',sysdate(),sysdate())';
    // echo $sql;
    
    if ($conn->query($sql) === TRUE) {
        echo '<p>Poem added</p>';
    }
    else{
       die("Error");
    }
}

function end_conn($conn){
    $conn->close();
}

?>