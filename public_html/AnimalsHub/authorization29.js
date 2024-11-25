const authButton = document.getElementById('authorization-button');
const inputLogin = document.getElementById('login');
const tooltipLogin = document.querySelector('.login-tooltip');
const inputPassword = document.getElementById('password');
const tooltipPassword = document.querySelector('.password');
const tooltipInformation = document.querySelector('.information');
tooltipInformation.style.color = 'red';

function updateTooltipLogin() {
  tooltipLogin.textContent = '';
  tooltipInformation.textContent = '';
}

function updateTooltipPassword() {
  tooltipPassword.textContent = '';
  tooltipInformation.textContent = '';
}

authButton.addEventListener('click', function (event) {
  event.preventDefault();
  let auth_user_login;
  let auth_user_password;

  if (inputPassword.value != '' && inputLogin.value != '') {
    let formData = new FormData();

    formData.append('login', inputLogin.value);
    formData.append('pass', inputPassword.value);
    formData.append('token', token);

    fetch('https://api.animalshub.ru/Login.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        let user = JSON.parse(JSON.stringify(data));
        auth_user_login = data.Login;
        auth_user_password = data.Password;

        if (auth_user_login.toLowerCase() == inputLogin.value.toLowerCase()) {
          let formData_2 = new FormData();

          formData_2.append('user', JSON.stringify(user));

          fetch('AnimalsHub/LogIn.php', {
            method: 'POST',
            body: formData_2
          })
            .then(response => {
              
              if (response.ok) {
                window.location.href = 'https://animalshub.ru';
              } else {
                console.log('Ошибка при сохранении данных в сессию!');
              }
            })
            .catch(error => {
              console.log('Ошибка при отправке запроса!');
            });
        } else {
          tooltipInformation.textContent = 'Неправильный логин или пароль!';
        }
      })
      .catch(error => {
        console.log('На сервер отправлены неправильные данные!');
        tooltipInformation.textContent = 'Неправильный логин или пароль!';
      });
  } else {
    tooltipPassword.textContent = 'Пароль не должен быть пустым!';
    tooltipLogin.textContent = 'Логин не должен быть пустым!';
  }
});