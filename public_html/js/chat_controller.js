
let chats = null;
let selectedChat = "";
let lastCountChats = 0;
let lastCountMessages = 0;
let selectedUserChat = null;
let last_date_message = null;
const block_chat = document.querySelector('#block-chat');
const show_info_select_chat = document.querySelector('#show-info-select-chat');
block_chat.style.visibility = 'hidden';

const months = [
    "Января", "Февраля", 
    "Марта", "Апреля", "Мая", 
    "Июня", "Июля", "Августа",
    "Сентября", "Октября", 
    "Ноября", "Декабря"
];

async function updateChatList(){
    const chatList = document.querySelector('#chatList');

    if(session == null){
        session = await getDataSession("user", token);
    }

    chats = await getAllChats(token);
    let chatListHTML = "";
    
    if(chats != null && chats.chats != null){
        if(chats.chats.length != lastCountChats){
            chats.chats.forEach(element => {
                
                if(session['Id'] != element['id_User1']['Id']) {
                    chatListHTML += getChatList(element['id_User1'], element['id'], element['messages']);
                }
                else{
                    chatListHTML += getChatList(element['id_User2'], element['id'], element['messages']);
                }
                lastCountChats++;
            });
        }
        else{
            chats.chats.forEach(element => {
               
                if(session['Id'] != element['id_User1']['Id']) {
                    changeBlockChat(element, element['id_User1']);
                }
                else{
                    changeBlockChat(element, element['id_User2']);
                }
            });
            
        }
        
    }
    else{
        chatList.innerHTML = '';
    }
    
  
    if(chatList.innerHTML != chatListHTML){
        if(chatListHTML != ""){
            chatList.innerHTML = chatListHTML;
        }
        
    }

    openChat();
    searchChat();
}

function getChatList(element, elementId, messages){
    let blockStyle = "";
    let profileIcon = "https://cdn.icon-icons.com/icons2/3066/PNG/512/user_person_profile_avatar_icon_190943.png";
    let visibilityIndicationChecking = "hidden";
    let username = element['UserDetails']['Name'] == "" ? element['UserDetails']['UserName'] : element['UserDetails']['Name'] + " " + element['UserDetails']['MiddleName'];
    let onlineStatus = "collapse";

    if(element['IsOnline'] == "1") onlineStatus = "visible";

    if(messages[messages.length - 1]['id_Sender'] == session['Id'].toString() && messages[messages.length - 1].IsChecked == false){
        visibilityIndicationChecking = "visible";
        if(elementId.toString() == selectedChat) blockStyle += " active";
    }
    else{
        if(getNotCheckedMessage(messages, element['Id']) > 0 && messages[messages.length - 1]['Id_Sender'] != session['Id']){
            blockStyle= "unread"; 
            if(elementId.toString() == selectedChat) blockStyle += " active";
            visibilityIndicationChecking = "visible";
        }
        else{
            if(elementId.toString() == selectedChat) blockStyle += " active";
        }
    }
   
    if(element['UserDetails']['ImageUrl'] != "")  profileIcon = element['UserDetails']['ImageUrl'];
    
    let countMessage = getNotCheckedMessage(messages, element['Id']) == 0 ? "" : getNotCheckedMessage(messages, element['Id']).toString();
    let image = element['UserDetails']['ImageUrl'] == "" ? "https://cdn.icon-icons.com/icons2/1622/PNG/512/3741756-bussiness-ecommerce-marketplace-onlinestore-store-user_108907.png" : element['UserDetails']['ImageUrl'];
    
    return `<div onclick="selectChat(this)" id="chat-id-`+ elementId + `" class="chat-block d-flex">
    <div class="col-3 d-flex justify-content-center align-items-center">
        <img class="rounded-circle chat-icon-border" style="object-fit:cover;" width="48" height="48" src="`+image+`" alt="">
        <div class="user-online-status"></div>
    </div>
    <div class="col-6 d-flex align-items-center">
        <div class="d-block w-100" id="chat-details">
            <div class="chat-user-name" id="userName">`+username+`</div>
            <div class="preview-message">`+messages[messages.length-1]['Message']+`</div>
        </div>
    </div>
    <div class="col-3 d-flex">
        <div class="block-indication w-100">
            <div class="time-last-message">`+getDateTimeMessage(messages[messages.length-1])+`</div>
            <div class="message-check-indicator" style="visibility: `+visibilityIndicationChecking+`">`+countMessage+`</div>
        </div>
    </div>
</div>
<hr class="m-0">`;
}

