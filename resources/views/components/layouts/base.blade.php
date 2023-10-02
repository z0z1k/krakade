@props([
    'title'
])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/main.css'])
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                HEADER

                @auth
                    <a href="#">Logout</a>
                @else
                    <a href="#">Login</a>
                @endif
                
            </div>
        </header>

        <main class="main py-3">
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-3">
                        <ul class="nav nav-pills flex-column mb-auto">    
                        @auth                        
                                                   
                        
                            <li>
                                <a href="{{ route('orders.index') }}" class="nav-link link-dark">Активні замовлення</a>
                            </li>
                            <li>
                                <a href="{{ route('orders.create') }}" class="nav-link link-dark">Створити замовлення</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}" class="nav-link link-dark">Користувачі</a>
                            </li>
                        @else
                        @endif
                        </ul>
                    </div>
                    <div class="col col-12 col-md-9">
                        <h1 class="h3 mb-4">{{ $title }}</h1>
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <div class="container">
                <hr>
                FOOTER
            </div>
        </footer>
    </div>
</body>
</html>