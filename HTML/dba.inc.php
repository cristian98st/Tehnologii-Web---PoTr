<?php
    $connection = new mysqli("localhost", "root", "", "potr");

    if(!$connection){
        die("Connection failed: " . mysqli_connect_error());
    }

?>