var socket = new WebSocket(wsURL);

socket.onmessage = function(event) {
    var timer, sound;
    sound = new Howl({
        src: ['assets/sounds/notification.mp3']
    });
    setInterval(function(){
        sound.play();
    },1000);
    setTimeout(function(){location.reload()},1900);
};