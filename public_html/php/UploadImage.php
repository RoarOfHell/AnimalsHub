<?php
session_start();
	require_once '../vendor/connect.php';
	require 'checkToken.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$token = mysqli_real_escape_string($connect, $_POST['token']);

	if(check_token_api($connect, $token) == "seccess"){
		$check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$pass'");


		if(mysqli_num_rows($check_user) > 0){
			 
			$user = mysqli_fetch_assoc($check_user)['Id'];
			 $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user . '/avatar/';
			 
			
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			
			$folderPath = $target_dir; // Путь к папке
			$files = glob($folderPath . "/*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE); // Получаем список файлов
			
			
			
			foreach($files as $file){ // Итерируемся по списку файлов
				if(is_file($file)){ // Проверяем, является ли файл файлом (не папкой)
					unlink($file); // Удаляем файл
				}
			}
			$current_time = date("H:i:s.u");

			$fileName = md5(basename($_FILES["file"]["name"]) . $current_time) . ".webp";
			 
			 //basename($_FILES["file"]["name"])
		   
			 $target_file = $target_dir . $fileName;
			 
			 move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
			 
			 //echo "The file ". 'path = '. $target_dir . '  ' . basename( $_FILES["file"]["name"]). " has been uploaded.";
			 echo "completed";
			 
			 $imagePath = "https://animalshub.ru/users/" . $user . "/avatar/" . $fileName;
			
			 mysqli_query($connect, "UPDATE `UserDetails` SET `ImageUrl` = '$imagePath' WHERE `UserId` = $user");
			 $_SESSION['message'] = 'Complited';
		}
		else{
			echo 'Login or password error';
			$_SESSION['message'] = 'Login or password error';
		}
	}
	else{
		$_SESSION['message'] = 'Token error';
	}

	
	
   
}
else{
	echo 'error';
	$_SESSION['message'] = 'error';
}
?>