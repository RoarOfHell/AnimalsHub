<?php
session_start();
    require_once '../vendor/connect.php';
    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
	$token = mysqli_real_escape_string($connect, $_GET['token']);

echo 'login: ' .  $login . '<br>';
echo 'password: ' .  $password . '<br>';
echo 'token: ' .  $token . '<br>';
   // $petNickname = mysqli_real_escape_string($connect, $_POST['petNickname']);
   // $imageUrl = mysqli_real_escape_string($connect, $_POST['imageUrl']);
   // $petDescription = mysqli_real_escape_string($connect, $_POST['petDescription']);
   // $petPrice = mysqli_real_escape_string($connect, $_POST['petPrice']);
   // $petType = mysqli_real_escape_string($connect, $_POST['petType']);
   // $adType = mysqli_real_escape_string($connect, $_POST['adType']);
   // $redirection = mysqli_real_escape_string($connect, $_POST['isRedirection']);
   // 
   // $petAge = mysqli_real_escape_string($connect, $_POST['petAge']);
   // $petVeterinary = mysqli_real_escape_string($connect, $_POST['petVeterinary']);
   // $petBreed = mysqli_real_escape_string($connect, $_POST['petBreed']);
    
    

//header("Location: https://animalshub.ru/AnimalsHub/about_us");
?>