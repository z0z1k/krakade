<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #ff80b3">
<div class="container-fluid">
    <a class="navbar-brand" href="{{ route('orders.index') }}">Krakade</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        @auth
            @can('courier')
                <li class="nav-item">
                    <a href="{{ route('courier.show', Auth::user()->id) }}" class="nav-link ">Статистика</a>
                </li>
            @endif
            <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link ">Активні замовлення</a>
            </li>
            @can('place')
                <li class="nav-item">
                    <a href="{{ route('orders.delivered') }}" class="nav-link ">Виконані замовлення</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.cancelled') }}" class="nav-link ">Скасовані замовлення</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('places.index') }}" class="nav-link ">Заклади</a>
                </li>
                @foreach(\App\Models\Place::where('user_id', Auth::user()->id)->get() as $place)                                
                    <li class="nav-item">
                        <a href="{{ route('orders.create', $place->id) }}" class="nav-link ">{{$place->name}}</a>
                    </li>
                @endforeach
            @endif
            @can('admin')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link ">Користувачі</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cities.index') }}" class="nav-link">Ціни</a>
                </li>
            @endif
                <li class="nav-item">
                    <a href="{{ route('profile.info') }}" class="nav-link ">Редагувати профіль</a>
                </li>
        @else                        
            <li class="nav-item">
                <a href="{{ route('registration.create') }}" class="nav-link ">Реєстрація</a>
            </li>
        @endif
        </ul>
    </div>
</div>
</nav>