const cardsContainer = document.getElementById("indexContainer");
const searchInpt = document.getElementById("search-input");

let filter = 'Тип';
searchInpt.addEventListener("input", handleSearch);

function selectFilter(value) {
  filter = value;
}

let arrayAllPets = [];

let formData = new FormData();
formData.append('userid', '0');
formData.append('token', token);

//fetch('https://api.animalshub.ru/GetAllPets.php', { method: 'POST', body: formData })
//  .then(response => response.json())
//  .then(data => {
//    arrayAllPets = Object.values(data.Pets);
//    arrayAllPets = shuffleArray(arrayAllPets);
//    generateCards(arrayAllPets);
//  })
//  .catch(error => {
//    console.log("Ошибка: " + error);
//  });

function createCardHTML(pet) {

  if (pet.adType === 'Потеряшка') {
    return `
      <div id="pet-id-${pet.Id}" class="animal-card" onclick="showPetCardDialog(this)">
        <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
        <p class="animal-name">${pet.petNickname}</p>
        <div class="animal-details">
          <p>Тип: ${pet.petType}</p>
          <p>Порода: ${pet.breed}</p>
          <p>Возраст: ${pet.age}</p>
        </div>
        <div class="animal-price">${pet.petPrice} руб</div>
        <div class="animal-buttons">
          <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify(${pet.Id}))"><i class="fa fa-heart" aria-hidden="true"></i></button>
        </div>
        <div class="ribbon">Потерян</div>
      </div>
    `;
  } else if (pet.adType === 'Продажа') {
    return `
      <div id="pet-id-${pet.Id}" class="animal-card" onclick="showPetCardDialog(this)">
        <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
        <p class="animal-name">${pet.petNickname}</p>
        <div class="animal-details">
          <p>Тип: ${pet.petType}</p>
          <p>Порода: ${pet.breed}</p>
          <p>Возраст: ${pet.age}</p>
        </div>
        <div class="animal-price">${pet.petPrice} руб</div>
        <div class="animal-buttons">
          <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify(${pet.Id}))"><i class="fa fa-heart" aria-hidden="true"></i></button>
        </div>
      </div>
    `;
  } else {
    return `
      <div id="pet-id-${pet.Id}" class="animal-card" onclick="showPetCardDialog(this)">
        <img src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
        <p class="animal-name">${pet.petNickname}</p>
        <div class="animal-details">
          <p>Тип: ${pet.petType}</p>
          <p>Порода: ${pet.breed}</p>
          <p>Возраст: ${pet.age}</p>
        </div>
        <div class="animal-price">Бесплатно</div>
        <div class="animal-buttons">
          <button class="animal-button favorite" style="width: auto;" onclick="addFavorite(JSON.stringify(${pet.Id}))"><i class="fa fa-heart" aria-hidden="true"></i></button>
        </div>
      </div>
    `;
  }
}

function addFavorite(pet) {
  formData = new FormData();
  formData.append('petid', pet);

  fetch('check_favorite.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
      if (data === "{}") {
        fetch('https://animalshub.ru/AnimalsHub/get_user_with_session.php')
          .then(response => response.json())
          .then(data => {
            formData = new FormData();

            formData.append('petid', pet);
            formData.append('login', data.Login);
            formData.append('pass', data.Password);
            formData.append('token', token);

            fetch('https://api.animalshub.ru/AddFavouritesPet.php', { method: 'POST', body: formData })
              .then(response => {
                if (response.ok) {
                  alert('Карточка добавлена в избранное!');
                } else {
                  console.log("Ошибка при выполнении запроса:", response.status);
                }
              })
              .catch(error => {
                console.log("Ошибка при добавлении животного в таблицу избранных!");
              });
          })
          .catch(error => {
            console.log("Ошибка при получении пользователя!");
          });
      } else {
        alert('Это животное уже находится в избранных!');
      }
    })
    .catch(error => {
      console.log("Ошибка при получении избранного животного!" + error);
    });
}

function goToAnimalPage(pet) {
  console.log(pet);
  window.location.href = 'AnimalsHub/animal?Id=' + pet;
}

function shuffleArray(array) {
  let shuffledArray = array.slice();

  for (let i = shuffledArray.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [shuffledArray[i], shuffledArray[j]] = [shuffledArray[j], shuffledArray[i]];
  }

  return shuffledArray;
}

function generateCards(arrayWithPets) {
  for (let i = 0; i < arrayWithPets.length; i++) {
    const cardHTML = createCardHTML(arrayWithPets[i]);
    cardsContainer.insertAdjacentHTML("beforeend", cardHTML);
  }
}

function handleSearch() {
  const searchText = searchInpt.value.trim().toLowerCase();
  let filteredPets = [];

  if (searchText.length === 0) {
    cardsContainer.innerHTML = "";
    generateCards(arrayAllPets);
  } else {
    if (filter === 'Тип') {
      filteredPets = arrayAllPets.filter(pet => {
        return pet.petType.toLowerCase().startsWith(searchText);
      });
    } else if (filter === 'Возраст') {
      filteredPets = arrayAllPets.filter(pet => {
        return pet.age.toLowerCase().startsWith(searchText);
      });
    } else if (filter === 'Имя') {
      filteredPets = arrayAllPets.filter(pet => {
        return pet.petNickname.toLowerCase().startsWith(searchText);
      });
    } else if (filter === 'Порода') {
      filteredPets = arrayAllPets.filter(pet => {
        return pet.breed.toLowerCase().startsWith(searchText);
      });
    }

    cardsContainer.innerHTML = "";
    generateCards(filteredPets);
  }
}

