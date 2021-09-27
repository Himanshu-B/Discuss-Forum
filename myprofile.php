<?php include 'header.php' ?>
<?php
    //check for loggedin user
    if(isset($_SESSION['loggedin'])){
        $auser = $_SESSION['active_user'];
    }else{
        header('location: index.php');
    }
?>
<div style="margin-left:200px">
<?php
    // get active user details
    $u_qy = "SELECT * FROM users WHERE user_name='$auser'";
    $u_re = mysqli_query($conn,$u_qy);
    $u_da = mysqli_fetch_assoc($u_re);
?>
<?php
    // update active user details
    if(isset($_POST['update'])){
        // trim function is used to remove blank space as value
        $upname = trim($_POST['fname']);
        $upemail = trim($_POST['email']);
        $upphone = $_POST['phone'];
        $uid=$u_da['user_id'];
        // stop blank field update in database especially name and email
        if(!empty($upname)&&!empty($upemail)){
            $up_qy = "UPDATE users SET user_name='$upname',user_email='$upemail',user_phone='$upphone' WHERE user_id='$uid'";
            $up_re = mysqli_query($conn,$up_qy);
            if($up_re){
                echo 'Profile Updated Successfully... Reload the page to see your updated profile';
            }else{
                echo 'ERROR: '.mysqli_error($conn);
            }
        }else{
            echo 'Blank field can not be updated';
        }
        // header('location: myprofile.php');
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
            <h1 style="margin-top:20px">My Profile</h1>
            <small>You can edit your contact details</small>
            <br>
            <br>
            <div class="form">
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-control">
                        <label>Username</label>
                        <input type="text" name="fname" value="<?php echo $u_da['user_name'];?>">
                    </div>
                    <div class="form-control">
                        <label>Email</label>
                        <input type="text" name="email" value="<?php echo $u_da['user_email'];?>">
                    </div>
                    <div class="form-control">
                        <label>Mobile Number</label>
                        <input type="number" name="phone" value="<?php echo $u_da['user_phone'];?>" maxlength="10">
                    </div>
                    <!-- confirm before submission -->
                    <input type="submit" value="Update" name="update" onclick="return confirm('Want to continue?');">&nbsp;
                    <input type="reset" value="Reset or Clear">
                </form>
            </div>
        </div>
    </div>
<?php include 'footer.php' ?>