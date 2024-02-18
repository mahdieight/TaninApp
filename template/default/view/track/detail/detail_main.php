<?php
$track_name = $track_info['track_name'];
$album_name = $track_info['album_name'];

$album_image 			= json_decode($track_info['primaryImagePathHQ'],true);
?>
<div class="col-md-12 m-b-40">
	<button class="btn btn-success waves-effect waves-light" onclick="redirectTracksShow('<?=$taninAppConfig->base_url?>');" type="button">
		<span class="btn-label"><i class="fa fa-reply"></i></span>
		بازگشت به صفحه موزیک ها</button>
</div>
<script>
	function redirectTracksShow(url){
		window.location.href = url +'track/allTrack/' ;
	}
</script>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a>
					<img src="<?=$taninAppConfig->base_url .  $album_image['path'] . '/' . $album_image['name']. $album_image['ext'] ?>" alt="">
				</a>
				<h1><?=$track_name?></h1>
				<!--<p>Behet Nagoftam!</p>-->
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a onclick=""><i class="fa fa-user"></i>اطلاعات تراک</a></li>
			</ul>
		</section>
	</aside>
	<div id="component"></div>
</div>
<script src="assets/jquery-knob/js/jquery.knob.js"></script>
<script>

	$(function () {
		showRelatyPage('biography','<?=$track_info['track_id']?>');
	});

	function showRelatyPage(paga_name,track_id) {
		$.ajax('../showTrackPage',{
			type:'POST',
			dataType: 'json',
			data:{
				showPage: paga_name,
				trackID: track_id,
			},
			success:function (date) {
				$('#component').empty();
				$('#component').append(date.result);
			}
		})
	}
</script>