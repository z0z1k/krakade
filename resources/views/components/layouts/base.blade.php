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
                            @can('courier', 'place')
                            <li>
                                <a href="{{ route('orders.index') }}" class="nav-link link-dark">Активні замовлення</a>
                            </li>
                            @endif
                            @can('place')
                            <li>
                                <a href="#" class="nav-link link-dark">Виконані замовлення</a>
                            </li>
                            <li>
                                <a href="{{ route('places.index') }}" class="nav-link link-dark">Заклади</a>
                            </li>
                            @foreach(\App\Models\Place::where('user_id', Auth::user()->id)->get() as $place)                                
                            <li>
                                <a href="{{ route('orders.create', $place->id) }}" class="nav-link link-dark">{{$place->name}}</a>
                            </li>
                            @endforeach
                            @endif
                            @can('admin')
                            <li>
                                <a href="{{ route('users.index') }}" class="nav-link link-dark">Користувачі</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('profile.info') }}" class="nav-link link-dark">Редагувати профіль</a>
                            </li>
                        @else                        
                            <li>
                                <a href="{{ route('registration.create') }}" class="nav-link link-dark">Реєстрація</a>
                            </li>
                        @endif
                            <li>
                                <a href="{{ route('info') }}" class="nav-link link-dark">Інформація</a>
                            </li>
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