<?php
session_start();
require_once("vendor/connect.php");
require_once("php/CardBlueprint.php");

$userId = $_SESSION['user']->Id;
$allNews = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM News 
                                                    where (Author = $userId and News.IsCommunity = 0) or ((select count(*) from Subscribers where Subscriber = $userId and Author = News.Author) > 0 and News.IsCommunity = 0)
                                                    or ((select count(*) from SubscribersCommunity where UserId = $userId and Community = News.CommunityId) > 0 and News.IsCommunity = 1) or Author = 17
                                                    order by Id desc")); 


$page = "main";
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
    <title>Главная</title>
  </head>

  <body id="bd" style="background-color: rgb(219, 218, 218); display:flex; flex-direction:column; min-height: 100%">
    <div>

    </div>
    <?php include 'php/header.php' ?>

      <main class="w-100 h-100" style="flex: 1;">
        <div class="container w-100 d-flex justify-content-center">
          <div class="w-75">
            <div class="news-container">
              <div class="cards-container bg-light border rounded-3">
                <div class="cards-horizontal-list">
                  <?php

                    $query = "SELECT p.Id, p.petNickname, p.imageUrl, p.petDescription, p.petPrice, p.petType, p.Id_User , p.Age, p.Breed, p.Veterinarian, p.AdTypeId 
                    FROM Pets p
                    LEFT JOIN Users u ON u.Id = p.Id_User
                    WHERE (SELECT Cards FROM UserConfidentiality WHERE UserId = p.Id_User) = 1 or 
                          ((SELECT Cards FROM UserConfidentiality WHERE UserId = p.Id_User) = 2 and (SELECT count(*) FROM Subscribers WHERE Author = p.Id_User AND Subscriber = $userId) > 0) or
                          ((SELECT Cards FROM UserConfidentiality WHERE UserId = p.Id_User) = 3 and (SELECT count(*) FROM Subscribers WHERE Author = p.Id_User AND Subscriber = $userId) > 0 and (SELECT count(*) FROM Subscribers WHERE Author = $userId AND Subscriber = p.Id_User) > 0) or
                          p.Id_User = $userId
                          order by rand() limit 10;
                    ";

                    $pets = mysqli_fetch_all(mysqli_query($connect, $query));
                    foreach ($pets as $key => $value) {
                    GetCard($value);
                    }
                    ?>
                </div>
              </div>
              <?php include 'php/BlockAddNewNews.php' ?>
              
            </div>
          </div>

        </div>
      </main>

      <?php include 'php/footer.php' ?>
                 


      <script src="js/DateFormats/date_formats.js"></script>
        <script src="js/token.js"></script>
        <script src="js/news.js"></script>
     
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>

        <script src="js/pet_card.js"></script>
        
  </body>

  </html>   