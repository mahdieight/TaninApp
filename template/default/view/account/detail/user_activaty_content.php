
		<?php
		$i = 1;
		foreach($content as $activaty_item){
			if($i % 2 ==0){
				$item_div = 'alt purple';

			}else{
				$item_div = 'blue';
			}
			$i++;
		?>
		<div class="activity <?=$item_div?>">
			<span>
				<i class="<?=getUserActivatyIcon($activaty_item['section']);?>"></i>
			</span>
			<div class="activity-desk">
				<div class="panel">
					<div class="panel-body">
						<i class="fa fa-clock-o"></i>
						<h4><?=JdateController::converDate($activaty_item['created_at']);?></h4>
						<p><?=$activaty_item['description']?></p>
					</div>
				</div>
			</div>
		</div>

<?php }?>


