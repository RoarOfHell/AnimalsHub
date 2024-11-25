<?php
    session_start();
    require_once("vendor/connect.php");
    $page = "help";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <title>Помощь</title>

    <style>
        #helpAccordion {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
    </style>

</head>

<body style="background-color: rgb(219, 218, 218);">
    <?php include 'php/header.php' ?>

    <div class="container">
        <div class="bg-light border rounded-3 p-3 pt-1">
        <div class="fullscreen-div" style="padding: 10px; box-sizing: border-box;">
        <div class="d-flex justify-content-center">
            <div class="accordion" id="helpAccordion" style="width: 100%;">
                <h1 class="text-center">Часто задаваемые вопросы</h1>
                <div class="accordion-item m-1">
                    <h2 class="accordion-header" id="question1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer1"
                            aria-expanded="true" aria-controls="answer1">
                            1. Как создать объявление?
                        </button>
                    </h2>
                    <div id="answer1" class="accordion-collapse collapse" aria-labelledby="question1"
                        data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                        Для того чтобы создать объявление, в случае если учетная запись не была зарегистрирована, следует создать её. После чего, Вам необходимо будет авторизироваться под новой учетной записью. Затем, на шапке сайта отобразится кнопка "Создать объявление". Вас перенаправит на форму создания объявления. Последовательно заполнив все данные о Вашем питомце, загрузите основное и несколько дополнительных изображений, после чего нажмите на кнопку "Создать карточку".
                        </div>
                    </div>
                </div>
                <div class="accordion-item m-1">
                    <h2 class="accordion-header" id="question2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#answer2" aria-expanded="false" aria-controls="answer2">
                            2. Как сохранить объявление другого человека?
                        </button>
                    </h2>
                    <div id="answer2" class="accordion-collapse collapse" aria-labelledby="question2"
                        data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                        Чтобы сохранить чужое объявление, Вам необходимо быть авторизованным, затем перейти на главную страницу нашего сайта. Выбрать понравившееся миниатюрное объявление. Внизу у самого края нажать на кнопку с изображением "сердечка". После чего, система оповестит Вас о успешном сохранении объявления. В результате карточка животного будет отображаться в вашем профиле. Сохраненное объявление видите лишь вы.
                        </div>
                    </div>
                </div>
                <div class="accordion-item m-1">
                    <h2 class="accordion-header" id="question3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#answer3" aria-expanded="false" aria-controls="answer3">
                            3. Как изменить данные профиля?
                        </button>
                    </h2>
                    <div id="answer3" class="accordion-collapse collapse" aria-labelledby="question3"
                        data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                        Для изменения данных профиля, перейдите на соответствующую вкладку под названием "Профиль".  Под полями с отображаемой Вашей информацией находится кнопка с изображением "шестерни". Нажмите на неё, после чего блокировка изменения данных в полях выше - снимется и Вам предоставят возможность изменить их. После завершения редактирования, на месте кнопки с "шестерней" появится "галочка".  Для применения настроек, Вам следует нажать на неё.
                        </div>
                    </div>
                </div>
                <div class="accordion-item m-1">
                    <h2 class="accordion-header" id="question4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#answer4" aria-expanded="false" aria-controls="answer4">
                            4. Как связаться с продавцом?
                        </button>
                    </h2>
                    <div id="answer4" class="accordion-collapse collapse" aria-labelledby="question4"
                        data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                        Для того, чтобы связаться с продавцом, Вам необходимо перейти к выбранному вами объявлению, при помощи стрелочки, расположенной внутри объявления на главной странице. После чего Вы должны нажать на кнопку "Связаться с продавцом". При нажатии на эту кнопку между Вами и продавцом образуется новый чат, во вкладке "Сообщения", В результате чего Вы можете продолжить общаться там.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
        <script src="../AnimalsHub/search_redirect3.js"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
</body>

</html>