<?php
session_start();



?>

<div class="w-100 h-100 vertical-box">
    <div class="pt-2 pb-2 ps-3">
        <strong>Фото и фон профиля</strong>
    </div>
    <hr class="p-0 m-0">

    <div class="ps-3 pe-3 pt-3 w-100 h-100 vertical-box" style="overflow: hidden; overflow-y:auto;">
        <div class="vertical-box w-100 h-100">
            <div class="icon-user-select vertical-box pb-2 pt-2">
                <span>Аватарка</span>
                <div style="height: 128px; width: 128px; background-color:antiquewhite; cursor:pointer;" onclick="ShowSelectAndCroppedDialog()">
                    <img id="new-image" src="<?php echo $userImage?>" alt="" class="w-100 h-100" style="object-fit: cover;">
                </div>
            </div>

            <div class="bg-profile-select pb-2 pt-2">
                <span>Фон профиля</span>
                <div class="background-profile-image-container">
                    <img src="https://animalshub.ru/images/android-app/style-1-light/profile/background/profile_cover.jpg" alt="" class="w-100 h-100" style="object-fit: cover;" disable>
                    <div class="background-locked-image-profile vertical-box vertical-align-center horizontal-align-center">
                        <span class="material-symbols-outlined lock-bg-icon">lock</span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>