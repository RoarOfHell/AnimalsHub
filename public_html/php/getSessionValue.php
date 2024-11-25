<?php
	session_start();
	require_once '../vendor/connect.php';
	require 'checkToken.php';

	$value = $_GET['value'];
	$token = $_GET['token'];

if(check_token_api($connect, $token) == "seccess") echo json_encode($_SESSION["$value"], JSON_UNESCAPED_UNICODE);
else echo 'error token';
	
?>