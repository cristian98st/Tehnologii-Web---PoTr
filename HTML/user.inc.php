<?php

function getUser($conn, $id){
    $sql = "SELECT * FROM users WHERE id = '$id'";

    $result = $conn->query($sql);

    $rtnValaue = $result->fetch_assoc();
    return $rtnValaue;
}

?>