<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $recipient = mysqli_real_escape_string($connect, $_POST['recipient']);
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    
    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $userId = $user['Id'];
        $chats = mysqli_query($connect, "select * from Chats where Id_User1 = $recipient and Id_User2 = $userId or 
        Id_User2 = $recipient and Id_User1 = $userId");
        if(mysqli_num_rows($chats) > 0){
            $chat = mysqli_fetch_assoc($chats);
            $chatId = $chat['Id'];
            mysqli_query($connect, "INSERT INTO `Messages` (`Id_Chat`, `Id_Sender`, `IsChecked`, `Message`, `DateTime`) 
            VALUES ('$chatId', '$userId', '0', '$message', NOW());");
        }
        else{
            mysqli_query($connect, "INSERT INTO `Chats` (`Id`, `Id_User1`, `Id_User2`) 
            VALUES (NULL, '$userId', '$recipient');");
            
            $newidChat = mysqli_insert_id($connect);
            
            mysqli_query($connect, "INSERT INTO `Messages` (`Id_Chat`, `Id_Sender`, `IsChecked`, `Message`, `DateTime`) 
            VALUES ('$newidChat', '$userId', '0', '$message', NOW());");
        }
        echo 'complited';
    }
    else{
        echo 'Login or password error';
    }
    
    
    
        
?>