	<? foreach ($orders as $order): ?>
		<div class="row">
                <div class="col"><?=$order['place']?></div>
				<div class="col"><?=$order['client_address']?></div>
            	<div class="col"><?=$order['client_phone']?></div>
                <div class="col">Бути до <?=$order['beReady']?></div>

				<?php if($order['paymentType'] == 'Оплата не потрібна') {
						$order['paymentType'] = "Кур'єр не оплачує";
					} else {
						$order['paymentType'] = "Кур'єр оплачує " . mb_substr($order['paymentType'], 18);
					}	
				?>

					<div class="col"><?=$order['paymentType']?></div>

                <div class="col">
                    <? if($order['orderComent'] != ''): ?>
                        <?=$order['orderComent']?>
                    <? endif ?>
                </div>
				
				<?php
					if ($order['dt_get'] != NULL){
						$order['dt_get'] = substr($order['dt_get'], 10);
					}
				?>
				

            	<div class="col">
                    <a href="<?=BASE_URL?>active/<?=$order['order_id']?>" class="btn btn-primary mt-auto">Отримав <?=$order['dt_get']?></a>
            	    <a href="<?=BASE_URL?>ready/<?=$order['order_id']?>" class="btn btn-primary mt-auto">Доставлено</a>
                </div>

				<hr>

			</div>
	<? endforeach; ?>
