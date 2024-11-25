<?php 
    session_start();
    require_once("../vendor/connect.php");
    
    if(!isset($_SESSION['user'])){
        header('Location: https://animalshub.ru/AnimalsHub/authorization');
    }
    $page = "create_ad";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="style.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Создание объявления</title>
</head>
<body style="background-color: rgb(219, 218, 218);">
    <?php include '../php/header.php' ?>

    <div style="margin-top: 10px;" class="container">
        <div class="bg-light border rounded-3 p-3">
        <form id="FormPost" action="https://animalshub.ru/php/AddNewCardPet.php" method="post" enctype="multipart/form-data">
            <div class="form-group text-center">
                <label class="d-block">Тип объявления:</label>
                <select id="ad-type" name="adType" class="form-control custom-select mx-auto" style="max-width: 200px;">
                    <option value="enter_type" disabled selected hidden>Укажите тип</option>
                    <option value="1">Продажа</option>
                    <option value="2">Бесплатно</option>
                    <option value="3">Потеряшка</option>
                </select>
            </div>
            <div id="mainForm" class="row" style="display: none;">
                <div class="col-md-4">
                    <div class="animal-info">
                        <label>Имя животного:</label>
                        <input type="text" id="name" name="petNickname" class="form-control" placeholder="Введите имя животного">
                    </div>
                    <div class="text-center">
                        <label>Основная фотография:</label>
                        <input type="file" id="main-photo" name="file" class="form-control-file" accept=".jpeg, .png, .jpg">
                        <!--<img id="main-photo-preview" src="#" alt="Предпросмотр" class="animal-photo">-->
                    </div>
                    <div class="text-center mt-3">
                        <label>Дополнительные фотографии:</label>
                        <input type="file" id="additional-photos" name="files[]" class="form-control-file" accept=".jpeg, .png, .jpg" multiple>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Описание:</label>
                        <textarea id="description" name="petDescription" class="form-control auto-resize" placeholder="Введите описание" style="height: 300px;"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Тип:</label>
                        <select id="animal-type" name="petType" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Порода:</label>
                        <input type="text" id="pet-breed" name="petBreed" class="form-control" placeholder="Введите породу животного">
                    </div>
                    <div class="form-group">
                        <label>Возраст:</label>
                        <input type="number" id="age" name="petAge" class="form-control" placeholder="Введите возраст">
                    </div>
                    <div id="vet_form" class="form-group">
                        <label>Посещение ветеринара:</label>
                        <select id="vet-visit" name="petVeterinary" class="form-control" readonly>
                            <option value="" disabled selected hidden>Укажите частоту обращения</option>
                            <option value="Не посещали">Не посещали</option>
                            <option value="Посещали раз в месяц">Посещали раз в месяц</option>
                            <option value="Посещели 2 раза в год">Посещели 2 раза в год</option>
                            <option value="Посещали раз в год">Посещали раз в год</option>
                        </select>
                    </div>
                    <div id="price_form" class="form-group">
                        <label id="price_text">Цена:</label>
                        <input type="number" id="price" name="petPrice" class="form-control" placeholder="Введите цену">
                    </div>
                </div>
            </div>
            <button style="display: none;" id="create_ad_btn" type="submit" class="btn btn-primary mt-3">Создать карточку</button>
        </form>
        </div>
    </div>

    <!--<script>
        document.getElementById('main-photo').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var preview = document.getElementById('main-photo-preview');
            var reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    </script>-->

    <script src="../js/token.js"></script>
    <script src="search_redirect.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="create_ad39.js"></script>
</body>
</html>