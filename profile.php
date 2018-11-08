<?php
session_start();
include 'post.php';
include 'helper.php';

if (!isset($_SESSION['success'])){
    header('Location: signin.php');
}

$user = $_SESSION['username'];
$is_users_profile = true;
if(isset($_REQUEST['username']) && $user != $_REQUEST['username']){
    $username = $_REQUEST['username'];
    $is_users_profile = false;
    if(isset($_POST['follow'])){
        follow($user, $username);
    } else if(isset($_POST['unfollow'])){
        unfollow($user, $username);
    }
    $is_following = get_is_following($user, $username);
} else {
    $username = $user;
}

$db = get_connection();

$row = get_info($username);
$fullname = $row['fullname'];
$profession = $row['profession'];

if(isset($_POST['post_item'])){
    post($row['username'], $db);
}

$post_query = "SELECT * FROM posts WHERE postmaker = '$username'";
$posts = $db->query($post_query) or die($posts->error());
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/profile1.css">
    <script src="js/jquery-3.3.1.js"></script> 
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
    
<div class='postbox'>
    <div style='width:100%; height:20vw;margin-bottom: 20px;'>
        <div style='width: 33%;height:100%;display: inline-block;position: relative;overflow: hidden;'>
            <img src='images/profile_pic/<?php echo $username ?>.jpg' class='profilepic'>
            <?php 
            if(!$is_users_profile){
                if(!$is_following){
                    echo "<form action = 'profile.php?username=" . $username ."' method = 'post'>
                        <input class='followbutton' type = 'submit' name = 'follow' value = 'Follow'>";
                }
                else {
                    echo "<form action = 'profile.php?username=" . $username ."' method = 'post'>
                        <input class='followbutton' type = 'submit' name = 'unfollow' value = 'Following'>";
                }
            }
            ?>
        </div>
        
        <div class='profile_description'>
            <div style='display: table;margin-top: 20px;text-align: center;margin-left: auto;margin-right: auto'>
                <b style='font-size: 25px'><?php echo $fullname; ?></b><img id='settingsbutton' style='cursor:pointer;margin-left:1vw;height:2vw;width:2vw' src='images/settings.png'><br>
                <span style='font-size: 15px'><?php echo $profession; ?></span>
            </div>
            <div style='display: table;height: 40px;width:100%;margin-top: 25px;'>
                <div style='width:70%;height: 100%;margin-left: auto;margin-right: auto'>
                    <div class='number'>
                        <b><?php echo $row['num_posts']; ?></b> Posts
                    </div>
                    <div class='number'>
                        <b><?php echo $row['num_follower']; ?></b> Followers
                    </div>
                    <div class='number'>
                        <b><?php echo $row['num_following']; ?></b> Following
                    </div>
                </div>
                
            </div>
            <div style='display: table;height: 40px;width:100%;margin-top: 15px;text-align: center'>
                <b id='user'><?php echo $username; ?></b> <?php echo $row['description']; ?>
            </div>
            
        </div>
    
    </div>
    <hr>
</div>
    <?php
    if($is_users_profile){
        echo "<button id='myBtn' class='postbutton'>Post an item</button>";
    }
    ?>
<div id='postbox' class='postbox' style='background-color:#FAFAFA;margin-top: 20px;'>    
</div>
    
<button onclick='loadmore(this)' class='postbutton' style='margin-top:30px;margin-bottom:30px;'>Load More...</button>    
    
    
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <form action="profile.php" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" id="fileToUpload"> <br>
        <input type="textarea" name="description" value='description' style='width:100%;height:30px'> <br>
        Buy Option <input type="checkbox" name="checkbox[]" value="buy_option"> <br>
        Price <input type="number" name="price" value = "10"> <br>
        Bidding Option <input type="checkbox" name="checkbox[]" value="bidding_option"> <br>
        Starting Price <input type="number" name="start_price" value="5"> <br>
        <input type="submit" value="Post Item" name="post_item">
    </form>
  </div>
</div>
    
<div id="settingsModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
        <br>
        <button class='postbutton' onclick='edit()'>Edit Profile</button><br>
        <button class='postbutton' onclick='logout()'>Log Out</button>
  
  </div>
</div>    
    
    
<script src='js/profile.js'></script>
<script src='js/profile1.js'></script>

</body>
</html>