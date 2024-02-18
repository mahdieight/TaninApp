<?php
if (isSupperAdmin()){
	$block_size_last_album = 'col-lg-4';
	$block_size_queue_album = 'col-lg-8';
}else{
	$block_size_last_album = 'col-lg-12';
	$block_size_queue_album = 'col-lg-12';
}
?>
<div class="row">
	<div class="col-lg-12">
		<div id="loading">
			<div class="loading-img"><img class="img-responsive" src="<?=$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/loading.svg'?>" /></div>
		</div>
	</div>
</div>

<!--state overview start-->
<div class="row state-overview">
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol terques">
				<i class="livicon" data-name="sky-dish" data-eventtype="hover" data-color="#ffffff" data-hovercolor="#ffffff" data-size="48" data-loop="true"></i>
			</div>
			<div class="value">
				<h1 class="counter"><?=setDesimal($count_track_qu)?></h1>
				<p class="p-iran-sans">آلبوم در دسترس</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol red">
				<i class="livicon" data-name="albums" data-eventtype="hover" data-color="#ffffff" data-hovercolor="#ffffff" data-size="48" data-loop="true"></i>
			</div>
			<div class="value">
				<h1 class="counter"><?=setDesimal($count_album_db)?></h1>
				<p class="p-iran-sans">آلبوم ثبت شده</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol yellow">
				<i class="livicon" data-name="playlist" data-eventtype="hover" data-color="#ffffff" data-hovercolor="#ffffff" data-size="48" data-loop="true"></i>
			</div>
			<div class="value">
				<h1 class="counter"><?=setDesimal($count_track_db)?></h1>
				<p class="p-iran-sans">موزیک های ثبت شده</p>
			</div>
		</section>
	</div>
	<div class="col-lg-3 col-sm-6">
		<section class="panel">
			<div class="symbol blue">
				<i class="livicon" data-name="music" data-eventtype="hover" data-color="#ffffff" data-hovercolor="#ffffff" data-size="48" data-loop="true"></i>
			</div>
			<div class="value">
				<h1 class="counter"><?=setDesimal($count_track_dl)?></h1>
				<p class="p-iran-sans">موزیک های دانلود شده</p>
			</div>
		</section>
	</div>
</div>
<!--state overview end-->


