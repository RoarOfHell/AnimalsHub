
<div id="div-news-create" class="news-list">
  <?php
  


  $isShowInputNews = $_SESSION['user']->Id == $userId;

  if($page == "community"){
    $_SESSION['Community'] = [
      "IsCommunity" => true,
      "CommunityId" => $communityId
    ];
    $currentId = $_SESSION['user']->Id;
    $isAdmin = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM SubscribersCommunity WHERE UserId = $currentId and Role > 1"))['count'] > 0;

    $isShowInputNews = $isAdmin;
  }
  else{
    $_SESSION['Community'] = [
      "IsCommunity" => false,
      "CommunityId" => 1
    ];
  }

  if($isShowInputNews) echo '<div id="new-card-block" class="card-news bg-light border rounded-3 vertical-box p-3" style="min-height: 48px !important; height: 73px;">
  <div class="horizontal-box vertical-align-center w-100">
    <div class="author-icon-news">
      <img style="height: 32px; width: 32px; border-radius: 15px; object-fit:cover;" src="'.$_SESSION['user']->UserDetails->ImageUrl.'" alt="">
    </div>
    <div class="create-news ps-2 pe-2 w-100 horizontal-box">
      <!--<input id="news-text-input" type="text" autocomplete="off" name="textInput" id="" class="input-create-news w-100">-->
      <textarea spellcheck="true" id="news-text-input" name="textInput" class="textarea resize-ta fs-16px br-5px bg-white w-100 p-2" style="color: black; margin-top: 0 !important; margin-bottom: 0 !important;"></textarea>
    </div>
  </div>
  <div id="more-tools-create-news" class="horizontal-box create-news-more-tools h-100 vertical-align-bottom">
    <div class="horizontal-box vertical-align-center w-100" style="height:50px;">
      <div class="button-news-tools">
        <span class="material-symbols-outlined">
          add_a_photo
        </span>
      </div>
      <div class="button-news-tools">
        <span class="material-symbols-outlined">
          pets
        </span>
      </div>
    </div>
    <button class="btn btn-primary" style="font-size: 14px;" onclick="sendNews()">
          Опубликовать
    </button>
  </div>
