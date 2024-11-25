<?php
session_start();
require_once '../../../../vendor/connect.php';
require '../../../checkToken.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //if(check_token_api($connect, $token) != "seccess"){
    //    header("Location: https://animalshub.ru/profileSettings");
    //    exit();
    //}

    $middleName = mysqli_real_escape_string($connect, $_POST['middleName']);
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $lastName = mysqli_real_escape_string($connect, $_POST['lastName']);
    $email =  mysqli_real_escape_string($connect, $_POST['email']);
    $phoneNum = mysqli_real_escape_string($connect, $_POST['phoneNum']);
    $region = mysqli_real_escape_string($connect, $_POST['region']);
    $city = mysqli_real_escape_string($connect, $_POST['city']);

    

    if(isset($_SESSION['user'])){
        $login = $_SESSION['user']->Login;
        $password = $_SESSION['user']->Password;
        $mail = mysqli_fetch_assoc(mysqli_query($connect, "SELECT IsConfirmMail FROM Users WHERE Login = '$login' AND Password = '$password'"))['IsConfirmMail'] == 1 ? "" : "Mail='$mail',";
        mysqli_query($connect, "UPDATE UserDetails SET $mail Name='$name', MiddleName='$middleName', city='$region $city', NumPhone='$phoneNum' WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')");
        $_SESSION['user']->UserDetails->MiddleName = $middleName;
        $_SESSION['user']->UserDetails->Name = $name;
        if($mail != ""){
            $_SESSION['user']->UserDetails->Mail = $email;
        }
        $_SESSION['user']->UserDetails->NumPhone = $phoneNum;
        $_SESSION['user']->UserDetails->City = $region . ' ' . $city;
    }

   echo "complite";
}
else{
    echo "error";
}


