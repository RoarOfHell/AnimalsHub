
function message(text){
    jQuery('#chat-result').append(text);
}

jQuery(document).ready(function($){
    var socket = new WebSocket("ws://localhost:8090/chat/servet.php");

    socket.onopen = function(){
        message("<div>Соединение установлено</div>");
    }

    socket.onerror = function(){
        message("<div>Ошибка при соединении" + (error.message ? error : "")+ "</div>");
    }

    socket.onclose = function(){
        message("<div>Соединение закрыто</div>"); 
    }
}); 