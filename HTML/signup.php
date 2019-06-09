
<?php
if ($_GET['psw']==$_GET['psw-repeat']
    ) {
        require_once('functions.php');
        add_user($_GET['user'],$_GET['email'],$_GET['psw']);
    }   
    else{
        echo "<p>Try inserting the same password</p>";
        die();
    }
?>