<?php
session_start();
  require_once 'vendor/connect.php';
  require_once "php/GetUserInfo.php";
  $user_id_url = 0;

  if(isset($_SESSION['user'])){
    $user_id_url = $_SESSION['user']->Id;

    $login = $_SESSION['user']->Login;
    $password = $_SESSION['user']->Password;
    
    $newSession = getUserInfo($connect, "feVTjcfvmVELBWWm44cDJdFfb3FG6JHd", $login, $password);
    
    $_SESSION['user'] = $newSession;
    $confidentiality = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM UserConfidentiality WHERE UserId = $user_id_url"));
    
    $_SESSION['settings'] = $confidentiality;

    $userImage = $_SESSION['user']->UserDetails->ImageUrl;
  }

  

  $version_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * from ProjectVersion"));
?>

<script src="js/session.js"></script>
<script src="js/header.js"></script>

<header class="p-3 mb-3 border-bottom header-bg">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
            <img style="width: 32px; width: 32px;" src="https://animalshub.ru/images/icons/web-icon/logo/LogoMyPets.svg" alt="Logo">
            <strong class="ps-2 pe-4">AnimalsHub</strong>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a class="nav-link px-2 <?php echo ($page == "main" ? "link-secondary" : "link-dark")?>" href="https://animalshub.ru">Главная</a></li>
            <li><a class="nav-link px-2 <?php echo ($page == "cards" ? "link-secondary" : "link-dark")?>" href="https://animalshub.ru/cards">Карточки</a></li>
            <li><a class="nav-link px-2 <?php echo ($page == "help" ? "link-secondary" : "link-dark")?>" href="https://animalshub.ru/help">Помощь</a></li>
            <li><a class="nav-link px-2 <?php echo ($page == "about" ? "link-secondary" : "link-dark")?>" href="https://animalshub.ru/about_us">О нас</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input id="search-input" type="search" class="form-control" placeholder="Поиск животных ..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?php 
              if(isset($_SESSION['user'])) echo $_SESSION['user']->UserDetails->ImageUrl;
              else echo "";
            ?>" alt="mdo" width="32" height="32" class="rounded-circle" style="object-fit:cover;">
          </a>
          <ul class="dropdown-menu text-small" style="width: 350px;" aria-labelledby="dropdownUser1">
            <li>
              <div class="bg-light border rounded-3 ms-2 me-2 mb-2" style="box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2)">
                <div class="p-3 d-flex">
                  <!-- User Icon -->
                  
                  <div style="width:64px; height: 64px;">
                      <img src="<?php 
                        if(isset($_SESSION['user'])) echo $_SESSION['user']->UserDetails->ImageUrl;
                        else echo "";
                      ?>" alt="mdo" class="rounded-circle w-100 h-100" style="object-fit:cover;">
                    </div>

                    <div class="align-self-center">
                      <div class="fs-5 ps-2">
                        <?php 
                          if(isset($_SESSION['user'])) echo $_SESSION['user']->UserDetails->UserName;
                          else echo "";
                        ?>
                      </div>
                      <div class="fs-6 ps-3">
                        <?php 
                          if(isset($_SESSION['user'])) echo "+". $_SESSION['user']->UserDetails->NumPhone;
                          else echo "Телефон не указан...";
                        ?>
                      </div>
                    </div>

                    <div style="position: absolute; right:0px; padding-right:20px; align-self:center;">
                      <div>
                        <?php 
                          $countFavorite = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count from Favourites where UserId = $user_id_url"))['count'];
                          echo $countFavorite;
                        ?>
                        <img src="../images/icons/web-icon/navIcon/favorite.svg" alt="" style="width:16px; height:16px;">
                      </div>
                      <div>
                      <?php 
                          $countPets = mysqli_fetch_assoc(mysqli_query($connect, "select count(*) as count from Pets where Id_User = $user_id_url"))['count'];
                          echo $countPets;
                        ?>
                        <img src="../images/icons/web-icon/logo/LogoMyPets.svg" alt="" style="width:16px; height:16px;">
                      </div>
                    </div>

                </div>
              </div>
            </li>

            <li>
              <a class="dropdown-item" href="profile?id=<?php echo $user_id_url;?>">
                <img src="../images/icons/web-icon/navIcon/ProfileIcon.svg" alt="">
                Профиль
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="chat">
                <img src="../images/icons/web-icon/navIcon/MessageIcon.svg" alt="">
               Сообщения
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="profileSettings">
                <img src="../images/icons/web-icon/navIcon/SettingsIcon.svg" alt="" style="width: 16px; height:16px;">
               Настройки
              </a>
            </li>

            <li>
              <a class="dropdown-item" href="#">
                <img src="../images/icons/web-icon/navIcon/HelpIcon.svg" alt="">
                Тех поддержка
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item" href="<?php if(isset($_SESSION['user'])) echo "php/LogOut.php"; else echo "https://animalshub.ru/authorization";?>">
                  <img src="../images/icons/web-icon/navIcon/ExitIcon.svg" alt="">
                  <?php
                    if(isset($_SESSION['user'])) echo "Выйти";
                    else echo "Войти";
                  ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <div class="project-version">
    <div class="version">
        Version: <?php echo $version_info['Version']; ?>
    </div>
    <div class="company">
        Company: <?php echo $version_info['Company']; ?>
    </div>
  </div>

  <div class="notification-box">
      
  </div>

  
<script>

  setTimeout(function(){
    const formData = new FormData();

    formData.append('userId', session.Id);

    const responce = fetch("https://api.animalshub.ru/InitUserConfidentiality.php", {
      method: 'POST',
      body: formData
    });

    if(responce.ok){
      const result = responce.text();
      console.log(result);
    }
  }, 1000);

  
  

  function closeMessageNotification(element){
    const notificationBlock = element.parentNode.parentNode.parentNode;
    notificationBlock.classList.add("notification-delete");

    setTimeout(() => {
                if(notificationBlock != null){
                  notificationBlock.remove();
                }
            }, 400);
  }
</script>