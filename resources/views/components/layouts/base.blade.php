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
                    <a href="{{ route('login.exit') }}">Logout</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
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
                                <a href="{{ route('places.index') }}" class="nav-link link-dark">Заклади</a>
                            </li>
                            <li>
                                <a href="{{ route('places.create') }}" class="nav-link link-dark">Додати заклад</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}" class="nav-link link-dark">Користувачі</a>
                            </li>
                            <li>
                                <a href="{{ route('profile.info') }}" class="nav-link link-dark">Редагувати профіль</a>
                            </li>
                            <li>
                                <a href="{{ route('registration.create') }}" class="nav-link link-dark">Реєстрація</a>
                            </li>
                        @else
                        @endif
                        </ul>
                    </div>
                    <div class="col col-12 col-md-9">
                        <x-notifications />
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