<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = $_POST['pass'];

    $password = md5($password);
    
    
    if($login != ""){
    	$check_user = mysqli_query($connect, "select * from Users where LOWER(Login) = LOWER('$login') and Password='$password'");
    }
    else{
    	echo 'Login or password error';
    	exit();
    }
    

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $userId = $user['Id'];
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$userId"));
        $user['UserDetails'] = $userDetails_get;

        $responce = mysqli_query($connect, "SELECT * FROM UserConfidentiality WHERE UserId = $userId");

        if(mysqli_num_rows($responce) == 0){
            mysqli_query($connect, "INSERT INTO `UserConfidentiality` (`UserId`, `Profile`, `News`, `Cards`, `Community`, `Subscriptions`, `Subscribers`, `Message`, `Phone`) VALUES ('$userId', '1', '1', '1', '1', '1', '1', '1', '1')");
        }

        echo json_encode($user);
    }
    else{
        echo 'Login or password error';
    }
    
    
    
        
?>