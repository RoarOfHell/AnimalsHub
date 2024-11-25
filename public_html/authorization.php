<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Авторизация</title>
</head>
<body style="background-color: rgb(219, 218, 218); height: 100%">
    <div class="container d-flex" style="height: 100%; align-items:center; justify-content:center;">
        <div class="vertical-box vertical-align-center">
          <div class="vertical-box bg-light border rounded-3" style="position: absolute;top: 25%;transform: translate(0, -75%);width: 800px;">
            <strong style="text-align: center; padding: 10px">
              Добро пожаловать на Animals Hub – вашу онлайн-гавань для спасения животных!
            </strong>

            <small class="p-2">
              🐾 Мы верим в магию дружбы между человеком и животными и стремимся сделать этот мир лучше для всех пернатых, шершавых и пушистых существ. Присоединяйтесь к нашему сообществу и помогите нам дарить надежду каждой брошенной лапке.
            </small>

            <small class="p-2">
            🏠 Здесь вы найдете уютный уголок для обмена идеями, поддержки приютов и спасения животных. Вместе мы создаем место, где истории успеха наполняют сердца, и каждая помощь важна.
            </small>

            <small class="p-2">
            💬 Давайте начнем действовать вместе. Зарегистрируйтесь, создайте карточки о животных, общайтесь в чате и делитесь своей страстью к животным. Вместе мы делаем больше!
            </small>

            <small class="p-2">
            🌟 Добро пожаловать в Animals Hub, место, где меняется не только мир животных, но и мир внутри нас. Разделяйте свою любовь к животным, и вместе мы сделаем разницу. Поехали!
            </small>
          </div>

          <form style="width: 800px">
              <div class="login-form">
                  <h2>Войти</h2>
                    <div class="form-floating">
                      <input type="text" class="form-control" id="login" placeholder="Login" onkeyup="updateTooltipLogin()">
                      <label for="email">Введитe логин...</label>
                      <div class="form-text login-tooltip"></div>
                    </div>
                    <div class="form-floating">
                      <input type="password" class="form-control" id="password" placeholder="Password" onkeyup="updateTooltipPassword()">
                      <label for="password">Введите пароль...</label>
                      <div class="form-text password"></div>
                    </div>
                    <button id="authorization-button" type="submit" class="btn">Войти</button>
                    <div class="form-text information"></div>
                    <span style="text-align: center;" class="mt-3">У вас нет аккаунта? <a style="text-decoration: none;" href="registration">Зарегестрируйтесь!</a></span>
              </div>
          </form>
        </div>
    </div>

    <script src="js/token.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="AnimalsHub/authorization29.js" crossorigin="anonymous"></script>
  </body>
</html>