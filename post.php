<?php
include 'database.php';

function post($username, $db) {
    $c = $db->query("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'id5639449_shokherarot' AND TABLE_NAME = 'posts' ")->fetch_assoc();
    $count = $c['AUTO_INCREMENT'];
    
    $ImageName = $_FILES['photo']['name'];
    $fileElementName = 'photo'; 
    $exten = pathinfo($ImageName, PATHINFO_EXTENSION);
    $path = 'images/posts/';
    $location = $path . $count . '.' . $exten; 
    move_uploaded_file($_FILES['photo']['tmp_name'], $location);

    $bidding_option = 0;
    $buy_option = 0;
    if(isset($_REQUEST['checkbox'])){
        foreach ($_REQUEST['checkbox'] as $check){
            if($check == 'bidding_option') $bidding_option = 1;
            if($check == 'buy_option') $buy_option = 1;
        }
    }
    $desc = $_REQUEST['description'];
    $price = $_REQUEST['price'];
    $start_price = $_REQUEST['start_price'];
    date_default_timezone_set('Asia/Dhaka');
    $timestamp = date('Y/m/d H:i:s', time());

    $location = $count . '.' . $exten;

    $insert_query = "INSERT INTO posts(postmaker, description, img1, buy_option, price, bidding_option, starting_price, created_at, updated_at) values ('$username', '$desc' , '$location', '$buy_option', '$price', '$bidding_option', '$start_price', '$timestamp', '$timestamp')";
    $update_query = "UPDATE users SET num_posts = num_posts+1 WHERE username = '$username'";
    
    $res = $db->query($insert_query);
    $res = $db->query($update_query);
    if(!$res) die(mysqli_error($db));
}

?>