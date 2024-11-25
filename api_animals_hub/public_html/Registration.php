<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $midleName = mysqli_real_escape_string($connect, $_POST['midleName']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $city = mysqli_real_escape_string($connect, $_POST['city']);
    $mail = "";
    $gender = "";
    $image = "";
    $password = $_POST['pass'];

    $password = md5($password);
    
    $check_user_login = mysqli_query($connect, "SELECT * FROM Users where Login = '$login'");
    
    if(mysqli_num_rows($check_user_login) > 0){
    	echo 'user with this username already exists';
    }
    else{
    	
    	mysqli_query($connect, "INSERT INTO `Users` ( `Login`, `Password`, `IsConfirmMail`, `IsBaned`) VALUES ('$login', '$password', '0', '0');");
    	$newUserId = mysqli_insert_id($connect);
    	mysqli_query($connect, "INSERT INTO `UserDetails` ( `UserId`, `UserName`, `Name`, `MiddleName`, `Mail`, `City`, `NumPhone`, `Birthday`, `Gender`, `ImageUrl`) 
    												VALUES ('$newUserId', '$login', '$name', '$midleName', '$mail', '$city', '$phone', NOW(), '$gender', '$image');");
        mysqli_query($connect, "INSERT INTO `UserConfidentiality` (`UserId`, `Profile`, `News`, `Cards`, `Community`, `Subscriptions`, `Subscribers`, `Message`, `Phone`) VALUES ('$newUserId', '1', '1', '1', '1', '1', '1', '1', '1')");
    	echo 'complite';
    	
    }

    
        
?>