<?php include 'header.php' ?>
<?php
    //check for loggedin user
    if(isset($_SESSION['loggedin'])){
        // echo $_SESSION['active_user'];
    }else{
        header('location: index.php');
        exit();
        //exit() prevents the code from running, it litterly EXITS the code as soon as it hits that line.
    }
?>

    <div class="container">
        <span style="background:darkslategray; position:fixed; top:0; left:0;width:225px; height:100%; z-index:-1"></span>
        <div class="sidebar">
            <ul>
                <li><a href="welcome.php"><i class="fas fa-th-large"></i><span>Dashboard</span></a></li>
                <li><a href="mydiscuss.php"><i class="far fa-file-alt"></i><span>New Discuss</span></a></li>
                <li><a href="myprofile.php"><i class="fas fa-user"></i><span>My Profile</span></a></li>
                <li><a href="mypost.php"><i class="fas fa-folder"></i><span>My Posts</span></a></li>
                <li><a href="javascript:void(0)"><i class="fas fa-comments"></i><span>My Comments</span></a></li>
            </ul>
        </div>
        <div class="sidecontent">
            <p>Welcome page <?php echo $_SESSION['active_user']; ?></p>
            
        </div>
    </div>
<?php include 'footer.php' ?>