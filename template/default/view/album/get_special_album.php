<div class="row">
	<div class="col-lg-12">
		<div id="loading">
			<div class="loading-img"><img class="img-responsive" src="<?=$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/loading.svg'?>" /></div>
		</div>
	</div>
</div>

<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				دریافت آلبوم
			</header>

		</section>

	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				دریافت آلبوم خاص
			</header>
			<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-lg-2">شماره شناسه آلبوم</label>
						<div class="col-lg-10">
							<div class="input-group m-bot15">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-white " type="button" id="submitStart" onclick="getSpecialAlbum();">شروع</button>
                                                </span>
								<input type="text" class="form-control" id="albumID" name="albumID">
							</div>

							<div class="row m-bot15">

									<label>
										دریافت تراک های آلبوم
										<input type="checkbox"   id="track_d"/>
									</label>

							</div>
						</div>
					</div>
			</div>
		</section>
	</div>
</div>

<!-- page end-->
<script>
	$(function () {
		$("#loading").hide();
	});

	function getSpecialAlbum(){
		$("#loading").show();
		$("#loading").css('display','block');

		var album_id 				= $('#albumID').val();
		var track_download =$('#track_d').is(':checked');
		iziToast.info({
			title: 'پردازش اطلاعات',
			message: 'در حال دریافت اطلاعات تراک هستیم. لطفا تا اتمام فرآیند از بستن صفحه خود داری کنید',
			icon: 'fa fa-get-pocket',
		});
		$('#submitStart').empty();
		$('#submitStart').append('<li class="fa fa-spinner fa-spin fa-1x fa-fw"></li>');
		$('#submitStart').attr("disabled", "disabled");
		$('#albumID').attr("disabled", "disabled");
		$.ajax('../get_special_album',{

			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_id,
				trackDownload:track_download,
			},
			success:function (date) {
				$("#loading").hide();
				$("#loading").css('display','none');


				if(date.status == false){
					if(date.redownload == true){
						reget_album_tracks(album_id);
					}else{
						iziToast.info({
							title: 'خطایی رخ داد!',
							message: date.result ,
							icon: 'fa fa-exclamation-circle ',
							iconColor: '#e74c3c',
						});
					}

				}else {

					iziToast.info({
						title: 'اطلاعات آلبوم با موفقیت ذخیره شد!',
						message: date.result,
						icon: 'fa fa-get-pocket',
					});
					if(date.track == true){
					if (date.track_status == false) {
						iziToast.info({
							title: 'دریافت تراک ناموفقیت آمیز!',
							message: date.track_result,
							icon: 'fa fa-exclamation-circle ',
							iconColor: '#e74c3c',
						});
					} else {
						iziToast.info({
							title: 'موفقیت آمیز بود!',
							message: date.track_result,
							icon: 'fa fa-get-pocket',
						});
					}
				}
				}
				$('#submitStart').empty();
				$('#submitStart').append('شروع');
				$('#submitStart').removeAttr("disabled");
				$('#albumID').removeAttr("disabled");
			}
		});


	}

	function reget_album_tracks(album_id) {
		swal({
			title: 'نیازمند تایید شما',
			text: 'این آلبوم از قبل دریافت شده است، آیا تمایل به دریافت تراک های آن هستید؟',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'خیر، نیازی نیست',
			confirmButtonText: 'بله، حتما'
		}).then((result) => {
			if (result.value) {
			$("#loading").show();
			$("#loading").css('display','block');
			iziToast.info({
				title: 'شروع فرآیند',
				message:'در حال دریافت اطلاعات تراک ها، لطفا تا اتمام فرآیند از بستن صفحه خودداری نمایید.',
				icon: 'fa fa-spinner',
			});

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
	})
	}

</script>
