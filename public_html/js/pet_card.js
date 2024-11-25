let allPets = [];

setTimeout(() => {getPets(session.Id);}, 1000);

function getPets(Id) {
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
      }
    })
    .catch(error => {
      console.log("Ошибка!");
    });
}

function generateCardsInPreviewList(pets) {
    let cardsHTML = "";
    pets.forEach(pet => {
      cardsHTML += `<div id="pet-id-${pet.Id}" class="list-pet-card m-2" onclick="showPetCardDialog(this)" >
      <div class="vertical-box" style="width: 200px; height: 200px; justify-content: space-between;">
          <div style="background-color: white; border-radius: 10px 10px 0 0" class="d-flex horizontal-align-center vertical-align-center">
            ${pet.petType}
          </div>
  
          <div style="height: 152px; width: 200px">
              <img class="w-100 h-100" style="object-fit: cover;" src="${pet.imageUrl}" alt="">
          </div>
  
          <div style="background-color: white; border-radius: 0 0 10px 10px" class="d-flex horizontal-align-center vertical-align-center">
            ${pet.petNickname}
          </div>
      </div>
  </div>`;
    });
  
    return cardsHTML;
  }

  function createCardHTML(pet, place) {
    if (place === 'default') {
      if (true) {
        return `
        <div id="pet-id-${pet.Id}" class="m-2 cursor-pointer preview-slot" onclick="showPetCardDialog(this)">
          <img class="w-100 h-100 cursor-pointer preview-slot" style="object-fit: cover;" src="${pet.imageUrl}" alt="Animal Photo" class="animal-photo">
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
                      <button class="animal-button go-to-animal" onclick="goEditAnimal(${pet.Id})" style="width: auto;"><i class="fa-solid fa-pencil"></i></button>
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
                      <button class="animal-button go-to-animal" onclick="goEditAnimal(JSON.stringify(${pet.Id}))" style="width: auto;"><i class="fa-solid fa-pencil"></i></button>
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


  function showPetCardDialog(element){
    let petId = element.id.replace("pet-id-","");
    let pet = allPets.find(pet => pet.Id == petId) ?? null;
  
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length;
  
    document.getElementById("bd").innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0; z-index: 999">
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
                                        Возраст: 
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
                  <div><button class="btn btn-primary mt-2" onclick="closeDialog()">Закрыть</button></div>
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

  function getAllPhotoAtPetId(id){  
    let pet = allPets.find(p => p.Id === id);
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