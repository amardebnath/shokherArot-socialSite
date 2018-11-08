<?php

function get_newsfeed($post, $postmaker_info, $comments){
    $username = $_SESSION['username'];
    $posts = get_posts($username);
    
    $postmaker = $post['postmaker'];
    $post_id = $post['id'];
    $img = $post['img1'];
    $post_desc = $post['description'];
    $fullname = $postmaker_info['fullname'];
    date_default_timezone_set('Asia/Dhaka');
    $time_ago = time() - strtotime($post['updated_at']);

    $newsfeed = "";
    if($time_ago < 60*60){
    	$time_ago = 'less than 1h';
    } else {
      if($time_ago < 24*60*60){
    	   $time_ago = number_format($time_ago / (60*60), 0, '.', '') . 'h ago';
      } else {
        $time_ago = number_format($time_ago / (24*60*60), 0, '.', '') . 'days ago';
      }
    }

    $newsfeed = $newsfeed . "
      <div class='post'>
          <div class='postpic'>
          <img class='photo' id='myImg' onclick='modalClick(this)' src='images/posts/" . $img . "' >    
            
          </div>
          
          <div class='postdescription' style='position:relative;'>
            <div style='padding:15px;'>
              <div style='position:relative;table;vertical-align:top;width:100%;height:60px;'>
                <img src='images/profile_pic/" . $postmaker . ".jpg' class='profilepic'>
                  <div style='padding-left: 20px; margin-top: 10px; float:left; height:80%;'>
                    <b style='display: inline-block;'> <a style='color:black' href = profile.php?username=" . $postmaker . ">" . $fullname . "</a></b>
                      <p style='margin:0'>" . $postmaker_info['profession'] . "</p>
                  </div> 
              </div>
                <hr>
                <div id='".$post_id."' style='display:table;padding-top:15px;overflow:auto;'>
                    <b>" . $postmaker . "</b> " . $post_desc . "<br>";

    if($comments->num_rows>0){
    	while($comment = $comments->fetch_assoc()){
    		$newsfeed = $newsfeed . "<b><a style='color:darkslategrey' href=profile.php?username=" . $comment['username'] . ">" . $comment['username'] . "</a></b> " . $comment['comment'] . "<br>";
    	}
    }
    $newsfeed = $newsfeed .  
                "</div>
                
              <div style='width:90%;margin-bottom: 20px; display: table; bottom:0;position: absolute;'>
                  <b class='price_desc'>Regular price:</b>
                  <a class='price_amount'>" . $post['price'] . "</a>
                  <b class='price_desc'>Bidding price:</b>
                  <a id = '".$post_id."price' class='price_amount'>" . $post['starting_price'] . "</a>
                  <hr>";
    if(is_liked($username, $post_id))
      $newsfeed = $newsfeed . "<img src='images/liked.jpg' class='post_icon' onclick='like(this,".$post_id.")'>";
    else
      $newsfeed = $newsfeed . "<img src='images/like.jpg' class='post_icon' onclick='like(this,".$post_id.")'>";
    $newsfeed = $newsfeed . 
                  "<img src='images/buy.jpg' onclick='buy(this,".$post_id.")' class='post_icon'>
                  <input id = '".$post_id."bid' type='text' placeholder='price' onkeyup='bid(event, this," .$post_id.")' style='float:right;width:3vw;display:none'>
                  <img src='images/bid.jpg' onclick='bidRequest(this,".$post_id.")' class='post_icon' style='float:right'><br>
                  <b id = '".$post_id."like'style='display: inline-block;padding-top:10px;font-size: 15px;'>" . $post['likes'] . " Likes</b> <br>
                  <a style='font-size: 12px;color: darkgrey'>" . $time_ago . "</a>
                  <hr>
                  <input type='text' name='usrname' placeholder='Add a comment...' onkeyup='addComment(event, this," .$post_id.")' style='border: 0; height:25px;'>
            </div>
               
            </div>  
          </div>
      </div>";
      return $newsfeed;
}

?>