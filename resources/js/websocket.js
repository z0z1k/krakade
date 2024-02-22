var socket = new WebSocket(wsURL);

socket.onmessage = function(event) {
    location.reload();
};