<?php
session_start();
include 'html/background.html';
include 'database.php';
include 'validate.php';

$errors = array();

$db_conn = get_connection();
$username = $_SESSION['username'];
//$errors = new array();

if(isset($_POST['fullname'])){
	$fullname = test_input($_REQUEST['Fullname']);
	$query = "UPDATE users SET fullname = '$fullname' WHERE username = '$username'";
	$db_conn->query($query) or die ($db_conn->error());
}

if(isset($_POST['email'])){
	$email = test_input($_REQUEST['Email']);
	$check_query = "SELECT * FROM users WHERE email = '$email'";
	$check = $db_conn->query($check_query) or die($db_conn->error());
	if($check->num_rows == 0){
		$query = "UPDATE users SET email = '$email' WHERE username = '$username'";
		$db_conn->query($query) or die($db_conn->error());
	} else {
		$errors['email'] = 'Email Exists!!!';
	}
}

if(isset($_POST['description'])){
	$description = test_input($_REQUEST['Description']);
	$query = "UPDATE users SET description = '$description' WHERE username = '$username'";
	$db_conn->query($query) or die($db_conn->error());
}

if(isset($_POST['profession'])){
	$profession = test_input($_REQUEST['Profession']);
	$query = "UPDATE users SET profession = '$profession' WHERE username = '$username'";
	$db_conn->query($query) or die($db_conn->error());
}

if(isset($_POST['password'])){
	$old_password = sha1(test_input($_REQUEST['old_password']));
	$password1 = test_input($_REQUEST['password1']);
	$password2 = test_input($_REQUEST['password2']);

	$old_password_query = "SELECT password FROM users WHERE username = '$username'";
	$password = $db_conn->query($old_password_query);
	$password = $password->fetch_assoc();
	$password = $password['password'];
	if($old_password != $password){
		$errors['password'] = 'Enter the correct current password';
	} else if($password1 != $password2){
		$errors['password'] = 'passwords do not match';
	} else if(strlen($password1) < 8){
        $errors['password'] = 'Password too short';
    } else {
        $password1 = sha1($password1);
		$query = "UPDATE users SET password = '$password1' WHERE username = '$username'";
		$db_conn->query($query) or die($db_conn->error());
	}
}

if(isset($_POST['pro_pic'])){
	$ImageName = $_FILES['photo']['name'];
    $fileElementName = 'photo'; 
    $path = 'images/profile_pic/';
    $location = $path . $username . '.jpg';
    if(file_exists($location)){
 		//echo "<img src='images/profile_pic/" . $username . ".jpg' >";
    	chmod($location, 0777);
    	unlink($location);
    } 
    move_uploaded_file($_FILES['photo']['tmp_name'], $location);
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/newsfeed.css">
</head>
<body style="background-color:#FAFAFA;font-family:Arial;margin:0">
    <div class='navbar' >
      <div style="width:80%;margin:auto;">
        <ul>
          <li><a style='padding:0' href='home.php'><img style='width:140px;height:52px;float:left;text-decoration: none;display: inline-block;' src='images/jjjkk.PNG' ></a></li>
            <form style='display:inline-block' action='search.php'><input type='text' name='searchField' placeholder="Search..." class='searchbar'></form>
            <li style="float:right"><a style='padding:0;margin:0;' href='profile.php'><img src='images/profile.jpg' class='newsfeed_icon'></a></li>
            <li style="float:right"><a style='padding:0;margin:0;' href='message.php'><img src='images/msg.png' class='newsfeed_icon'></a></li>
            <li style="float:right"><a style='padding:0;margin:0;' href='navigation.php'><img src='images/navigation.png' class='newsfeed_icon'></a></li>
               
        </ul>
      </div>
    </div>
    <div style='background-color:#FAFAFA'>
      <div class="w3-card-4" style='background-color:#FAFAFA;width:40%;height:100%;margin-top:4vw;margin-left:auto;margin-right:auto'>
        
        <div class="w3-container w3-center" style='background-color:gray;color:white'>
          <h2>Edit Profile</h2>
        </div>
          
        <form class="w3-container" action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' style='margin:2vw' method='post'>
            <p><label>Fullname</label>
            <input class='w3-input' type="text" name="Fullname"></p>
            <input class='w3-button w3-grey w3-center' type="submit" name="fullname" value="Change">
        </form>  
          
        <form class='w3-container' action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post' style='margin:2vw'>
            <p><label>Change Email</label>
            <input class='w3-input' type="email" name="Email"> <?php if(isset($errors['email'])) echo $errors['email']; ?></p>
            <input class='w3-button w3-grey w3-center' type="submit" name="email" value="Change">
        </form>  
          
        <form class='w3-container' action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post' style='margin:2vw'>
            <p><label>Change Password:</label><br>
            <label>Old Password</label>
            <input class='w3-input' type="password" name="old_password"> <?php if(isset($errors['password'])) echo $errors['password']; ?>
            <label>New Password</label>
            <input class='w3-input' type="password" name="password1"> </p>
            <p><label>Confirm Password</label>
            <input class='w3-input' type="password" name="password2"> </p>
            <input class='w3-button w3-grey w3-center' type="submit" name="password" value="Change">
        </form>
        <form class='w3-container' action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post' style='margin:2vw'>
            <p><label>Change Description</label>
            <input class='w3-input' type="text" name="Description"> <?php if(isset($errors['email'])) echo $errors['email']; ?></p>
            <input class='w3-button w3-grey w3-center' type="submit" name="description" value="Change">
        </form>
        <form class='w3-container' action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post' style='margin:2vw;'>
            <p><label>Change Profession</label>
            <input class='w3-input' type="text" name="Profession"> <?php if(isset($errors['email'])) echo $errors['email']; ?></p>
            <input class='w3-button w3-grey w3-center' type="submit" name="profession" value="Change">
        </form> 
        <form class='w3-container' action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post' style='margin:2vw' enctype="multipart/form-data">
            <p><label>Profile Picture</label>
            <input class='w3-input' type="file" name="photo" id="fileToUpload"> </p>
            <input class='w3-button w3-grey w3-center' type="submit" name="pro_pic" value="Change">
        </form>  
          <hr>
   
      </div>
    </div>
	
	
</body>