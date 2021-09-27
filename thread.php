<?php include 'header.php'?>
<?php
    // get thread id from url
    $tid = $_GET['tid'];

    $t = "SELECT * FROM threads WHERE thread_id=$tid";
    $sr = mysqli_query($conn,$t);
    $st = mysqli_fetch_assoc($sr);
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submit']){
        $comment_user = $_POST['c_user'];
        // any type of comment data(like special characters) can be stored in database and prevent xss attack
        $comment_text = mysqli_real_escape_string($conn,$_POST['c_para']);
        // to prevent xss attack with another layer of protection
        $comment_text = str_replace("<","&lt;",$comment_text);
        $comment_text = str_replace(">","&gt;",$comment_text);
        // insert comment to database
        if(!empty(trim($comment_text))){
            $q = "INSERT INTO comments (comment_content,thread_id,comment_user) VALUES ('$comment_text','$tid','$comment_user')";
            $r = mysqli_query($conn,$q);
            // echo 'success database';
        }else{
            echo 'Error!!!Blank comment trying to submit';
        }
    }
?>

<?php
//display all comments related to thread that is selected
    $show = "SELECT * FROM comments WHERE thread_id=$tid";
    $row = mysqli_query($conn,$show);
    $c = mysqli_fetch_all($row, MYSQLI_ASSOC);
    $n = mysqli_num_rows($row);
    // echo $n;
?>

<?php
// to get back to main category thread after thread selected
    $cat_qy = "SELECT thread_cat_id FROM threads WHERE thread_id=$tid";
    $cat_result = mysqli_query($conn,$cat_qy);
    $cat_row = mysqli_fetch_assoc($cat_result);
?>

<!-- to delete post -->
<?php
    if(isset($_POST['del'])){
        // capture thread id from displayed thread not from url
        $delid = $_POST['del_id'];
        // query to delete thread
        $dtqy = "DELETE FROM threads WHERE thread_id=$delid";
        $dtr = mysqli_query($conn,$dtqy);
        // query to delete comment related to thread
        $dcqy = "DELETE FROM comments WHERE thread_id=$delid";
        $dcr = mysqli_query($conn,$dcqy);
        if($dtr&&$dcr){
            echo 'Thread Deleted Premanently';
            // redirect along with post/thread deletion message
            header("location:mypost.php?msg=deleted");
            exit();
        }else{
            echo 'report problem';
        }
    }
?>

<?php
// Given a specific DateTime value, to display relative time, like
// 35 minutes ago
// 2 hours ago
// 3 days ago
// 1 month ago

function time2str($ts) {
    if(!ctype_digit($ts)) {
        $ts = strtotime($ts);
    }
    $diff = time() - $ts;
    if($diff == 0) {
        return 'now';
    } elseif($diff > 0) {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';

            // compare with current time to see if it was posted yesterday
            if( date( 'H' ) < ( $diff / 3600 ) ) return 'Yesterday';

            // if today
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) { return 'Yesterday'; }
        if($day_diff < 7) { return $day_diff . ' days ago'; }
        if($day_diff < 31) { return ceil($day_diff / 7) . ' weeks ago'; }
        if($day_diff < 60) { return 'last month'; }
        return date('F Y', $ts);
    } else {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0) {
            if($diff < 120) { return 'in a minute'; }
            if($diff < 3600) { return 'in ' . floor($diff / 60) . ' minutes'; }
            if($diff < 7200) { return 'in an hour'; }
            if($diff < 86400) { return 'in ' . floor($diff / 3600) . ' hours'; }
        }
        if($day_diff == 1) { return 'Tomorrow'; }
        if($day_diff < 4) { return date('l', $ts); }
        if($day_diff < 7 + (7 - date('w'))) { return 'next week'; }
        if(ceil($day_diff / 7) < 4) { return 'in ' . ceil($day_diff / 7) . ' weeks'; }
        if(date('n', $ts) == date('n') + 1) { return 'next month'; }
        return date('F Y', $ts);
    }
}
?>


    <div class="container">
        <?php if(isset($_SESSION['loggedin'])): ?>
            <a href="mypost.php" class="btn">Back to My Post</a>
        <?php endif; ?>
        <a href="threadlist.php?catid=<?php echo $cat_row['thread_cat_id'];?>" class="btn">Back to Main thread</a>
        <div class="ques-area">
            <h2><?php echo $st['thread_title'];?></h2>
            <small>Asked at <?php echo time2str($st['thread_timestamp']);?></small>
            <hr>
            <p style="margin-top:10px"><?php echo nl2br($st['thread_content']);?></p>
            <br>
            <!-- delete button only for registered user to their respective posts-->
            <?php if(isset($_SESSION['loggedin'])&& $_SESSION['active_user']==$st['thread_user']):?>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <input type="hidden" name="del_id" value="<?php echo $st['thread_id'];?>">
                    <input class="btn" type="submit" value="Delete" name="del">
                </form>
            <?php endif; ?>
            <p style="display:flex; justify-content:flex-end">Posted By: <?php echo $st['thread_user'];?></p>
        </div>

    <!-- Display Comment here -->
        <h2>Discussions</h2>
        <?php if($n):?>
            <?php foreach($c as $c): ?>
                <div class="comment">
                    <img src="userdefault.png" alt="..." width="56px" height="56px">
                    &ensp;<small><b>commented by:</b> <?php echo $c['comment_user']; ?> <b>at</b> <?php echo $c['comment_time'];?></small>
                    <p style="margin:5px 0"><?php echo nl2br($c['comment_content']);?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="comment">
                <p>No Comments here</p>
                <small>Start discussion here using below form</small>
            </div>
        <?php endif; ?>

    <!-- form area to post comment -->
        <?php if(isset($_SESSION['loggedin'])): ?>
        <div class="form">
            <h2 style="color:darkslategrey">Write your comment</h2>
            <form action="<?php $_SERVER['REQUEST_URI'];?>" method="POST">
                <div class="form-control">
                <!-- here disabling input field will lead to unaccesible value from input field -->
                    <input type="text" name="c_user" value="<?php echo $_SESSION['active_user'];?>" readonly='readonly'>
                </div>
                <div class="form-control">
                    <textarea name="c_para" placeholder="Type comment here..."></textarea>
                </div>
                <input type="submit" value="Post Comment" name="submit">
            </form>
        </div>
        <br>
        <?php else: ?>
        <div class="form">
            <h2>Post as Guest</h2>
            <form action="<?php $_SERVER['REQUEST_URI'];?>" method="POST">
                <div class="form-control">
                    <input type="text" name="c_user" value="guest" readonly='readonly'>
                </div>
                <div class="form-control">
                    <textarea name="c_para" placeholder="Type comment here..."></textarea>
                </div>
                <!-- confrim before submission -->
                <input type="submit" value="Post Comment" name="submit" onclick="return confirm('This comment will be posted as guest. Want to continue?');">
            </form>
        </div>
        <br>
        <?php endif; ?>

    </div>
<?php include 'footer.php'?>