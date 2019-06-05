<?php
function add_user($name,$mail,$pass){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }

    $sql = 'INSERT INTO users VALUES (0,\'' . $name . '\',\'' . $mail . '\',\'' . $pass . '\',sysdate(),sysdate()) ';
    echo $sql;
    if ($mysql->query($sql) === TRUE) {
        echo '<p>Registration succesful</p>';
    }
    else{
       die("Error");
    }
    $mysql->close();
}

?>