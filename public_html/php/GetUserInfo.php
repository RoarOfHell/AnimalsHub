<?php
    require 'php/checkToken.php';

    function getUserInfo($connect, $token, $login, $password){
    if(check_token_api($connect, $token) != "seccess"){ 
         return null;
         }

    
    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $userId = $user['Id'];
        $userDetails_get = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId=$userId"));
        $user['UserDetails'] = (object)$userDetails_get;
        return (object)$user;
    }
    else{
        return null;
    }
    }   
?>