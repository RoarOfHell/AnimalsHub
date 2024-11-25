<?php
    require_once 'vendor/connect.php';

    
    $login = mysqli_real_escape_string($connect, $_POST['login']);
    $password = mysqli_real_escape_string($connect, $_POST['pass']);
    $report_id = mysqli_real_escape_string($connect, $_POST['reportid']);
    $report_user_id = mysqli_real_escape_string($connect, $_POST['userid']);

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }
    
    $user_info = mysqli_query($connect, "select * from Users where Login='$login' and Password='$password'");
    
    if(mysqli_num_rows($user_info) > 0){
        $user_id = mysqli_fetch_assoc($user_info)['Id'];
         $date = date('Y-m-d H:i:s');
        mysqli_query($connect, "INSERT INTO `UserReported` (`UserId`, `TypeReportId`, `ReportDescription`) VALUES ('$report_user_id', '$report_id', 'Репорт был отправлен пользователем с GFHID: $user_id дата: $date')");
    }
    else{
        echo 'login or password error';
        exit();
    }
    
    
    
php?>