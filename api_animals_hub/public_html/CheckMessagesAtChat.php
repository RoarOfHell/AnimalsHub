<?php
    require_once 'vendor/connect.php';

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $chat_id = mysqli_real_escape_string($connect, $_POST['chatid']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user_id = mysqli_fetch_assoc($check_user)['Id'];
        mysqli_query($connect, "UPDATE `Messages` SET `IsChecked` = '1' WHERE `Messages`.`Id_Chat` = $chat_id and `Messages`.`Id_Sender` != $user_id;");
        echo 'complited';
        
    }
    else{
        echo 'Login or password error';
    }
    
    
    
        
?>