<?php
    session_start();
    require_once("vendor/connect.php");
    $page = "about";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="/images/icons/app-icon/app-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <title>О нас</title>
</head>

<body style="background-color: rgb(219, 218, 218);">
    <?php include 'php/header.php' ?>

    <div class="container">
        <div class="bg-light border rounded-3">
        <selection id="about">
        <div class="row" style="flex-flow: wrap;">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="about-1">
                    <h1>О НАС</h1>
                    <P>Добро пожаловать на наш сайт, который поможет вам найти нового друга и спутника жизни! Мы
                        предлагаем удобный и простой способ найти домашнее животное, которое подарит вам радость и
                        любовь.
                        Спасибо, что выбрали наш сайт и помогаете сделать мир лучше для наших маленьких друзей. Мы
                        надеемся, что вы найдете именно того, кто станет для вас настоящим другом на долгие годы.</P>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div>
            <div class="content-box-lg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="about-item text-center rounded"
                                style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px;">
                                <i class="fa fa-book"></i>
                                <h3>МИССИЯ</h3>
                                <hr>
                                <p class="px-4 py-1">
                                <ul class="px-4 text-center">
                                    <li class="mb-3" style="text-align: start;"><span>Мы создали этот сайт, чтобы помочь
                                            связать людей, которые ищут домашних животных, с теми, кто не может или не
                                            хочет их содержать.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Наша миссия - уменьшить число
                                            бездомных животных и помочь каждому животному найти свой дом.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>На нашем сайте можно найти
                                            множество объявлений от людей, которые готовы отдать своих питомцев в добрые
                                            руки.</span></li>
                                </ul>
                                <hr>
                                <p>Мы верим, что каждое животное заслуживает любви и заботы, и мы делаем все возможное,
                                    чтобы помочь им найти новый дом и новых друзей.</p>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="about-item text-center rounded"
                                style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px;">
                                <i class="fa fa-globe"></i>
                                <h3>ВИДЕНИЕ</h3>
                                <hr>
                                <p class="px-4 py-1">
                                <ul class="px-4 text-center">
                                    <li class="mb-3" style="text-align: start;"><span>Мы стремимся к тому, чтобы наш
                                            сайт был местом, где каждый может найти своего нового друга и компаньона на
                                            долгие годы.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Наша команда работает с
                                            энтузиазмом и старается сделать процесс поиска нового дома для вашего
                                            питомца как можно более простым и приятным.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Мы гордимся тем, что можем помочь
                                            людям находить и приютить животных, которые дадут им радость и
                                            счастье.</span></li>
                                </ul>
                                <hr>
                                <p>Мы надеемся продолжать свою работу в этом направлении и помогать еще большему числу
                                    животных и их новым заботливым хозяевам.</p>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="about-item text-center rounded"
                                style="padding-left: 20px; padding-right: 20px; padding-bottom: 10px;">
                                <i class="fa fa-pencil"></i>
                                <h3>ДОСТИЖЕНИЯ</h3>
                                <hr>
                                <p class="px-4 py-1">
                                <ul class="px-4 text-center">
                                    <li class="mb-3" style="text-align: start;"><span>Более 10 тысяч домашних животных
                                            нашли новый дом благодаря нашему сайту.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Наша команда активно сотрудничает
                                            с приютами для животных и другими благотворительными организациями, чтобы
                                            помочь еще большему числу животных.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Мы постоянно работаем над
                                            улучшением нашего сервиса, чтобы обеспечить максимальную удобность и
                                            эффективность поиска новых домов для домашних питомцев.</span></li>
                                    <li class="mb-3" style="text-align: start;"><span>Наш сайт полностью бесплатен для
                                            использования и доступен всем желающим помочь животным.</span></li>
                                </ul>
                                <hr>
                                <p>Мы надеемся продолжать свою работу в этом направлении и помогать еще большему числу
                                    животных и их новым заботливым хозяевам.</p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </selection>
        </div>
    </div>

    <script src="search_redirect3.js"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
</body>

</html>