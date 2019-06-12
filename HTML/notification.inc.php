<?php
date_default_timezone_set('Europe/Bucharest');
// include "notification.inc.js";

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
                    // $_SESSION['isNotificationVisible'] = "true";
                }
                if($poem['updated_at'] >= $user['last_loggin']){
                    echo '<option value="view_poem.php?poem_name='.$poem['title'].'&id='.$uploader['id'].'">'.$uploader['username'].' has modified a translation: '.$poem['title'].' </option>';
                    // $_SESSION['isNotificationVisible'] = "true";
                }
            }
        }
        echo '</select></div>';


        // if(isset($result)){
        //     if(isset($subscribee)){
        //         if($result2->num_rows == 1){
        //             $message = "You have ".$result2->num_rows. " new notification.";
        //             showNotification($message);
        //         }
        //         else if($result2->num_rows > 1){
        //             $message = "You have ".$result2->num_rows. " new notifications.";
        //             showNotification($message);
        //         }
        //     }
        // }
}

// function showNotification($message){
//     echo '<form method="POST" class="offNotification" action="'.offNotification().'" 
//     <input type="button" name="overlay_notification" id ="overlay_notification" value="'.$message.'">
//     </form>';
// }

// function offNotification(){
//     if(isset($_POST['offNotification'])){
//     $_SESSION['isNotificationVisible'] = "false";

//     header('Location: index.php');
//     }
// }

?>