<x-layouts.base title="Додати заклад">
    <x-form method="post" action="{{ route('places.store') }}">
        @include('places.form-fields')
        <button class="btn btn-success">Додати</button>
    </x-from>
</x-layouts.base>