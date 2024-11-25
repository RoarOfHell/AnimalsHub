const cityInput = document.getElementById('city');
const myCardsContainer = document.getElementById('my-cards');
const myFavoriteContainer = document.getElementById('my-favorite');
const confirmDeleteModal = document.getElementById('confirmDeleteModal');
const mainPhoto = document.getElementById('main-photo');


var allowedFormats = ['image/jpeg', 'image/png', 'image/jpg'];

let rgns;
let user_id;
let myAnimals = [];
let favorite = [];
let showFavorite = false;
let communityList = [];

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
  formData.append('token', token);

  fetch('https://api.animalshub.ru/GetAllFavouritesPets.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      if (data != null) {
        let mass = [];
        mass = data.Pets;
        favorite = mass;
        //generateCardsInFavoriteCards(mass);
      }
    })
    .catch(error => {
      console.log("Ошибка: " + error);
    });
}

function getMyPets(Id) {
  let formData = new FormData();
  formData.append('userid', Id);
  formData.append('token', token);
  formData.append('accountId', session.Id);

  fetch('https://api.animalshub.ru/GetAllPets.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      if (data != null) {
        let mass = [];
        mass = data.Pets;
        allPets = mass;
        let iterator = 0;

        for (var i = 0; i < mass.length; i++) {
          if (mass[i].User.Id === Id) {
            myAnimals[iterator] = mass[i];
            iterator = iterator + 1;
          }
        }

        generateCardsInMyCards(myAnimals);
      }
    })
    .catch(error => {
      console.log("Ошибка!");
    });
}

{/* <div id="${pet.Id}-my-card" class="animal-card">
                  <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
                  <p class="animal-name">${pet.petNickname}</p>
                  <div class="animal-details">
                    <p>Тип: ${pet.petType}</p>
                    <p>Порода: ${pet.breed}</p>
                    <p>Возраст: ${pet.age}</p>
                  </div>
                  <div class="animal-price">${pet.petPrice} руб</div>
                  <div class="animal-buttons">
                    <button class="animal-button go-to-animal" onclick="goEditAnimal(${pet.Id})" style="width: auto;"><i class="fa-solid fa-pencil"></i></button>
                    <button class="animal-button favorite" onclick="removeMyCard(${pet.Id})" style="width: auto;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </div>
                  <div class="ribbon">Потерян</div>
                </div> */}

//pet.adType === 'Потеряшка'


function goEditAnimal(pet) {
  window.location.href = 'edit_animal?Id=' + pet;
}

function goToAnimalPage(pet) {
  window.location.href = 'animal?Id=' + pet;
}

function generateCardsInMyCards(arrayWithPets) {
  myCardsContainer.innerHTML = '';
  if(arrayWithPets.length <= 0) {
    myCardsContainer.innerHTML = '<div style="height: 128px;align-items: center; display: flex; justify-content: center;" class="m-2">Здесь ничего нету</div>';
  }

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
  mainPhoto.style.visibility = 'visible';

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
      if (input.id != 'search-input' && input.id != 'main-photo') {
        isInputsEmpty = true;
      }
    }
  });

  if (!isInputsEmpty) {
    fetch('../AnimalsHub/get_user_with_session.php')
      .then(response => response.json())
      .then(data => {
        let formData = new FormData();
        const userLogin = data.Login;
        const userPassword = data.Password;
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

        // confirmMail(userLogin);

        uploadPhoto(userLogin, userPassword);

        formData.append('login', userLogin);
        formData.append('pass', userPassword);
        formData.append('userDetails', JSON.stringify(userDetails));
        formData.append('token', token);

        fetch('https://api.animalshub.ru/SaveProfileSettings.php', {
          method: 'POST',
          body: formData
        })
          .then(response => {
            if (response.ok) {
              console.log('Запрос на изменение профиля выполнен!');
              setTimeout(updateSession, 500);
            } else {
              console.log('Ошибка при выполнении запроса');
            }
          })
          .catch(error => {
            console.log("Ошибка при выполнении запроса: " + error);
          });
      })
      .catch(error => {
        console.log("Ошибка при получении данных пользователя: " + error);
      });

    const mainPhoto = document.getElementById('main-photo');
    mainPhoto.style.visibility = 'hidden';
    select.disabled = true;
    document.querySelector('.btn-primary').classList.remove('d-none');
    document.querySelector('.btn-success').classList.add('d-none');
  } else {
    alert('Все поля должны быть заполнены!');
  }
}

