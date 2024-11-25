<?php

require_once "vendor/connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);

    $responce = mysqli_query($connect, "SELECT * FROM UserConfidentiality WHERE UserId = $userId");

    if(mysqli_num_rows($responce) == 0){
        mysqli_query($connect, "INSERT INTO `UserConfidentiality` (`UserId`, `Profile`, `News`, `Cards`, `Community`, `Subscriptions`, `Subscribers`, `Message`, `Phone`) VALUES ('$userId', '1', '1', '1', '1', '1', '1', '1', '1')");
        echo "completed";
    }
    else{
        echo "Error";
    }


}

header("Location: http://animalshub.ru");