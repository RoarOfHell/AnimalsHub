<?php
session_start();
require_once '../../../../vendor/connect.php';
require '../../../checkToken.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //if(check_token_api($connect, $token) != "seccess"){
    //    header("Location: https://animalshub.ru/profileSettings");
    //    exit();
    //}
    
    $likeAnimal = mysqli_real_escape_string($connect, $_POST['likeAnimal']);
    $likeBreed = mysqli_real_escape_string($connect, $_POST['likeBreed']);

    $animalId = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM PetType WHERE Title = '$likeAnimal'"))['Id'];
    $breedId = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM AnimalsBreeds WHERE Breed = '$likeBreed' and IdTypePet = $animalId"))['Id'];

    if(isset($_SESSION['user'])){
        $login = $_SESSION['user']->Login;
        $password = $_SESSION['user']->Password;

        if(mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM UserInterests WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')"))['count'] > 0) {
            echo "1";
            mysqli_query($connect, "UPDATE `UserInterests` SET `IdAnimal` = '$animalId', `IdBreed` = '$breedId' WHERE UserId = (SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password')");
        }
        else{
            echo "2";
            mysqli_query($connect, "INSERT INTO `UserInterests` (`UserId`, `IdAnimal`, `IdBreed`) VALUES ((SELECT Id FROM Users WHERE Login = '$login' AND Password = '$password'), '$animalId', '$breedId')");
        }
        echo "complite";
    }
    else{
        echo "error login";
    }

   
}
else{
    echo "error";
}