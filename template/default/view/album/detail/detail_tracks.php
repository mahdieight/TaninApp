<div class="row">
	<div class="col-lg-8">
		<section class="panel">
			<header class="panel-heading">
				تراک های آلبوم
			</header>
			<table class="table table-striped table-advance table-hover">
				<thead>
				<tr>
					<th><i class="fa fa-bullhorn pad-l-5"></i>نام تراک</th>
					<th class="hidden-phone"><i class="fa fa-clock-o pad-l-5"></i>طول تراک</th>
					<th><i class="fa fa-money pad-l-5"></i>قیمت</th>
					<th><i class="fa fa-edit pad-l-5"></i>وضعیت</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (count($tracks_info) > 0){
				foreach ($tracks_info as $track){
					if($track['status'] == 1){
					$track_file_info = json_decode($track['fileInfo'],true);
					$track_file_address = $track_file_info['hqPath'] . '/' . $track_file_info['hqName'];
					}
					?>
					<tr>
						<td><a href="<?=$taninAppConfig->base_url .'track/details/' . $track['id']?>"><?=$track['name']?></a></td>
						<td class="hidden-phone"><?=$track['trackDuration']?></td>
						<td><?=$track['price']?></td>
						<?if($track['status'] == 1){?>
							<td><span class="label label-info label-mini">Ok</span></td>

							<td><a href="<?=$taninAppConfig->base_url . $track_file_address?>"><span class="fa fa-download"></span></a></td>
						<?}else{?>
							<td><span class="label label-danger label-mini">Failed</span></td>
						<?}?>

					</tr>
				<?php }}else{?>
					<td>هیچ تراکی برای این آلبوم ثبت نشده است!</td>
				<?}?>


				</tbody>
			</table>
		</section>
	</div>
</div>
<!-- page end-->