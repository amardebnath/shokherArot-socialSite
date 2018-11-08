<?php
session_start();
include 'database.php';
include 'validate.php';

$errors = array();

$db_conn = get_connection();

//$errors = new array();

if(isset($_POST["next"])){
	$username = $_REQUEST['username'];
	$password1 = $_REQUEST['password1'];
	$password2 = $_REQUEST['password2'];
	$email = $_REQUEST['email'];

	$username = test_input($username);
	$password1 = test_input($password1);
	$password2 = test_input($password2);

	$check_query = "SELECT * FROM users WHERE username = '$username'";

	$check_username = $db_conn->query($check_query);

	if($check_username->num_rows > 0){
		$errors['username'] = 'Username already taken';
	} else if(empty($username)){
		$errors['username'] = 'Username can not be empty';
	}

	$check_query = "SELECT * FROM users WHERE email = '$email'";

	$check_email = $db_conn->query($check_query);
	if($check_email->num_rows > 0){
		$errors['email'] = 'Email already taken';
	} else if(empty($email)){
		$errors['email'] = 'Email can not be empty';
	}

	if($password1 != $password2){
		$errors['password'] = 'Passwords do not match';
	} else if(strlen($password1) < 8){
		$errors['password'] = 'Password too short';
	}

	if(empty($errors)){
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		$_SESSION['password'] = sha1($password1);
		header('Location: personalinfo.php');
	}
}

include 'html/background.html';
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/w3.css">
</head>
<body >
    <div>
      <img src='images/jjjkkk.PNG' style='width:30%;display:block;margin:auto'>
      <div class="w3-card-4" style='background-color:#FAFAFA;width:40%;height:100%;margin-top:4vw;margin-bottom:4vw;margin-left:auto;margin-right:auto'>
          
        <div class="w3-container w3-center" style='background-color:gray;color:white'>
          <h2>Signup form</h2>
        </div>

        <form action='signup.php' method='post' class="w3-container" style='margin:2vw'>
              <p>
              <label>Username</label>
              <input class='w3-input' type="text" name="username"> <?php if(isset($errors['username'])) echo $errors['username']; ?> </p>
              <p>   
              <label>Email</label>
              <input class='w3-input' type="email" name="email"> <?php if(isset($errors['email'])) echo $errors['email']; ?></p>
              <p>   
              <label>Password</label>
              <input class='w3-input' type="password" name="password1"> <?php if(isset($errors['password'])) echo $errors['password']; ?></p>
              <p>   
              <label>Confirm Password</label>
		      <input class='w3-input' type="password" name="password2"></p>
              <input class='w3-button w3-grey w3-center' type="submit" name="next" value="Next">
        </form>
        <b style='padding-left:15px'>  Already a member? 
	     <a href="signin.php"><u>Sign in</u></a></b>
      </div>
    </div>
</body>