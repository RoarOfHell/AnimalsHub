<?php
session_start();
require_once '../../../../vendor/connect.php';
require_once '../../../controler/settingsParameter.php';
require '../../../checkToken.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $parameters = getAllParameters($connect);

   

    $message = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['message']));
    $news = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['news']));
    $community = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['community']));
    $newSubs = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['newSubs']));


    if(isset($_SESSION['user'])){
        $login = $_SESSION['user']->Login;
        $password = $_SESSION['user']->Password;

        if(mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM UserNotification WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')"))['count'] > 0) {
            echo "1";
            mysqli_query($connect, "UPDATE `UserNotification` SET `Message` = '$message', `News` = '$news', `NewSubs` = '$newSubs', `Community` = '$community' WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')");
            echo "UPDATE `UserNotification` SET `Message` = '$message', `News` = '$news', `NewSubs` = '$newSubs', `Community` = '$community' WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')";
        }
        else{
            echo "2";
            mysqli_query($connect, "INSERT INTO `UserNotification` (`UserId`, `Message`, `News`, `NewSubs`, `Community`) VALUES ((SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password'), '$message', '$news', '$newSubs','$community')");
        }
        echo "complite";
    }
    else{
        echo "error login";
    }

   
}
else{
    echo "error";
}