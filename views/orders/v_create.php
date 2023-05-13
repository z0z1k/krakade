
	<form method="post">
		<input type="text" class="form-control" name="address" placeholder="Адреса" />
		<input type="text" class="form-control"  name="phone" placeholder="Номер телефону" />
		<input type="text" class="form-control"  name="beReady" placeholder="Буде готове о" />
		<input type="text" class="form-control"  name="paymentType" placeholder="Кур'єр повинен оплатити:" />

		<div class="form-group">
    	<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Коментар" name="orderComent"></textarea>
  		</div>
		<button type="submit" class="btn btn-primary mt-auto">Створити замовлення</button>

	</form>

	<div>
    <a href="<?=BASE_URL . $orderTypes?>"><?=$orderTypesText?></a>
	</div>
