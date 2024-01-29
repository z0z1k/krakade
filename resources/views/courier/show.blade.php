<x-layouts.base title="Статистика">
    <table class="table table-bordered">
        <tr>
            <th><span class="badge text-bg-info">@if($isCourier)Кур'єр@elseНемає статусу кур'єра@endif</span></th>
        </tr>        
        <tr><th>{{ $user->name }}</th></tr>
        <tr><th>Доставок: {{ $ordersCnt }}</th></tr>
    </table>
</x-layouts.base>