<?php
    session_start();
    include 'database.php';
    include 'helper.php';

    $username = $_SESSION['username'];
    $request = $_REQUEST['q'];
     
    if($request=='comment')
    {
        echo $_SESSION['username'];
        $comment = $_REQUEST['cmt'];
        $postid = $_REQUEST['postID'];
        comment($username, $postid, $comment);
    }

    if($request=='like')
    {
        $post_id = $_REQUEST['postID'];
        $db_conn = get_connection();
        if(!is_liked($username, $post_id)){
            $query = "INSERT INTO likes(liker, post_id) values ('$username', '$post_id')";
            $db_conn->query($query) or die($db_conn->error());
            $query = "UPDATE posts SET likes = likes + 1 WHERE id = '$post_id'";
            $db_conn->query($query) or die($db_conn->error());
        } else {
            $query = "DELETE FROM likes WHERE liker = '$username' and post_id = '$post_id'";
            $db_conn->query($query) or die($db_conn->error());
            $query = "UPDATE posts SET likes = likes - 1 WHERE id = '$post_id'";
            $db_conn->query($query) or die($db_conn->error());
        }
        echo get_likes($post_id);
    }
    if($request=='load')
    {
        $starting = (int)$_REQUEST['start'];
        $ending = (int)$_REQUEST['end'];

        $posts = get_posts($username);
        $whole_newsfeed = "";
        if($posts->data_seek($starting)){
            $cnt = 0;
            while($post = $posts->fetch_assoc()){
                if($cnt == $ending - $starting) break;
                $postmaker = $post['postmaker'];
                $post_id = $post['id'];
                $postmaker_info = get_info($postmaker);
                $comments = get_comments($post_id);
                $cnt = $cnt + 1;
                $whole_newsfeed = $whole_newsfeed . get_newsfeed($post, $postmaker_info, $comments);
            }
            echo $whole_newsfeed . $cnt;
        }
    }
    if($request == 'buy')
    {
        $post = (int)$_REQUEST['postID'];
        $text = "Hey, I am interested to buy this ";
        $post_link = urlencode("<a href='postPage.php?postid=$post'> item </a>");
        $text = $text . $post_link;
        $get_receiver_query = "SELECT postmaker FROM posts WHERE id = $post";
        $db_conn = get_connection();
        $result = $db_conn->query($get_receiver_query) or die($db_conn->error());

        if($result->num_rows > 0){
            $receiver = $result->fetch_assoc();
            $receiver = $receiver['postmaker'];

            $message_query = "INSERT INTO messages(sender, receiver, message) values('$username', '$receiver', '$text')";
            $db_conn->query($message_query) or die($db_conn->error());
        }
        echo "Buying request sent!";
    }
    if($request == 'bid')
    {
        $post_id = $_REQUEST['postID'];
        $price = (float)$_REQUEST['price'];
        $db_conn = get_connection();

        $check_query_post = "SELECT starting_price, postmaker FROM posts WHERE id = '$post_id'";

        $result = $db_conn->query($check_query_post);
        if($result->num_rows > 0){
            $result = $result->fetch_assoc();
            $postmaker = $result['postmaker'];
            $starting_price = $result['starting_price'];

            if($price < $starting_price){
                echo "no";
            } else {
                $check_query_request = "SELECT price FROM requests WHERE post_id = '$post_id'";
                $result = $db_conn->query($check_query_request) or die($db_conn->error());

                if($result->num_rows == 0){
                    $insert_query = "INSERT INTO requests (post_id, bidder, price) values('$post_id', '$username', '$price')";
                    $update_posts_query = "UPDATE posts SET starting_price = '$price' WHERE id = '$post_id'";
                    $text = "Hey, my bid is " . $price . " for this ";
                    $post_link = urlencode("<a href='postPage.php?postid=$post_id'> item </a>");
                    $text = $text . $post_link;
                    $message_query = "INSERT INTO messages(sender, receiver, message) values('$username', '$postmaker', '$text')";

                    $db_conn->query($insert_query) or die($db_conn->error());
                    $db_conn->query($update_posts_query) or die($db_conn->error());
                    $db_conn->query($message_query) or die($db_conn->error());
                    echo "yes";
                } else {
                    $result = $result->fetch_assoc();
                    $starting_price = $result['price'];
                    if($price < $starting_price){
                        echo 'no';
                    } else {
                        $update_query = "UPDATE requests SET price = '$price' WHERE post_id = '$post_id'";
                        $update_query1 = "UPDATE requests SET bidder = '$username' WHERE post_id = '$post_id'";
                        $update_posts_query = "UPDATE posts SET starting_price = '$price' WHERE id = '$post_id'";
                        $text = "Hey, my bid is " . $price . " for this ";
                        $post_link = urlencode("<a href='postPage.php?postid=$post_id'> item </a>");
                        $text = $text . $post_link;
                        $message_query = "INSERT INTO messages(sender, receiver, message) values('$username', '$postmaker', '$text')";

                        $db_conn->query($update_query) or die($db_conn->error());
                        $db_conn->query($update_query1) or die($db_conn->error());
                        $db_conn->query($update_posts_query) or die($db_conn->error());
                        $db_conn->query($message_query) or die($db_conn->error());
                        echo "yes";
                    }
                }
            }
        }
    } else if($request == 'bidRequest'){
        $db_conn = get_connection();
        $post_id = $_REQUEST['postID'];
        $query = "SELECT starting_price FROM posts WHERE id = '$post_id'";
        $result = $db_conn->query($query) or die($db_conn->error());
        if($result->num_rows > 0){
            $result = $result->fetch_assoc();
            $starting_price = $result['starting_price'];
            echo $starting_price;
        }
    }
    
?>
    