<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = json_decode($_POST['user']);

  $userId = $user->Id;

  $_SESSION['user'] = $user;

  $responce = mysqli_query($connect, "SELECT * FROM UserConfidentiality WHERE UserId = $userId");

  if(mysqli_num_rows($responce) == 0){
      mysqli_query($connect, "INSERT INTO `UserConfidentiality` (`UserId`, `Profile`, `News`, `Cards`, `Community`, `Subscriptions`, `Subscribers`, `Message`, `Phone`) VALUES ('$userId', '1', '1', '1', '1', '1', '1', '1', '1')");
  }

  echo'Status: OK';
} else {
  echo 'Status: Error';
}
?>