async function getAllChats(){
    
    const formData = new FormData();

    if(session == null){
        session = await getDataSession("user", token);

    }
  
    if(session != "error"){
        formData.append('login', session['Login']);
        formData.append('pass', session['Password']);
        formData.append('token', token);
    
        let responce = await fetch("https://api.animalshub.ru/GetAllChats.php", {method: 'POST', body: formData});
    
        if(responce.ok){
            let data = await responce.json();
            return data;
        }
        else{
            return "error";
        }
    }
    else{
        return "error";
    }
    
}

async function getDataSession(value, token) {
    let responce = await fetch("https://animalshub.ru/php/getSessionValue.php?value=" + value + "&token=" + token);
    if(responce.ok){
        return responce.json();
    }
    else return "error";
}

function getNotCheckedMessage(messages, idUser) {
    let count = 0;
    messages.forEach(it =>{
        if(it['id_Sender'] == idUser.toString() && it['IsChecked'] == false){
            count++;
        }
    });

    return count;
}   

function getDateTimeMessage(messages) {

    let nowDateTime = new Date();
    let dateTime = new Date(messages['DateTime']);


    if(nowDateTime.getDate() > dateTime.getDate() || nowDateTime.getMonth() != dateTime.getMonth()){
        return + dateTime.getDate() + ' ' + months[dateTime.getMonth()];
    }
    else{
        return dateTime.getHours() + ':' + dateTime.getMinutes();
    }

}

function selectChat(element){
    var div = document.getElementsByClassName(element.className);
    last_date_message = null;
    const messagesList = document.querySelector('#messagesList');
    messagesList.innerHTML = "";
    block_chat.style.visibility = 'visible';
    show_info_select_chat.style.visibility = 'hidden';
    var elementsArray = Array.from(div);

    elementsArray.forEach(function(element) {
      element.classList.remove("active");
    });

    element.classList.add("active");

    selectedChat = (element.id.toString()).replace("chat-id-", "");
    openChat();
}

function openChat(){
    //rightSide
    
    const chatBox = document.querySelector('#chatBox');
    const messagesList = document.querySelector('#messagesList');
    const head_username = document.querySelector('#chat-head-username');
    const head_user_image = document.querySelector('#chat-head-user-image');

    
    chatBox.style.visibility = "visible";
    
    if(chats != null && chats.chats != null){

        chats.chats.forEach(element => {
            if(element['id'].toString() == selectedChat){
                removeDeletedMessageBlock(element);
                let idElement = element['id'];
                let user1 = element['id_User1'];
                let user2 = element['id_User2'];
                let messages = element['messages'];
            
                if(user1.Id != session['Id']) selectedUserChat = user1;
                else selectedUserChat = user2;

                if(getNotCheckedMessage(messages, selectedUserChat['Id']) > 0){
                    checkAllMessagesAtChat(idElement);
                }
                messages.forEach(it => {
                    if(!editMessageBlock(it)){
                        if(last_date_message == null || last_date_message.setHours(0,0,0) != new Date(it.DateTime).setHours(0,0,0)){
                            last_date_message = new Date(it.DateTime)
                            messagesList.innerHTML += messageDateHR(last_date_message);
                        }
                        let userSender = it['id_Sender'] == user1['Id'] ? user1 : user2;
                        messagesList.innerHTML += mesasgeBlock(it, userSender);
                    }
                    else{
                        
                    }
                });

                if(lastCountMessages != messages.length){
                    scrollToBottom();
                    lastCountMessages = messages.length;
                }
            }

        });
    }
    else{
        messagesList.innerHTML = '';
    }

    if(selectedUserChat == null) return;
    let username = selectedUserChat['UserDetails']['Name'] == "" ? selectedUserChat['UserDetails']['UserName'] : selectedUserChat['UserDetails']['Name'];
    if(selectedUserChat['UserDetails']['ImageUrl'] != "") head_user_image.src=selectedUserChat['UserDetails']['ImageUrl'];
    head_user_image.onclick = function(){
        window.location.href = "https://animalshub.ru/profile?id=" + selectedUserChat['Id'];
    };

    head_username.onclick = function(){
        window.location.href = "https://animalshub.ru/profile?id=" + selectedUserChat['Id'];
    };

    head_username.innerHTML = username;
}

