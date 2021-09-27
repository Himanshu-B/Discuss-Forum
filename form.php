<?php include 'header.php' ?>
<?php
    $alert = '';
    if(isset($_POST['submit_1'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        if(!empty($email) && !empty($pass)){
            $qy = "SELECT * FROM users WHERE user_email='$email' AND user_pass='$pass'";
            $l = mysqli_query($conn,$qy);
            $u = mysqli_fetch_assoc($l);
            $a = mysqli_num_rows($l);
            if($a == 1){
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['active_user'] = $u['user_name'];
                $_SESSION['active_userid'] = $u['user_id'];
                header('location: welcome.php');
            }else{
                $alert = 'Invalid Credentials';
            }
        }else{ 
            $alert = 'Blank fields';
        }
    }
?>

<?php
    $msg='';
    if(isset($_POST['submit_2'])){
        $fname = $_POST['fname'];
        $email = $_POST['femail'];
        $pass = $_POST['fpass'];
        $cpass = $_POST['fcpass'];

        if(!empty($fname)&&!empty($email)&&!empty($pass)&&!empty($cpass)){
            if($pass == $cpass){
                // check email existense in database
                $check_query = "SELECT user_email FROM users WHERE user_email='$email'";
                $check_result = mysqli_query($conn,$check_query);
                $check_num = mysqli_num_rows($check_result);
                if($check_num != 1){
                    $insert_query = "INSERT INTO users (user_name,user_email,user_pass) VALUES ('$fname','$email','$pass')";
                    mysqli_query($conn,$insert_query);
                    $msg = 'Account created successfully';
                }else{
                    $msg = 'Email already existed';
                }
            }else{
                $msg = 'Password do not match with confrim password';
            }
        }else{
            $msg = 'One or More Fields are empty';
        }
    }
?>

<div class="container">
    <div class="form-area">
        <div class="popup">
        <?php echo $alert; ?>
            <h2>LOG IN</h2>
            <div class="content">
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-control">
                        <input type="text" name="email" placeholder="Enter your email address here...">
                    </div>
                    <div class="form-control">
                        <input type="password" name="pass" placeholder="Enter your password here...">
                    </div>
                    <input type="submit" value="Login" name="submit_1">
                </form>
            </div>
        </div>

        <div style="display:flex; justify-content:center">
            <div class="modal__content">
                <p><?php echo $msg; ?></p>
                <h1>REGISTER FORUM</h1>
                <hr>
                <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
                    <div class="form-control">
                        <input type="text" name="fname" placeholder="Enter your full name here...">
                    </div>
                    <div class="form-control">
                        <input type="email" name="femail" placeholder="Enter your email address here...">
                    </div>
                    <div class="form-control">
                        <input type="password" name="fpass" placeholder="Enter your password here...">
                    </div>
                    <div class="form-control">
                        <input type="password" name="fcpass" placeholder="Enter confirm password here...">
                    </div>
                    <input type="submit" value="Register" name="submit_2">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>

<!-- <script>alert('hello')</script> -->