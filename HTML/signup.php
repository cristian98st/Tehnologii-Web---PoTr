<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <title>Sign up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <form class="modal-content">
        <div class="container">
            <h1>Sign Up</h1>
            <p>All field are compulsory for creating a new account.</p>
            <hr>

            <label for="username"><b>Username</b></label>
            <input type='text' placeholder='Enter User' name = 'user' required>

            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>

            <label for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

            <button type="submit" onclick="location.href='index_loggedin.html'">Sign up</button>

            <div class="container" style="background-color:#353531">
                <button type="button" onclick="window.history.go(-1)" class="cancelbtn">Cancel</button>
            </div>
        </div>
    </form>
</body>

</html>
<?php
if (
    isset($_GET['user']) and !empty($_GET['user'])
    and isset($_GET['email']) and !empty($_GET['email'])
    and isset($_GET['psw']) and !empty($_GET['psw'])
    and isset($_GET['psw-repeat']) and !empty($_GET['psw-repeat'])
    and $_GET['psw']==$_GET['psw-repeat']
    ) {
        $name = $_GET['user'];
        $mail = $_GET['email'];
        $pass1 = $_GET['psw'];
        $pass2 = $_GET['psw-repeat'];
        require_once('functions.php');
    add_user($_GET['user'],$_GET['email'],$_GET['psw']);
}
?>