function removeMyCard(Id) {
  fetch('../AnimalsHub/get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      let formData = new FormData();

      formData.append('login', data.Login);
      formData.append('pass', data.Password);
      formData.append('token', token);
      formData.append('petId', Id);
      formData.append('token', token);

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
  fetch('../AnimalsHub/get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      let formData = new FormData();

      formData.append('login', data.Login);
      formData.append('pass', data.Password);
      formData.append('petid', Id);
      formData.append('token', token);

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
        location.reload();
      } else {
        console.log('Ошибка при выполнении запроса');
      }
    })
    .catch(error => {
      console.log("Ошибка!");
    });
}

function get(name){
  if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
     return decodeURIComponent(name[1]);
}

function getUserId() {
  fetch('../AnimalsHub/get_user_with_session.php')
    .then(response => response.json())
    .then(data => {
      user_id = data.Id;

      if(get('id') == 0){
        getMyPets(user_id);
        getMyFavorites(user_id);
      }
      else{
        getMyPets(get('id'));
        getMyFavorites(get('id'));
      }
      
    })
    .catch(error => {
      console.log("Ошибка при получении пользователя: " + error);
    });
}

function uploadPhoto(userLogin, userPassword) {
  const mainPhoto = document.getElementById('main-photo');
  
  if (mainPhoto.value != '') {
    let formData = new FormData();
    formData.append('login', userLogin);
    formData.append('pass', userPassword);
    formData.append('token', token);
    formData.append('file', mainPhoto.files[0]);

    fetch('https://animalshub.ru/php/UploadImage.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (response.ok) {
          console.log('Фотография успешно отправлена на сервер');

        } else {
          console.log('Ошибка при отправке фотографии на сервер');
        }
      })
      .catch(error => {
        console.log('Ошибка при отправке фотографии на сервер: ' + error);
      });
  }
}

// function confirmMail(login){
//   const mail = document.getElementById('email').value;
//   let formData = new FormData();
//   console.log(login + " цуаодцуоадлцуоа " + mail)

//   formData.append('login', login);
//   formData.append('mail', mail);

//   fetch('https://api.animalshub.ru/SendSecretKeyToMail.php', { method: 'POST', body: formData })
//     .then(response => {
//       if (response.ok) {
//         alert("Подтверждение отправлено на почту: " + document.getElementById(email).value);
//       } else {
//         console.log("Ошибка при выполнении запроса:", response.status);
//       }
//     })
//     .catch(error => {
//       console.log("Ошибка при отправке сообщения на почту: " + error);
//     });
// }


//mainPhoto.addEventListener('change', function (event) {
//  var file = event.target.files[0];
//
//  if (allowedFormats.indexOf(file.type) === -1) {
//    alert('Недопустимый формат файла: ' + file.name);
//    event.target.value = '';
//  }
//});

function showAllCardsDialog(){
  if(showFavorite){
    showAllPetCardsDialog(favorite);
  }
  else{
    showAllPetCardsDialog(myAnimals);
  }
}