</div>';
else "";

   ?>
            
                <div id="div-news-list" class="news-list">
                <?php
                    include 'DateFormats/date_format.php';

                    foreach ($allNews as $key => $value) {
                        $idNews = $value[0];
                        $textNews = $value[1];
                        $auchorNews = $value[2];
                        $communityId = $value[3]; 
                        $dateNews = NormalizeDate($value[4]);
                       
                        $isCommunity = $value[5];
                        $abilityComment = $value[6];
                        $countLikeNews = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM LikedNews where IdNews = $idNews"))['count'];
                        $countComments = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Comments where News = $idNews"))['count'];

                        $sessionUserId = $_SESSION['user']->Id;

                        $checkNews = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count From LikedNews where IdUser = $sessionUserId and IdNews = $idNews;"))['count'];

                        $userDetails = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM UserDetails where UserId = $auchorNews"));

                        $communityDetails = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM Community where Id = $communityId"));

                        if($isCommunity == 1){
                          $userName = $communityDetails['Name'];
                        }
                        else{
                          $userName = $userDetails['Name'] == "" ? $userDetails['UserName'] : $userDetails['Name'] . " " . $userDetails['MiddleName'];
                        }
                        
                        $colorLike = $checkNews == 0 ? "black" : "red";

                        $actionMenuTool = $auchorNews == $_SESSION['user']->Id ? '<div class="action-menu-item">
                        <div class="action-menu-item-bg" onclick="removeNews('.$idNews.', '.$userId.')"></div>
                        Удалить запись
                      </div>' : '<div class="action-menu-item">
                      <div class="action-menu-item-bg" onclick="reportNews('.$idNews.', '.$userId.')"></div>
                        Пожаловаться
                      </div>';

                      $newsImage = $isCommunity == 1 ? $communityDetails['ImageUrl'] : $userDetails['ImageUrl'];
                      $urlNavName = $isCommunity == 1 ? "https://animalshub.ru/community?id=".$communityDetails['Id'] : "https://animalshub.ru/profile?id=".$userDetails['UserId'];

                      $commentButton = $abilityComment == 1 ? '<div class="news-hover-btn cursor-pointer horizontal-box vertical-align-center me-3" id="'.$idNews.'" onclick="openComments(this)">
                      <div class="d-flex vertical-align-center h-100">
                        <span style="font-size: 18px;" class="material-symbols-outlined">
                          Comment
                        </span>
                      </div>
                      <div id="count-comments-'.$idNews.'" class="ps-2">
                        '.$countComments.'
                      </div>
                    </div>' : '';

                        echo '<div id="card-news-'.$idNews.'" class="card-news more-tools-block bg-light border rounded-3 vertical-box p-3 h-100">
                    <div class="horizontal-box vertical-align-center">
                      <div class="author-icon-news"><img style="height: 32px; width: 32px; border-radius: 15px; object-fit:cover;" src="'.$newsImage.'" alt=""></div>
                      <div class="vertical-box ps-2 w-100">
                        <a style="text-decoration: none; color:black;" href="'.$urlNavName.'"><div style="font-size:16px;">'.$userName.'</div></a>
                        <div style="font-size:12px;color: rgb(124 124 124 / 66%);">'. $dateNews .'</div>
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
                          '.$actionMenuTool.'

                        </div>
                      
                      </div>
                    </div>
  
                    <div class="w-100 ps-3 pe-3 pt-2" style="flex: 1;">
                      <div>
                        <span>
                            '.$textNews.'
                          </span>
                      </div>
                    </div>
                    
                    <div class="horizontal-box horizontal-align-right w-100 ">
                      '. $commentButton .'


                      <div class="news-hover-btn cursor-pointer horizontal-box vertical-align-center me-3" id="'.$idNews.'" onclick="likeNews(this)">
                        <div class="d-flex vertical-align-center h-100">
                          <span id="news-like-'.$idNews.'" style="font-size: 18px;color: '.$colorLike.';" class="material-symbols-outlined">
                              favorite
                          </span>
                        </div>
                        <div id="news-count-like-'.$idNews.'" class="ps-2">
                          '.$countLikeNews.'
                        </div>
                      </div>
  
                      
                    </div>
                  </div>';
                    }
                ?>
                </div>
                

              </div>



<script src="js/comments_news.js"></script>
<script>
        const inputField = document.getElementById("news-text-input");
        const new_card_block = document.getElementById("new-card-block");
        const bg =document.getElementById('bd');
        const block_news = document.getElementById('div-news-create');

        const toolst = document.getElementById('more-tools-create-news');

        try {
          inputField.addEventListener("focus", function() {
            new_card_block.style.height = ((calcHeight(textarea.value) >= 120 ? 120 : (calcHeight(textarea.value) <= 73 ? 73 : calcHeight(textarea.value))) + 60) + "px";
            toolst.style.opacity = "1";
            toolst.style.visibility = "visible";
        });
        const handleClose = (e) => {
          e.stopPropagation();
          e.cancelBubble = true;
          new_card_block.style.height = (calcHeight(textarea.value) >= 120 ? 120 : (calcHeight(textarea.value) <= 73 ? 73 : calcHeight(textarea.value))) + "px";
          toolst.style.opacity = "0";
            toolst.style.visibility = "hidden";
        };
      
        const handleNotAction = (e) => {
          e.stopPropagation();
          e.cancelBubble = true;

        }

        bg.addEventListener('click', handleClose);
        block_news.addEventListener('click', handleNotAction);

        let textarea = document.querySelector(".resize-ta");
        textarea.addEventListener("keyup", () => {
          textarea.style.height = calcHeight(textarea.value) + "px";
          new_card_block.style.height = ((calcHeight(textarea.value) >= 120 ? 120 : (calcHeight(textarea.value) <= 73 ? 73 : calcHeight(textarea.value))) + 60) + "px";
        });
        }
        catch (Exception){

        }



        // Dealing with Textarea Height
        function calcHeight(value) {
          let numberOfLineBreaks = (value.match(/\n/g) || []).length;
          // min-height + lines x line-height + padding + border
          let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
          return newHeight;
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

        async function reportNews(id, userId){
          const news = document.getElementById('card-news-' + id);
          if(news != null){
            alert("В разработке");
          }
        }
      </script>      