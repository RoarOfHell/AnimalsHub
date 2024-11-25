<?php
    require_once 'vendor/connect.php';

    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $user_id_blocking = mysqli_real_escape_string($connect, $_POST['userid']);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }
    
    $user_info = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
    if(mysqli_num_rows($user_info) > 0){
        $user_id = mysqli_fetch_assoc($user_info)['Id'];
        
        $user_block = mysqli_query($connect, "select * from Users where Id='$user_id_blocking'");
    
    	if(mysqli_num_rows($user_block) > 0){
    	    $user_block_id = mysqli_fetch_assoc($user_block)['Id'];
			mysqli_query($connect, "INSERT INTO `BlockingUser` (`UserBlock`, `CurrentUser`) VALUES ('$user_block_id', '$user_id')");
			echo 'complited';
    	}
    }
    else{
        echo 'login or password error';
        exit();
    }
    
php?>