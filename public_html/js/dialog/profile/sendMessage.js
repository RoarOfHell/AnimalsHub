async function ShowSendMessageDialog(){
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length;
  
    const communityList = await getListCommunity();

    let background_color = count > 0 ? "background-color: transparent!important;" : "";
  
    document.getElementById('bd').innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0; z-index: 999;">
    <div class="container w-100 h-100" style="max-height: 500px; min-height: 500px; padding-left: 200px; padding-right: 200px">
        <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; max-height: 303px; min-height: 303px;">
            <div class="vertical-box w-100 h-100" style="overflow: hidden;overflow-y: auto;">
              <div class="w-100 horizontal-box vertical-align-center" style="height: 48px;">
                  <div class="w-100 ps-2">
                      Сообщение пользователю.
                  </div>
              </div>
              <hr class="w-100 p-0 m-0">
              <div class="vertical-box w-100 h-100" style="overflow:hidden;">
                <div class="vertical-box horizontal-align-center w-100 h-100">
                    <textarea name="" id="message-text" cols="30" rows="5" style="padding:4px; margin-inline:20px; color: black;resize: none;"></textarea>
                </div>
              </div>
  
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                    <div class="horizontal-box h-100 vertical-align-center m-3">
                        <div class="me-3"><button class="btn btn-secondary" onclick="closeDialog()">Отмена</button></div>
                        <div><button class="btn btn-primary" onclick="sendMessage()">Отправить</button></div>
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

  async function sendMessage(){
    const message = document.getElementById('message-text').value;
    const userId = get('id');
    
    const formData = new FormData();

    formData.append("token", token);
    formData.append("login", session.Login);
    formData.append("pass", session.Password);
    formData.append("recipient", userId);
    formData.append("message", message);
  
    if(message.trim() != ""){

        const response = await fetch("https://api.animalshub.ru/SendMessage.php", {
            method: 'POST',
            body: formData
        });

        if(response.ok){
            const result = await response.text();
            if(result == "complited"){
                closeDialog();
            }
            else{
                alert("Требуется авторизация!");
            }
        }

        
    }
    else{
        alert("Сообщение не может быть пустым!");
    }
    
  }