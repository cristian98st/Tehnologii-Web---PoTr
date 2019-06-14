<?php
    include 'dba.inc.php';
    include 'login.inc.php';
    session_start();
?>


<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Log in</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <?php
        $status = null;
        if(isset($_GET['status']))
            if($_GET['status']=="failed")
                $status = "Invalid credentials";

        echo "<form class='modal-content' action='".getLogin($connection)."' method='POST'>
            <div class='container'>
                <h1>Login</h1>
                <p style='color: #f44336;'>"
                .$status.
                "</p>
                <hr>

                <label for='uname'><b>Username</b></label>
                <input type='text' placeholder='Enter Username' name='uname' required>

                <label for='psw'><b>Password</b></label>
                <input type='password' placeholder='Enter Password' name='psw' required>

                <button type='submit' name = 'loginSubmit'>Login</button>
                <label>
                    <input type='checkbox' checked='checked' name='remember'> Remember me
                </label>
            </div>

            <div class='container' style='background-color:#353531'>
                <button type='button' onclick='window.history.go(-1)' class='cancelbtn'>Cancel</button>
                <span class='psw'><a href='#'>Forgot password?</a></span>
            </div>
        </form>"
    ?>
</body>

</html>