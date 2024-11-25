<?php
session_start();
require_once '../vendor/connect.php';

if (isset($_SESSION['user'])) {

    $user = $_SESSION['user'];

    $login = $_SESSION['user']->Login;
    $password = $_SESSION['user']->Password;

    $result = mysqli_fetch_assoc(mysqli_query($connect, "select * from Users where Login = '$login' and Password = '$password'"));

    echo json_encode($result, JSON_UNESCAPED_UNICODE);

} else {
    echo 'Не удалось получить объект user из сессии!';
}
?>