<?php
    require_once 'vendor/connect.php';

require 'checkToken.php';
    $token = mysqli_real_escape_string($connect, $_POST['token']);
    if(check_token_api($connect, $token) != "seccess"){ 
        echo "Token not valid";
        exit(); }    

    $user_id = mysqli_real_escape_string($connect, $_POST['userid']);
    $typeReport = mysqli_real_escape_string($connect, $_POST['typereport']);
    $reportDescription = mysqli_real_escape_string($connect, $_POST['reportdescription']);

    $user_info = mysqli_query($connect, "select * from Users where Id='$user_id' and IsBaned = '0'");
    
    if(mysqli_num_rows($user_info) > 0){
        $user_id = mysqli_fetch_assoc($user_info)['Id'];

        $pattern = '/GFHID: (\d+)/';
        $matches = [];

        if (preg_match($pattern, $reportDescription, $matches)) {
          $gfhId = $matches[1];
          
        } else {
          echo "error";
          exit();
        }

        $reported = mysqli_query($connect, "select * from UserReported where UserId = $user_id and TypeReportId = $typeReport and `ReportDescription` LIKE '%$gfhId%';");

        if(mysqli_num_rows($reported) <= 0){
            $query = "INSERT INTO `UserReported` (`UserId`, `TypeReportId`, `reportDescription`) VALUES ($user_id, $typeReport, '$reportDescription');";
            mysqli_query($connect, $query);
        }
        echo 'complited';
    }
    else{
        echo 'not user';
        exit();
    }
    
    
    
php?>