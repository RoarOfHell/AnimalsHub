<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);

    
    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $userId = $user['Id'];
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$userId"));
        $user['UserDetails'] = $userDetails_get;
        echo json_encode($user);
    }
    else{
        echo 'Login or password error';
    }
    
    
    
        
?>