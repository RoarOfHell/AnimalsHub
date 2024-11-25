<?php 
    session_start();
    require_once('../vendor/connect.php');
    require_once('../php/controler/RoleControler.php');
    $userId = 0;
    $sessionUserId = 0;
    if(!isset($_SESSION['user'])){
        echo "Not autorization";
    }
    else{
        $sessionUserId = mysqli_real_escape_string($connect, $_SESSION['user']->Id);
        $userId = mysqli_real_escape_string($connect, $_SESSION['user']->Id);
    }
    
    if(isset($_GET['id'])){
        $userId = mysqli_real_escape_string($connect, $_GET['id']);
    }

    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT IsOnline, IsBaned FROM Users WHERE Id = $userId"));
    $userDetails = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM UserDetails WHERE UserId = $userId"));
    $userRole = get_user_role($connect, $userId);

    $username = $userDetails['Name'] == "" ?  $userDetails['UserName'] :  $userDetails['Name'] . " " .  $userDetails['MiddleName'];
    $userImageUrl = $userDetails['ImageUrl'] == "" ? "https://animalshub.ru/images/icons/web-icon/default/DefaultUserIcon.svg" : $userDetails['ImageUrl'];
    $onlineStatus = $user['IsOnline'] == 1 ? "Online" : "Offline";
    $subscribers = 0;
    $subscription = 0;
    $isCurrentSession = $userId == $sessionUserId;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/components.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>Профиль</title>
</head>
<body id="bd" style="background-color: rgb(219, 218, 218);">
    <?php include '../php/header.php' ?>

    <?php 
        if(isset($user)){
            include '../php/MainProfile.php';
        }
        else{
            include '../php/ProfileNotFound.php';
        }
    ?>



    <script src="../AnimalsHub/test77.js" crossorigin="anonymous"></script>
    <script src="../js/token.js"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>