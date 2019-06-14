<?php
function conn(){
    $mysql = new mysqli ('localhost', 'root','','potr');
    
    if (mysqli_connect_errno()) {
        die ('Conexiunea a esuat...');
    }
    return $mysql;
}

function add_user($name,$mail,$pass,$conn){
    $sql = 'INSERT INTO users VALUES (0,\'' . $name . '\',\'' . $mail . '\',\'' . $pass . '\',sysdate(),sysdate(),sysdate()) ';
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo '<p>Registration succesful</p>';
    }
    else{
       die("Error");
    }
}

function add_tpoem($title,$author,$ortitle,$text,$language,$id,$conn){
    $sql = 'SELECT * FROM poems where title like "%' . $ortitle . '%"';
    $title1 = $conn->query($sql);
    if(mysqli_num_rows($title1)!=1){
        die("Error");
    }
    else{
    $title1 = $title1->fetch_assoc();
    $text = mysqli_real_escape_string($conn, $text);
    $sql = 'INSERT INTO translated_poems VALUES (0,\'' . $title1['poem_id'] . '\',\'' . $language . '\',\'' . $title . '\',\'' . $author . '\',0,0,\'' . $text . '\',' . $id .',sysdate(),sysdate())';
    // echo $sql;
    
    if ($conn->query($sql) === TRUE) {
        echo '<p>Poem added</p>';
    }
    else{
       die("Error");
    }
    $sql = 'SELECT max(poem_id) FROM translated_poems';
    $res = $conn->query($sql);
    $newid = $res->fetch_row();

    $sql = 'INSERT INTO translates VALUES(' .$title1['poem_id'].  ',' .$newid[0] . ')';
    if ($conn->query($sql) === TRUE) {
        echo '<p>Translation added</p>';
    }
    else{
       die("Error");
    }

}
}

function update_user($name,$pass,$conn,$id){
    if($name!=''){
        $sql = 'UPDATE users SET username = \'' . $name .'\' WHERE users.id = ' . $id;
        if($conn->query($sql) === true){
            echo 'Name updated succesfuly<br>';
        }
    }
    if($pass!= ''){
        $sql = 'UPDATE users SET password = "' . $pass .'" WHERE users.id = ' . $id;
        if($conn->query($sql) === true){
            echo 'Pass updated succesfuly<br>';
        }
    }
}

