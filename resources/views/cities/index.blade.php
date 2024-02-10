<x-layouts.base title="Населені пункти і ціни">

@foreach($cities as $city)
@foreach($city->price as $distance => $price)
<input type="hidden" name="{{ $city->id }}_{{ $distance }}" value="{{ $price }}">
@endforeach
@endforeach

<x-form method="put" action="{{ route('cities.update') }}">
    @foreach($cities as $city)
    @foreach($city->price as $distance => $price)
    @php $price = $price / 1.05 @endphp
    <input type="hidden" name="{{ $city->id }}_{{ $distance }}" value="{{ $price }}">
    @endforeach
    @endforeach
        <button class="btn btn-danger">-5%</button>
</x-form>
<x-form method="put" action="{{ route('cities.update') }}">
        @foreach($cities as $city)
        @foreach($city->price as $distance => $price)
        @php $price = $price * 1.05 @endphp
        <input type="hidden" name="{{ $city->id }}_{{ $distance }}" value="{{ $price }}">
        @endforeach
        @endforeach
        <button class="btn btn-success">+5%</button>
</x-form>

<!-- yes, this is shit, i will fix it later -->

<x-form method="put" action="{{ route('cities.update') }}">
    <table class="table table-bordered">
        <tr>
            <th>Населений пункт</th>
            <th>Ціна</th>
        </tr>
        @foreach($cities as $city)
        <tr>
            <td>{{ $city->city }}</td>
            @foreach($city->price as $distance => $price)
            <td>
                @if(count($city->price) > 2) до {{ $distance }} @endif                
                <x-form-input name="{{ $city->id }}_{{ $distance }}" value="{{ $price }}" />                
            </td>            
            @endforeach
        </tr>
        @endforeach
    </table>
<button class="btn btn-success">Змінити дані</button>
</x-form>
</x-layouts.base>