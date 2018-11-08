<?php
    session_start();
	include 'database.php';
    $username = $_SESSION['username'];
    $user = $username;
    $request = $_REQUEST['q'];
        
    if($request=='load')
    {
    	if(isset($_REQUEST['username'])){
    		$username = $_REQUEST['username'];
    	}
    	$starting = (int)$_REQUEST['start'];
    	$ending = (int)$_REQUEST['end'];


    	$db = get_connection();
		$post_query = "SELECT * FROM posts WHERE postmaker = '$username'";
		$posts = $db->query($post_query) or die($posts->error());
		
		$whole_newsfeed = "";
        if($posts->data_seek($starting)){
            $cnt = 0;
            while($post = $posts->fetch_assoc()){
            	if($cnt == $ending - $starting) break;
            	$cnt++;
	            $str = 
                "<div  class='posts' onmouseleave='notShow(this)' onmouseover='show(this)' >
                    
                    <img id='".$post['id']."' class='photo image' onclick='loadPost(this)' src='images/posts/" . $post['img1'] . "'>";
                if(!isset($_REQUEST['username'])) {
                    $str = $str . "<span onclick='deletee(this,".$post['id'].")' class='close'>&times;</span>";
                }
                if(isset($_REQUEST['username'])) {
                    if($user == $_REQUEST['username']){
                        $str = $str . "<span onclick='deletee(this,".$post['id'].")' class='close'>&times;</span>";
                    }
                }
                $str = $str . "<div class='middle'>
                        <div class='text'>" . $post['likes'] . " Likes!</div>
                    </div>
                </div>";
                $whole_newsfeed = $whole_newsfeed . $str;

        	}
        	echo $whole_newsfeed . $cnt;
        }
    } 

    if($request=='delete')
    {
        $conn = get_connection();
        $temp = $_SESSION['username'];
        $idd = $_REQUEST['postid'];
        $sql = "DELETE FROM posts WHERE id=$idd";
        $sql2 = "UPDATE users SET num_posts = num_posts - 1 WHERE username = '$username'";
        if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
            echo $temp;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);;
        }

        mysqli_close($conn);
    }

    if($request=='logout')
    {
        session_destroy();
        echo "Logged Out.";
    }
    
?>