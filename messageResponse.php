<?php
    session_start();
    include 'database.php';
    include 'validate.php';

    $db = get_connection();

    $request = $_REQUEST['q'];

    if($request=='loadmessage')
    {
        $user1 = $_SESSION['username'];
        $user2 = $_REQUEST['username'];

        $query = "SELECT * FROM messages where (sender='$user1' and receiver='$user2') or (sender='$user2' and receiver='$user1')";

        $result = $db->query($query) or die($db->error());

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $sender = $row['sender'];
                $text = urldecode($row['message']);
                $time = $row['texting_time'];
                if($sender == $user1){
                    echo 
                    "<div class='container'>
                      <img src='images/profile_pic/$sender.jpg' class='right' alt='Avatar' style='width:4vw;height:4vw;'>
                      <p>$text</p>
                      <span class='time-left'>$time</span>
                    </div>";
                } else {
                    echo 
                    "<div class='container'>
                      <img src='images/profile_pic/$sender.jpg' alt='Avatar' style='width:4vw;height:4vw;'>
                      <p>$text</p>
                      <span class='time-right'>$time</span>
                    </div>";
                }
            }
        }
    }

    
    if($request=='sendmessage')
    {
        $sender = $_SESSION['username'];
        $receiver = $_REQUEST['username'];
        $text = test_input($_REQUEST['message']);

        date_default_timezone_set('Asia/Dhaka');
        $timestamp = date('Y/m/d H:i:s', time());

        $query = "INSERT INTO messages (sender, receiver, message, texting_time) values('$sender', '$receiver', '$text', '$timestamp    ')";

        echo 
        "<div class='container'>
          <img src='images/profile_pic/$sender.jpg' class='right' alt='Avatar' style='width:4vw;height:4vw;'>
          <p>$text</p>
          <span class='time-left'>$timestamp</span>
        </div>";


        $db->query($query) or die($db->error());
    }
    
?>