<?php
function add_user($name,$mail,$pass){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }

    $sql = 'INSERT INTO users VALUES (0,\'' . $name . '\',\'' . $mail . '\',\'' . $pass . '\',sysdate(),sysdate()) ';
    // echo $sql;

    if ($mysql->query($sql) === TRUE) {
        echo '<p>Registration succesful</p>';
    }
    else{
       die("Error");
    }
    $mysql->close();
}

function add_tpoem($title,$author,$text,$translated,$language){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }
}

function add_poem($title,$author,$text,$id){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }
    $sql = 'INSERT INTO poems VALUES (0,\'' . $title . '\',\'' . $author . '\',\'' . $text . '\',\'' . $id . '\',sysdate(),sysdate())';
    // echo $sql;
    
    if ($mysql->query($sql) === TRUE) {
        echo '<p>Poem added</p>';
    }
    else{
       die("Error");
    }
    $mysql->close();
}

?>