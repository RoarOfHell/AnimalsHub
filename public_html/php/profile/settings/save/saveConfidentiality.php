<?php
session_start();
require_once '../../../../vendor/connect.php';
require_once '../../../controler/settingsParameter.php';
require '../../../checkToken.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //if(check_token_api($connect, $token) != "seccess"){
    //    header("Location: https://animalshub.ru/profileSettings");
    //    exit();
    //}

    $parameters = getAllParameters($connect);

    $profile = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['profile']));
    $news = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['news']));
    $cards = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['cards']));
    $community = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['community']));
    $subscriptions = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['subscriptions']));
    $subscribers = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['subscribers']));
    $message = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['message']));
    $phone = getIdAtParameterInArray($parameters, mysqli_real_escape_string($connect, $_POST['phone']));

    if(isset($_SESSION['user'])){
        $login = $_SESSION['user']->Login;
        $password = $_SESSION['user']->Password;
        $sql = "UPDATE `UserConfidentiality` SET `Profile` = '$profile', `News` = '$news', `Cards` = '$cards', `Community` = '$community', `Subscriptions` = '$subscriptions', `Subscribers` = '$subscribers', `Message` = '$message', `Phone` = '$phone' WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')";
        mysqli_query($connect, $sql);
    }

    echo "complite";
}
else{
    echo "error";
}







