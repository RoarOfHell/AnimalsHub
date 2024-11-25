<?php
session_start();
require_once '../vendor/connect.php';

$PetId = $_GET['Id'];

echo '<div id="petId" style="visibility: collapse; position: absolute;">' . $PetId . '</div>';

$pet = mysqli_fetch_assoc(mysqli_query($connect, "select * from Pets where Id = $PetId"));

$imagesResult = mysqli_query($connect, "select * from PetImages where PetCardId = $PetId");

while ($imgR = mysqli_fetch_assoc($imagesResult)) {
    $images[] = $imgR;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title><?php echo $pet['petNickname'] ?></title>

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 48
        }

        .element {
            height: 128px;
            width: 128px;
            margin: 10px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .element-icon {
            cursor: pointer;
            position: absolute;
            color: white;
            right: 0;
            transition: .3s;
        }

        .element-icon:hover {
            transition: .3s;
            color: red;

        }
    </style>
</head>

<body style="background-color: rgb(219, 218, 218);">

    <?php include '../php/header.php' ?>

    <div style="margin-top: 10px;" class="container">
        <div class="form-group text-center">
            <label class="d-block">Тип объявления:</label>
            <select id="ad-type" name="adType" class="form-control custom-select mx-auto" style="max-width: 200px;">
                <option value="enter_type" disabled selected hidden>Укажите тип</option>
                <option value="1">Продажа</option>
                <option value="2">Бесплатно</option>
                <option value="3">Потеряшка</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="animal-info">
                    <label for="name">Имя животного:</label>
                    <input type="text" id="name" class="form-control" placeholder="Введите имя животного" value="<?php echo $pet['petNickname'] ?>">
                </div>
                <div class="text-center">
                    <img src="<?php echo $pet['imageUrl'] ?>" alt="Фотография животного" class="animal-photo">
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
                <div class="mb-3">
                    <label for="description">Описание животного:</label>
                    <textarea style="height: 270px;" id="description" class="form-control auto-resize"><?php echo $pet['petDescription'] ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="type">Тип животного:</label>
                        <input type="text" id="type" class="form-control" value="<?php echo $pet['petType'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="age">Возраст:</label>
                        <input type="number" id="age" class="form-control" value="<?php echo $pet['Age'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="price">Порода:</label>
                        <input type="text" id="breed" class="form-control" value="<?php echo $pet['Breed'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="price">Цена:</label>
                        <input type="text" id="price" class="form-control" value="<?php if ($pet['AdTypeId'] == 1) echo $pet['petPrice'];
                                                                                    else echo "0"; ?>">
                    </div>
                    <input style="visibility: hidden;" name="Id" value="<?php echo $PetId ?>">
                </div>
                <div class="row">
                    <div style="display: flex; flex-wrap: wrap; width: 512px;">
                        <?php
                        foreach ($images as $img) {
                            echo '<div class="element" style="background-image: url(\'' . $img["ImageUrl"] . '\');">
                        <span class="material-symbols-outlined element-icon" onclick="onRemoveCard(this)">
                            delete
                        </span>
                    </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-5" onclick="saveChangePetAd()">Сохранить</button>
    </div>


    <script src="../js/token.js" crossorigin="anonymous"></script>
    <script src="../js/session.js" crossorigin="anonymous"></script>
    <script src="../js/validation/FieldValidator.js" crossorigin="anonymous"></script>
    <script src="../js/edit_ad.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>

</body>

</html>