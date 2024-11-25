const loginInput = document.getElementById('login');
const tooltipLogin = document.querySelector('.login-tooltip');
const passwordInput = document.getElementById('password');
const tooltipPassword = document.querySelector('.password-strength-tooltip');
const repeatPasswordInput = document.getElementById('repeat-password');
const tooltipRepeatPassword = document.querySelector('.repeat-password-tooltip');
const registerButton = document.getElementById('registerButton');
const agreeCheckbox = document.getElementById('agreeCheck');
const tooltipInformation = document.querySelector('.information');

let difficulties = ['Слабый', 'Средний', 'Сильный', 'Очень сильный', 'Сильнейший'];

function checkLogin() {
  tooltipInformation.textContent = '';
  loginInput.value = loginInput.value.replace(/[^a-zA-Z0-9]/g, '');
  let length = loginInput.value.length;

  if (length <= 0) {
    tooltipLogin.textContent = '';
  } else if (length > 0 && length <= 5) {
    tooltipLogin.textContent = 'Логин должен быть больше 5 символов!';
    tooltipLogin.style.color = 'red';
  } else {
    tooltipLogin.textContent = '';
  }
}

function checkRepeatPassword() {
  let password = passwordInput.value;
  let repeatPassword = repeatPasswordInput.value;

  if (repeatPassword.length <= 0) {
    tooltipRepeatPassword.textContent = '';
  } else if (repeatPassword != password) {
    tooltipRepeatPassword.textContent = 'Пароли не совпадают!';
    tooltipRepeatPassword.style.color = 'red';
  } else {
    tooltipRepeatPassword.textContent = '';
  }
}

function checkPasswordStrength() {
  const password = passwordInput.value;
  const strength = calculatePasswordStrength(password);

  if (strength === 0) {
    tooltipPassword.textContent = '';
    tooltipPassword.style.visibility = 'hidden';
  } else {
    const strengthText = getStrengthText(strength);
    tooltipPassword.textContent = `Надежность пароля: ${strengthText}`;
    tooltipPassword.style.visibility = 'visible';
  }
}

function calculatePasswordStrength(password) {
  let strength = 0;

  if (/\d/.test(password)) {
    strength += 1;
  }

  if (/[A-Z]/.test(password) | /[А-Я]/.test(password)) {
    strength += 1;
  }

  if (/[a-z]/.test(password) | /[а-я]/.test(password)) {
    strength += 1;
  }

  if (/[\W_]/.test(password)) {
    strength += 1;
  }

  if (password.length >= 5) {
    strength += 1;
  }

  else {
    if (password.length === 0) {
      strength = 0;
    } else {
      strength = 1;
    }
  }

  return strength;
}

function getStrengthText(strength) {
  switch (strength) {
    case 1:
      return difficulties[0];
    case 2:
      return difficulties[1];
    case 3:
      return difficulties[2];
    case 4:
      return difficulties[3];
    case 5:
      return difficulties[4];
    default:
      return '';
  }
}

registerButton.addEventListener('click', function (event) {
  event.preventDefault();

  if (tooltipPassword.textContent != difficulties[0] && (tooltipRepeatPassword.textContent === '' &&
    repeatPasswordInput.value.length > 0) && (tooltipLogin.textContent === '' && loginInput.value.length > 0) &&
    agreeCheckbox.checked && (passwordInput.value === repeatPasswordInput.value)) {
    let formData = new FormData();

    formData.append('login', loginInput.value);
    formData.append('pass', passwordInput.value);
    formData.append('token', token);

    fetch('https://api.animalshub.ru/Registration.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error('Ошибка при выполнении запроса');
        }
      })
      .then(data => {
        if (data === 'complite') {
          window.location.href = 'authorization';
        } else {
          tooltipInformation.textContent = 'Такой пользователь уже существует!';
          tooltipInformation.style.color = 'red';
        }
      })
      .catch(error => {
        console.log('Ошибка при отправке запроса: ' + error);
      });
  }

  else {
    console.log('Final: no');
  }
});