var ws = new WebSocket("wss://185.114.245.107");

ws.onopen = function(){
    console.log("Соединение установлено!");
};

ws.onclose = function(event){
    console.log("Соединение закрыто. Код «" + event.code + "». Причина «" + event.reason + "».");
};

ws.onmessage = function(event){ 
    console.log("New message: " + event.data);
};

ws.onerror = function(event){
    console.log("Error: " + event.data);
};