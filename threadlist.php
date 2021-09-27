<?php include 'header.php'?>
<?php
    //get category id from url
    $id = $_GET['catid'];

    $sql = "SELECT category_name,category_description FROM category WHERE category_id=$id";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);

    $query = "SELECT thread_id,thread_title,thread_content FROM threads WHERE thread_cat_id=$id";
    $info = mysqli_query($conn,$query);
    $thread = mysqli_fetch_all($info, MYSQLI_ASSOC);
    $num = mysqli_num_rows($info);
?>

<?php
// accept discussion from active user only
    if(isset($_POST['submit'])){
        // this method doesn't store any type of data and don't display correct data of different type
        // $th_title = $_POST['t_title'];
        // $th_content = $_POST['t_content'];

        // below parameter is used to add any type of character(like special characters) to database and to prevent xss attack
        $th_title = mysqli_real_escape_string($conn,$_POST['t_title']);
        $th_content = mysqli_real_escape_string($conn,$_POST['t_content']);
        // to prevent xss attack with another layer
        $th_title = str_replace("<","&lt;",$th_title);
        $th_title = str_replace(">","&gt;",$th_title);
        $th_content = str_replace("<","&lt;",$th_content);
        $th_content = str_replace(">","&gt;",$th_content);

        $th_cat = $id;
        $th_user = $_SESSION['active_user'];
        $th_userid = $_SESSION['active_userid'];

        if(!empty($th_title)&&!empty($th_content)){
            $th_qy = "INSERT INTO threads(thread_title,thread_content,thread_cat_id,thread_user,thread_user_id) VALUES('$th_title','$th_content','$th_cat','$th_user','$th_userid')";

            if(mysqli_query($conn,$th_qy)){
                echo 'Thread created successfully';
                // once thread is added then display it
                $query = "SELECT thread_id,thread_title,thread_content FROM threads WHERE thread_cat_id=$id";
                $info = mysqli_query($conn,$query);
                $thread = mysqli_fetch_all($info, MYSQLI_ASSOC);
                $num = mysqli_num_rows($info);
            }else{
                echo 'ERROR: '.mysqli_error($conn);
            }
        }else{
            echo 'Blank Fields can not be accepted';
        }
    }
?>

    <div class="container">
        <div class="jumbotron">
            <h1>Welcome to <?php echo $data['category_name'];?> thread</h1>
            <p><?php echo $data['category_description'];?></p>
        </div>

        <!-- display every thread according to category selected by user -->
        <br>
        <?php if($num):?>
            <h2>Browse threads:</h2>
            <?php foreach($thread as $th): ?>
            <div class="lists">
                <a href="thread.php?tid=<?php echo $th['thread_id'];?>"></a>
                <img src="userdefault.png" alt="..." width="56px" height="56px">
                <div class="ques">
                    <h3><?php echo $th['thread_title'];?></h3>
                    <p><?php echo $th['thread_content'];?></p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="margin:10px 20px">No Threads Found</p>
        <?php endif; ?>
        <hr>

        <?php if(isset($_SESSION['loggedin'])): ?>
        <div class="form">
            <h2>Start a Discussion</h2>
            <form action="<?php $_SERVER['REQUEST_URI'];?>" method="POST">
                <div class="form-control">
                    <input type="text" name="t_title" placeholder="Problem title">
                </div>
                <div class="form-control">
                    <textarea name="t_content" placeholder="Elaborate your problem...."></textarea>
                </div>
                <!-- confirm before submission -->
                <input type="submit" value="Submit" name="submit" onclick="return confirm('If Any violation of our policy from this post will lead to remove/delete. Want to continue?');">
            </form>
        </div>
        <?php else: ?>
            <p style="margin:5px 0"><em>Login to start a discussion<em></p>
        <?php endif; ?>
        <br>
    </div>
<?php include 'footer.php'?>