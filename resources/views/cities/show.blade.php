<x-layouts.base title="Населені пункти і ціни">
    <h5><b>Відстань рахується через google maps для авто</b></h5>
    <h6>Під час дощу, снігу, морозу додається бонус 10-15грн, актуальна ціна завжди на цій сторінці</h6>
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
                @if(count($city->price) > 2) <em>до {{ $distance }}км:</em> @endif                
                <b>{{ $price }}грн</b>           
            </td>            
            @endforeach
        </tr>
        @endforeach
    </table>
</x-layouts.base>