function editMessageBlock(message){
    
    const messageBlock = document.querySelector('#msg-id-' + message.id);
    if(messageBlock == null) return false;
    const mesasgeText = messageBlock.querySelector('#msg-text');

    if(mesasgeText.innerHTML != message.Message){
        mesasgeText.innerHTML = message.Message;
    }

    return true;
}

function removeDeletedMessageBlock(chat){
    const messagesBlocks = document.querySelectorAll('[id^="msg-id-"]');
    messagesBlocks.forEach(it => {
        if(!chat['messages'].some(msg => "msg-id-"+msg.id == it.id)){
            it.remove();
        }
    });
}

function mesasgeBlock(message, userSender){
    let block = "";
    let username = userSender['UserDetails']['Name'] == "" ? userSender['UserDetails']['UserName'] : userSender['UserDetails']['Name'];
    let image = userSender['UserDetails']['ImageUrl'] == "" ? "https://cdn.icon-icons.com/icons2/1622/PNG/512/3741756-bussiness-ecommerce-marketplace-onlinestore-store-user_108907.png" : userSender['UserDetails']['ImageUrl'];
    let time = new Date(message['DateTime']);
    block = `<div class="horizontal-box ps-4 vertical-align-top p-2 mgs-box" id="msg-id-`+message.id+`" style="align-items: center;">
    <div style="height:32px;width:32px;" class="mt-2">
        <img src="`+image+`" alt="" style="object-fit: cover;border-radius: 50%;height: 32px;width: 32px;" class="h-100">
    </div>
    <div class="vertical-box ps-2">
        <div class="horizontal-box vertical-align-center">
            <div class="pe-4 fs-14px fw-bold">`+username+`</div>
            <div class=" fs-14px fw-light">`+time.getHours()+":"+time.getMinutes()+`</div>
        </div>
        <div class="horizontal-box fs-13px" style="max-width:350px;">
            <div class="w-100" style="word-wrap: break-word;" id="msg-text">`+message['Message']+`</div>
        </div>
    </div>
    <div class="message-tools">
        <div class="horizontal-box w-100 h-100 vertical-align-center horizontal-align-right">
            <div class="hover-bg-light-gray d-flex vertical-align-center cursor-pointer" onclick="deleteMessage(this)">
                <span class="material-symbols-outlined">
                    delete
                </span>
            </div>
            <div class="hover-bg-light-gray d-flex vertical-align-center cursor-pointer">
                <span class="material-symbols-outlined">
                    edit
                </span>
            </div>
        </div>     
    </div>
</div>`;
    return block;
}

function messageDateHR(time){
    let currentDate = new Date();
    currentDate.setHours(0,0,0,0);
    time.setHours(0,0,0,0);
    let date_show = null;

    if(time.getDate() == currentDate.getDate()) {
        date_show = "Сегодня";
    }
    else if(time.getDate() == new Date(new Date().setDate(new Date().getDate()-1)).getDate()) {
        date_show = "Вчера";
    }
    else{
        date_show = time.getDate() + " " + months[time.getMonth()];
    }

    let hr = `<div class="date-hr-block horizontal-box">
    <hr class="w-100">
    <div class="date-hr">`+date_show+`</div>
    <hr class="w-100">
</div>`;
return hr;
}

