<form method="post">
	<div class="form-group">
		<label for="auth-login">Логін</label>
		<input type="text" class="form-control" id="auth-login" name="login"> 
	</div>
	<div class="form-group">
		<label for="auth-password">Пароль</label>
		<input type="password" class="form-control" id="auth-password" name="password"> 
	</div>
    <div class="form-group">
		<label for="auth-passwordR">Повторити пароль</label>
		<input type="password" class="form-control" id="auth-passwordR" name="passwordR"> 
	</div>
    <div class="form-group">
		<label for="auth-name">Назва закладу</label>
		<input type="text" class="form-control" id="auth-name" name="name"> 
	</div>
    <div class="form-group">
		<label for="auth-address">Адреса</label>
		<input type="text" class="form-control" id="auth-address" name="address"> 
	</div>
    <div class="form-group">
		<label for="auth-number">Номер</label>
		<input type="text" class="form-control" id="auth-number" name="number"> 
	</div>
    <div class="form-group">
		<label for="auth-email">email</label>
		<input type="text" class="form-control" id="auth-email" name="email"> 
	</div>

    <hr>
	<button class="btn btn-primary">Додати заклад</button>

    <? if($createErr): ?>
		<hr>
		<div class="alert alert-danger">
			Паролі не співпадають
		</div>
	<? endif; ?>
</form>