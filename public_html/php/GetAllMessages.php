<?php

session_start();
require_once("../vendor/connect.php");

$login = $_SESSION['user']->Login;
$password = $_SESSION['user']->Password;

$messages = [];

$sql = "SELECT ms.Id, ms.Id_Chat, ms.Id_Sender, ms.IsChecked, ms.Message, ud.UserName, ud.Name, ud.MiddleName, ud.ImageUrl FROM `Messages` ms 
        LEFT JOIN UserDetails ud ON ud.UserId = ms.Id_Sender
        WHERE (SELECT count(*) as count FROM Chats 
                WHERE (Id_User1 = (SELECT Id FROM Users WHERE Login = '$login' and Password = '$password ') and Id_User2 = ms.Id_Sender) or 
                        (Id_User1 = ms.Id_Sender and Id_User2 = (SELECT Id FROM Users WHERE Login = '$login' and Password = '$password '))) > 0 
            and ms.Id_Sender != (SELECT Id FROM Users WHERE Login = '$login' and Password = '$password ')";

$responceMessages = mysqli_query($connect, $sql);

while($message = mysqli_fetch_assoc($responceMessages)){
    $messages[] = $message;
}

echo json_encode($messages, JSON_UNESCAPED_UNICODE);