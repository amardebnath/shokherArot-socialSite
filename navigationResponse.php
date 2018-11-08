<?php
include 'database.php';

$request = $_REQUEST['q'];

if($request == 'load'){
	$starting = (int)$_REQUEST['start'];
	$ending = (int)$_REQUEST['end'];


	$db = get_connection();

	$time = time() - 10*24*60*60;
	date_default_timezone_set('Asia/Dhaka');
    $timestamp = date('Y/m/d H:i:s', $time);

	$post_query = "SELECT * FROM posts WHERE created_at > '$timestamp' ORDER BY likes DESC";
	$posts = $db->query($post_query) or die($posts->error());
	
	$whole_newsfeed = "";
    if($posts->data_seek($starting)){
        $cnt = 0;
        while($post = $posts->fetch_assoc()){
        	if($cnt == $ending - $starting) break;
        	$cnt++;
            $whole_newsfeed = $whole_newsfeed . 
            "<div class='posts' onmouseleave='notShow(this)' onmouseover='show(this)' >
                <img id='".$post['id']."' class='photo image' onclick='loadPost(this)' src='images/posts/" . $post['img1'] . "'>
                <div class='middle'>
                    <div class='text'>" . $post['likes'] . " Likes!</div>
                </div>
            </div>";
    	}
    	echo $whole_newsfeed . $cnt;
    }
}

?>