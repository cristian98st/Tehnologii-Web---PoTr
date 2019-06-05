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
  if(isset($_GET['email']) and !empty($_GET['code'])
      and isset($_GET['month']) and !empty($_GET['month'])){
      $code = htmlspecialchars($_GET['code']);
      $month = htmlspecialchars($_GET['month']);
      $holidays = json_decode(
          file_get_contents('https://date.nager.at/api/v2/publicholidays/'.date('Y').'/'. $code),
          true);
      $count = 0;
      foreach ($holidays as $holiday){
          $date = explode("-", $holiday['date']);
          $my_month = $date[1];
          if((int)$my_month == (int)$month){
              echo $holiday['localName'] . ' on '. $holiday['date'] . '<br>';
              $count = $count +1;
          }
      }
      if($count == 0){
          echo 'Nu exista sarbatori pentru '. $code . ' in luna '. $month;
      }
  }
  else{
      echo 'astept input corect';
  }
?>