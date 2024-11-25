async function ShowCreatePetCardDialog(){
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length;
  
    const communityList = await getListCommunity();

    let background_color = count > 0 ? "background-color: transparent!important;" : "";
  
    document.getElementById('bd').innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0; z-index: 999;">
    <div class="container w-100 h-100" style="max-height: 500px; min-height: 500px; padding-left: 200px; padding-right: 200px; z-index: 999;">
        <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; max-height: 1000px; min-height: 500px;">
            <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
              <div class="w-100 horizontal-box vertical-align-center" style="height: 48px;">
                  <div class="w-100 ps-2">
                      Создание карточки животного.
                  </div>
              </div>
              <hr class="w-100 p-0 m-0">
              <div class="vertical-box w-100 h-100" style="overflow:hidden; overflow-y:auto;">
                  <div class="vertical-box w-100 h-100 p-4">
                    <div class="horizontal-box w-100 h-100">
                        <div style="height: 128px; width:128px;cursor:pointer;" onclick="ShowSelectAndCroppedDialog()">
                            <img id="new-image" src="#" alt="" style="height: 128px; width:128px;">
                        </div>
                        <div class="horizontal-box">
                            <div class="vertical-box w-100 ms-4 me-4">
                                <div class="vertical-box w-100">
                                    <div>Кличка</div>
                                    <input type="text" name="" id="pet-name">
                                </div>

                                <div class="vertical-box w-100">
                                    <div>Порода</div>
                                    <input type="text" name="" id="pet-breed">
                                </div>

                                <div class="vertical-box w-100">
                                    <div>Возраст</div>
                                    <input type="text" name="" id="pet-age">
                                </div>
                            </div>

                            <div class="vertical-box w-100 ms-4 me-4">
                                <div class="vertical-box w-100">
                                    <div>Тип животного</div>
                                    <input type="text" name="" id="pet-name">
                                </div>
    
                                <div class="vertical-box w-100">
                                    <div>Посещение ветеринара</div>
                                    <input type="text" name="" id="pet-breed">
                                </div>
    
                                <div class="vertical-box w-100">
                                    <div>Стоимость</div>
                                    <input type="text" name="" id="pet-age">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="vertical-box vertical-align-center horizontal-align-center h-100 w-100">
                      <div>
                          Доп. изображения (В разработке).
                      </div>
                    </div>
                  </div>
              </div>
  
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                    <div class="horizontal-box h-100 vertical-align-center m-3">
                        <div class="me-3"><button class="btn btn-secondary" onclick="closeDialog()">Отмена</button></div>
                        <div><button class="btn btn-primary" onclick="development()">Создать</button></div>
                    </div>
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

async function createCommunity(){
  const image = document.getElementById('new-image-community');
  const nameCommunity = document.getElementById('name-community');
  const descriptionCommunity = document.getElementById('community-description');

  if (image.src[image.src.length - 1] == '#'){
    alert("Выберите изображение!");
    return;
  }

  const canvas = document.createElement('canvas');
  const context = canvas.getContext('2d');
  let imageDataUrl = null;

  try {
    canvas.width = image.width;
    canvas.height = image.height;
    context.drawImage(image, 0, 0, image.width, image.height);
    imageDataUrl = canvas.toDataURL('image/jpeg');
  }
  catch (e) {
    alert("Произошла с добавлением изображения");
    return;
  }

  const formData = new FormData();


  formData.append('image', dataURLtoBlob(imageDataUrl), 'iconCommunity.jpeg');
  formData.append('communityName', nameCommunity.value);
  formData.append('communityDescription', descriptionCommunity.value);
  formData.append('author', session.Id);

  const response = await fetch("https://animalshub.ru/php/CreateNewCommunity.php", {
    method: 'POST',
    body: formData
  });

  if(response.ok){
    const data = await response.text();
    
    if(data == "complited"){
        closeDialog();
        location.reload();
    }
    console.log(data);
  }

  canvas.remove();
}



