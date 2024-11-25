let currentIdComment = null;
let currentComment = null;
let comments = null;
var timer = null;

async function updateComments(){
  comments = await getAllComments(currentIdComment);
  console.log(comments.length);

  const commentsList = document.getElementById('comments-list');
  const btnCountComment = document.getElementById('count-comments-'+currentIdComment);

  let commentsblock = getBlockComments(comments);
  btnCountComment.innerHTML = comments.length;

  commentsList.innerHTML = commentsblock;
}

async function openComments(element){
    const id = element.id;
    currentIdComment = id;
    await dialogComments(id);
    currentComment = id;
    timer = setInterval(updateComments, 1000);
}

async function dialogComments(id){
    comments = await getAllComments(id);
    showCommentsDialog(comments, id);
   
}

async function getAllComments(id){
    const formData = new FormData();

    formData.append("newsId", id);

    const response = await fetch("https://api.animalshub.ru/GetCommentsNews.php", {
        method: "POST",
        body: formData
    });

    if(response.ok){
        
        let data = await response.json();
        return data;
    }
}

async function sendComment(){   
    const input = document.getElementById('comment-input');
    const userId = await getSessionUserId();
    //currentComment
    if(sendMessageComment(userId, input.value, currentComment)){
        input.value = "";
    }
    
}

function showCommentsDialog(comments, id){
    const all_bg_dialog = document.querySelectorAll("[id^='background-dialog-']");
    let count = all_bg_dialog.length;

    let commentsblock = getBlockComments(comments);
  
    document.getElementById("bd").innerHTML += `<div id="background-dialog-${count}" class="dialog-background vertical-align-center horizontal-align-center d-flex" style="position:fixed; height: 100%; width: 100%; top: 0">
    <div class="container" style="height: 800px; padding-left: 200px; padding-right: 200px">
      <div id="forward-dialog" class="dialog-forward" style="background-color: white; height: 100%; width: 100%; z-index: 10">
          <div class="w-100 h-100 vertical-box p-3">
              <div class="w-100 card-title" style="font-size: 20px; font-weight: bold;">Комментарии</div>
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="w-100 h-100 card-content" style="font-size: 20; font-weight: bold; overflow:hidden; overflow-y: auto;">
                  <div style="overflow:hidden; overflow-y: auto;" class="w-100 h-100">
                    <div id="comments-list" class="w-100 h-100 vertical-box p-1">
                        ${commentsblock}
                    </div>
                  </div>
              </div>
              <div>
                <div class="horizontal-box">
                    <textarea id="comment-input" class="w-100"></textarea>
                    <button class="btn btn-primary" onclick="sendComment(${id})">Отправить</button>
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
      clearInterval(timer);
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
    clearInterval(timer);
    setTimeout(function() {
  
      bg_dialog.remove();
    }, 100);
    
  }

  function getBlockComments(comments){
    let commentsResult = "";
    comments.forEach(element => {
        let username = element[6] == "" ? element[5] : element[6] + " " + element[7];
        commentsResult += `
        <div class="bg-light border rounded-2 mt-2">
            <div class="horizontal-box m-2">
              <div style="height: 48px; width: 48px; border-radius: 100%">
                  <img src="${element[8]}" alt="" style="width: 48px; height: 48px; object-fit:cover; border-radius: 100%">
              </div>
              <div class="vertical-box w-100 ps-2">
                  <div>${username}</div>
                  <small class="ps-1" style="font-weight:normal;">${element[2]}</small>
              </div>
              <div style="font-weight:normal; font-size: 0.7em; white-space: nowrap">
              ${NormalizeDate(element[3])}
              </div>
            </div>
        </div>`;
    });

    return commentsResult;
  }

 async function getSessionUserId() {
    const response = await fetch("https://animalshub.ru/AnimalsHub/get_user_with_session.php");

    if(response.ok){
        const data = await response.json();
        return data.Id;
    }

}

async function sendMessageComment(user_id, comment, news_id){
    const formData = new FormData();

    formData.append("user_id", user_id);
    formData.append("comment", comment);
    formData.append("news_id", news_id);

    const response = await fetch("https://api.animalshub.ru/SendCommentNews.php", {
        method: "POST",
        body: formData
    });

    if(response.ok){
        const data = await response.text();
        if(data == "ok"){
            return true;
        }
        else{
            return false;
        }
    }
}