<div class="row">
	<div class="<?=$block_size_last_album?>">
		<!--user info table start-->
		<section class="panel">
			<div class="panel-body">
				<div class="task-progress">
					<h1>آخرین آلبوم های دریافتی</h1>
					<p>5 آلبومی که اخیرا دریافت شده است!</p>
				</div>
			</div>
			<table class="table table-hover personal-task">
				<tbody>

				<td>نام آلبوم</td>
				<td>تاریخ درج</td>
				<?foreach ($lastAlbumInserted as $lastAlbumInserted){?>
					<tr>

						<td><a href="<?=$taninAppConfig->base_url . 'album/details/' . $lastAlbumInserted['id'] ?>"><?=$lastAlbumInserted['name']?></a></td>
						<td><?=JdateController::converDate($lastAlbumInserted['updated_at']);?></td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</section>
		<!--user info table end-->
	</div>

	<?if (isSupperAdmin()){?>
	<div class="col-lg-3">
		<!--user info table start-->
		<section class="panel">
			<div class="panel-body">
				<div class="task-progress">
					<h1><a href="#">آخرین گزارش ها</a></h1>
					<p>5 گزارش اخیر از آلبوم ها و تراک ها</p>
				</div>
			</div>
			<table class="table table-hover personal-task">
				<tbody>
				<td></td>
				<td>نوع گزارش</td>
				<td>لینک دریافت</td>
				<?foreach ($lastReport as $last_report){?>
					<tr>
						<td><i class=" fa fa-tasks"></i></td>
						<td><?=$last_report['type']?></td>
						<?if($last_report['type'] == 'ALBUM'){?>
							<td><a href="<?=$taninAppConfig->base_url . 'media/report/track/' .$last_report['fileName'] ?>" class="badge bg-primary"><span class="fa fa-download"></span></a></td>
						<?}else if($last_report['type'] == 'TRACK'){?>
							<td><a href="<?=$taninAppConfig->base_url . 'media/report/track/' .$last_report['fileName'] ?>" class="badge bg-primary"> <span class="fa fa-download"></span></a></td>
						<?}else{?>
							<td><a href="<?=$taninAppConfig->base_url . 'media/report/track/' .$last_report['fileName'] ?>" class="badge bg-primary"><span class="fa fa-download"></span></a></td>
						<?}?>

					</tr>
				<?}?>
				</tbody>
			</table>
		</section>
		<!--user info table end-->
	</div>


	<div class="col-lg-5">
		<!--work progress start-->
		<section class="panel">
			<div class="panel-body">
				<div class="task-progress">
					<h1>گزارش API</h1>
					<p>5 اتصال اخیر API</p>
				</div>

			</div>
			<table class="table table-hover personal-task">
				<td>ردیف</td>
				<td>کاربر</td>
				<td>وضعیت</td>
				<td>تاریخ</td>
				<tbody>
				<?php
				if(!empty($lastApiUsed)){
					$j =1;
					foreach ($lastApiUsed as $last_api_used){
						#تنظیم نام شرکت استفاده کننده
						if($last_api_used['company'] == '0'){
							$company_name = $last_api_used['ip'];
						}else{
							$company_name = $last_api_used['company'];
						}

						if($last_api_used['errorStatus'] == 1){
							$errorApi = true;
						}else{
							$errorApi = false;
						}
				?>
				<tr>
					<td><?=$j?></td>
					<td>
						<?=$company_name?>
					</td>
					<td>
						<?if($errorApi){?>
							<span class="badge bg-important"><?=$last_api_used['errorCode']?></span>
							<?}else{?>
							<span class="badge bg-success"> </span>
							<?}?>
					</td>
					<td>
						<div class="badge"><?=JdateController::converDate($last_api_used['created_at'])?></div>
					</td>
				</tr>
				<?
					$j++;
					}}else{?>
					<p>هیچ محتوایی یافت نشد!</p>
				<?}?>
				</tbody>
			</table>
		</section>
		<!--work progress end-->
	</div>
	<?php }?>
</div>

<div class="row">
	<div class="<?=$block_size_queue_album?>">
	<div id="album-queue">

	</div>
	</div>
<?php if(isSupperAdmin()){?>
	<div class="col-lg-4">
		<!--user info table start-->
		<section class="panel">
			<div class="panel-body">
				<div class="task-progress">
					<h1><a href="#">فعالیت کاربران</a></h1>

				</div>
			</div>
			<table class="table table-hover personal-task">
				<tbody>
				<td><i class=" fa fa-users"></i></td>
				<td>نام کاربری</td>
				<td>تاریخ ورود</td>
				<?foreach ($lastUserLogin as $last_user_login){?>
					<tr>
						<td><?=setBrowserIcon($last_user_login['browser_name']) .'  ' .setOsIcon($last_user_login['os_name']);?></td>
						<td><a href="<?=$taninAppConfig->base_url . 'account/details/' . $last_user_login['user_id']?>"><?=$last_user_login['fullname']?></a> </td>
						<td><?=JdateController::converDate($last_user_login['created_at'])?></td>
					</tr>
				<?}?>
				</tbody>
			</table>
		</section>
		<!--user info table end-->
	</div>
	<?php }?>
</div><!--END ALBUM QUEUE-->

<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.counterup.min.js"></script>
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/waypoints.min.js"></script>

<script>
	jQuery(document).ready(function( $ ) {
		$('.counter').counterUp({
			delay: 10,
			time: 1000
		});
	});

	$(function () {
		getLastAlbumQueue();
	});
</script>

<script>
	function getLastAlbumQueue() {
		$.ajax('../album/showLastAlbumQueue',{
			tupe: 'POST',
			dataType: 'json',
			success:function (date) {
				$('#album-queue').empty();
				$('#album-queue').append(date.result);
			}
		});
	}
</script>
