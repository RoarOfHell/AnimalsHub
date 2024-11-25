<?php
session_start();
require_once("vendor/connect.php");
require_once("php/CardBlueprint.php");


$communityId = 0;
$communityInfo = null;
$communitySubs = [];

$userInfo = 1;
$admins = [];
$userId = $_SESSION['user']->Id;

if(isset($_GET["id"])){
    $communityId = $_GET["id"];

    $communitySubsRequest = mysqli_query($connect, "SELECT sc.Id, sc.Community, sc.UserId, (SELECT Name FROM CommunityRole WHERE Id = sc.Role) as Role, ud.UserName, ud.Name, ud.MiddleName, ud.ImageUrl FROM SubscribersCommunity sc
    LEFT JOIN UserDetails ud ON ud.UserId = sc.UserId
    where Community = $communityId");

    while ($row = mysqli_fetch_array($communitySubsRequest)) {
        $communitySubs[] = $row;
    }

    $adminsQuery = mysqli_query($connect, "SELECT sc.UserId FROM SubscribersCommunity sc 
    Where Community = $communityId and Role > 1");

    while ($row = mysqli_fetch_array($adminsQuery)) {
      $admins[] = $row;
    }

    $communityInfo = mysqli_fetch_assoc(mysqli_query($connect, "SELECT c.Id, c.Name, c.Description, c.ImageUrl, (SELECT COUNT(*) FROM SubscribersCommunity where Community = c.Id) as Count FROM Community c
    WHERE c.Id = $communityId"));
}

$allNews = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM News 
                                                    where CommunityId = $communityId and News.IsCommunity = 1
                                                    order by Id desc")); 


$page = "community";

$isAdmin = isUserInModerate($admins, $userId);

function isUserInModerate($adminList, $userId){
  foreach ($adminList as $key => $value) {
    if($value['UserId'] == $userId) return true;
  }

  return false;
}
?>
  <!DOCTYPE html>
  <html lang="en" style="height: 100%;">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    <title><?php echo $communityInfo['Name'];?></title>
  </head>

  <body id="bd" style="background-color: rgb(219, 218, 218); display:flex; flex-direction:column; min-height: 100%">
    <div>

    </div>
    <?php include 'php/header.php' ?>

      <main class="w-100 h-100" style="flex: 1;">
        

        <?php if($communityInfo == null) echo '<div class="container bg-light br-10px" style="position:absolute; display: flex; height: calc(100% - 100px); left: 50%; transform: translate(-50%, 0px);">
    <div class="vertical-box h-100 w-100 vertical-align-center horizontal-align-center">
        <div class="pb-5"><img src="https://animalshub.ru/images/icons/web-icon/logo/LogoMyPets.svg" style="height: 256px; width: 256px" alt=""></div>
        <div style="font-size: 20px; font-weight: bold;">Данного сообщества не существует!</div>
    </div>
</div>';
        else{
            include 'php/CommunityInfo.php';
        }
        ?>
      </main>

      <?php include 'php/footer.php' ?>
                 



        <script src="js/token.js"></script>
        <script src="js/news.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
        <script  src="js/cropper/cropper.js"></script>
        <script src="js/cropper/dialog/cropper_dialog.js"></script>
        <script src="js/dialog/community/edit_community.js"></script>
        <script src="js/cropper/image_encoder.js"></script>
        <script src="js/url_tool.js"></script>

  </body>

  </html>   