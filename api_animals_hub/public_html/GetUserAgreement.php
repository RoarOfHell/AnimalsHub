<?php
   require_once 'vendor/connect.php';

    
    $user_agreement = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserAgreement where Id = 1"));
	
	$json = json_encode($user_agreement, JSON_UNESCAPED_UNICODE);
	
	echo $json;
	
php?>