function showAllPetCardsDialog(animals){
  const username = document.querySelector('#user-name').innerHTML;
  const userimage = document.querySelector('#user-image').src;
  const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
  let count = all_bg_dialog.length;

  let pets = generateCardsInPreviewList(animals);

  document.getElementById('bd').innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0; z-index: 999">
  <div class="container w-100 h-100" style="max-height: 800px; min-height: 500px; padding-left: 200px; padding-right: 200px">
      <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; max-height: 1000px; min-height: 500px;">
          <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
              <div class="horizontal-box" style="padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-bottom: 10px;">
                  <div style="height: 48px; width:48px;">
                      <img src="${userimage}" alt="" class="w-100 h-100" style="object-fit: cover; border-radius: 50%">
                  </div>
                  <div class="vertical-box vertical-align-left horizontal-align-center ps-3 w-100">
                      ${username}
                  </div>
                  <div class="btn-close cursor-pointer" style="align-self: center;" onclick="closeDialog()"></div>
              </div>
              <hr class="p-0 m-0">

              <div class="w-100 h-100" style="overflow:hidden;overflow-y:auto;background-color: aliceblue;padding-bottom: 50px;margin-bottom: 20px;">
                  <div class="w-100 h-100 horizontal-box" style="flex-wrap: wrap; justify-content: flex-start; align-content: flex-start; padding-left: 28px; padding-right: 28px;">
                      ${pets}
                  </div>
              </div>
              <hr class="p-0 m-0">
          </div>
      </div>
  </div>
</div>`;

const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
const fw_dialog = bg_dialog.querySelector('#forward-dialog');
setTimeout(function() {
  bg_dialog.classList.add('dialog-bg-active');
  fw_dialog.classList.add('dialog-fw-active');
}, 100);
const handleClose = (e) => {
  e.stopPropagation();
  e.cancelBubble = true;
  bg_dialog.classList.remove('dialog-bg-active');
  fw_dialog.classList.remove('dialog-fw-active');
  setTimeout(function() {
    
    bg_dialog.remove();
  }, 100);
  
};
const handleNotAction = (e) => {
  e.stopPropagation();
  e.cancelBubble = true;
}
bg_dialog.addEventListener('click', handleClose);
fw_dialog.addEventListener('click', handleNotAction);
}


function closeDialog(){
  const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
  let count = all_bg_dialog.length-1;
  const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
  const fw_dialog = bg_dialog.querySelector('#forward-dialog');


  bg_dialog.classList.remove('dialog-bg-active');
  fw_dialog.classList.remove('dialog-fw-active');
  setTimeout(function() {

    bg_dialog.remove();
  }, 100);
  
}

function showAdsCards(){
  let pageAds = document.querySelector('#ads');
  let pageFavorites = document.querySelector('#favorites');

  pageAds.classList.add('active-page');
  pageFavorites.classList.remove('active-page');

  showFavorite = false;
  generateCardsInMyCards(myAnimals);
}

function showFavoriteCards(){
  let pageAds = document.querySelector('#ads');
  let pageFavorites = document.querySelector('#favorites');

  pageAds.classList.remove('active-page');
  pageFavorites.classList.add('active-page');

  showFavorite = true;
  generateCardsInMyCards(favorite);
}



async function ShowAllCommunityDialog(){
  const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
  let count = all_bg_dialog.length;

  const communityList = await getListCommunity();

  document.getElementById('bd').innerHTML += `<div id="background-dialog-${count}" class="dialog-background dialog-bg-active vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0; z-index: 999;">
  <div class="container w-100 h-100" style="max-height: 800px; min-height: 500px; padding-left: 200px; padding-right: 200px">
      <div id="forward-dialog" class="dialog-forward dialog-fw-active" style="background-color: white; height: 100%; width: 100%; max-height: 1000px; min-height: 500px;">
          <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
            <div class="w-100 horizontal-box vertical-align-center">
                <div class="w-100 ps-2">
                    Сообщества.
                </div>
                <button class="btn btn-primary m-2" onclick="ShowCreateCommunityDialog()">Создать</button>
            </div>
            <hr class="w-100 p-0 m-0">

            <div class="vertical-box w-100 h-100" style="overflow:hidden; overflow-y:auto;">
                <div class="vertical-box w-100 h-100">
                    ${communityList}
                </div>
            </div>

            <hr class="w-100" style="margin: 0; padding: 0;">
            <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                <div><button class="btn btn-primary m-2" onclick="closeDialog()">Закрыть</button></div>
            </div>
          </div>
      </div>
  </div>
</div>
`;

const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
const fw_dialog = bg_dialog.querySelector('#forward-dialog');
setTimeout(function() {
  bg_dialog.classList.add('dialog-bg-active');
  fw_dialog.classList.add('dialog-fw-active');
}, 100);
const handleClose = (e) => {
  e.stopPropagation();
  e.cancelBubble = true;
  bg_dialog.classList.remove('dialog-bg-active');
  fw_dialog.classList.remove('dialog-fw-active');
  setTimeout(function() {
    
    bg_dialog.remove();
  }, 100);
  
};
const handleNotAction = (e) => {
  e.stopPropagation();
  e.cancelBubble = true;
}
bg_dialog.addEventListener('click', handleClose);
fw_dialog.addEventListener('click', handleNotAction);
}

async function getListCommunity(){
  const sessionCommunity = await getDataSession("communityList", token);
  
  let result = "";

  sessionCommunity.forEach(element => {
    result += `<a style="text-decoration:none; color: black;" href="https://animalshub.ru/community?id=${element[0]}">
    <div class="horizontal-box p-2 m-2 bg-light border rounded-3">
    <div style="height: 48px; width: 48px; border-radius: 80%">
        <img style="height: 48px; width: 48px; border-radius: 80%" src="${element[3]}" alt="">
    </div>

    <div class="vertical-box w-100 ps-3">
        <div style="text-overflow: ellipsis;overflow: hidden;width: 95%; padding-right: 30px; text-wrap: nowrap;">${element[1]}</div>
        <div style="text-overflow: ellipsis;overflow: hidden;width: 95%; padding-right: 30px; text-wrap: nowrap;">${element[2]}</div>
    </div>
</div>
    </a>`;
  });

  return result;
}

//<div id="background-dialog" class="dialog-background dialog-bg-active vertical-align-center horizontal-align-center d-flex" style="position:absolute; height: 100%; width: 100%; top: 0">
//  <div class="container" style="height: 800px; padding-left: 200px; padding-right: 200px">
//    <div id="forward-dialog" class="dialog-forward dialog-fw-active" style="background-color: white; height: 100%; width: 100%; z-index: 10">
//        <div class="w-100 h-100 vertical-box p-3">
//            <div class="w-100 card-title" style="font-size: 20px; font-weight: bold;">Кеша (попугай)</div>
//            <hr class="w-100" style="margin: 0; padding: 0;">
//            <div class="w-100 h-100 card-content" style="font-size: 20; font-weight: bold; overflow:hidden; overflow-y: auto;">
//                <div class="w-100 h-100 vertical-box">
//                    <div class="horizontal-box p-3">
//                        <div style="height: 128px; width: 128px;">
//                            <img src="https://animalshub.ru/users/21/petImages/114/8b56031fab24870491be.jpg" alt="" style="width: 100%; height: 100%; object-fit:cover;">
//                        </div>
//
//                        <div class="vertical-box" style="justify-content: space-around; padding-right: 30px; padding-left: 20px">
//                            <div>
//                                Тип животного: попугай
//                            </div>
//
//                            <div>
//                                Порода: Пятнистый
//                            </div>
//
//                            <div>
//                                Возраста: 2
//                            </div>
//                        </div>
//
//                        <div class="vertical-box" style="justify-content: space-around; padding-right: 30px">
//                            <div>
//                                Посещение ветеринара: ежемесечно
//                            </div>
//
//                            <div>
//                                Стоимость: 1250 руб
//                            </div>
//
//                            <div style="visibility: hidden;">
//                                asd
//                            </div>
//                        </div>
//                    </div>
//                    <hr>
//                    <div class="w-100 pb-4 d-flex vertical-align-center horizontal-align-center">
//                        <div class="w-75" style="aspect-ratio: 16/9;">
//                            <div style="position: absolute;
//                                        top: 50%;
//                                        transform: translate(20px, 50%);
//                                        font-size: 20px;
//                                        background: white;
//                                        height: 32px;
//                                        width: 32px;
//                                        align-items: center;
//                                        display: flex;
//                                        justify-content: center;
//                                        border-radius: 50%;
//                                        cursor:pointer;">
//                                <
//                            </div>
//                            <img src="https://animalshub.ru/users/21/petImages/114/1d56a2dd7c44dfbe68a2.jpg" alt="" style="width: 100%; height: 100%; object-fit:cover;">
//                        </div>
//                    </div>
//
//                    <div>
//                        Описание...
//                    </div>
//                </div>
//            </div>
//            <hr class="w-100" style="margin: 0; padding: 0;">
//            <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
//                <div><button class="btn btn-primary mt-2" onclick="closeDialog()">Закрыть</button></div>
//            </div>
//        </div>
//    </div>
//  </div>
//</div>