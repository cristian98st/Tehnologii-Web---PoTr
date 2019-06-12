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
    $sql = 'SELECT * FROM COMMENTS WHERE user_id = ' . $_SESSION['id'] . ' order by created_at desc';
    $comm = $conn->query($sql)->fetch_assoc();
    $sql = 'SELECT * FROM POEMS WHERE uploader_id = ' . $_SESSION['id'] . 'order by created_at desc';
    $poems = $conn->query($sql)->fetch_assoc();
    $sql = 'SELECT * FROM TRANSLATED_POEMS WHERE uploader_id = ' . $_SESSION['id'] . 'order by created_at desc';
    $tpoems = $conn->query($sql)->fetch_assoc();
    for($i = 0; $i<3;$i++){
        if($i+1<=$comm->num_rows){
            echo '<li>' . get_news_poem($comm['id'],0,$conn) . '</li>';
        }
        if($i+1<=$poems->num_rows){
            echo '<li>' . get_news_poem($poems['id'],1,$conn) . '</li>';
        }
        if($i+1<=$tpoems->num_rows){
            echo '<li>' . get_news_poem($tpoems['id'],2,$conn) . '</li>';
        }
    }

}

function get_news_poem($id,$type,$conn){
    switch($type){
    case (0):
        $sql = 'SELECT * FROM COMMENTS where id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        $sql = 'SELECT * FROM POEMS where id = ' . $table['poem_id'] ;
        $title = $conn->query($sql);
        $title = $title->fetch_assoc();
        return '<article> <h4>On the poem: ' . $title['title'] . ' you wrote</h4>
        <p>' . substr($table['body'],0,20) . '</p> </article>';
    break;
    case '1':
        $sql = 'SELECT * FROM POEMS where id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        return '<article> <h4>You added the poem: ' . $table['title'] . '</h4>
        <p>' . substr($table['body'],0,20) . '</p> </article>';
    break;
    case '2':
        $sql = 'SELECT * FROM TRANSLATED_POEMS where id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        return '<article> <h4>You added the poem: ' . $table['title'] . '</h4>
        <p>' . substr($table['body'],0,20) . '</p> </article>';
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