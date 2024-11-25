let oldMessages = [];
let messages = [];
let newMessages = [];


getAllMessages();

setInterval(() => getAllMessages(), 15000);

function getAllMessages(){
    fetch("https://animalshub.ru/php/GetAllMessages.php", {method: "GET"}).then(x => x.json()).then(data => {
        oldMessages = messages;
        messages = data;
        if(oldMessages.length > 0) checkNewMessages();
    });
}

function checkNewMessages(){
    const notificationBox = document.querySelector(".notification-box");

    newMessages = [];
    for (let index = oldMessages.length; index < messages.length; index++) {
        newMessages += messages[index];

        if(messages[index].IsChecked == 1) continue;

        try {
            if(selectedUserChat != null){
                if(selectedUserChat.Id != messages[index].Id_Sender){
                    notificationBox.innerHTML += getNotificationAtMessage(messages[index]);
                    let msgId = messages[index].Id;
                    playAnim(msgId);
                }
            }
        } catch (error) {
            notificationBox.innerHTML += getNotificationAtMessage(messages[index]);
            let msgId = messages[index].Id;
            playAnim(msgId);
        }

        
    }
    
}

function playAnim(id){
    setTimeout(() => document.getElementById(`msg-${id}`).classList.add("notification-show"), 100);
    setTimeout(() => {
        if(document.getElementById(`msg-${id}`) != null){
            document.getElementById(`msg-${id}`).classList.remove("notification-show");
            document.getElementById(`msg-${id}`).classList.add("notification-delete");
            setTimeout(() => {
                if(document.getElementById(`msg-${id}`) != null){
                    document.getElementById(`msg-${id}`).remove();
                }
            }, 400);
        }
        
        
    }, 3000);
}

function getNotificationAtMessage(message){
    
    let notification = `
    <div id="msg-${message.Id}" class="message-notification-box">
        <div class="message-notification-block bg-light border rounded-3">
            <div style="position:relative;" class="w-100 h-100 horizontal-box">
                <div style="align-self:center;" class="ps-2">
                  <div style="height: 48px; width:48px; border-radius:50%; background-color:aqua;">
                    <div style="height: 48px; width:48px; border-radius:50%;">
                        <img src="${message.ImageUrl}" style="height: 48px; width:48px; border-radius:50%;">
                    </div>
                  </div>
                </div>
                <div class="vertical-box w-100 h-100 ps-2 horizontal-align-center">
                    <div>
                      <span>${message.Name == "" ? message.UserName : message.Name + " " + message.MiddleName}</span>
                    </div>
                    <div>
                      <small>${message.Message}</small>
                    </div>
                </div>

                <div class="message-notification-close-btn vertical-align-center horizontal-align-center" onclick="closeMessageNotification(this)">
                  <small>x</small>
                </div>
            </div>
        </div>
    </div>`;

    return notification;
}