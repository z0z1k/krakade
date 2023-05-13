	Активні замовлення:
	<? foreach ($orders as $order): ?>
		<div class="row">
			<div class="col">
				<p class="card-text">Адреса: <?=$order['client_address']?></p>
            	<p class="card-text">Номер клієнта: <?=$order['client_phone']?></p>

				<?php if($order['paymentType'] == 'Оплата не потрібна') {
						$order['paymentType'] = "Кур'єр не оплачує";
					} else {
						$order['paymentType'] = "Кур'єр оплачує " . mb_substr($order['paymentType'], 18);
					}	
				?>

					<p class="card-text"><?=$order['paymentType']?></p>

				
				<? if($order['orderComent'] != ''): ?>
					<p class="card-text">Коментар: <?=$order['orderComent']?></p>
				<? endif ?>
				
				<?php
					if ($order['dt_get'] != NULL){
						$order['dt_get'] = substr($order['dt_get'], 10);
					}
				?>
				

            	<a href="<?=BASE_URL?>active/<?=$order['order_id']?>" class="btn btn-primary mt-auto">Кур'єр отримав <?=$order['dt_get']?></a>
            	<a href="<?=BASE_URL?>ready/<?=$order['order_id']?>" class="btn btn-primary mt-auto">Доставлено</a>
				<hr>
				</div>
			</div>
	<? endforeach; ?>
