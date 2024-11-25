<?php
    require_once '../vendor/connect.php';
	require 'checkToken.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $token = mysqli_real_escape_string($connect, $_POST['token']);
      
	$login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $petNickname = mysqli_real_escape_string($connect, $_POST['petNickname']);
    $imageUrl = mysqli_real_escape_string($connect, $_POST['imageUrl']);
    $petDescription = mysqli_real_escape_string($connect, $_POST['petDescription']);
    $petPrice = mysqli_real_escape_string($connect, $_POST['petPrice']);
    $petType = mysqli_real_escape_string($connect, $_POST['petType']);
    $adType = mysqli_real_escape_string($connect, $_POST['adType']);
    $redirection = mysqli_real_escape_string($connect, $_POST['isRedirection']);
    
    $petAge = mysqli_real_escape_string($connect, $_POST['petAge']);
    $petVeterinary = mysqli_real_escape_string($connect, $_POST['petVeterinary']);
    $petBreed = mysqli_real_escape_string($connect, $_POST['petBreed']);
    

	if(check_token_api($connect, $token) == "seccess"){
      $check_user = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");

    if(mysqli_num_rows($check_user) > 0){
    	 
        $user = mysqli_fetch_assoc($check_user)['Id'];
        
        
        $query = "INSERT INTO `Pets` (`petNickname`, `imageUrl`, `petDescription`, `petPrice`, `petType`, `Id_User`, `Age`, `Veterinarian`, `Breed`, `AdTypeId`) 
    	VALUES ('$petNickname', '$imageUrl', '$petDescription', '$petPrice', '$petType', '$user', '$petAge', '$petVeterinary', '$petBreed', '$adType');";
    	mysqli_query($connect, $query);
        
        $id_pet_card = mysqli_insert_id($connect);
        if($redirection != ""){
            echo $id_pet_card;
        }
        
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user . '/petImages/'. $id_pet_card . '/';
        if (!file_exists($target_dir)) {
    		mkdir($target_dir, 0777, true);
		}
        $user_info = mysqli_query($connect, "select * from Users where UserName='$login' and Password='$password'");
    
        
        
        $query = "INSERT INTO `PetImages` (`ImageUrl`, `PetCardId`) VALUES ";
        // Проходим по каждому файлу в массиве $_FILES и сохраняем его в папку
    	foreach ($_FILES["files"]["error"] as $key => $error) {
    	    if ($error == UPLOAD_ERR_OK) {
    	    	if($query != "INSERT INTO `PetImages` (`ImageUrl`, `PetCardId`) VALUES "){
    	    		$query = $query . ",";
    	    	}
    	        $tmp_name = $_FILES["files"]["tmp_name"][$key];
    	        $name = basename($_FILES["files"]["name"][$key]);
    	        
    	        $filename = substr(md5(microtime() . rand(0, 9999) . $tmp_name), 0, 20);
    	        
    	        $path = "https://animalshub.ru/users/" . $user . '/petImages/'. $id_pet_card . '/' . $filename . ".jpg";
    	        move_uploaded_file($tmp_name, "$target_dir/$filename.jpg");
    	        
    	        
    	        $query = $query . "('$path', '$id_pet_card')";
    	    }
    	}
        $query = $query . ";";
        
        mysqli_query($connect, $query);
        
        $folderPath = $target_dir; // Путь к папке
		$files = glob($folderPath . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE); // Получаем список файлов
		
		
        
        $fileName = basename( $_FILES["file"]["name"]);
		 
		 
         //basename($_FILES["file"]["name"])
       
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		 
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        if($redirection != ""){
            echo "The file ". 'path = '. $target_dir . '  ' . basename( $_FILES["file"]["name"]). " has been uploaded.";
        }
		
		 
		 
		$imagePath = "https://animalshub.ru/users/" . $user . '/petImages/'. $id_pet_card . '/' . $fileName;
		 
		$queryUpdate = "UPDATE `Pets` SET imageUrl = '$imagePath' where Id = $id_pet_card;";
    	mysqli_query($connect, $queryUpdate);
		
        if($redirection != ""){
            echo 'complited'; 
       
        }
    	
	 
    }
    else{
        if($redirection != ""){
            echo 'Login or password error';
        }
        
    }
	
   
}
else{
    if($redirection != ""){
        echo 'error';
    }
	
  
    }
      
	
}

if($redirection == ""){
    
    header("Location: https://animalshub.ru/AnimalsHub/profile.php");
}

?>

