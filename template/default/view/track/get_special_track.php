	<!-- page start-->
			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							دریافت تراک های یک آلبوم

						</header>

					</section>

				</div>
			</div>


			<div class="row">
				<div class="col-lg-12">
					<section class="panel">
						<header class="panel-heading">
							دریافت تراک های یک آلبوم ثبت شده
						</header>
						<div class="panel-body">
							<form class="form-horizontal tasi-form" method="get">
								<div class="form-group">
									<label class="control-label col-lg-2">شماره شناسه آلبوم</label>
									<div class="col-lg-10">
										<div class="input-group m-bot15">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-white" type="button" id="submitStart" onclick="getSpecialTrack()">شروع</button>
                                                </span>
											<input id="album-id" type="text" class="form-control">
										</div>

									</div>
								</div>
							</form>
						</div>
					</section>
				</div>
			</div>
			<!-- page end-->
<script>
	function getSpecialTrack() {
		var albumID 				= $('#album-id').val();

		iziToast.info({
			title: 'پردازش اطلاعات',
			message: 'در حال دریافت اطلاعات تراک هستیم. لطفا تا اتمام فرآیند از بستن صفحه خود داری کنید',
			icon: 'fa fa-get-pocket',
		});
		$('#submitStart').empty();
		$('#submitStart').append('<li class="fa fa-spinner fa-spin fa-1x fa-fw"></li>');
		$('#submitStart').attr("disabled", "disabled");
		$('#album-id').attr("disabled", "disabled");

		$.ajax('../get_special_track',{
			type: 'POST',
			dataType: 'json',
			data:{
				album_id:albumID,
			},
			success: function (date) {
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

				$('#submitStart').empty();
				$('#submitStart').append('شروع');
				$('#submitStart').removeAttr("disabled");
				$('#album-id').removeAttr("disabled");
			}
		})
	}
</script>