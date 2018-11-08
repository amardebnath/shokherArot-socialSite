<?php

$host = 'localhost';
$username = 'id5639449_root';
$password = 'shokherarot';
$db_name = 'id5639449_shokherarot';
$db_connection = mysqli_connect($host, $username, $password, $db_name);

function get_connection(){
	global $db_connection;
	return $db_connection;
}

function get_info($username){
	global $db_connection;
	$query = "SELECT * FROM users WHERE username = '$username'";
	$result = $db_connection->query($query);
	if($result->num_rows == 1){
		$info = $result->fetch_assoc();
		return $info;
	}
}

function get_posts($username){
	global $db_connection;
    $get_post_query = "SELECT * FROM posts WHERE postmaker in (SELECT following FROM follow WHERE follower = '$username') ORDER BY updated_at DESC";

    $posts = $db_connection->query($get_post_query) or die($db_conn->error());
    return $posts;
}

function get_comments($post_id){
	global $db_connection;
	$query = "SELECT * FROM comments WHERE post_id = '$post_id'";
	$comments = $db_connection->query($query) or die($db_connection->error());
	return $comments;
}

function get_is_following($follower, $following){
	global $db_connection;
	$query = "SELECT count(*) FROM follow WHERE follower = '$follower' and following = '$following'";
	$result = $db_connection->query($query);
	$result = $result->fetch_assoc();
	if($result['count(*)'] == 0){
		return false;
	} else {
		return true;
	}
}

function follow($follower, $following){
	global $db_connection;
	$query = "INSERT into follow(follower, following) values ('$follower', '$following')";
	$db_connection->query($query) or die($db_connection->error());
	$update_following_query = "UPDATE users SET num_follower = num_follower + 1 WHERE username = '$following'";
	$db_connection->query($update_following_query) or die($db_connection->error());
	$update_follower_query = "UPDATE users SET num_following = num_following + 1 WHERE username = '$follower'";
	$db_connection->query("$update_follower_query") or die($db_connection->error());
}

function comment($username, $post_id, $comment){
	global $db_connection;
	date_default_timezone_set('Asia/Dhaka');
    $timestamp = date('Y/m/d H:i:s', time());
	$query = "INSERT INTO comments(comment, username, post_id, created_at) values('$comment', '$username', '$post_id', '$timestamp')";
	$db_connection->query($query) or die($db_connection->error());
}

function get_likes($post_id){
	global $db_connection;
	$query = "SELECT likes FROM posts WHERE id = '$post_id'";
	$result = $db_connection->query($query) or die($db_connection->error());
	$likes = $result->fetch_assoc();
	$likes = $likes['likes'];
	return $likes;
}

function is_liked($username, $post_id){
	global $db_connection;
	$query = "SELECT count(*) FROM likes WHERE liker = '$username' and post_id = '$post_id'";
	$result = $db_connection->query($query) or die($db_connection->error());
	$result = $result->fetch_assoc();
	if($result['count(*)'] == 0) return false;
	else return true;
}

function unfollow($follower, $following){
	global $db_connection;
	$query = "DELETE FROM follow where follower='$follower' and following='$following'";
	$db_connection->query($query) or die($db_connection->error());
	$update_following_query = "UPDATE users SET num_follower = num_follower - 1 WHERE username = '$following'";
	$db_connection->query($update_following_query) or die($db_connection->error());
	$update_follower_query = "UPDATE users SET num_following = num_following - 1 WHERE username = '$follower'";
	$db_connection->query("$update_follower_query") or die($db_connection->error());
}	

function getPost($username, $postid){
    global $db_connection;
    $get_post_query = "SELECT * FROM posts WHERE id='$postid'";

    $posts = $db_connection->query($get_post_query) or die($db_connection->error());
    return $posts;
}

?>