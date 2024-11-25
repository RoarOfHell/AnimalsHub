const cityInput = document.getElementById('city');
const myCardsContainer = document.getElementById('my-cards');
const myFavoriteContainer = document.getElementById('my-favorite');
const confirmDeleteModal = document.getElementById('confirmDeleteModal');
const mainPhoto = document.getElementById('main-photo');

let token = 'feVTjcfvmVELBWWm44cDJdFfb3FG6JHd';

var allowedFormats = ['image/jpeg', 'image/png', 'image/jpg'];

let rgns;
let user_id;
let myAnimals = [];
let favorite = [];

updateSession();
getUserId();
getAllRegions();

function getAllRegions() {
  fetch('https://api.animalshub.ru/GetAllRegions.php')
    .then(response => response.json())
    .then(data => {
      rgns = data.regions;
    })
    .catch(error => {
      console.log("Ошибка при получении городов и областей!");
    });
}

function getMyFavorites(Id) {
  let formData = new FormData();
  formData.append('userid', Id);

  fetch('https://api.animalshub.ru/GetAllFavouritesPets.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      let mass = [];
      mass = data.Pets;
      console.log(mass);
      generateCardsInFavoriteCards(mass);
    })
    .catch(error => {
      console.log("Ошибка: " + error);
    });
}

function getMyPets(Id) {
  let formData = new FormData();
  formData.append('userid', Id);

  fetch('https://api.animalshub.ru/GetAllPets.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      let mass = [];
      mass = data.Pets;
      let iterator = 0;

      for (var i = 0; i < mass.length; i++) {
        if (mass[i].User.Id === Id) {
          myAnimals[iterator] = mass[i];
          console.log(iterator + ' = ' + mass[i].petNickname);
          iterator = iterator + 1;
        }
      }
      console.log('Прошел цикл');
      console.log(myAnimals);
      generateCardsInMyCards(myAnimals);
    })
    .catch(error => {
      console.log("Ошибка!");
    });
}

function createCardHTML(pet, place) {
  console.log(pet);
  if (place === 'default') {
    if (pet.adType === 'Потеряшка') {
      return `
                <div id="${pet.Id}-my-card" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">${pet.petPrice} руб</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeMyCard(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                  <div class="ribbon">Потерян</div>
                </div>
              `;
    } else if (pet.adType === 'Продажа') {
      return `
                <div id="${pet.Id}-my-card" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">${pet.petPrice} руб</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeMyCard(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              `;
    } else {
      return `
                <div id="${pet.Id}-my-card" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">Бесплатно</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(JSON.stringify(${pet.Id}))" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeMyCard(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              `;
    }
  } else if (place === 'favorite') {
    if (pet.adType === 'Потеряшка') {
      return `
                <div id="${pet.Id}-favorite" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">${pet.petPrice} руб</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeFavorite(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                  <div class="ribbon">Потерян</div>
                </div>
              `;
    } else if (pet.adType === 'Продажа') {
      return `
                <div id="${pet.Id}-favorite" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">${pet.petPrice} руб</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeFavorite(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              `;
    } else {
      return `
                <div id="${pet.Id}-favorite" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">Бесплатно</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goToAnimalPage(${pet.Id})" style="width: auto;">&#10132;</button>
                    <button class="animal-button favorite" onclick="removeFavorite(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              `;
    }
  }
}


function goToAnimalPage(pet) {
  console.log(pet);
  window.location.href = 'animal?Id=' + pet;
}

function generateCardsInMyCards(arrayWithPets) {
  for (let i = 0; i < arrayWithPets.length; i++) {
    const cardHTML = createCardHTML(arrayWithPets[i], 'default');
    myCardsContainer.insertAdjacentHTML("beforeend", cardHTML);
  }
}

function generateCardsInFavoriteCards(arrayWithFavorite) {
  for (let i = 0; i < arrayWithFavorite.length; i++) {
    const cardHTML = createCardHTML(arrayWithFavorite[i], 'favorite');
    myFavoriteContainer.insertAdjacentHTML("beforeend", cardHTML);
  }
}


function filterCities(city) {
  const cityResults = document.getElementById('city-results');

  cityResults.innerHTML = '';

  let filteredCities = rgns.filter(region => region.city.toLowerCase().startsWith(city.toLowerCase()));

  for (let i = 0; i < Math.min(filteredCities.length, 5); i++) {
    const option = document.createElement('div');
    option.textContent = `${filteredCities[i].region}, ${filteredCities[i].city}`;
    option.classList.add('city-option');
    option.onclick = function () {
      cityInput.value = `${filteredCities[i].region}, ${filteredCities[i].city}`;
      cityResults.innerHTML = '';
    };
    cityResults.appendChild(option);
  }
}


function toggleEdit() {
  const inputs = document.querySelectorAll('input');
  const select = document.querySelector('select');
  //mainPhoto.style.visibility = 'visible';

  inputs.forEach(input => {
    input.readOnly = false;
  });
  select.disabled = false;

  document.querySelector('.btn-primary').classList.add('d-none');
  document.querySelector('.btn-success').classList.remove('d-none');
}

