<?php
    require_once 'vendor/connect.php';

    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $pet_id = mysqli_real_escape_string($connect, $_POST['petid']);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }
    
    $user_info = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
    if(mysqli_num_rows($user_info) > 0){
        $user_id = mysqli_fetch_assoc($user_info)['Id'];
        
    }
    else{
        echo 'login or password error';
        exit();
    }
    
    
    $query = "INSERT INTO `Favourites` (`UserId`, `PetCardId`) VALUES ('$user_id', '$pet_id');";
    mysqli_query($connect, $query);
    echo 'complited';
php?>

