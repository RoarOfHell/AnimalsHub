<?php
require_once '../vendor/connect.php';
require_once 'controler/directoryController.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $communityName = mysqli_real_escape_string($connect, $_POST['communityName']);
    $communityDescription = mysqli_real_escape_string($connect, $_POST['communityDescription']);
    $userId = mysqli_real_escape_string($connect, $_POST['userId']);
    
    $communityId = mysqli_real_escape_string($connect, $_POST['communityId']);

    $isUserPermission = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE UserId = $userId and Role > 1"))['count'] > 0;

    $author = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM SubscribersCommunity WHERE Community = $communityId and Role = 4"))['UserId'];

    if($isUserPermission == 0) echo "error";
    
    if (isset($_FILES['image'])) {
        $targetDirectory = '../users/' . $author . '/community' . '/' . $communityId . '/avatar' . '/'; // Папка, куда будет сохранено изображение

        remove_all_files_at_path($targetDirectory);

        $pathImage = upload_image_to_directory($_FILES['image'], $targetDirectory, true)['path'];

        mysqli_query($connect, "UPDATE `Community` SET ImageUrl='https://animalshub.ru/$pathImage', Name='$communityName', Description='$communityDescription' where Id = $communityId");


        echo "complited";
        
    }
    else{
        echo "error";
    }


    
}
else{
    echo "error";
}