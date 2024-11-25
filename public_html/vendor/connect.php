<?php 
	$connect = new mysqli("localhost", "cz56918_mypets", "999888777z", "cz56918_mypets");
    if($connect->connect_error){
        die("Ошибка: " . $connect->connect_error);
    }
    $connect->set_charset("utf8mb4");
 ?>