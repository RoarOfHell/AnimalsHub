<?php
	require_once '../vendor/connect.php';
	require 'checkToken.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$token = mysqli_real_escape_string($connect, $_POST['token']);

	$check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$pass'");

    if(mysqli_num_rows($check_user) > 0){
    	 
        $user = mysqli_fetch_assoc($check_user)['Id'];
         $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user . '/avatar/';
         
        
        $folderPath = $target_dir; // Путь к папке
		$files = glob($folderPath . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE); // Получаем список файлов
		
		foreach($files as $file){ // Итерируемся по списку файлов
		    if(is_file($file)){ // Проверяем, является ли файл файлом (не папкой)
		        unlink($file); // Удаляем файл
		    }
		}
        
        $fileName = basename( $_FILES["file"]["name"]);
		 
		 
         //basename($_FILES["file"]["name"])
       
		 $target_file = $target_dir . basename($_FILES["file"]["name"]);
		 
		 move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
		 
		 echo "The file ". 'path = '. $target_dir . '  ' . basename( $_FILES["file"]["name"]). " has been uploaded.";
		 
		 
		 $imagePath = "https://animalshub.ru/users/" . $user . "/avatar/" . $fileName;
		 echo "UPDATE `Users` SET `ImageUrl` = '$imagePath' WHERE `Users`.`Id` = $user";
		 mysqli_query($connect, "UPDATE `Users` SET `ImageUrl` = '$imagePath' WHERE `Users`.`Id` = $user");
		 
    }
    else{
        echo 'Login or password error';
    }
	
   
}
else{
	echo 'error';
}
?>