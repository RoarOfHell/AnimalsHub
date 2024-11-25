<?php
    session_start();
    require_once("vendor/connect.php");
    require_once("php/CardBlueprint.php");
    require_once("php/GetPetsAtPageAndOffset.php");
    $pageNum = 1;
    $page = "cards";
    if(isset($_GET['page'])){
        $pageNum = $_GET['page'];
    }

    $userId = $_SESSION['user']->Id;

    $countCardAtPage = 8;
  
    $pets = getPets($connect, $userId, $pageNum, $countCardAtPage);

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
    <title>Карточки</title>
</head>

<body id="bd" style="background-color: rgb(219, 218, 218); display:flex; flex-direction:column; min-height: 100%">
<?php include 'php/header.php' ?>

<main class="w-100 h-100" style="flex: 1;">
    <div class="container w-100">
        <div class="horizontal-box">
            <div class="bg-light border rounded-3 d-flex justify-content-center align-items-center" style="width: 75%;">
                <div id="indexContainer" class="my-container">
                    <?php 
                        foreach ($pets['Pets'] as $key => $value) {
                            GetCardAtName($value);
                        }
                    ?>
                </div>
            </div>

            <div style="width: 25%;">
                <div class="bg-light border rounded-3 w-100 h-100 ms-3">
                    <div class="vertical-box p-2 h-100">
                        <div class="vertical-box h-100">
                            <input type="text" name="" id="" class="form-control" aria-label="Search" placeholder="Поиск животных...">

                            <div class="vertical-box pt-3">
                                <span>Тип животного</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Порода</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Посещение ветеринара</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Возраст</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Область</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Город</span>
                                <input type="text" name="" id="" class="form-control" aria-label="Search" value="Не имеет значения">
                            </div>
                            <div class="vertical-box pt-3">
                                <span>Стоимость</span>
                                <input type="range" name="" id="">
                            </div>
                        </div>

                        <button class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            echo paginationList($connect, $pageNum, $countCardAtPage);
        ?>
    </div>
</main>

<?php include 'php/footer.php' ?>
    
    <script src="js/token.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="cards38.js" crossorigin="anonymous"></script>
    <script src="js/pet_card.js"></script>
   
</body>

</html>