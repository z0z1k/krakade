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
<script>
    var wsURL = '{{ env('WS_URL') }}';
</script>
<body>
    <div class="wrapper">
        <header class="header">    
            <x-navbar />
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
        </main>

        <footer class="footer">
        <div class="p-3 text-light text-center" style="background-color: #ff80b3">
            <p>Krakade delivery</p>
        </div>
        </footer>
    </div>

    
</body>
</html>