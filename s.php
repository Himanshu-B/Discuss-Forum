<?php
// here variable name in POST method are according to ajax data send
    if(isset($_POST['fname'])){
        // here connection to database
        include 'dbconnect.php';
        // to prevent xss attack in database
        $name = mysqli_real_escape_string($conn,$_POST['fname']);
        $email =mysqli_real_escape_string($conn,$_POST['email']);
        $subject = mysqli_real_escape_string($conn,$_POST['csub']);
        $mesg = mysqli_real_escape_string($conn,$_POST['cmsg']);

        if(!empty($_POST['fname']) && !empty($_POST['email']) && !empty($_POST['csub']) && !empty($_POST['cmsg'])){
            $qy = "INSERT INTO contacts (contact_name,contact_email,contact_subject,contact_query) VALUES ('$name','$email','$subject','$mesg')";
            if(mysqli_query($conn,$qy)){
                echo 'Thank you for sending query... We will contact you soon';
            }else{
                echo 'Error!!! Problem Occured';
            }
        }else{
            echo 'One or more Empty Fields';
        }
    }

    // echo 'Thank you'."\n";
    // // $data = file_get_contents("php://input");
    // // echo $data;
    // foreach($_POST as $varb){
    //     echo $varb."\n";
    // }

    // if(isset($_POST['fname'])){
    //     echo $_POST['fname'];
    // }
?>