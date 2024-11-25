<?php
require_once 'vendor/connect.php';

    $email = mysqli_real_escape_string($connect, $_POST['mail']);
    $typeKey = mysqli_real_escape_string($connect, $_POST['typekey']);
    $key = mysqli_real_escape_string($connect, $_POST['key']);
    
    $check_user = mysqli_query($connect, "select * from UserDetails where Mail='$email'");

    if(mysqli_num_rows($check_user) > 0){
    	$user_id = mysqli_fetch_assoc($check_user)['UserId'];

		$check_user_in_secret_key = mysqli_query($connect, "select * from UsersConfirmKey where UserId='$user_id' and IdTypeKey = '$typeKey' and SecretKey = '$key'");
		if(mysqli_num_rows($check_user_in_secret_key) > 0){
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