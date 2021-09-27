<?php include 'header.php' ?>
<?php
    //check for loggedin user
    if(isset($_SESSION['loggedin'])){
        // echo $_SESSION['active_user'];
    }else{
        header('location: index.php');
    }
?>

<div style="margin-left:200px">
<?php
// accept discussion from active user only
    if(isset($_POST['submit'])){
        // below parameter is used to add any type of character(like special characters) to database and to prevent xss attack
        $th_cat_name = mysqli_real_escape_string($conn,$_POST['cat_name']);
        $th_title = mysqli_real_escape_string($conn,$_POST['t_title']);
        $th_content = mysqli_real_escape_string($conn,$_POST['t_content']);
        // to prevent xss attack with another layer
        $th_title = str_replace("<","&lt;",$th_title);
        $th_title = str_replace(">","&gt;",$th_title);
        $th_content = str_replace("<","&lt;",$th_content);
        $th_content = str_replace(">","&gt;",$th_content);
        // to prevent only blank space insertion in database
        $th_cat_name = trim($th_cat_name);
        $th_title = trim($th_title);
        $th_content = trim($th_content);

        $th_user = $_SESSION['active_user'];
        $th_userid = $_SESSION['active_userid'];

        if(!empty($th_title)&&!empty($th_content)&&!empty($th_cat_name)){
            $ch_qy = "SELECT * FROM category WHERE category_name LIKE '$th_cat_name'";
            $ch_re = mysqli_query($conn,$ch_qy);
            $ch_num = mysqli_num_rows($ch_re);
            $ch_d = mysqli_fetch_assoc($ch_re);

            if($ch_num){
                // echo 'category already existed';
                $th_cat = $ch_d['category_id'];
                $th_qy = "INSERT INTO threads(thread_title,thread_content,thread_cat_id,thread_user,thread_user_id) VALUES('$th_title','$th_content','$th_cat','$th_user','$th_userid')";

                if(mysqli_query($conn,$th_qy)){
                    echo 'Thread/Post created successfully';
                }else{
                    echo 'ERROR: '.mysqli_error($conn);
                }
            }else{
                // echo 'category not existed want to create new one';
                $cat_qy = "INSERT INTO category(category_name) VALUES('$th_cat_name')";
                $cat_re = mysqli_query($conn,$cat_qy);
                if($cat_re){
                    // again get category id of new added category in database
                    $ch_qy = "SELECT * FROM category WHERE category_name LIKE '$th_cat_name'";
                    $ch_re = mysqli_query($conn,$ch_qy);
                    $ch_num = mysqli_num_rows($ch_re);
                    $ch_d = mysqli_fetch_assoc($ch_re);
                    $th_cat = $ch_d['category_id'];
                    $th_qy = "INSERT INTO threads(thread_title,thread_content,thread_cat_id,thread_user,thread_user_id) VALUES('$th_title','$th_content','$th_cat','$th_user','$th_userid')";
                    if(mysqli_query($conn,$th_qy)){
                        echo 'Thread/Post and new category has been created successfully';
                    }else{
                        echo 'ERROR: '.mysqli_error($conn);
                    }
                }
            }
        }else{
            echo 'Blank Fields can not be Accepted';
        }
    }
?>
</div>

    <div class="container">
        <span style="background:darkslategray; position:fixed; top:0; left:0;width:225px; height:100%; z-index:-1"></span>
        <div class="sidebar">
            <ul>
                <li><a href="welcome.php"><i class="fas fa-th-large"></i><span>Dashboard</span></a></li>
                <li><a href="mydiscuss.php"><i class="far fa-file-alt"></i><span>New Discuss</span></a></li>
                <li><a href="myprofile.php"><i class="fas fa-user"></i><span>My Profile</span></a></li>
                <li><a href="mypost.php"><i class="fas fa-folder"></i><span>My Posts</span></a></li>
                <li><a href="#"><i class="fas fa-comments"></i><span>My Comments</span></a></li>
            </ul>
        </div>
        <div class="sidecontent">
            <h1 style="margin-top:20px">Post a new dicussion</h1>
            <small>Use this form to create new post or create new category for your post</small>
            <br>
            <br>
            <div class="form">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-control">
                        <input type="text" name="cat_name" placeholder="Specify the category of the post">
                        <small><em>Check category section for correct naming for existed language</em></small>
                    </div>
                    <div class="form-control">
                        <input type="text" name="t_title" placeholder="Problem title">
                    </div>
                    <div class="form-control">
                        <textarea name="t_content" placeholder="Elaborate your problem...."></textarea>
                    </div>
                    <!-- confrim before submission -->
                    <input type="submit" value="Submit" name="submit" onclick="return confirm('If Any violation of our policy from this post will lead to remove/delete. Want to continue?');">
                </form>
            </div>
        </div>
    </div>
<?php include 'footer.php' ?>