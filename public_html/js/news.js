let user = null;

async function likeNews(element){
    let id = element.id;
    const likeBtn = document.getElementById("news-like-" + id);
    const countLike = document.getElementById("news-count-like-" + id);
    

    if(user == null) user = await getDataSession("user", token);

    const formData = new FormData();
    
    formData.append("newsId", id);
    formData.append("userId", user.Id);

    const response = await fetch("https://api.animalshub.ru/LikeNews.php", {
      method: "POST",
      body: formData,
    });

    if(response.ok){
        const data = await response.json();
        if(data.status == "add"){
            likeBtn.style.color = "red";
        }
        else{
            likeBtn.style.color = "black";
        }
        countLike.innerHTML = data.count;
    }
    
    
}

async function sendNews(){
    const inputField = document.getElementById("news-text-input");

    let community = await getDataSession("Community", token);
    if(user == null) user = await getDataSession("user", token);

    const formData = new FormData();
    text = inputField.value.replace(/\n/g, "<br>");
    formData.append("message", text);
    formData.append("userId", user.Id);
    formData.append("isCommunity", community.IsCommunity);
    formData.append("communityId", community.CommunityId);

    const response = await fetch("https://api.animalshub.ru/SendNews.php", {
      method: "POST",
      body: formData,
    });

    if(response.ok){
        const data = await response.json();
        console.log(data);
        if(data.result == "successfully"){
            addCardNews(text, data.id);
            inputField.value = "";
            inputField.style.height = "20px";
        }
    }
}

function addCardNews(message, idNews){
    const listNews = document.getElementById('div-news-list');

    let userName = user.UserDetails.Name == "" ? user.UserDetails.UserName : user.UserDetails.Name + " " + user.UserDetails.MiddleName;

    let news = `<div id="card-news-${idNews}" class="card-news more-tools-block bg-light border rounded-3 vertical-box p-3 h-100">
    <div class="horizontal-box vertical-align-center">
      <div class="author-icon-news"><img style="height: 32px; width: 32px; border-radius: 15px; object-fit:cover;" src="${user.UserDetails.ImageUrl}" alt=""></div>

      <div class="vertical-box ps-2 w-100">
      <a style="text-decoration: none; color:black;" href="https://animalshub.ru/profile?id=${user.Id}"><div style="font-size:16px;">${userName}</div></a>
        <div style="font-size:12px;color: rgb(124 124 124 / 66%);">Только что</div>
      </div>

      <div class="ac-box" style="position: relative;">
        <div class="more-tools">
          <div class="tool-dots">
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>

        <div class="action-menu-block">
          <div class="action-menu-item">
            <div class="action-menu-item-bg" onclick="removeNews(${idNews}, ${user.Id})"></div>
            Удалить запись
          </div>
        </div>
      
      </div>
    </div>

    <div class="w-100 ps-3 pe-3 pt-2" style="flex: 1;">
      <div>
        <span>
            ${message}
          </span>
      </div>
    </div>

    <div class="horizontal-box horizontal-align-right w-100 ">
      <div class="news-hover-btn cursor-pointer horizontal-box vertical-align-center me-3" id="${idNews}" onclick="openComments(this)">
        <div class="d-flex vertical-align-center h-100">
          <span style="font-size: 18px;" class="material-symbols-outlined">
            Comment
          </span>
        </div>
        <div id="count-comments-${idNews}" class="ps-2">
          0
        </div>
      </div>

      <div class="news-hover-btn cursor-pointer horizontal-box vertical-align-center">
        <div class="d-flex vertical-align-center h-100">
          <span id="news-like-${idNews}" style="font-size: 18px;color: '.$colorLike.';" class="material-symbols-outlined">
              favorite
          </span>
        </div>
        <div id="news-count-like-${idNews}" class="ps-2">
          0
        </div>
      </div>
    </div>
  </div>`;

  listNews.innerHTML = news + listNews.innerHTML;
}

async function removeNews(id, userId){
  const news = document.getElementById('card-news-' + id);
  if(news != null){
    
    const formData = new FormData();

    formData.append("userId", userId);
    formData.append("newsId", id);

    const responce = await fetch("https://api.animalshub.ru/RemoveNews.php", {
      method: 'POST',
      body: formData
    });

    if(responce.ok){
      let result = await responce.text();
      if(result == "successfully"){
        news.remove();
      }
    }
  }
}

async function getDataSession(value, token) {
    let responce = await fetch("https://animalshub.ru/php/getSessionValue.php?value=" + value + "&token=" + token);
    if(responce.ok){
        let data = await responce.json();
        return data;
    }
    else return "error";
}