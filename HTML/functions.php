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

function update_user($name,$pass,$conn){
    if($name!=''){
        $sql = 'UPDATE users SET username = \' ' . $name .' \' WHERE users.id = ' . $_SESSION['id'];
        if($conn->query($sql) === true){
            echo 'Name updated succesfuly<br>';
        }
    }
    if($pass!= ''){
        $sql = 'UPDATE users SET password = \' ' . $pass .' \' WHERE users.id = ' . $_SESSION['id'];
        if($conn->query($sql) === true){
            echo 'Pass updated succesfuly<br>';
        }
    }
}

function get_news($conn){
    $sql = 'SELECT * FROM COMMENTS WHERE user_id = ' . $_SESSION['id'] . ' order by created_at desc';
    $comm = $conn->query($sql);
    $commrez = $comm->fetch_assoc();
    $sql = 'SELECT * FROM POEMS WHERE uploader_id = ' . $_SESSION['id'] . ' order by created_at desc';
    $poems = $conn->query($sql);
    $poemsrez = $poems->fetch_assoc();
    $sql = 'SELECT * FROM TRANSLATED_POEMS WHERE uploader_id = ' . $_SESSION['id'] . ' order by created_at desc';
    $tpoems = $conn->query($sql);
    $tpoemsrez = $tpoems->fetch_assoc();
    for($i = 1; $i<4;$i++){
        if(mysqli_num_rows($comm)>=$i){
            echo '<li>' . get_news_text($commrez['comment_id'],0,$conn) . '</li>';
        }
        if(mysqli_num_rows($poems)>=$i){
            echo '<li>' . get_news_text($poemsrez['poem_id'],1,$conn) . '</li>';
        }
        if(mysqli_num_rows($tpoems)>=$i){
            echo '<li>' . get_news_text($tpoemsrez['poem_id'],2,$conn) . '</li>';
        }
    }

}

function get_news_text($id,$type,$conn){
    switch($type){
    case (0):
        $sql = 'SELECT * FROM COMMENTS WHERE comment_id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        $sql = 'SELECT * FROM POEMS WHERE poem_id = ' . $table['poem_id'] ;
        $title = $conn->query($sql);
        $title = $title->fetch_assoc();
        $return = '<article> <p>On the poem: ' . $title['title'] . ' you wrote:<br>"' .
        substr($table['body'],0,52) ;
        if(strlen($table['body'])<52){
            $return = $return . '"<br> And you got : ' . $table['upvotes'] .'votes!</p> </article>';
        }
        else{
            $return = $return . '..."<br> And you got : ' . $table['upvotes'] .'votes!</p> </article>';
        }
        return $return;
    break;
    case '1':
        $sql = 'SELECT * FROM POEMS where poem_id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        return '<article> <p>You added the poem: ' . $table['title'] . '
        <br>"' . substr($table['body'],0,52) . '..."</p> </article>';
    break;
    case '2':
        $sql = 'SELECT * FROM TRANSLATED_POEMS where poem_id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        return '<article> <p>You added the poem: ' . $table['title'] . '
        <br>"' . substr($table['body'],0,52) . '..."<br> with : ' . $table['upvotes'] .' votes!</p> </article>';
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