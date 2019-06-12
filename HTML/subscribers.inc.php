<?php
date_default_timezone_set('Europe/Bucharest');

function setSubscriber($conn, $subscriber, $subscrebee){
    $sql = "INSERT INTO subscribers(user_id, subscriber_id, created_at, updated_at) VALUES('$subscrebee', '$subscriber', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."'";
    $result = $conn->query($sql);

}

?>