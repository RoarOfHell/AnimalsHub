<?php
session_start();
require_once("vendor/connect.php");

if (!isset($_SESSION['user'])) {
    header('Location: https://animalshub.ru/authorization');
}
    $user = $_SESSION['user'];
    $page = "profile";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <title>Профиль</title>
   
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        .city-option {
            cursor: pointer;
            padding: 5px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
        }

        .city-option:hover {
            background-color: #e5e5e5;
        }
    </style>
</head>

<body style="background-color: rgb(219, 218, 218);">
    
    <?php include 'php/header.php' ?>

    <div class="container px-3">
        <div class="bg-light border rounded-3 p-5 pt-0">
            <h1 class="text-center mt-4">Ваш профиль</h1>
            <hr>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <label class="d-block text-center mb-2">GFH ID: <?php echo $user->Id; ?></label>
                    <div class="rounded-circle overflow-hidden mx-auto" style="width: 300px; height: 300px;">
                        <img src="<?php if ($user->UserDetails->ImageUrl != '') {
                                        echo $user->UserDetails->ImageUrl;
                                    } else {
                                        echo 'noAvatar.jpg';
                                    } ?>" alt="User Photo" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="edit-container mt-3">
                        <div class="d-flex justify-content-center">
                            <input type="file" id="main-photo" accept=".jpeg, .png, .jpg" style="visibility: hidden;">
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Почта</label>
                                <input type="email" class="form-control" id="email" value="<?php echo $user->UserDetails->Mail; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="first-name">Фамилия</label>
                                <input type="text" class="form-control" id="first-name" value="<?php echo $user->UserDetails->Name; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="middle-name">Имя</label>
                                <input type="text" class="form-control" id="middle-name" value="<?php echo $user->UserDetails->MiddleName; ?>" readonly>
                            </div>
                            <!-- <div class="form-group">
                      <label for="login">Login</label>
                      <input type="text" class="form-control" id="login" value="derrje" readonly>
                    </div> -->
                            <div class="form-group">
                                <label for="nickname">Никнейм</label>
                                <input type="text" class="form-control" id="nickname" value="<?php echo $user->UserDetails->UserName; ?>" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Birthday">Дата рождения</label>
                                <input type="date" class="form-control datepicker" id="Birthday" value="<?php echo $user->UserDetails->Birthday; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone">Номер телефона</label>
                                <input type="tel" class="form-control" id="phone" value="<?php echo $user->UserDetails->NumPhone; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="gender">Пол</label>
                                <select class="form-control" id="gender" disabled>
                                    <option value="0" <?php if ($user->UserDetails->Gender == 0) echo 'selected'; ?>>Мужской</option>
                                    <option value="1" <?php if ($user->UserDetails->Gender == 1) echo 'selected'; ?>>Женский</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="city">Город</label>
                                <input type="text" class="form-control" id="city" oninput="filterCities(this.value)" placeholder="Введите город" value="<?php echo $user->UserDetails->City; ?>" readonly>
                                <div id="city-results"></div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary mt-4" onclick="toggleEdit()"><i class="fas fa-cog"></i></button>
                                <button class="btn btn-success d-none mt-4" onclick="saveChanges()"><i class="fas fa-check"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                <h1 class="text-center mt-4 mr-4">Ваши объявления</h1>
                    <div style="float:right;">
                            <a class="btn btn-primary" href="AnimalsHub/create_ad">+</a>
                        </div>
                    <hr>
                    <div id="my-cards" class="my-container d-flex justify-content-center align-items-center">

                    </div>
                </div>
                <div class="container-fluid">
                    <h1 class="text-center mt-4 mr-4">Избранные объявления</h1>
                    <hr>
                    <div id="my-favorite" class="my-container d-flex justify-content-center align-items-center">

                    </div>
                </div>

                                




                <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
                <script src="js/token.js"></script>
                <script src="AnimalsHub/test77.js" crossorigin="anonymous"></script>
                                
            </div>
        </div>
        
    </div>
</body>

</html>