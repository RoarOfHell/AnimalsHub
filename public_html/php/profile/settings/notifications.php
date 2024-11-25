<?php
session_start();
require_once "vendor/connect.php";
require_once "php/controler/settingsParameter.php";

$userId = $_SESSION['user']->Id;
$notification = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM UserNotification WHERE UserId = $userId"));
?>

<div class="w-100 h-100 vertical-box">
    <div class="pt-2 pb-2 ps-3">
        <strong>Уведомления</strong>
    </div>
    <hr class="p-0 m-0">

    <div class="ps-3 pe-3 pt-3 w-100 h-100 vertical-box" style="overflow: hidden; overflow-y:auto;">
        <div class="vertical-box w-100 h-100">
        <div class="horizontal-box w-100 pb-2 pt-2">
                <span class="w-100">Сообщения</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" name="messageNotify" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $notification['Message'])?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Все</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Подписчики</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Друзья</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Никто</a></li>
                    </ul>
                  </li>
                </ul>
            </div>

            <div class="horizontal-box w-100 pb-2 pt-2">
                <span class="w-100">Новости</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" name="newsNotify" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $notification['News'])?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Включено</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Отключено</a></li>
                    </ul>
                  </li>
                </ul>
            </div>

            <div class="horizontal-box w-100 pb-2 pt-2">
                <span class="w-100">Сообщества</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" name="communityNotify" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $notification['Community'])?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Включено</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Отключено</a></li>
                    </ul>
                  </li>
                </ul>
            </div>

            <div class="horizontal-box w-100 pb-2 pt-2">
                <span class="w-100">Новые подписчики</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" name="newSubsNotify" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo getParameterAtId($connect, $notification['NewSubs'])?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Включено</a></li>
                      <li><a class="dropdown-item" href="#" onclick="select(this)">Отключено</a></li>
                    </ul>
                  </li>
                </ul>
            </div>

            <div class="vertical-box w-100 horizontal-align-center vertical-align-bottom pb-2 pt-2">
              <button type="submit" class="btn btn-primary save-btn" style="visibility: collapse;" onclick="saveNotification()">Сохранить</button>
            </div>
        </div>
        
    </div>
</div>

<script>
  async function saveNotification(){
    const message =document.getElementsByName("messageNotify")[0];
    const news =document.getElementsByName("newsNotify")[0];
    const community =document.getElementsByName("communityNotify")[0];
    const newSubs =document.getElementsByName("newSubsNotify")[0];

    const formData = new FormData();

    formData.append("message", message.innerHTML.trim());
    formData.append("news", news.innerHTML.trim());
    formData.append("community", community.innerHTML.trim());
    formData.append("newSubs", newSubs.innerHTML.trim());

    const responce =await fetch("https://animalshub.ru/php/profile/settings/save/saveNotification.php", {
      method: "POST",
      body: formData
    });

    if(responce.ok){
      const data =await responce.text();
      onDropChangedValue();
    }
  }
</script>