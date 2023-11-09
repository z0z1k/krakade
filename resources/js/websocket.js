    var socket = new WebSocket("ws://192.168.0.116:8080");

    socket.onopen = function(){
        alert("Connection");
    };

    socket.onmessage = function(event) {
        alert(event.data);
    };