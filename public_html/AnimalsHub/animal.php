<?php
session_start();
require_once '../vendor/connect.php';

$PetId = $_GET['Id'];

$pet = mysqli_fetch_assoc(mysqli_query($connect, "select * from Pets where Id = $PetId"));

$imagesResult = mysqli_query($connect, "select * from PetImages where PetCardId = $PetId");

while ($imgR = mysqli_fetch_assoc($imagesResult)) {
    $images[] = $imgR;
}
$page = "petInfo";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title><?php echo $pet['petNickname'] ?></title>
</head>

<body style="background-color: rgb(219, 218, 218);">
    <?php include '../php/header.php' ?>

    <div style="margin-top: 10px;" class="container">
        <div class="bg-light border rounded-3 p-3">
        <form method="GET" action="profile_trader">
            <div class="row">
                <div class="col-md-4">
                    <div class="animal-info">
                        <label for="name">Имя животного:</label>
                        <input type="text" id="name" class="form-control" placeholder="Введите имя животного" value="<?php echo $pet['petNickname'] ?>" readonly>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo $pet['imageUrl'] ?>" alt="Фотография животного" class="animal-photo">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="description">Описание животного:</label>

                        <textarea style="height: 270px;" id="description" class="form-control auto-resize" readonly><?php echo $pet['petDescription'] ?>
                        </textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="type">Тип животного:</label>
                            <input type="text" id="type" class="form-control" value="<?php echo $pet['petType'] ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="age">Возраст:</label>
                            <input type="number" id="age" class="form-control" value="<?php echo $pet['Age'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="price">Порода:</label>
                            <input type="text" id="breed" class="form-control" value="<?php echo $pet['Breed'] ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="price">Цена:</label>
                            <input type="text" id="price" class="form-control" value="<?php if ($pet['AdTypeId'] == 1) echo $pet['petPrice'];
                                                                                        else echo "0"; ?> руб." readonly>
                        </div>
                        <input style="visibility: hidden;" name="Id" value="<?php echo $PetId ?>">
                    </div>
                </div>
            </div>

            <center>
                <div style="width:350px; height: 380px; margin-top: 10px;" id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height: 430px;">
                        <?php
                        $isFirst = true;
                        foreach ($images as $img) {
                            if ($isFirst) {
                                echo '<div class="carousel-item active">
                        <img src="' . $img['ImageUrl'] . '" class="d-block w-100" alt="Изображение 1">
                    </div>';
                                $isFirst = false;
                            } else {
                                echo '<div class="carousel-item">
                        <img src="' . $img['ImageUrl'] . '" class="d-block w-100" alt="Изображение 2">
                    </div>';
                            }
                        }

                        ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </center>

            <?php if($_SESSION['user'] != null) echo '<button type="submit" class="btn btn-primary mt-5">Связаться с продавцом</button>'; else "";?>
        </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
</body>

</html>