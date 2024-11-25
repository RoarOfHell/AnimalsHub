<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    
    //{"Birthday":"2023-04-20","City":"","Gender":"0","Id":"1","ImageUrl":"test","Mail":"andrunaki20@gmail.com","MiddleName":"Andrunak","Name":"Alexande","NumPhone":"","UserId":"17","UserName":"RoarOfHell"}
    $userDetails = json_decode($_POST['userDetails'], true);



	$user_name= mysqli_real_escape_string($connect, $userDetails['UserName']);
	$name= mysqli_real_escape_string($connect, $userDetails['Name']);
    $middleName= mysqli_real_escape_string($connect, $userDetails['MiddleName']);
    $phone= mysqli_real_escape_string($connect, $userDetails['NumPhone']);
    $city= mysqli_real_escape_string($connect, $userDetails['City']);
    
    $birthday= mysqli_real_escape_string($connect, $userDetails['Birthday']);
    $gender= mysqli_real_escape_string($connect, $userDetails['Gender']);
    $mail= mysqli_real_escape_string($connect, $userDetails['Mail']);

    
    $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user)['Id'];
      $sqlQuery = "UPDATE `UserDetails` SET `UserName` = $user_name, `Name` = '$name', `MiddleName` = '$middleName', `NumPhone` = '$phone', `City` = '$city', `ImageUrl` = '$imageUrl', `Birthday` = '$birthday', `Gender` = '$gender', Mail = '$mail' WHERE `UserId` = $user";
       $sqlNew = "UPDATE `UserDetails` SET 
       `UserName` = '$user_name', 
       `Name` = '$name', 
       `MiddleName` = '$middleName', 
       `Mail` = '$mail', 
       `City` = '$city', 
       `NumPhone` = '$phone', 
       `Birthday` = '$birthday', 
       `Gender` = '$gender'
       WHERE `UserId` = $user";
       mysqli_query($connect, $sqlNew);
        echo "complited";
    }
    else{
        echo 'Login or password error';
    }
    
    
    

        
?>