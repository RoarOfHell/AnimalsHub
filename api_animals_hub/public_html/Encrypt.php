<?php

function encrtypt($plaintext){
	$key = "qwertyuiopasdfghjklzxcvbnmdfgtrwe";
	$iv = "ridkfmgfdjtredfg";
	return openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}

function decrypt($ciphertext){
	$key = "qwertyuiopasdfghjklzxcvbnmdfgtrwe";
	$iv = "ridkfmgfdjtredfg";
	return openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
}


?>