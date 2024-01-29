<x-layouts.base title="Logout">
<div class="card">
		<div class="card-body">
			<div class="card-text">
				<x-form method="delete" action="{{ route('login.destroy') }}">
					
					<button class="btn btn-danger">Logout</button>
				</x-form>
			</div>
		</div>
	</div>
</x-layouts.base>