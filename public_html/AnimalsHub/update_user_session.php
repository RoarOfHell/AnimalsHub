<?php
session_start();
require_once('../vendor/connect.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['UserName'];
    $firstName = $_POST['Name'];
    $middleName = $_POST['MiddleName'];
    $numPhone = $_POST['NumPhone'];
    $city = $_POST['City'];
    $birthday = $_POST['Birthday'];
    $gender = $_POST['Gender'];
    $mail = $_POST['Mail'];

    $_SESSION['temp'] = $_POST['UserName'];

    $id = $_SESSION['user']->UserDetails->UserId;

    $imageUrl = mysqli_fetch_assoc(mysqli_query($connect, "select ImageUrl from UserDetails where UserId = '$id'"))['ImageUrl'];


    $_SESSION['user']->UserDetails->UserName = $userName;
    $_SESSION['user']->UserDetails->Name = $firstName;
    $_SESSION['user']->UserDetails->MiddleName = $middleName;
    $_SESSION['user']->UserDetails->NumPhone = $numPhone;
    $_SESSION['user']->UserDetails->City = $city;
    $_SESSION['user']->UserDetails->Birthday = $birthday;
    $_SESSION['user']->UserDetails->Gender = $gender;
    $_SESSION['user']->UserDetails->Mail = $mail;
    $_SESSION['user']->UserDetails->ImageUrl = $imageUrl;

} else {
    echo 'Ошибка!';
}
?>