<?php
require_once '../vendor/connect.php';
require 'checkToken.php';
require 'FileManager/FileManager.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_manager = new FileManager();

    $token = mysqli_real_escape_string($connect, $_POST['token']);
    
      
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $petNickname = mysqli_real_escape_string($connect, $_POST['petNickname']);
    $imageUrl = mysqli_real_escape_string($connect, $_POST['imageUrl']);
    $petDescription = mysqli_real_escape_string($connect, $_POST['petDescription']);
    $petPrice = mysqli_real_escape_string($connect, $_POST['petPrice']);
    $petType = mysqli_real_escape_string($connect, $_POST['petType']);
    $adType = mysqli_real_escape_string($connect, $_POST['adType']);
    $petId = mysqli_real_escape_string($connect, $_POST['petId']);
    $removeImages = json_decode($_POST['removeImages'], true);
    $redirection = mysqli_real_escape_string($connect, $_POST['isRedirection']);
    
    $petAge = mysqli_real_escape_string($connect, $_POST['petAge']);
    $petVeterinary = mysqli_real_escape_string($connect, $_POST['petVeterinary']);
    $petBreed = mysqli_real_escape_string($connect, $_POST['petBreed']);
    
    

    if (check_token_api($connect, $token) == "seccess") {
        $check_user = mysqli_query($connect, "SELECT * FROM Users WHERE Login='$login' AND Password='$password'");

        if (mysqli_num_rows($check_user) > 0) {
            $user = mysqli_fetch_assoc($check_user)['Id'];
            
            $query = "UPDATE Pets SET 
                petNickname = '$petNickname',
                petDescription = '$petDescription',
                petPrice = '$petPrice',
                petType = '$petType',
                Id_User = '$user',
                Age = '$petAge',
                Veterinarian = '$petVeterinary',
                Breed = '$petBreed',
                AdTypeId = '$adType'
            WHERE Id = '$petId';";
    
            mysqli_query($connect, $query);
            
            $id_pet_card = $petId;
            
            if ($redirection !== "") {
                echo $id_pet_card;
            }
            
            // create directory
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/users/" . $user . '/petImages/' . $id_pet_card . '/';
            $file_manager->createDirectory($target_dir);
    
            print_r( $removeImages);
            // remove files
            if (!empty($removeImages)) {
                foreach ($removeImages as $removeImage) {
                    mysqli_query($connect, "DELETE FROM PetImages WHERE PetCardId='$id_pet_card' and ImageUrl = '$removeImage'");
                    $file_remove_dir = $target_dir . basename($removeImage);
                    $file_manager->deleteFile($file_remove_dir);
                }
            }
    
            // get user information
            $user_info = mysqli_query($connect, "SELECT * FROM Users WHERE UserName='$login' AND Password='$password'");
        
            
    
            // adding additional images to the catalog and adding a URL to the images in the database
            $query = "INSERT INTO PetImages (ImageUrl, PetCardId) VALUES ";
            foreach ($_FILES["files"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    if ($query !== "INSERT INTO PetImages (ImageUrl, PetCardId) VALUES ") {
                        $query .= ",";
                    }
                    $tmp_name = $_FILES["files"]["tmp_name"][$key];
                    $name = basename($_FILES["files"]["name"][$key]);
                    
                    $filename = substr(md5(microtime() . rand(0, 9999) . $tmp_name), 0, 20);
                    
                    $path = "https://animalshub.ru/users/" . $user . '/petImages/' . $id_pet_card . '/' . $filename . ".jpg";
                    $file_manager->uploadFile($tmp_name, $target_dir, "$filename.jpg");
                    
                    $query .= "('$path', '$id_pet_card')";
                }
            }
            $query .= ";";
            
            mysqli_query($connect, $query);
            
            if($_FILES["file"] != null && $_FILES["file"]["tmp_name"] != null){
                // adding the main image to the catalog and adding the URL to the image to the database
                $folderPath = $target_dir;
                $files = glob($folderPath . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                echo "file: " . $_FILES["file"]["tmp_name"];
                $filename = substr(md5(microtime() . rand(0, 9999) . basename($_FILES["file"]["name"])), 0, 20);

                $file_manager->uploadFile($_FILES["file"]["tmp_name"], $target_dir, "$filename.jpg");

                if ($redirection !== "") {
                    echo "The file ". 'path = '. $target_dir . '  ' . basename($_FILES["file"]["name"]). " has been uploaded.";
                }

                $imagePath = "https://animalshub.ru/users/" . $user . '/petImages/' . $id_pet_card . '/' . $filename . ".jpg";

                $queryUpdate = "UPDATE Pets SET imageUrl = '$imagePath' WHERE Id = $id_pet_card;";
                mysqli_query($connect, $queryUpdate);

            }
            
            if ($redirection !== "") {
                echo 'completed'; 
            }
        }
        else {
            if ($redirection !== "") {
                echo 'Login or password error';
            }
        }
    }
    else {
        if ($redirection !== "") {
            echo 'error';
        }
    }
}
else{
    echo 'not post';
}

if ($redirection === "") {
    header("Location: https://animalshub.ru/AnimalsHub/profile.php");
}
?>