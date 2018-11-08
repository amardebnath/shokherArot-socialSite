<?php
  session_start();
  include 'database.php';

  $username = $_SESSION['username'];
  $db = get_connection();

  $query = "SELECT username FROM users WHERE username in (SELECT sender FROM messages WHERE receiver = '$username') or username in (SELECT receiver FROM messages
                                                                                                                    WHERE sender = '$username')" ;

  $result = $db->query($query) or die($db->error());

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/message.css">
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
    
    <div  class='postbox' style='height:100%'>
        <div id='msgbox' style='background-color:white;border:1px solid gray; border-radius:2px;margin:0 auto; max-width:800px; padding:0 20px;overflow:auto;max-height:70%'>
        </div>

        <div style='background-color:#FAFAFA;border-radius:2px;margin:5px auto; max-width:800px; padding-left:0px;overflow:auto;max-height:70%'>
            <textarea id='username' rows='3' onkeyup='sendMessage(event, this)' placeholder='Type a message and hit Enter to send...' style='background-color:#FAFAFA;width:100%;margin:0 auto;max-width:800px;border-radius:2%;border:1px solid gray'></textarea>
        </div>
        
       <div style='background-color:#FAFAFA;border-radius:2px;margin:5px auto; margin-top:20px; max-width:800px; padding:0 20px;overflow-x:scroll;overflow-y:hidden;white-space:nowrap;max-height:70%'>
          <?php
            if($result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                $username = $row['username'];
                $user_info = get_info($username);
                $fullname = $user_info['fullname'];
                echo 
                 "<div id='$username' class='profileCard' onclick='loadMessage(this)'>
                     <a><img src='images/profile_pic/$username.jpg' style='width:4vw;height:4vw;margin-top:1vw;border-radius:50%;'></a>
                    <a style='text-decoration:none;color:black;display:block;font-size:16px;margin-bottom:15px;padding-top:20px;'><b>".explode(' ',trim($fullname))[0]."</b></a>
                 </div>";
              }
            }
           ?>
           
           
        </div>
    <script src="js/message.js"></script> 
 
</body>
</html>