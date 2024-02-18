<aside class="profile-info col-lg-9">
	<div class="row state-overview">
		<div class="col-lg-6 col-sm-12">
			<section class="panel">
				<div class="symbol terques">
					<i class="fa fa-microphone p-t-5 p-b-5"></i>
				</div>
				<div class="value">
					<p class="p-iran-sans ">خواننده در</p>
					<h1 class="counter"><?=setDesimal($count_as_owner)?></h1>
					<p class="p-iran-sans">قطعه</p>
				</div>
			</section>
		</div>
		<div class="col-lg-6 col-sm-12">
			<section class="panel">
				<div class="symbol red">
					<i class="fa fa-music p-t-5 p-b-5" ></i>
				</div>
				<div class="value">
					<p class="p-iran-sans">آهنگساز در</p>
					<h1 class="counter"><?=setDesimal($count_as_composers)?></h1>
					<p class="p-iran-sans">قطعه</p>
				</div>
			</section>
		</div>
		<div class="col-lg-6 col-sm-12">
			<section class="panel">
				<div class="symbol yellow">
					<i class="fa fa-pencil p-t-5 p-b-5" ></i>
				</div>
				<div class="value">
					<p class="p-iran-sans">شاعر در</p>
					<h1 class="counter"><?=setDesimal($count_as_poet)?></h1>
					<p class="p-iran-sans">قطعه</p>
				</div>
			</section>
		</div>
		<div class="col-lg-6 col-sm-12">
			<section class="panel">
				<div class="symbol blue">
					<i class="fa fa-sliders p-t-5 p-b-5" ></i>
				</div>
				<div class="value">
					<p class="p-iran-sans">تنظیم کننده در</p>
					<h1 class="counter"><?=setDesimal($count_as_arrangers)?></h1>
					<p class="p-iran-sans">قطعه</p>
				</div>
			</section>
		</div>
	</div>
	<!--state overview end-->

	<section class="panel">

		<div class="panel-body bio-graph-info">

			<div class="row">


				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							5 مشارکت آخر هنرمند

						</header>
						<div class="list-group">
							<?php foreach ($last_album_subscribed as $lastAlbumSubscribed){?>
								<a class="list-group-item" href="<?=$taninAppConfig->base_url . 'album/details/' . $lastAlbumSubscribed['id']?>" target="_blank" "></span><?=$lastAlbumSubscribed['name']?></a>
							<?}?>
						</div>
					</section>
				</div>
			</div>
		</div>
	</section>
</aside>

<script>
	jQuery(document).ready(function( $ ) {
		$('.counter').counterUp({
			delay: 10,
			time: 1000
		});
	});
</script>