<?php
session_start();

include 'database.php';

$db_conn = get_connection();

if(isset($_POST["signup"])){
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$email = $_SESSION['email'];

	$fullname = $_REQUEST['fullname'];

	$ImageName = $_FILES['photo']['name'];
  $fileElementName = 'photo'; 
  $path = 'images/profile_pic/';
  $location = $path . $username . '.jpg'; 
  move_uploaded_file($_FILES['photo']['tmp_name'], $location);

	$desc = $_REQUEST['descrption'];
	$contact = $_REQUEST['contact'];
	$profession = $_REQUEST['profession'];

	$dob = $_REQUEST['dob'];
	$dob_mysql = date('Y-m-d', strtotime($dob));

	$sql_query = "INSERT INTO users(username, fullname, email, password, contact_no, profession, dob, description)
					values('$username', '$fullname', '$email', '$password', '$contact', '$profession', '$dob_mysql', '$desc');";

  $sql_query2 = "INSERT INTO follow(following, follower) values('$username', '$username')";

	if($db_conn->query($sql_query) && $db_conn->query($sql_query2)){
		$_SESSION['username'] = $username;
		$_SESSION['success'] = "You are now logged in";
		$subject = 'Sign Up Verification';
		$headers = 'From:nazmus.sakib.czs2012@gmail.com' . "\r\n";
		$message = 'Your account has been created';
		mail($email, $subject, $message, $headers);
		header('Location: index.php');
	} else {
		echo mysqli_error($db_conn);
	}
}
include 'html/background.html';
?>


<!DOCTYPE html>
<html>
<head>
</head>
<body>
    
    <div>
      <img src='images/jjjkkk.PNG' style='width:30%;display:block;margin:auto'>
      <div class="w3-card-4" style='background-color:#FAFAFA;width:40%;height:100%;margin-top:4vw;margin-bottom:4vw;margin-left:auto;margin-right:auto'>
          
        <div class="w3-container w3-center" style='background-color:gray;color:white'>
          <h2>Personal Info</h2>
        </div>

        <form class="w3-container" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" style='margin:2vw' enctype="multipart/form-data">
              <p>
              <label>Fullname</label>
              <input class='w3-input' type="text" name="fullname"> </p>
              <p>
              <label>Description</label>
              <input class='w3-input' type="text" name="descrption"> </p>
              <p>
              <label>Birthday</label>
              <input class='w3-input' type="date" name="dob"> </p>
              <p>
              <label>Profession</label>
              <input class='w3-input' type="text" name="profession"> </p>
              <p>
              <label>Contact No</label>
              <input class='w3-input' type="text" name="contact"> </p>
              <p>   
              <label>Profile Picture</label>
              <input class='w3-input' type="file" name="photo" id='fileToUpload'> </p>
              
              <input class='w3-button w3-grey w3-center' type="submit" name="signup" value="Confirm Signup">
        </form>
        <b style='padding-left:15px'>  Already a member? 
	     <a href="signin.php"><u>Sign In</u></a></b>
      </div>
    </div>
</body>