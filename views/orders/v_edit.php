<form method="post">
		<input type="text" class="form-control" value="<?=$order['client_address']?>" name="address" placeholder="Адреса" />
		<input type="text" class="form-control" value="<?=$order['client_phone']?>"  name="phone" placeholder="Номер телефону" />
		<input type="text" class="form-control" value="<?=$order['beReady']?>"  name="beReady" placeholder="Буде готове о" />
		<input type="text" class="form-control" value="<?=$order['paymentType']?>"  name="paymentType" placeholder="Кур'єр повинен оплатити:" />

		<div class="form-group">
    	<textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Коментар" name="orderComent"><?=$order['orderComent']?></textarea>
  		</div>
		<button type="submit" class="btn btn-primary mt-auto">Редагувати замовлення</button>

</form>