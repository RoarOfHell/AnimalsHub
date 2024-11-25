<?php

    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $online_status = mysqli_real_escape_string($connect, $_POST['status']);
    
  

    mysqli_query($connect, "UPDATE `Users` SET `IsOnline` = '$online_status' WHERE Login = '$login' and Password = '$password'");


?>