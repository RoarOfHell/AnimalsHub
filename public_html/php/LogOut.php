<?php
    session_start();

    if(isset($_SESSION['user'])){
        session_destroy();
        header('Location: https://animalshub.ru');
        die();
    }

    header('Location: https://animalshub.ru');
    die();
?>