<?php
    function getLogin($conn) {
        if(isset($_POST['loginSubmit'])){
            $username = $_POST['uname'];
            $password = $_POST['psw'];

            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($sql);

            if(mysqli_num_rows($result) == 1){
                if($row = $result->fetch_assoc()){
                    $_SESSION['id'] = $row['id'];
                    header("Location: index.php?loginsuccess");
                    exit();
                }
            } else {
                // header("Location: index.php?loginfailed");
                // exit();

                echo "failed";
            }
        }
    }
?>