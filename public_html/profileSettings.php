<?php
    require_once "vendor/connect.php";
    
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

    <title>Настройки профиля</title>
</head>
<body id="bd" style="background-color: rgb(219, 218, 218);">
    <?php include 'php/header.php' ?>
    
    <div class="container vertical-box vertical-align-center" style="height: 800px">
        <div class=" w-75 h-100 horizontal-box">
            <div class="w-75 h-100 bg-light rounded-3 me-3" style="position: relative;">
                <div id="personal-data" class="block-settings w-100 h-100" style="position: absolute;">
                    <?php include 'php/profile/settings/personalData.php'?>
                </div>

                <div id="profile-photo" class="block-settings w-100 h-100" style="position: absolute; visibility:collapse;">
                    <?php include 'php/profile/settings/profilePhoto.php'?>
                </div>

                <div id="confidentiality" class="block-settings w-100 h-100" style="position: absolute; visibility:collapse;">
                    <?php include 'php/profile/settings/confidentiality.php'?>
                </div>

                <div id="interests" class="block-settings w-100 h-100" style="position: absolute; visibility:collapse;">
                    <?php include 'php/profile/settings/interests.php'?>
                </div>

                <div id="notifications" class="block-settings w-100 h-100" style="position: absolute; visibility:collapse;">
                    <?php include 'php/profile/settings/notifications.php'?>
                </div>
                
            </div>
            <div class="w-25 h-50">
                <div class="w-100 bg-light rounded-3 border">
                    <ul style="list-style-type:none;" class="m-0 p-0 pt-2 pb-2">
                        <li id="1" class="ps-3 item-li selected" style="height: 48px;" onclick="selectItem(this)">Личные данные</li>
                        <li id="2"  class="ps-3 item-li" style="height: 48px;" onclick="selectItem(this)">Фото и фон профиля</li>
                        <li id="3"  class="ps-3 item-li" style="height: 48px;" onclick="selectItem(this)">Конфиденциальность</li>
                        <li id="4"  class="ps-3 item-li" style="height: 48px;" onclick="selectItem(this)">Интересы</li>
                        <li id="5"  class="ps-3 item-li" style="height: 48px;" onclick="selectItem(this)">Уведомления</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = document.getElementById('personal-data');
        let currentPosition = 1;
        let isChanged = false;

        function selectItem(element){
            const items = document.querySelectorAll('.item-li');
            const blocks = document.querySelectorAll('.block-settings');
            const id =element.id;

            

            if(isChanged){
                var isDrop =confirm("Вы хотите отменить сохранение данных?");
                
                if(!isDrop) return;
            }

            items.forEach(item => item.classList.remove('selected'));
            element.classList.add('selected');

            blocks.forEach(item => item.style.visibility = 'collapse');

            onDropChangedValue();
                switch(id){
                    case '1':
                        currentPage = document.getElementById('personal-data');
                        currentPage.style.visibility = 'visible';
                        currentPosition = 1;
                        break;
                    
                    case '2':
                        currentPage = document.getElementById('profile-photo');
                        currentPage.style.visibility = 'visible';
                        currentPosition = 2;
                        break;
                    
                    case '3':
                        currentPage = document.getElementById('confidentiality');
                        currentPage.style.visibility = 'visible';
                        currentPosition = 3;
                        break;
                    
                    case '4':
                        currentPage = document.getElementById('interests');
                        currentPage.style.visibility = 'visible';
                        currentPosition = 4;
                        break;
                    
                    case '5':
                        currentPage = document.getElementById('notifications');
                        currentPage.style.visibility = 'visible';
                        currentPosition = 5;
                        break;
                }
        }

        function onChangeValueDetection(){
            isChanged = true;
            if(currentPage.querySelector(".save-btn")){
                currentPage.querySelector(".save-btn").style.visibility = 'visible';
            }
            
        }

        function onDropChangedValue(){
            isChanged = false;
            if(currentPage.querySelector(".save-btn")){
                currentPage.querySelector(".save-btn").style.visibility = 'collapse';
            }
            
        }

    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="js/token.js"></script>
<script src="js/cropper/dialog/cropper_dialog.js"></script>
<script src="js/cropper/cropper.js"></script>
<script src="js/cropper/image_encoder.js"></script>
<script>uploadImageID = 2;</script>
</body>

</html>