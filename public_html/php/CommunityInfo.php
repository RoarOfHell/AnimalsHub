<?php
    function checkUserSubAtId($communitySubs, $id){
        foreach ($communitySubs as $key => $value) {
            if($value['UserId'] == $id) return true;
        }
        return false;
    }

    $isAdmin
?>

<div class="container w-100 d-flex justify-content-center vertical-box">
    <div class="w-100 bg-light rounded-3 mb-3">
        <div class="community-bg"><img src="" alt="" class="w-100 h-100 rounded-3" style="object-fit: cover;"></div>
        <div class="horizontal-box">
            <div style="position: relative; height: 128px; width: 128px; margin-left: 10px;margin-right: 10px; transform: translate(0, -25%);">
                <div style="height: 128px; width: 128px;">
                    <div class="community-avatar"><img id="community-avatar" src="<?php echo $communityInfo['ImageUrl']?>" alt="" class="w-100 h-100" style="object-fit: cover; border-radius: 50%"></div>
                </div>
            </div>
            <div class="community-name w-100 vertical-box">
                <div id="community-name">
                    <?php echo $communityInfo['Name']?>
                </div>
                <div id="community-description">
                    <?php echo $communityInfo['Description']?>
                </div>
            </div>
            
            <div class="horizontal-box p-3">
                <?php
                    if($isAdmin){
                        echo '<div>
                            <button id="btn-settings" class="btn btn-primary me-3" onclick="ShowEditCommunityDialog()">Настройки</button>
                        </div>';
                    }
                ?>
                <div>
                    <button id="btn-subs" class="btn btn-<?php echo checkUserSubAtId($communitySubs, $userId) ? "secondary" : "primary"?>" onclick="subCommunity()"><?php echo checkUserSubAtId($communitySubs, $userId) ? "Отписаться" : "Подписаться"?></button>
                </div>
            </div>
        </div>
    </div>
  <div class="w-100">
    <div class="news-container">
      <div class="w-100 horizontal-box">
        <div class="cards-container bg-light border rounded-3 w-75">
            <div class="cards-horizontal-list">
              <?php
                $pets = mysqli_fetch_all(mysqli_query($connect, "select * from Pets order by rand() limit 10;"));
                foreach ($pets as $key => $value) {
                GetCard($value);
                }
                ?>
            </div>
        </div>
        <div class="w-25 bg-light rounded-3 ms-3 p-2 vertical-box" style="height: 330px;">
            <div id="count-subs">Подписчики: <?php echo $communityInfo['Count'];?></div>
            <hr class="m-0 p-0">
            <?php
            
                foreach ($communitySubs as $key => $sub) {
                   if($key == 5) break;
                    $username = $sub['Name'] == "" ? $sub['UserName'] : $sub['Name'] . " " . $sub['MiddleName'];
                    $image = $sub['ImageUrl'];
                    $userSubId = $sub['UserId'];

                    echo '<div class="p-2">
                    <div class="w-100 horizontal-box">
                        <div style="height: 32px; width: 32px"><img src="'.$image.'" alt="" class="w-100 h-100" style="object-fit: cover;"></div>
                        <div style="text-overflow: ellipsis; overflow: hidden; w-100"><a style="color: black; text-decoration: none;" href="https://animalshub.ru/profile?id='.$userSubId.'">'.$username.'</a></div>
                    </div>
                </div>';
                }
            ?>
            
        </div>
      </div>
      <div class="w-75 vertical-box">
        <?php include 'php/BlockAddNewNews.php' ?>
      </div>
        
    </div>
   
  </div>
</div>


<script>
    function get(name){
      if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
         return decodeURIComponent(name[1]);
    }

    async function subCommunity(){
        const subBtn = document.getElementById('btn-subs');
        const subCount =document.getElementById('count-subs');
        const communityId = get('id');
        const userSessionId = await getSessionUserId();

        const formData = new FormData();

        formData.append('communityId', communityId);
        formData.append('userId', userSessionId);

        const response = await fetch("https://api.animalshub.ru/SubscribeCommunity.php", {
            method: 'POST',
            body: formData
        });

        if(response.ok){
            const data =await response.json();
            if(data.status == "removed"){
                subBtn.classList.remove('btn-secondary');
                subBtn.classList.add('btn-primary');
                subBtn.innerHTML = "Подписаться";
            }
            else{
                subBtn.classList.add('btn-secondary');
                subBtn.classList.remove('btn-primary');
                subBtn.innerHTML = "Отписаться";
            }

            subCount.innerHTML = "Подписчики: " + data.count;
        }
    }

</script>