<?php
    session_start();
    include 'database.php';
    include 'validate.php';
    $str = $_REQUEST['searchField'];
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/search.css">
    
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
            
            <?php
                $conn = get_connection();
                $str = test_input($str);
                $str = $conn->real_escape_string($str);
                if(!empty($str)){
                    $sql = "select * FROM users WHERE username LIKE '%$str%';";
                    $result = mysqli_query($conn, $sql);
                    if($result->num_rows>0){
                        while($data = $result->fetch_assoc()){
                            $username = $data['username'];
                            $fullname = $data['fullname'];
                            $propic = "images/profile_pic/". $username . ".jpg";
                            
                            echo "
                            <div style='background-color:green;margin:30px'>
                                <div style='text-align:center;width:100%;background-color:white;'>
                                    <a href='profile.php?username=".$username."' style='text-decoration:none;color:black;display:block;font-size:16px;margin-bottom:15px;padding-top:20px;'><b>".$fullname."</b></a>
                                 <a href='profile.php?username=".$username."' >  <img src='".$propic."' style='width:120px;height:120px;border-radius:50%;margin-bottom:25px;'></a>
                                </div>
                            </div> ";
                        }
                    }
                }
            ?>
                    
        </div>
    
    </body>
    
</html>