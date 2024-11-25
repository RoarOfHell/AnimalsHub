const modal = document.getElementById("modal-message");
const mesageBox = document.getElementById("message");
const openModalBtn = document.getElementById("openModalBtn");
const closeModal = document.getElementsByClassName("close")[0];
const sendMessageBtn = document.getElementById("sendMessage");
const traiderId = document.getElementById("trader-id");
let session = null;

openModalBtn.addEventListener("click", function() {
  modal.style.display = "block";
});

closeModal.addEventListener("click", function() {
  modal.style.display = "none";
});

window.addEventListener("click", function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
});


sendMessageBtn.addEventListener("click", async function(event) {
    let id = parseInt(traiderId.textContent.match(/\d+/)[0]);
    let message = mesageBox.value;
    let result = await sendMessage(message, parseInt(id));
   
    if(result){
        modal.style.display = "none";
    }
    
});

async function sendMessage(message, recipientId){
    if(message.toString().trimLeft() != ""){
        if(session == null){
            session = await getDataSession("user", token);
        }
        ;
        if(session != "error"){
            const formData = new FormData();
            formData.append('login', session['Login']);
            formData.append('pass', session['Password']);
            formData.append('recipient', recipientId);
            formData.append('message', message);
            formData.append('token', token);

          
        
            let responce = await fetch("https://api.animalshub.ru/SendMessage.php", {method: 'POST', body: formData});
        
            if(responce.ok){
                
                return true;
            }

        }

    }
    return false;
}

async function getDataSession(value, token) {
    let responce = await fetch("https://animalshub.ru/php/getSessionValue.php?value=" + value + "&token=" + token);
    if(responce.ok){
        return responce.json();
    }
    else return "error";
}