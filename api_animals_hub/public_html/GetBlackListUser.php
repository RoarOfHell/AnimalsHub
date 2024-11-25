<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }
    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);

    $user_info = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
    if(mysqli_num_rows($user_info) > 0){
        $user_id = mysqli_fetch_assoc($user_info)['Id'];
    
    	$user_blocking_list = mysqli_query($connect, "SELECT * FROM `BlockingUser` where UserBlock='$user_id' or CurrentUser='$user_id'");
    	
    	while($block_user = mysqli_fetch_assoc($user_blocking_list)){
    		$block_user_list['UserBlocked'][] = $block_user;
    	}
    	
    	echo json_encode($block_user_list, JSON_UNESCAPED_UNICODE);
    }
    else{
        echo 'login or password error';
        exit();
    }
    
php?>

