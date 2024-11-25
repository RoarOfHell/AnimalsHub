<?php 
    session_start();
    require_once('vendor/connect.php');
    require_once('php/controler/RoleControler.php');
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

    $communityList = [];

    $communityQuery = mysqli_query($connect, "SELECT * FROM Community WHERE Community.Id in (SELECT Community as Id FROM SubscribersCommunity WHERE UserId = $userId)");

    while ($row = mysqli_fetch_array($communityQuery)) {
        $communityList[] = $row;
    }

    $_SESSION['communityList'] = $communityList;

    $user = mysqli_fetch_assoc(mysqli_query($connect, "SELECT IsOnline, IsBaned FROM Users WHERE Id = $userId"));
    $userDetails = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM UserDetails WHERE UserId = $userId"));
    $userRole = get_user_role($connect, $userId);

    $username = $userDetails['Name'] == "" ?  $userDetails['UserName'] :  $userDetails['Name'] . " " .  $userDetails['MiddleName'];
    $userImageUrl = $userDetails['ImageUrl'] == "" ? "https://animalshub.ru/images/icons/web-icon/default/DefaultUserIcon.svg" : $userDetails['ImageUrl'];
    $onlineStatus = $user['IsOnline'] == 1 ? "Online" : "Offline";
    $subscribers = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $userId"))['count'];
    $subscription = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Subscriber = $userId"))['count'];
    $isCurrentSession = $userId == $sessionUserId;

    $allNews = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM News where Author = $userId and IsCommunity = 0 order by Id desc"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="css/style.css" rel="stylesheet">
    <link href="css/components.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title><?php echo $username;?></title>
</head>
<body id="bd" style="background-color: rgb(219, 218, 218);">
    <?php include 'php/header.php' ?>

    <?php 
    
        if(isset($user)){
            include 'php/MainProfile.php';
        }
        else{
            include 'php/ProfileNotFound.php';
        }
    ?>

<!--<div id="background-dialog-${count}" class="dialog-background dialog-bg-active vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0">
    <div class="container w-100 h-100" style="max-height: 800px; min-height: 500px; padding-left: 200px; padding-right: 200px">
        <div id="forward-dialog" class="dialog-forward dialog-fw-active" style="background-color: white; height: 100%; width: 100%; max-height: 1000px; min-height: 500px;">
            <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
              <div class="w-100 horizontal-box vertical-align-center" style="height: 48px;">
                  <div class="w-100 ps-2">
                      Создание нового сообщества.
                  </div>
              </div>
              <hr class="w-100 p-0 m-0">
  
              <div class="vertical-box w-100 h-100" style="overflow:hidden; overflow-y:auto;">
                  <div class="vertical-box w-100 h-100">
                      
                  </div>
              </div>
  
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                  <div><button class="btn btn-primary mt-2" onclick="closeDialog()">Закрыть</button></div>
              </div>
            </div>
        </div>
    </div>
  </div>-->

  <script>
    function development(){
        alert("Данная функция в разработке!");
    }
  </script>

    <script src="js/pet_card.js"></script>
    <script src="AnimalsHub/test77.js" crossorigin="anonymous"></script>
    <script src="js/token.js"></script>
        <script src="js/news.js"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script  src="js/cropper/cropper.js"></script>
    <script src="js/cropper/dialog/cropper_dialog.js"></script>
    <script src="js/dialog/profile/community.js"></script>
    <script src="js/dialog/profile/sendMessage.js"></script>
    <script src="js/cropper/image_encoder.js"></script>
    <script src="js/dialog/profile/createNewPetCard.js"></script>
        <script src="js/url_tool.js"></script>
        
</body>
</html>