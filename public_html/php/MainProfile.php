<?php
session_start();
    require_once 'php/controler/RoleStyle.php';
    $role = $user['IsBaned'] == 1 ? "baned" : $userRole;

?>
<div class="container br-10px" style="height: calc(100% - 90px); padding: 0;">
    <div class="profile-container vertical-box h-100" >
        <div class="mini-bg-profile">
            <img src="https://animalshub.ru/images/android-app/style-1-light/profile/background/profile_cover.jpg" alt="" style="object-fit: cover; width:100%; height:100%; aspect-ratio: 220/43;">
        </div>
        <div class="w-100" style="height: 5px; background-color: <?php echo get_color_at_role($role)?>; <?php echo get_shadow_style_at_role($role)?>">
        </div>
        <div class="horizontal-box w-100 bg-light" style="height: 165px; border-radius: 0 0 0.5em 0.5em">
            <div style="height:128px; width:300px;">
                <div class="user-profile-icon-border" style="position:absolute; background-color: <?php echo get_color_at_role($role)?>; <?php echo get_shadow_style_at_role($role)?>"></div>
                <img id="user-image" class="user-profile-icon" src="<?php echo $userImageUrl?>" alt="">
            </div>
            <div class="vertical-box h-100 ps-3 pt-2 vertical-align-center w-100">
                <div class="horizontal-box w-100 h-100">
                    <div id="user-name" class="user-name-profile vertical-align-center h-100 d-flex"><?php echo $username;?></div>
                    <div class="user-active-profile vertical-align-center h-100 w-100 d-flex ps-4"><?php echo $onlineStatus;?></div>
                    
                    <?php 
                    $subId = $_SESSION['user']->Id;
                    $subText = mysqli_fetch_assoc(mysqli_query($connect, "SELECT count(*) as count FROM Subscribers WHERE Author = $userId and Subscriber = $subId"))['count'] > 0 ? "Отписаться" : "Подписаться";
                        $subscribeBtn = $userId == $_SESSION['user']->Id ? '' : '<button id="subscriberBtn" class="btn me-2 btn-'.($subText == "Отписаться" ? "secondary" : "primary").'" onclick="subscribeBtnClick('.$_SESSION['user']->Id.','.$userId.')">
                        '. $subText .' </button>';

                        if($user['IsBaned'] == 0 && $userId != $_SESSION['user']->Id){
                            echo '<div class="vertical-align-center h-100 d-flex pe-4">
                            '. $subscribeBtn .'
                            <button class="btn btn-primary me-2" onclick="ShowSendMessageDialog()">Сообщение</button>
                            <button class="btn btn-primary me-2" onclick="development()">Позвонить</button>
                        </div>';
                        }
                        else if($userId == $_SESSION['user']->Id){
                            echo '<div class="vertical-align-center h-100 d-flex pe-4">
                            <form action="profileSettings">
                                <button type="submit" class="btn btn-primary me-2">Настройки</button>
                            </form>
                            
                        </div>';
                        }
                    ?>
                    
                </div>
                <div class="vertical-box w-100 h-100">
                    <div id="count-subs">Подписчики: <?php echo $subscribers;?></div>
                    <div>Подписки: <?php echo $subscription;?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container p-0 mt-3">
<?php 
            if($user['IsBaned'] == 0){
                include 'php/ProfileInfo.php';
            }
            else{
                include 'php/ProfileBlocked.php';
            }
        ?>
</div>

<script>
    async function subscribeBtnClick(userId, author){
        const subscriberBtn = document.getElementById('subscriberBtn');
        const subsCount =document.getElementById('count-subs');
        let checkSubsFormData = new FormData();
        checkSubsFormData.append('userId', userId);
        checkSubsFormData.append('author', author);
        const responceCheck = await fetch("https://api.animalshub.ru/SubscribeUser.php", {
            method: "POST",
            body: checkSubsFormData
        });

        if(responceCheck.ok) {
            let result = await responceCheck.json();
            
            if(result.status == "added"){
                subscriberBtn.classList.remove("btn-primary");
                subscriberBtn.classList.add("btn-secondary");
            
                subscriberBtn.innerHTML = "Отписаться";
            }
            else if(result.status == "removed"){
                subscriberBtn.classList.remove("btn-secondary");
                subscriberBtn.classList.add("btn-primary");
                subscriberBtn.innerHTML = "Подписаться";
            }

            subsCount.innerHTML = "Подписчики: " + result.count;

            location.reload();
        }



        
    }
</script>