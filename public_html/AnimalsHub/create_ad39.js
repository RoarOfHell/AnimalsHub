const adTypeSelect = document.getElementById('ad-type');
const form = document.getElementById('FormPost');
const mainForm = document.getElementById('mainForm');
const btn = document.getElementById('create_ad_btn');
const priceForm = document.getElementById('price_form');
const vetForm = document.getElementById('vet_form');
const priceText = document.getElementById('price_text');
const mainPhoto = document.getElementById('main-photo');
const photos = document.getElementById('additional-photos');
const selectTypes = document.getElementById('animal-type');
var allowedFormats = ['image/jpeg', 'image/png', 'image/jpg'];

fillSelectorWithAnimalType();

function searchInMainSheet() {
  const searchInput = document.getElementById('search-input');

  const searchTerm = searchInput.value;
  const redirectUrl = 'https://animalshub.ru?search=' + encodeURIComponent(searchTerm);

  window.location.href = redirectUrl;
}

function selectFilter() {
  window.location.href = 'https://animalshub.ru';
}

function StringBuilder() {
  this.strings = [];
}

StringBuilder.prototype.append = function (string) {
  this.strings.push(string);
};

StringBuilder.prototype.toString = function () {
  return this.strings.join('');
};

function showAllFields() {
  priceForm.style.display = 'block';
  vetForm.style.display = 'block';
  priceText.textContent = 'Цена:';
}

adTypeSelect.addEventListener('change', function () {
  mainForm.style.display = 'flex';
  btn.style.display = 'block';

  if (this.value === '2') {
    showAllFields();
    priceForm.style.display = 'none';
  } else if (this.value === '1') {
    showAllFields();
  } else {
    showAllFields();
    vetForm.style.display = 'none';
    priceText.textContent = 'Вознаграждение:';
  }
});

mainPhoto.addEventListener('change', function (event) {
  console.log('проверка main');
  var file = event.target.files[0];

  if (allowedFormats.indexOf(file.type) === -1) {
    alert('Недопустимый формат файла: ' + file.name);
    event.target.value = '';
  }
});

photos.addEventListener('change', function (event) {
  var files = event.target.files;

  if (files.length > 10) {
    alert('Вы можете загрузить только до 10 фотографий');
    event.target.value = '';
    return;
  }

  for (var i = 0; i < files.length; i++) {
    var file = files[i];

    if (allowedFormats.indexOf(file.type) === -1) {
      alert('Недопустимый формат файла: ' + file.name);
      event.target.value = '';
      return;
    }
  }
});

btn.addEventListener("click", function (event) {
  event.preventDefault();

  var errors = new StringBuilder();

  var name = document.getElementById('name').value;
  var mainPhotoValue = document.getElementById('main-photo').value;
  var additionalPhotos = document.getElementById('additional-photos').value;
  var description = document.getElementById('description').value;
  var age = document.getElementById('age').value;
  var veterinary = document.getElementById('vet-visit').value;
  var price = document.getElementById('price').value;
  var breed = document.getElementById('pet-breed').value;

  if (name === '') {
    errors.append('Введите имя!\n');
  }

  if (mainPhotoValue === '') {
    errors.append('Выберите основную фотографию!\n');
  }

  if (additionalPhotos === '') {
    errors.append('Выберите дополнительные фотографии!\n');
  }

  if (description === '') {
    errors.append('Введите описание!\n');
  }

  if (selectTypes.value === '') {
    errors.append('Введите тип животного!\n');
  }

  if (breed === '') {
    errors.append('Введите породу животного!\n');
  }

  if (age === '') {
    errors.append('Введите возраст животного!\n');
  }

  if (veterinary === '') {
    if (adTypeSelect.value != '3') {
      errors.append('Выберите частоту обращения к ветеринару!\n');
    }
  }

  if (price === '' | price <= 0) {
    if (adTypeSelect.value != '2') {
      errors.append('Введите корректную цену!\n');
    }
  }

  if (errors.strings.length > 0) {
    alert(errors.toString());
    return;
  }

  if (adTypeSelect.value === '2') {
    document.getElementById('price').value = '0';
  }
  if (adTypeSelect.value === '3') {
    document.getElementById('vet-visit').value = '';
  }

  fetch('get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      const loginInput = document.createElement('input');
      loginInput.setAttribute('type', 'hidden');
      loginInput.setAttribute('name', 'login');
      loginInput.setAttribute('value', data.Login);

      const passwordInput = document.createElement('input');
      passwordInput.setAttribute('type', 'hidden');
      passwordInput.setAttribute('name', 'pass');
      passwordInput.setAttribute('value', data.Password);

      const tokenInput = document.createElement('input');
      tokenInput.setAttribute('type', 'hidden');
      tokenInput.setAttribute('name', 'token');
      tokenInput.setAttribute('value', token);


      form.appendChild(loginInput);
      form.appendChild(passwordInput);
      form.appendChild(tokenInput);

      form.submit();

      const inputs = document.querySelectorAll('input');
      inputs.forEach(input => {
        input.value = '';
      });
    })

    .catch(error => {
      console.log("Ошибка при получении пользователя: " + error);
    });
});

function fillSelectorWithAnimalType() {
  fetch('https://api.animalshub.ru/GetAllAnimalsType.php')
    .then(response => response.json())
    .then(data => {
      let mass = data.PetsType;

      for (var item = 0; item < mass.length; item++) {
        const option = document.createElement('option');
        option.value = mass[item].Title;
        option.textContent = mass[item].Title;
        selectTypes.appendChild(option);
      }
    })
    .catch(error => {
      console.log('Ошибка при загрузке данных:', error);
    });
}