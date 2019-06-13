<?php
date_default_timezone_set('Europe/Bucharest');

function setSubscriber($conn, $subscriber, $subscrebee){
    if(isset($_POST['subscribeSubmit'])){
        $sql = "INSERT INTO subscribers(user_id, subscriber_id, created_at, updated_at) VALUES('$subscrebee', '$subscriber', '".date('Y-m-d')."', '".date('Y-m-d')."')";
        $result = $conn->query($sql);
        
        $location = "Location: user_info.php?uid=".$subscrebee;
        header($location);
    }
}

function isSubscribed($conn, $subscirber, $subscrebee){
    $sql = "SELECT * FROM subscribers WHERE subscriber_id='$subscirber' AND user_id='$subscrebee'";
    $result = $conn->query($sql);

    if(($row = $result->fetch_assoc()) != null)
        return TRUE;
    
    return FALSE;
}

?>