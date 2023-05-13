<div id="wrapper">
	<form id="signin" method="post">
		<input type="text" id="user" name="login" placeholder="Логін" />
		<input type="password" id="pass" name="password" placeholder="Пароль" />

		<div class="form-check">
		<input class="form-check-input" type="checkbox" id="login-remember" name="remember">
		<label class="form-check-label" for="login-remember">
			Запам'ятати на 30 днів
		</label>
		</div>
		
		<button type="submit">Увійти</button>
		
		<? if($authErr): ?>
		<hr>
			<div class="alert alert-danger">
				Невірні дані
			</div>
		<? endif; ?>
		
	</form>
</div>