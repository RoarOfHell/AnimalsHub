<?php
    session_start();
    require_once("vendor/connect.php");

    if (!isset($_SESSION['user'])) {
        header('Location: https://animalshub.ru/authorization');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="https://animalshub.ru/images/icons/app-icon/app-icon.png">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        body, html {
            height: 100%;
        }
    </style>

    <title>Сообщения</title>
</head>


<body style="background-color: rgb(219, 218, 218);">


<?php include 'php/header.php' ?>

<div class="chat-container" id="chat-container">
    
    <div class="content container pb-2">
        <!-- Your content goes here -->
        <div class="vertical-box bg-light rounded-left-5 w-max-350">
            <!-- First column content -->
            <div style="height: 65px;">
                <input id="search-input" type="search" class="form-control" placeholder="Поиск пользователей..." aria-label="Search" onkeyup="searchChat()">
            </div>
            <div class="scrollable-column h-100" id="chatList">
                
            </div>
        </div>
        <div class="vertical-box w-100 bg-light rounded-right-5" id="chatBox">
            <!-- Second column content -->
            <div style="position: fixed; width: 120px; height: 120px; left: 50%; top: 50%; transform: translate(120px, -120px);" class="vertical-align-center horizontal-align-center d-flex" id="show-info-select-chat">
                <div class="vertical-align-center horizontal-align-center d-flex">
                    Выберите чат.
                </div>
            </div>
            <div class="messages-container h-100" style="visibility: hidden;" id="block-chat">
                <div class="messages-header d-flex">
                    <div class="d-flex align-items-center h-100 ps-3 w-100">
                        <div id="chat-head-username" style="font-size: 18px; font-weight: bold; cursor:pointer;">
                            RoarOfHell
                        </div>
                        <div id="chat-head-online-status" class="ps-4" style="font-size: 13px; font-weight: light; color:gray;">
                            Не в сети
                        </div>
                    </div>

                    <div class="d-flex float-end align-items-center h-100 pe-2">
                        <div class="action-chat-user-hover">
                            <div class="action-chat-user">
                                <div class="point-more-action"></div>
                                <div class="point-more-action"></div>
                                <div class="point-more-action"></div>
                            </div>

                            <div class="chat-action-menu" >
                                <div class="w-100 h-100 vertical-box p-2">
                                    <div class="horizontal-box w-100">
                                        <div class="d-flex align-items-center w-100 m-1 p-1 cursor-pointer hover-bg-light-gray br-4px">
                                            <span class="material-symbols-outlined">
                                                report
                                            </span>
                                            <div>Пожаловаться</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img id="chat-head-user-image" class="rounded-circle chat-icon-border" style="object-fit: cover; cursor:pointer;" width="48" height="48" src="https://cdn.icon-icons.com/icons2/1622/PNG/512/3741756-bussiness-ecommerce-marketplace-onlinestore-store-user_108907.png" alt="">
                    </div>
                </div>
                <hr class="m-0">
                <div class="vertical-scroll h-100 w-100 pb-4" id="messagesList">

                </div>
                <hr class="m-0">
                <div class="message-input-box horizontal-box vertical-align-center ps-2 pe-2">
                    <span class="material-symbols-outlined fs-32px hover-gray cursor-pointer">attach_file</span>
                    <textarea spellcheck="true" id="message" class="textarea resize-ta p-2 fs-14px br-5px bg-white w-100" style="color: black;"></textarea>
                    <span class="material-symbols-outlined fs-32px pe-2 ps-3 hover-gray cursor-pointer" onclick="sendMessage()">send</span>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="../js/token.js"></script>
    <script src="https://kit.fontawesome.com/e4b39858b6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../js/chat_controller.js"></script>
    


    <script>
        // Dealing with Textarea Height
        function calcHeight(value) {
          let numberOfLineBreaks = (value.match(/\n/g) || []).length;
          // min-height + lines x line-height + padding + border
          let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
          return newHeight;
        }

        let textarea = document.querySelector(".resize-ta");
        textarea.addEventListener("keyup", () => {
          textarea.style.height = calcHeight(textarea.value) + "px";
          
        });

        textarea.addEventListener("keydown", (evt) => {
            if (!evt.shiftKey && evt.keyCode == 13) {
                if (evt.type == "keypress") {
                    pasteIntoInput(this, "\n");
                }
                else{
                    sendMessage();
                }
                evt.preventDefault();
            }
        });

        updateChatList();
        setInterval(() => {
            updateChatList();
        }, 2000);
    </script>

</body>
</html>