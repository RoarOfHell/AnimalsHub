<?php
    require_once "vendor/connect.php";

    require_once "php/controler/settingsParameter.php";
?>

<div class="w-100 h-100 vertical-box">
    <div class="pt-2 pb-2 ps-3">
        <strong>Конфиденциальность</strong>
    </div>
    <hr class="p-0 m-0">

    <div class="ps-3 pe-3 pt-3 w-100 h-100 vertical-box" style="overflow: hidden; overflow-y:auto;">
        <div class="vertical-box w-100 h-100">
        <div class="horizontal-box w-100 pb-2 pt-2">
                <span class="w-100">Профиль</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="profile" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <?php echo getParameterAtId($connect, $confidentiality['Profile'])?>
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
                <span class="w-100">Кто видит мои записи</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="news" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['News'])?>
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
                <span class="w-100">Кто видит мои карточки</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="cards" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Cards'])?>
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
                <span class="w-100">Кто видит мои сообщества</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="community" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Community'])?>
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
                <span class="w-100">Кто видит мои подписки</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="subscriptions" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Subscriptions'])?>
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
                <span class="w-100">Кто видит моих подписчиков</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="subscribers" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Subscribers'])?>
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
                <span class="w-100">Кто может отправлять мне сообщения</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="message" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Message'])?>
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
                <span class="w-100">Кто может видеть мой номер телефона</span>
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle p-0" name="phone" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo getParameterAtId($connect, $confidentiality['Phone'])?>
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

            <div class="vertical-box w-100 horizontal-align-center vertical-align-bottom pb-2 pt-2">
              <button class="btn btn-primary save-btn" style="visibility: collapse;" onclick="saveConfidentiality()">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script>
    function select(item){
        const ul = item.parentNode.parentNode;
        const selectedItem = ul.parentNode;
        const text = selectedItem.querySelector(".dropdown-toggle");

        text.innerHTML = ` ${item.innerHTML.trim()} `;
        onChangeValueDetection();
    }

    async function saveConfidentiality(){
      const profile = document.getElementsByName("profile")[0];
      const news = document.getElementsByName("news")[0];
      const cards = document.getElementsByName("cards")[0];
      const community = document.getElementsByName("community")[0];
      const subscriptions = document.getElementsByName("subscriptions")[0];
      const subscribers = document.getElementsByName("subscribers")[0];
      const message = document.getElementsByName("message")[0];
      const phone = document.getElementsByName("phone")[0];

      const formData = new FormData();

      formData.append("profile", profile.innerHTML.trim());
      formData.append("news", news.innerHTML.trim());
      formData.append("cards", cards.innerHTML.trim());
      formData.append("community", community.innerHTML.trim());
      formData.append("subscriptions", subscriptions.innerHTML.trim());
      formData.append("subscribers", subscribers.innerHTML.trim());
      formData.append("message", message.innerHTML.trim());
      formData.append("phone", phone.innerHTML.trim());

      const responce =await fetch("https://animalshub.ru/php/profile/settings/save/saveConfidentiality.php", {
        method: "POST",
        body: formData
      });

      if(responce.ok){
        const result = await responce.text();
        onDropChangedValue();
      }
    }
</script>