<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $message_id = mysqli_real_escape_string($connect, $_POST['messageid']);
    $password = $_POST['pass'];

    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user_id = mysqli_fetch_assoc($check_user)['Id'];
        mysqli_query($connect, "DELETE FROM Messages WHERE `Messages`.`Id` = $message_id and Id_Sender = $user_id");
        echo 'complited';
        
    }
    else{
        echo 'Login or password error';
    }
    
    
    
        
?>