function showPetCardDialog(element){
  let petId = element.id.replace("pet-id-","");
  let pet = arrayAllPets.find(pet => pet.Id == petId) ?? null;
  console.log(pet.petPrice);

  const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
  let count = all_bg_dialog.length;

  document.getElementById("bd").innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0">
  <div class="container" style="height: 800px; padding-left: 200px; padding-right: 200px">
    <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; z-index: 10">
        <div class="w-100 h-100 vertical-box p-3">
            <div class="w-100 card-title" style="font-size: 20px; font-weight: bold;">Карточка животного</div>
            <hr class="w-100" style="margin: 0; padding: 0;">
            <div class="w-100 h-100 card-content" style="font-size: 20; font-weight: bold; overflow:hidden; overflow-y: auto;">
                <div class="w-100 h-100 vertical-box">
                    <div class="horizontal-box p-3">
                        <div style="height: 128px; width: 128px;">
                            <img src="${pet.imageUrl}" alt="" style="width: 100%; height: 100%; object-fit:cover; border-radius: 10px;">
                        </div>

                        <div class="vertical-box" style="justify-content: space-around; padding-right: 30px; padding-left: 20px">

                          <div>
                            <div class="dialog-text-block">
                              <div class="dialog-text-type">
                                  Кличка: 
                              </div>
                              <div class="dialog-text">
                                  ${pet.petNickname}
                              </div>
                            </div>
                          </div>
                      
                          <div>
                              <div class="dialog-text-block">
                                  <div class="dialog-text-type">
                                      Порода: 
                                  </div>
                                  <div class="dialog-text">
                                      ${pet.breed}
                                  </div>
                              </div>
                          </div>
                          <div>
                              <div class="dialog-text-block">
                                  <div class="dialog-text-type">
                                      Возраста: 
                                  </div>
                                  <div class="dialog-text">
                                      ${pet.age}
                                  </div>
                              </div>
                          </div>
                      </div>
                      
                      <div class="vertical-box" style="justify-content: space-around; padding-right: 30px">
                          <div>
                            <div class="dialog-text-block">
                              <div class="dialog-text-type">
                                  Тип животного: 
                              </div>
                              <div class="dialog-text">
                                  ${pet.petType}
                              </div>
                            </div>
                          </div>
                      
                          <div>
                              <div class="dialog-text-block">
                                  <div class="dialog-text-type">
                                      Посещение ветеринара: 
                                  </div>
                                  <div class="dialog-text">
                                      ${pet.veterinarian}
                                  </div>
                              </div>
                          </div>
                          <div>
                              <div class="dialog-text-block">
                                  <div class="dialog-text-type">
                                      Стоимость: 
                                  </div>
                                  <div class="dialog-text">
                                      ${pet.petPrice}
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>
                    <hr>
                    <div class="w-100 pb-4 d-flex vertical-align-center horizontal-align-center">
                        <div class="w-75" style="aspect-ratio: 16/9;">
                            <div style="margin-top: 10px;" id="carouselExampleIndicators" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                              <div class="carousel-inner w-100 h-100">
                                ${getAllPhotoAtPetId(pet.Id)}
                              </div>
                              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Previous</span>
                              </button>
                              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                  <span class="visually-hidden">Next</span>
                              </button>
                            </div>
                        </div>
                    </div>

                    <div>
                      <div class="dialog-text-description">
                        <div class="dialog-text">${pet.petDescription}</div>
                      </div>
                    </div>
                </div>
            </div>
            <hr class="w-100" style="margin: 0; padding: 0;">
            <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                <div><button class="btn btn-secondary mt-2" onclick="closeDialog()">Закрыть</button></div>
                <div><button class="btn btn-primary ms-2 mt-2" onclick="">Написать пользователю</button></div>
            </div>
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

function getAllPhotoAtPetId(id){  
  let pet = arrayAllPets.find(p => p.Id === id);
  let images = "";

  pet.petImages.forEach(function(image, index) {
   
    if (index == 0) {
      images += `<div class="carousel-item active h-100 w-100" style="border-radius: 10px;">
              <img src="${image}" class="d-block w-100 h-100" alt="Изображение 1" style="object-fit: cover; border-radius: 10px;">
   
            </div>`;
      } 
      else {
        images += `<div class="carousel-item h-100 w-100" style="border-radius: 10px;">
          <img src="${image}" class="d-block w-100 h-100" alt="Изображение ${index+1}" style=" object-fit: cover; border-radius: 10px;">
        </div>`;
      }
  });

  return images;
}


/*
<div class="my-card">
      <div class="image-container" style="background-image: url('${pet.imageUrl}');"></div>
      <h1>${pet.petNickname}</h1>
      <h4>Type: ${pet.petType}</h4>
      <h4>Breed: ${pet.breed}</h4>
      <h4>Age: ${pet.age}</h4>
      <div class="card-buttons">
        <button class="card-button-like"><i class="fa fa-heart" aria-hidden="true"></i></button>
        <button class="card-button-look"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
      </div>
    </div>
*/