<?php
session_start();
require_once("../vendor/connect.php");

if (isset($_GET['Id'])) {
    $petId = $_GET['Id'];
    $pet = mysqli_fetch_assoc(mysqli_query($connect, "select * from Pets where Id ='$petId'"));
    $traiderId = $pet['Id_User'];

    if ($_SESSION['user']->Id == $traiderId) {
        header("Location: profile");
    } else {
        $trader = mysqli_fetch_assoc(mysqli_query($connect, "select * from Users where Id = '$traiderId'"));
        $userDetails = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserDetails where UserId ='$traiderId'"));

        $userName = $userDetails['UserName'];
        $userAvatar = $userDetails['ImageUrl'];

        if (empty($trader) && empty($userDetails)) {
            header("Location: http://animalshub.ru");
        } else {
            $trader['UserDetails'] = $userDetails;
        }


    }
} else {
    header("Location: http://animalshub.ru");
}

$page = "profileTrader";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <title>Профиль пользователя <?php echo $trader['UserDetails']['Name']; ?></title>
    <link rel="stylesheet" href="../css/modalStyle.css">
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

        .report-block {
            cursor: pointer;
            padding: 10px;
            margin-bottom: 5px;
            border: 1px solid transparent;
            transition: background-color 0.3s;
        }

        .report-block:hover {
            background-color: #f1f1f1;
        }

        .report-block.selected {
            background-color: #e9e9e9;
        }
    </style>
</head>

<body style="background-color: rgb(219, 218, 218);">
    <?php include '../php/header.php' ?>
    <div class="container-fluid px-3">
        <h1 class="text-center mt-4">Профиль пользователя <?php echo $trader['UserDetails']['Name']; ?></h1>
        <hr>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <label id="trader-id" class="d-block text-center mb-2">GFH ID: <?php echo $trader['Id']; ?></label>
                <div class="rounded-circle overflow-hidden mx-auto" style="width: 300px; height: 300px;">
                    <img src="<?php if ($trader['UserDetails']['ImageUrl'] != '') {
                                    echo $trader['UserDetails']['ImageUrl'];
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
                            <input type="email" class="form-control" id="email" value="<?php echo $trader['UserDetails']['Mail']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="first-name">Фамилия</label>
                            <input type="text" class="form-control" id="first-name" value="<?php echo $trader['UserDetails']['Name']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="middle-name">Имя</label>
                            <input type="text" class="form-control" id="middle-name" value="<?php echo $trader['UserDetails']['MiddleName']; ?>" readonly>
                        </div>
                        <!-- <div class="form-group">
                  <label for="login">Login</label>
                  <input type="text" class="form-control" id="login" value="derrje" readonly>
                </div> -->
                        <div class="form-group">
                            <label for="nickname">Никнейм</label>
                            <input type="text" class="form-control" id="nickname" value="<?php echo $trader['UserDetails']['UserName']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Birthday">Дата рождения</label>
                            <input type="date" class="form-control datepicker" id="Birthday" value="<?php echo $trader['UserDetails']['Birthday']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Номер телефона</label>
                            <input type="tel" class="form-control" id="phone" value="<?php echo $trader['UserDetails']['NumPhone']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="gender">Пол</label>
                            <select class="form-control" id="gender" disabled>
                                <option value="0" <?php if ($trader['UserDetails']['Gender'] == 0) echo 'selected'; ?>>Мужской</option>
                                <option value="1" <?php if ($trader['UserDetails']['Name'] == 1) echo 'selected'; ?>>Женский</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Город</label>
                            <input type="text" class="form-control" id="city" value="<?php echo $trader['UserDetails']['City']; ?>" readonly>
                            <div id="city-results"></div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-start">
                                <button class="btn btn-danger mt-4" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>
                                <button id="openModalBtn" class="btn btn-primary mt-4 ms-2"><i class="fa fa-envelope" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <h1 class="text-center mt-4 mr-4">Объявления</h1>
                <hr>
                <div id="trader-cards" class="my-container d-flex justify-content-center align-items-center">

                </div>
            </div>

            <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reportModalLabel">Выберите репорт</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="report-block" data-report="1">Мошенничество или обман</div>
                            <div class="report-block" data-report="2">Неправдивая информация</div>
                            <div class="report-block" data-report="3">Некорректное поведение в чате</div>
                            <div class="report-block" data-report="4">Нарушение правил безопасности</div>
                            <div class="report-block" data-report="5">Несоответствие описанию или фотографиям</div>
                            <div class="report-block" data-report="6">Несоответствие условиям использования</div>
                            <div class="report-block" data-report="7">Жестокое обращение с животными</div>
                            <div class="report-block" data-report="8">Спам</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="sendReportButton">Отправить</button>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php include '../php/modal.php' ?>


            <script src="../js/token.js"></script>
            <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
            <script src="prifile_report4.js"></script>
            <script src="../js/modal.js"></script>
        </div>
    </div>
</body>

</html>