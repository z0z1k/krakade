<x-layouts.base title="{{ $title }}">
<div class="row">
    @if($courier)
        @include('components.orders.courier_index')
    @else
        @include('components.orders.place_index')
    @endif
</div>
@vite(['resources/js/websocket.js'])
</x-layouts.base>