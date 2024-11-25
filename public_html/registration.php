<?php
    session_start();
    require_once("vendor/connect.php");

    $result = mysqli_fetch_assoc(mysqli_query($connect, "select * from UserAgreement where Id = 2"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Регистрация</title>
</head>
<body style="background-color: rgb(219, 218, 218);">
    <div class="container">
        <form>
            <div class="login-form">
                <h2>Регистрация</h2>
                <div class="form-floating">
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login" onkeyup="checkLogin()">
                    <label>Придумайте логин...</label>
                    <div class="form-text login-tooltip"></div>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="password" name="pass" placeholder="Password" onkeyup="checkPasswordStrength()">
                    <label>Придумайте пароль...</label>
                    <div class="form-text password-strength-tooltip"></div>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="repeat-password" placeholder="Password" onkeyup="checkRepeatPassword()">
                    <label>Повторите пароль...</label>
                    <div class="form-text repeat-password-tooltip"></div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="agreeCheck">
                    <label class="form-check-label">Я соглашаюсь с пользовательским соглашением</label>
                </div>
                <div class="form-text information" style="color: red;"></div>
                <button type="submit" class="btn mt-3" id="registerButton">Зарегистрироваться</button>
                <span style="text-align: center;" class="mt-3">У вас есть аккаунт? <a style="text-decoration: none;" href="authorization">Войдите!</a></span>
            </div>
        </form>
    </div>
    <div class="modal fade" id="modalAgreement" tabindex="-1" aria-labelledby="modalAgreementLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="height: 600px;">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAgreementLabel">Пользовательское соглашение</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="overflow-y: scroll;">
          <p style="font-size: 14px;">
            <?php
                print ($result['Agreement']);
            ?>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

    <script src="js/token.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="AnimalsHub/user_agreement_modal_window.js"></script>
    <script src="AnimalsHub/password_complexity_calculation32.js"></script>
</body>
</html>