<?php
require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }

    $email = mysqli_real_escape_string($connect, $_POST['mail']);
    $typeKey = mysqli_real_escape_string($connect, $_POST['typekey']);
    $key = mysqli_real_escape_string($connect, $_POST['key']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    
    $password = md5($password);
    
    $check_user = mysqli_query($connect, "select * from UserDetails where Mail='$email'");

    if(mysqli_num_rows($check_user) > 0){
    	$user_id = mysqli_fetch_assoc($check_user)['UserId'];

		$check_user_in_secret_key = mysqli_query($connect, "select * from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$typeKey' and SecretKey = '$key'");
		if(mysqli_num_rows($check_user_in_secret_key) > 0){
			mysqli_query($connect, "delete from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$typeKey' and SecretKey = '$key'");
			mysqli_query($connect, "update Users set Password = '$password' where Id = $user_id");
			echo 'true';
		}
		else{
			echo 'false';
		}

    }
    else{
        echo 'there is no user with such mail';
    }

?>