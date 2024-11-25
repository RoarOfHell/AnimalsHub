<?php
require_once '../vendor/connect.php';
require_once 'controler/directoryController.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $communityName = mysqli_real_escape_string($connect, $_POST['communityName']);
    $communityDescription = mysqli_real_escape_string($connect, $_POST['communityDescription']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);
    //echo $communityName . ' ' . $communityDescription . ' ';
    mysqli_query($connect, "insert into Community (Name, Description, ImageUrl) values ('$communityName', '$communityDescription', '')");

    $communityId = $connect->insert_id;

    $roleId = mysqli_fetch_assoc(mysqli_query($connect, "select MAX(Id) as Id from CommunityRole"))['Id'];

    mysqli_query($connect, "insert into SubscribersCommunity (Community, UserId, Role) values ($communityId, $author, $roleId)");

    if (isset($_FILES['image'])) {
        $targetDirectory = '../users/' . $author . '/community' . '/' . $communityId . '/avatar' . '/'; // Папка, куда будет сохранено изображение

        $pathImage = upload_image_to_directory($_FILES['image'], $targetDirectory, true)['path'];

        mysqli_query($connect, "UPDATE `Community` SET ImageUrl='https://animalshub.ru/$pathImage' where Id = $communityId");


        echo "complited";
        
    }
    else{
        echo "error";
    }


    
}
else{
    echo "error";
}