function changeBlockChat(element, user){
    const chatBlock = document.querySelector('#chat-id-' + element.id);

    const details = chatBlock.querySelector('#chat-details');

    let onlineStatus = chatBlock.querySelector('.user-online-status');

    const userName = details.querySelector('#userName');

    const message_p = details.querySelector('.preview-message');

    const dateTimeLastMessage = chatBlock.querySelector('.time-last-message');

    let countMessage = getNotCheckedMessage(element['messages'], user['Id']) == 0 ? "" : getNotCheckedMessage(element['messages'], user['Id']).toString();
    const unreadMessageIndicator = chatBlock.querySelector('.message-check-indicator');
    
    userName.innerHTML = user['UserDetails']['Name'] == "" ? user['UserDetails']['UserName'] : user['UserDetails']['Name'] + " " + user['UserDetails']['MiddleName'];
    dateTimeLastMessage.innerHTML = getDateTimeMessage(element['messages'][element['messages'].length - 1]);

    if(user['IsOnline'] == "1") onlineStatus.style.visibility = "visible";
    else onlineStatus.style.visibility = "collapse";
        
    unreadMessageIndicator.style.visibility = "hidden";

    if(element['messages'][element['messages'].length - 1]['id_Sender'] == session['Id'].toString() && element['messages'][element['messages'].length - 1].IsChecked == false){

        unreadMessageIndicator.style.visibility = "visible";
    }
    else{
        
        if(getNotCheckedMessage(element['messages'], user['Id']) > 0 && element['messages'][element['messages'].length - 1]['Id_Sender'] != session['Id']){
            chatBlock.classList.add("unread");
            unreadMessageIndicator.style.visibility = "visible";
        }
        else{
            unreadMessageIndicator.style.visibility = "hidden";
            chatBlock.classList.remove("unread");
        }
    }
    message_p.innerHTML = element['messages'][element['messages'].length - 1].Message;
    unreadMessageIndicator.innerHTML = countMessage;
}

async function handleKeyPress(event, text) {
    if (event.keyCode === 13) {
        const formData = new FormData();

        
        if(text.value.toString().trimLeft() != ""){
            if(session == null){
                session = await getDataSession("user", token);
            }
        
            if(session != "error"){
                formData.append('login', session['Login']);
                formData.append('pass', session['Password']);
                formData.append('recipient', selectedUserChat.Id);
                formData.append('message', text.value);
                formData.append('token', token);
            
                let responce = await fetch("https://api.animalshub.ru/SendMessage.php", {method: 'POST', body: formData});
            
                if(responce.ok){

                }

            }

        }
        text.value = "";
    }
  }

async function sendMessage(){
    let inputElement = document.getElementById("message");
    let text = inputElement.value;
    text = escapeHtml(text);
    if(text.toString().trimLeft() != ""){
        if(session == null){
            session = await getDataSession("user", token);
        }
        ;
        if(session != "error"){
            const formData = new FormData();
            formData.append('login', session['Login']);
            formData.append('pass', session['Password']);
            formData.append('recipient', selectedUserChat.Id);
            formData.append('message', text);
            formData.append('token', token);

          
        
            let responce = await fetch("https://api.animalshub.ru/SendMessage.php", {method: 'POST', body: formData});
        
            if(responce.ok){
                
            }

        }

    }
    inputElement.value = "";
}

async function checkAllMessagesAtChat(chatId){
    let fromData = new FormData();
    fromData.append("token", token);
    fromData.append("login", session['Login']);
    fromData.append("pass", session['Password']);
    fromData.append("chatid", chatId);

    let responce = await fetch("https://api.animalshub.ru/CheckMessagesAtChat.php", {method: 'POST', body: fromData});

    if(responce.ok){
        let data = await responce.text();
        return data;
    }
    else{
        return "error";
    }
}

function searchChat(){
    const chats = document.querySelectorAll('[id^="chat-id-"]');
    const serarchBox = document.querySelector('#search-input');

    if(chats == null) return;

    for(let chat of chats){
        let userName = chat.querySelector('#userName').innerHTML;
        if(userName.startsWith(serarchBox.value)){
            chat.style.display = 'flex';
        }
        else{
            chat.style.display = 'none';
        }
        
    }
}

function scrollToBottom() {
    var chatContainer = document.getElementById("messagesList");
    chatContainer.scrollTop = chatContainer.scrollHeight;
  }

function closeChat() {
    const chatBox = document.querySelector('#chatBox');
    chatBox.style.visibility = "hidden";
}

function escapeHtml(input) {
    return input.replace(/[&<>"'\/]/g, function(match) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;',
            '/': '&#x2F;'
        }[match];
    });
}

async function deleteMessage(msgRemoveBtn){
    let message_block = msgRemoveBtn.parentNode.parentNode.parentNode
    let message_id = message_block.id.replace("msg-id-", "");
    
    
    if(session != "error"){
        const formData = new FormData();
        formData.append('login', session['Login']);
        formData.append('pass', session['Password']);
        formData.append('messageid', message_id);
        
        formData.append('token', token);

        let responce = await fetch("https://api.animalshub.ru/RemoveMessage.php", {method: 'POST', body: formData});
    
        if(responce.ok){

        }

    }
    
}   