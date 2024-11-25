<?php
require_once 'vendor/connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $communityName = mysqli_real_escape_string($connect, $_POST['communityName']);
    $communityDescription = mysqli_real_escape_string($connect, $_POST['communityDescription']);
    $author = mysqli_real_escape_string($connect, $_POST['author']);

    mysqli_query($connect, "insert into Community (Name, Description) values ('$communityName', '$communityDescription')");

    $communityId = $connect->insert_id;

    mysqli_query($connect, "insert into SubscribersCommunity (Community, UserId, Role) values ($communityId, $author, 3)");

    if (isset($_FILES['image'])) {
        $targetDirectory = 'users/' . $author . '/community' . '/' . $communityId . '/avatar' . '/'; // Папка, куда будет сохранено изображение

        // Проверяем, существует ли целевая папка, и создаем её, если она отсутствует
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true); // Создать папку с правами доступа 0777 (пожалуйста, установите более строгие права в боевом окружении)
        }
        $current_time = date("H:i:s.u");
        $targetFile = $targetDirectory . md5(basename($imageFile['name']) . $current_time) . ".webp";
        
        print_r($_FILES['image']);

        // Проверка и сохранение изображения
        if (move_uploaded_file($imageFile['tmp_name'], $targetFile)) {
            // Изображение успешно сохранено, можно выполнить другие действия
        } 
        else{
            echo "error create file";
        }

        mysqli_query($connect, "update from Community set ImageUrl = 'https://animalshub.ru/$targetFile'");



        echo "complited";
    }
    else{
        echo "error getting file";
    }

    $countSubs = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE Community = $communityId and UserId = $userId"))['count'];

    
}
else{
    echo "error";
}