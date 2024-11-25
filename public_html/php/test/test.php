<!DOCTYPE html>
  <html lang="en" style="height: 100%;">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    <title>Главная</title>
  </head>

  <body id="bd" style="background-color: rgb(219, 218, 218); display:flex; flex-direction:column; min-height: 100%">
    
    
      <main class="w-100 h-100" style="flex: 1;">
        
      <div id="background-dialog-1" class="dialog-background vertical-align-center horizontal-align-center d-flex dialog-bg-active" style="position:fixed; height: 100%; width: 100%; top: 0">
    <div class="container" style="height: 800px; padding-left: 200px; padding-right: 200px">
      <div id="forward-dialog" class="dialog-forward dialog-fw-active" style="background-color: white; height: 100%; width: 100%; z-index: 10">
          <div class="w-100 h-100 vertical-box p-3">
              <div class="w-100 card-title" style="font-size: 20px; font-weight: bold;">Комментарии</div>
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="w-100 h-100 card-content" style="font-size: 20; font-weight: bold; overflow:hidden; overflow-y: auto;">

                  <div style="overflow:hidden; overflow-y: auto;" class="w-100 h-100">
                    <div class="w-100 h-100 vertical-box p-1">
                        
                    <div class="bg-light border rounded-2">
                        <div class="horizontal-box m-2">
                          <div style="height: 48px; width: 48px; border-radius: 100%">
                              <img src="https://animalshub.ru/users/17/avatar/91b7539ed8a734e671414118f5d62a0d.webp" alt="" style="width: 48px; height: 48px; object-fit:cover; border-radius: 100%">
                          </div>
                          <div class="vertical-box w-100 ps-2">
                              <div>UserName</div>
                              <small class="ps-1" style="font-weight:normal;">Message</small>
                          </div>
                          <div>
                              Time
                          </div>
                        </div>
                    </div>



                    </div>
                  </div>

              </div>
              <div>
                <div class="horizontal-box">
                    <textarea id="comment-input" class="w-100"></textarea>
                    <button class="btn btn-primary" onclick="sendComment(1)">Отправить</button>
                </div>
              </div>
              <hr class="w-100" style="margin: 0; padding: 0;">
              <div class="horizontal-box w-100 vertical-align-center horizontal-align-right">
                  <div><button class="btn btn-primary mt-2" onclick="closeDialog()">Закрыть</button></div>
              </div>
          </div>
      </div>
    </div>
  </div>

      </main>

      <?php include '../../php/footer.php' ?>
                 


      
        <script src="../../js/token.js"></script>
        <script src="../../js/news.js"></script>
     
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>

        <script src="../../js/pet_card.js"></script>
        
  </body>

  </html>   
