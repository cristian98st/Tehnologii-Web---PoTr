
<?php
if ($_POST['psw']==$_POST['psw-repeat']
    ) {
        require_once('functions.php');
        $conn = conn();
        add_user($_POST['user'],$_POST['email'],$_POST['psw'],$conn);
        end_conn($conn);
    }   
    else{
        echo "<p>Try inserting the same password</p>";
        die();
    }
?>