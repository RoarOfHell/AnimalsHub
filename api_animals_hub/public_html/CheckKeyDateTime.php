<?php

	require_once 'vendor/connect.php';

	mysqli_query($connect, "delete from UsersConfirmKey where DateTimeRemove <= NOW()");
	
?>