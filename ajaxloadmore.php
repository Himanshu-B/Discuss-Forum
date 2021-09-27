<?php
    require_once 'dbconnect.php';

    if(isset($_GET['record'])){
        // get the value passed from url
        $record = $_GET['record'];
        $set = $_GET['set'];

        $sql = "SELECT * FROM threads WHERE thread_user='Gandhi' AND thread_user_id='3' LIMIT $record,$set";
        $res = mysqli_query($conn,$sql);
        // Storing all returned records in an array $dat
        $dat = mysqli_fetch_all($res,MYSQLI_ASSOC);
        // Sending response back to AJAX
        echo json_encode($dat);
    }
?>
