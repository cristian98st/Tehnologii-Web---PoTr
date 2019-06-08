<?php
date_default_timezone_set('Europe/Bucharest');

function initNotificationBox($conn, $user){

    $sql = "SELECT * FROM subscribers WHERE subscriber_id = '".$user['id']."'";
    
    $result = $conn->query($sql);

    echo '<div class="formNotification">
        <select class="selectNotification" name="formNotification" onChange = "location = this.value">
        <option style="background-image:url("notification_icon.png");"></option>';
        while($subscribee = $result->fetch_assoc()){
            $sql = "SELECT * FROM translated_poems WHERE uploader_id = '".$subscribee['user_id']."'";
            $result2 = $conn->query($sql);
            $uploader = getUser($conn, $subscribee['user_id']);

            while($poem = $result2->fetch_assoc()){
                if($poem['created_at'] >= $user['last_loggin']){
                    echo '<option value="view_poem.php?poem_name='.$poem['title'].'&id='.$uploader['id'].'">'.$uploader['username'].' has added a new translation: '.$poem['title'].' </option>';
                }
                if($poem['updated_at'] >= $user['last_loggin']){
                    echo '<option value="view_poem.php?poem_name='.$poem['title'].'&id='.$uploader['id'].'">'.$uploader['username'].' has modified a translation: '.$poem['title'].' </option>';
                }
            }
        }
        echo '</select></div>';

}

?>