<?php

	require_once 'vendor/connect.php';

	$key = $_GET['key'];
	$login = $_GET['login'];
	$typeKey = $_GET['typeKey'];
	
	$check_user = mysqli_query($connect, "select * from Users where Login='$login'");
	$user = mysqli_fetch_assoc($check_user);
	$user_id = $user['Id'];
	$check_user_in_secret_key = mysqli_query($connect, "select * from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$typeKey' and SecretKey = '$key'");
	if(mysqli_num_rows($check_user_in_secret_key) > 0){
		mysqli_query($connect, "delete from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$typeKey' and SecretKey = '$key'");
		$emailConfirm = $user['IsConfirmMail'] == "1" ? '0' : '1';
		mysqli_query($connect, "update Users set IsConfirmMail = '$emailConfirm' where Id = $user_id");
	}
	else{
		echo 'false';
	}

?>