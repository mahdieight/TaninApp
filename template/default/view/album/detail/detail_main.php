<?php

$album_id 									= $album_info['id'];
$album_external_id 					= $album_info['ex_id'];
$album_name 								= $album_info['name'];
$album_eng_name 						= $album_info['engName'];
$album_primary_image_path 	= json_decode($album_info['primaryImagePathHQ'],true);



$count_album_track 					= TrackModel::get_count_album_track_by_id($album_external_id);

?>
<div class="row">
	<div class="col-lg-12">
		<div id="loading">
			<div class="loading-img"><img class="img-responsive" src="<?=$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/loading.svg'?>" /></div>
		</div>
	</div>
</div>
<div class="col-md-12 m-b-40">
	<button class="btn btn-success waves-effect waves-light" onclick="redirectAlbumsShow('<?=$taninAppConfig->base_url?>');" type="button">
		<span class="btn-label"><i class="fa fa-reply"></i></span>
		بازگشت به صفحه آلبوم ها</button>
</div>
<script>
	function redirectAlbumsShow(url){
		window.location.href = url +'album/allAlbums/' ;
	}
</script>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="<?=$taninAppConfig->base_url . $album_primary_image_path['path'] . '/' . $album_primary_image_path['name'] . $album_primary_image_path['ext'] ?>" target="_blank">
				<span class="btn btn-success " style="border-radius: 100px !important;"><span class="fa fa-download"></span> </span>
				</a>
				<a>
					<img src="<?=$taninAppConfig->base_url . $album_primary_image_path['path'] . '/' . $album_primary_image_path['name'] . $album_primary_image_path['ext'] ?>" alt="">
				</a>
				<h1><?=$album_name?></h1>
			</div>
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a onclick="showRelatyPage('biography','<?=$album_id?>');"><i class="fa fa-user"></i>اطلاعات آلبوم</a></li>
				<li><a onclick="showRelatyPage('tracks','<?=$album_id?>');"><i class="fa fa-music"></i>تراک های آلبوم<span class="label label-danger pull-left r-activity"><?=$count_album_track?></span></a></li>
				<li><a onclick="showRelatyPage('edit','<?=$album_id?>');"><i class="fa fa-edit"></i>ویرایش آلبوم</a></li>
			</ul>
		</section>
		<span onclick="unLinkAlbum(<?=$album_id?>)"  class="btn btn-sm btn-round btn-warning"><span class="fa fa-remove"></span></span>
		<span onclick="checkAlbumTracks(<?=$album_id?>)"  class="btn btn-sm btn-round btn-success"><span class="fa fa-refresh"></span></span>
	</aside>
	<div id="component"></div>
</div>


<script>
	function checkAlbumTracks(album_id) {
		$.ajax('../check_tracks_one_album',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumID :album_id,
			},
			success: function (answer) {

				if(answer.broken == true){
					swal({
						title: 'دریافت مجدد آلبوم',
						text: "آیا شما تایید می کنید که اطلاعات آلبوم را از نو دریافت کنیم؟",
						type: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: 'خیر، نیازی نیست',
						confirmButtonText: 'بله، حتما'
					}).then((result) => {
						if (result.value) {
						reget_album_tracks(answer.album_id);

					}
				})
				}else{
					iziToast.info({
						title: 'این خیلی عالیه!',
						message: 'این آلبوم به صورت کامل دریافت شده است و نیازی به دریافت مجدد آن وجود ندارد.',
						icon: 'fa fa-get-pocket',
					});
				}
			}
		})
	}

	function reget_album_tracks(album_id) {
		$("#loading").show();
		$("#loading").css('display','block');

		$.ajax('../deleteHardAllTracksAlbum',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_id,
			},
			success: function (date) {

				$("#loading").hide();
				$("#loading").css('display','none');


				if(date.status == false){
					iziToast.info({
						title: 'خطایی رخ داد!',
						message: date.result ,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}else {

					iziToast.info({
						title: 'اطلاعات آلبوم با موفقیت ذخیره شد!',
						message: date.result,
						icon: 'fa fa-get-pocket',
					});
				}
			}
		});
	}


	function unLinkAlbum(album_id) {
		swal({
			title: 'آیا شما اطمینان دارید؟',
			text: "این عمل غیر قابل بازگشت است!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'خیر، منصرف شدم',
			confirmButtonText: 'بله، حذف کن!'
		}).then((result) => {
			$.ajax('../unlink_album',{
				type: 'POST',
				dataType: 'json',
				data:{
					albumid:album_id,
				},
				success: function(mdata){
					if(mdata.status == true){

						iziToast.info({
							title: 'عملیات موفقیت آمیز بود!',
							message: mdata.msg,
							icon: 'fa fa-get-pocket',
						});
						setTimeout(function(){ window.location = mdata.redirect; }, mdata.time);
					}else{
						iziToast.info({
							title: 'خطایی رخ داد!',
							message: mdata.msg,
							icon: 'fa fa-exclamation-circle ',
							iconColor: '#e74c3c',
						});
						return;
					}
				}
			});
	})
	}
</script>
<script>

	$(function () {
		showRelatyPage('biography','<?=$album_id?>');
	});

	function showRelatyPage(paga_name,album_id) {
		$.ajax('../showAlbumPage/',{
			type:'POST',
			dataType: 'json',
			data:{
				showPage: paga_name,
				albumID: album_id,
			},
			success:function (date) {
				$('#component').empty();
				$('#component').append(date.result);
			}
		})
	}
</script>
