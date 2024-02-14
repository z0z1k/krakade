@props([
    'title'
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/main.css', 'resources/css/loader.css'])
</head>
<body>
    <div class="wrapper">
        <header class="header">    
            <x-navbar />

<canvas id='myCanvas' width='800' height='300'></canvas>
        </header>

        <main class="main py-3">
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-12">
                        <x-notifications />
                        <h1 class="h3 mb-4">{{ $title }}</h1>
                        {{ $slot }}
                    </div>
                </div>
            </div>

<script>
const endAngle = 226;
let canvas = document.getElementById('myCanvas');
let context = canvas.getContext('2d');
let counter = 60;
let radius, tx, ty;
context.translate(tx, ty);
randomize();
requestAnimationFrame(animate);
 
function animate() {
  let x, y;
  if (counter <= endAngle) {
    let radians = Math.PI / 180 * counter;
    y = radius * Math.sin(radians);
    x = radius * Math.cos(radians);
    context.fillRect(radius / 2 - x, -y, 2, 2);
    context.fillRect(-radius / 2 + x, -y, 2, 2);
  } else {
    x = counter - endAngle - radius * 1.2;
    y = counter - endAngle + radius * .71;
    context.fillRect(x, y, 2, 2);
    context.fillRect(-x, y, 2, 2);
  }
  counter = counter + 1;
  if (counter >= endAngle + radius * 1.2) randomize();
  requestAnimationFrame(animate);
}
 
function randomize() {
  counter = 60;
  context.fillStyle = 'rgba(255,' + Math.floor(Math.random() * 255) + ', 255 ,1)';
  radius = Math.random() * 100;
  context.translate(-tx, -ty);
  tx = Math.random() * canvas.width;
  ty = Math.random() * canvas.height;
  context.translate(tx, ty);
}
</script>
        </main>

        <footer class="footer">
        <div class="p-3 text-light text-center" style="background-color: #ff80b3">
            <p>Krakade delivery</p>
        </div>
        </footer>
    </div>

    
</body>
</html>