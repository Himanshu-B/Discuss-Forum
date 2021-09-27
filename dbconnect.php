<?php
    $conn = mysqli_connect('localhost','root','<?PHP?>4132','forumdiscuss');
    mysqli_set_charset($conn,"utf8");

    if($conn){
    //    echo 'Sucess';
    }else{
        die('Unable to connect db');
    }
?>