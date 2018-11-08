<?php
session_start();
include 'database.php';

$db_conn = get_connection();
if(isset($_POST["login"])){
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $password = sha1($password);

  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db_conn, $query);
    if (mysqli_num_rows($results) == 1) {
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
    }else {
        $errors['error'] = "wrong username or password";
    }
  include 'html/background.html';
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>
<body>
    <div>
      <img src='images/jjjkkk.PNG' style='width:30%;display:block;margin:auto'>
      <div class="w3-card-4" style='background-color:#FAFAFA;width:40%;height:100%;margin-top:4vw;margin-bottom:4vw;margin-left:auto;margin-right:auto'>
          
        <div class="w3-container w3-center" style='background-color:gray;color:white'>
          <h2>Signin form</h2>
        </div>

        <form class="w3-container" action="signin.php" method="post" style='margin:2vw'>
              <p style='color:red;'><?php if(isset($errors['error'])) echo $errors['error']; ?></p>
              <p>
              <label>Username</label>
              <input class='w3-input' type="text" name="username"> </p>
              <p>   
              <label>Password</label>
              <input class='w3-input' type="password" name="password"></p>
              
              <input class='w3-button w3-grey w3-center' type="submit" name="login" value="Sign in">
        </form>
        
        <b style='padding-left:15px;'>  Not a member? 
	     <a href="signup.php"><u>Sign Up</u></a></b>
      </div>
    </div>
  
</body>
</html>
