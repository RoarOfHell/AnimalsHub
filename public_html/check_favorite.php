<?php
    session_start();
    require_once 'vendor/connect.php';
    if(isset($_SESSION['user'])){
        $user_id = $_SESSION['user']->Id;
        $pet_id = $_POST['petid'];

        $result = mysqli_query($connect, "select * from Favourites where UserId = '$user_id' and PetCardId = '$pet_id'");

        if(mysqli_num_rows($result) > 0){
            $favorite = mysqli_fetch_assoc($result);
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode("{}", JSON_UNESCAPED_UNICODE);
        }

    }else{
        header("Location: https://animalshub.ru/AnimalsHub/authorization");
    }
?>