function get_news($conn,$id){
    $sql = 'SELECT * FROM COMMENTS WHERE user_id = ' . $id . ' order by created_at desc';
    $comm = $conn->query($sql);
    $commrez = $comm->fetch_assoc();
    $sql = 'SELECT * FROM POEMS WHERE uploader_id = ' . $id . ' order by created_at desc';
    $poems = $conn->query($sql);
    $poemsrez = $poems->fetch_assoc();
    $sql = 'SELECT * FROM TRANSLATED_POEMS WHERE uploader_id = ' . $id . ' order by created_at desc';
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

function get_news_bydate($conn,$id,$date){
    $sql = 'SELECT * FROM COMMENTS WHERE user_id = ' . $id . ' order by created_at desc';
    $comm = $conn->query($sql);
    
    $sql = 'SELECT * FROM POEMS WHERE uploader_id = ' . $id . ' order by created_at desc';
    $poems = $conn->query($sql);
    
    $sql = 'SELECT * FROM TRANSLATED_POEMS WHERE uploader_id = ' . $id . ' order by created_at desc';
    $tpoems = $conn->query($sql);
    
    for($i = 1; $i<max(mysqli_num_rows($comm),mysqli_num_rows($poems),mysqli_num_rows($tpoems));$i++){
        if(mysqli_num_rows($comm)>=$i){
            $commrez = $comm->fetch_assoc();
            if(strtotime($commrez['created_at']) > strtotime($date)){
                echo '<li>' . get_news_text_bydate($commrez['comment_id'],0,$conn) . '</li>';
            }
        }
        if(mysqli_num_rows($poems)>=$i){
            $poemrez = $poems->fetch_assoc();
            if(strtotime($poemrez['created_at']) > strtotime($date)){
                echo '<li>' . get_news_text_bydate($poemrez['poem_id'],1,$conn) . '</li>';
            }    
        }
        if(mysqli_num_rows($tpoems)>=$i){
            $tpoemsrez = $tpoems->fetch_assoc();
            if(strtotime($tpoemsrez['created_at']) > strtotime($date)){
                echo '<li>' . get_news_text_bydate($tpoemsrez['poem_id'],2,$conn) . '</li>';
            }
        }
    }
}

function get_ann($conn,$id){
    $sql = 'SELECT * FROM annotations where poem_id = ' . $id . ' order by verse_number asc';
    // echo $sql;
    $rez = $conn->query($sql);
    if(mysqli_num_rows($rez)>0){
        echo '<h4> Annotations:</h4>';
        while($line = $rez->fetch_assoc()){
            echo '<p><b>'. $line['verse_number'] . '</b> ' . $line['body'] . ' </p>';
        }
        $ret='<form action = "add_ann.php" method = "post">
        <input type="number" max="';
        $sql = 'SELECT * FROM translated_poems where poem_id = ' .$id;
        $rows = $conn->query($sql)->fetch_assoc();
        $array= explode("\n", $rows['body']);
        $ret = $ret . count($array);
        $ret = $ret . '" min="1" name="line" step="1" value="1" />
        <br />
        <textarea placeholder="Add new adnotation.." name = "text"></textarea></form>';
        echo $ret;
    }
    else{
        echo 'No annotations';
    }
}

function get_feed($conn,$id){
    $sql = 'SELECT * FROM SUBSCRIBERS WHERE user_id = ' . $id;
    $arr = $conn->query($sql);

    while($rez = $arr->fetch_assoc()){
        get_news($conn,$rez['subscriber_id']);
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
        $sql = 'SELECT * FROM users WHERE id = ' . $id ;
        $name = $conn->query($sql);
        $name = $name->fetch_assoc();
        $return = '<article><p>' . $name['username'] . ' commented on the poem <a href = "view_poem.php?poem_name=' . $title['title'] .'&id='. $title['uploader_id'] .'">"' . $title['title'] . '"</a>:<br>"' . substr($table['body'],0,100) ;
        // $return = '<article> <p>Commented on the poem ' . $title['title'] . '":<br>"' . substr($table['body'],0,100) ;
        if(strlen($table['body'])<100){
            $return = $return . '"<br> with : ' . $table['upvotes'] .' votes!</p></article>';
        }
        else{
            $return = $return . '..."<br> with : ' . $table['upvotes'] .' votes!</p></article>';
        }
        return $return;
    break;
    case '1':
        $sql = 'SELECT * FROM POEMS where poem_id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        $sql = 'SELECT * FROM users WHERE id = ' . $table['poem_id'] ;
        $title = $conn->query($sql);
        $title = $title->fetch_assoc();
        $sql = 'SELECT * FROM users WHERE id = ' . $id ;
        $name = $conn->query($sql);
        $name = $name->fetch_assoc();
        return '<article><p>' . $name['username'] . ' added the poem: <a href = "view_poem.php?poem_name=' . $table['title'] . '&id=' . $table['uploader_id'] . '">"' . $table['title'] . '
        "</a><br>"' . substr($table['body'],0,100) . '..."</p></article>';
        // return '<article><p>Added the poem: "' . $table['title'] . '
        // "<br>"' . substr($table['body'],0,100) . '..."</p></article>';
    break;
    case '2':
        $sql = 'SELECT * FROM TRANSLATED_POEMS where poem_id = ' . $id ;
        $table = $conn->query($sql);
        $table = $table->fetch_assoc();
        $sql = 'SELECT * FROM users WHERE id = ' . $id ;
        $name = $conn->query($sql);
        $name = $name->fetch_assoc();
        return '<article><p>' . $name['username'] . ' added the translation to: <a href = "view_poem.php?poem_name=' . $table['title'] . '&id=' . $table['uploader_id'] . '">"' . $table['title'] . '"</a>
        <br>"' . substr($table['body'],0,100) . '..."<br> with : ' . $table['upvotes'] .' votes!</p></article>';
        // return '<article><p>Added the translation to: "' . $table['title'] . '"
        // <br>"' . substr($table['body'],0,100) . '..."<br> with : ' . $table['upvotes'] .' votes!</p></article>';
    }
}

function get_subs($conn,$id){
    $sql = 'SELECT COUNT(*) FROM subscribers where subscriber_id = ' . $id;
    $sub_to = $conn->query($sql);
    $sql = 'SELECT COUNT(*) FROM subscribers where user_id = ' . $id;
    $sub_from = $conn->query($sql);
    $sub_to = $sub_to->fetch_row();
    $sub_from = $sub_from->fetch_row();
    $rez = array($sub_to[0],$sub_from[0]);
    return $rez;
}

function get_userinfo($conn,$id){
    $sql = 'SELECT * FROM users where id = ' . $id;
    $inf = $conn->query($sql);
    return $inf;
}

function add_poem($title,$author,$text,$id,$conn){
    $text = mysqli_real_escape_string($conn, $text);
    $sql = 'INSERT INTO poems VALUES (0,\'' . $title . '\',\'' . $author . '\',\'' . $text . '\',\'' . $id . '\',sysdate(),sysdate())';
    // echo $sql;
    
    if ($conn->query($sql) === TRUE) {
        echo '<p>Poem added</p>';
    }
    else{
       die("Error");
    }
}

function Rss_GetFeed(){
    $con = conn();
    $sql = 'SELECT * FROM `translated_poems` WHERE updated_at + 7 > sysdate()';
    $resset = $con->query($sql);
    $details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
    <rss version="2.0">
     <channel>
      <title>Potter</title>
      <link>http://localhost/HTML/index.php</link>
      <description>An app for translating, commenting and annotating poems.</description>
      <language>en-us</language>
      <image>
       <title>Potter</title>
       <url>http://pluspng.com/img-png/feather-pen-png-black-and-white-size-512.png</url>
       <link>http://localhost/HTML/index.php</link>
       <width>50</width>
       <height>50</height>
      </image>';
      $items = '';
    while($rez = $resset->fetch_assoc()){
        $items .= '<item>
         <title>'. $rez["title"] .'</title>
         <link>http://localhost/HTML/view_poem.php?poem_name="'. $rez["title"] . '"&amp;id="'. $rez["uploader_id"] .'"</link>
         <description>' . substr($rez["body"],0,200) .'</description>
        </item>';
       }
    echo $details . $items . '</channel></rss>';
    end_conn($con);
}

function end_conn($conn){
    $conn->close();
}

?>
