<?php
session_start();
if (!isset($_SESSION['success'])){
    header('Location: signin.php');
} else {
  include 'database.php';
  include 'helper.php';
  $db_conn = get_connection();

  $username = $_SESSION['username'];

  $row = get_info($username);

  $posts = get_posts($username);
}
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/newsfeed.css">
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


<div class='postbox' id='postbox'>  
</div>

<button onclick='loadmore(this)' class='loadbutton'>Load More...</button>
    
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
</div>    
    
<script src="js/home.js"></script> 

</body>
</html>