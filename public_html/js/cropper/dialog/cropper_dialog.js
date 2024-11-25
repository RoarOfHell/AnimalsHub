async function ShowSelectAndCroppedDialog(){
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length;

    let background_color = count > 0 ? "background-color: transparent!important;" : "";
  
    document.getElementById('bd').innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="${background_color} position:fixed; height: 100%; width: 100%; top: 0; z-index: 999">
    <div class="container w-100 h-100" style="max-height: 800px; min-height: 500px; padding-left: 200px; padding-right: 200px">
        <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; max-height: 1000px; min-height: 500px;">
            <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
              <div class="w-100 horizontal-box vertical-align-center" style="height: 48px;">
                  <div class="w-100 ps-2">
                      Выбор изображения.
                  </div>
              </div>
              <hr class="w-100 p-0 m-0">
  
              <div class="vertical-box w-100 h-100 horizontal-align-center vertical-align-center" style="overflow:hidden; position:relative; overflow-y: auto;">
                <div id="file-drop-area" class="vertical-box vertical-align-center horizontal-align-center" style="position:absolute;">
                    <input type="file" id="file-input" accept=".jpg, .jpeg, .png, .gif" style="display:none;">
                    <p>Перетащите файл сюда или нажмите для выбора файла</p>
                </div>
                <div id="image-crop-box" class="w-100 h-100 p-5" style="visibility:collapse; position:absolute;">
                    <div class="w-100 h-100 vertical-box">
                        <div class="horizontal-box w-100 vertical-align-center horizontal-align-center">
                            <div class="w-75 h-100">
                                <div id="container" class="h-100" style="position:relative; width: 50%">
                                    <div class="w-100 h-100">
                                        <img id="image-cropping" class="w-100" src="" alt="">
                                    </div>
                                    <div id="crop-box" style="position: absolute; height: 128px; width: 128px; top:0; left: 0;" class="border">

                                    </div>
                                </div>
                            </div>

                            <div class="w-25" style="aspect-ratio: 1/1;">
                                <div class="w-100 h-100 m-3 bg-light border">
                                    <img id="image-cropped" class="w-100 h-100" src="" alt="">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
              </div>
  
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                <div class="w-100 h-100 vertical-box">
                    <div class="horizontal-box">
                        <input type="range" name="" id="size-crop-box" min="0.1" max="2" value="1" step="0.1" onchange="setSizeCrop()">
                        <div>Область выделения</div>
                    </div>
                    <div class="horizontal-box">
                        <input type="range" name="" id="size-image-box" min="10" max="100" value="50" step="1" onchange="setSizeImage()">
                        <div>Размер изображения</div>
                    </div>
                   
                </div>
                  <div><button class="btn btn-primary mt-2" onclick="saveAndCloseDialog()">Применить</button></div>
              </div>
            </div>
        </div>
    </div>
  </div>
  `;
  
  const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
  const fw_dialog = bg_dialog.querySelector('#forward-dialog');
  const crop_box = document.getElementById('crop-box');
  setTimeout(function() {
    bg_dialog.classList.add('dialog-bg-active');
    fw_dialog.classList.add('dialog-fw-active');
  }, 100);
  const handleClose = (e) => {
    e.stopPropagation();
    e.cancelBubble = true;
    bg_dialog.classList.remove('dialog-bg-active');
    fw_dialog.classList.remove('dialog-fw-active');
    crop_box.remove();

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

  cropShowed();
  }

  function closeCropperDialog(){
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length-1;
    const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
    const fw_dialog = bg_dialog.querySelector('#forward-dialog');
    const crop_box = document.getElementById('crop-box');

    crop_box.remove();
    bg_dialog.classList.remove('dialog-bg-active');
    fw_dialog.classList.remove('dialog-fw-active');
    setTimeout(function() {
  
      bg_dialog.remove();
    }, 100);
    
  }

  async function saveAndCloseDialog(){
    await saveNewImage();

    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length-1;
    const bg_dialog = document.querySelector("[id^='background-dialog-"+count+"']");
    const fw_dialog = bg_dialog.querySelector('#forward-dialog');
    const crop_box = document.getElementById('crop-box');

    crop_box.remove();
    bg_dialog.classList.remove('dialog-bg-active');
    fw_dialog.classList.remove('dialog-fw-active');
    setTimeout(function() {
  
      bg_dialog.remove();
    }, 100);
  }