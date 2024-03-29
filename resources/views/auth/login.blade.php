<x-layouts.base title="Увійти">
    <div class="card">
		<div class="card-body">
			<div class="card-text">
				<x-form method="post" action="{{ route('login.store') }}">
					<div class="mb-3">
                        <x-form-input name="email" label="Email" />
                    </div>
					<div class="mb-3">
                        <x-form-input name="password" label="Пароль" type="password" />
                    </div>
					<div class="mb-3">
                        <x-form-checkbox name="remember" label="Запам'ятати мене" checked />
                    </div>
					<button class="btn btn-primary">Увійти</button>
				</x-form>
			</div>
		</div>
	</div>
</x-layouts.base>