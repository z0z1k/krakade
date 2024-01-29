var socket = new WebSocket("ws://192.168.0.116:8080");

socket.onmessage = function(event) {
    location.reload();
};