function saveChanges() {
  const inputs = document.querySelectorAll('input');
  const select = document.querySelector('select');

  let isInputsEmpty = false;

  inputs.forEach(input => {
    if (input.value.trim() === '') {
      if (input.id != 'srch' && input.id != 'main-photo') {
        isInputsEmpty = true;
      }
    }
  });

  if (!isInputsEmpty) {
    fetch('get_user_with_session.php')
      .then(response => response.json())
      .then(data => {
        let formData = new FormData();
        user_id = data.Id;
        formData.append('login', data.Login);
        formData.append('pass', data.Password);
        const userDetails = {
          UserName: document.getElementById('nickname').value,
          Name: document.getElementById('first-name').value,
          MiddleName: document.getElementById('middle-name').value,
          NumPhone: document.getElementById('phone').value,
          City: document.getElementById('city').value,
          Birthday: document.getElementById('Birthday').value,
          Gender: document.getElementById('gender').value,
          Mail: document.getElementById('email').value
        };

        uploadPhoto(data.Login, data.Password);

        formData.append('userDetails', JSON.stringify(userDetails));

        fetch('https://api.animalshub.ru/SaveProfileSettings.php', { method: 'POST', body: formData })
          .then(response => {
            if (response.ok) {
              console.log('Запрос на изменение профиля выполнен!');
            } else {
              console.log('Ошибка при выполнении запроса');
            }
          })
          .catch(error => {
            console.log("Ошибка!");
          });
      })
      .catch(error => {
        console.log("Ошибка!");
      });
    updateSession();
    //mainPhoto.style.visibility = 'hidden';
    select.disabled = true;
    document.querySelector('.btn-primary').classList.remove('d-none');
    document.querySelector('.btn-success').classList.add('d-none');
  } else {
    alert('Все поля должны быть заполнены!');
  }
}

function removeMyCard(Id) {
  fetch('get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      let formData = new FormData();

      formData.append('login', data.Login);
      formData.append('pass', data.Password);
      formData.append('token', token);
      formData.append('petId', Id);

      fetch('https://animalshub.ru/php/RemoveCard.php', { method: 'POST', body: formData })
        .then(response => {
          if (response.ok) {
            var card = document.getElementById(Id + '-my-card');
            card.remove();
            window.location.href = 'https://animalshub.ru/AnimalsHub/profile';
          } else {
            console.log("Ошибка при выполнении запроса:", response.status);
          }
        })
        .catch(error => {
          console.log("Ошибка при получении пользователя: " + error);
        });
    })
    .catch(error => {
      console.log("Ошибка при получении Id!");
    });
}

function removeFavorite(Id) {
  fetch('get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      let formData = new FormData();

      formData.append('login', data.Login);
      formData.append('pass', data.Password);
      formData.append('petid', Id);

      fetch('https://api.animalshub.ru/RemoveFavourites.php', { method: 'POST', body: formData })
        .then(response => {
          if (response.ok) {
            var card = document.getElementById(Id + '-favorite');
            card.remove();
          } else {
            console.log("Ошибка при выполнении запроса:", response.status);
          }
        })
        .catch(error => {
          console.log("Ошибка при удалении животного из избранных: " + error);
        });
    })
    .catch(error => {
      console.log("Ошибка при получении пользователя: " + error);
    });
}

function updateSession() {
  let form_data = new FormData();
  form_data.append('UserName', document.getElementById('nickname').value);
  form_data.append('Name', document.getElementById('first-name').value);
  form_data.append('MiddleName', document.getElementById('middle-name').value);
  form_data.append('NumPhone', document.getElementById('phone').value);
  form_data.append('City', document.getElementById('city').value);
  form_data.append('Birthday', document.getElementById('Birthday').value);
  form_data.append('Gender', document.getElementById('gender').value);
  form_data.append('Mail', document.getElementById('email').value);

  fetch('update_user_session.php', { method: 'POST', body: form_data })
    .then(response => {
      if (response.ok) {
        console.log('Запрос на обновление сессии выполнен!');
      } else {
        console.log('Ошибка при выполнении запроса');
      }
    })
    .catch(error => {
      console.log("Ошибка!");
    });
}

function getUserId() {
  fetch('get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      user_id = data.Id;
      getMyPets(user_id);
      getMyFavorites(user_id);
    })
    .catch(error => {
      console.log("Ошибка при получении пользователя: " + error);
    });
}

function uploadPhoto(userLogin, userPassword) {
  console.log(userLogin + " " + userPassword + " " + mainPhoto.files[0]);
  if (mainPhoto.value != '') {
    let headers = new Headers();
    let formData = new FormData();

    headers.append('Accept', 'application/json');
    headers.append('Content-Type', 'multipart/form-data');
    formData.append('login', userLogin);
    formData.append('pass', userPassword);
    formData.append('token', token);
    formData.append('file', mainPhoto.files[0]);

    fetch('https://animalshub.ru/php/UploadImage.php', { method: 'POST', body: formData, headers: headers })
    .then(response => {
      if (response.ok) {
        console.log('Запрос на обновление фотографии выполнен!');
      } else {
        console.log('Ошибка при выполнении запроса');
      }
    })
      .catch(error => {
        console.log("Ошибка при отправки фотографии на сервер: " + error);
      });
  }
}

mainPhoto.addEventListener('change', function (event) {
  var file = event.target.files[0];

  if (allowedFormats.indexOf(file.type) === -1) {
    alert('Недопустимый формат файла: ' + file.name);
    event.target.value = '';
  }
});