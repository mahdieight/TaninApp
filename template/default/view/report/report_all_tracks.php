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
				گزارش گیری از تراک ها
			</header>

		</section>

	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				ایجاد گزارش جدید
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="panel">
					<div class="col-lg-12">

						<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.multi-select.js"></script>

						<!-- start -->
						<label >فیلد های در دسترسی</label>
						<select id='fields' class="selectpicker"  multiple='multiple'>
							<option value='id'>شناسه تراک</option>
							<option value='name'>نام تراک</option>
							<option value='engName'>نام انگلیسی تراک</option>
							<option value='lyrics'>توضیحات تراک</option>
							<option value='price'>قیمت تراک</option>
							<option value='trackDuration'>مدت زمان تراک</option>
						</select>
						<!-- ends -->

					</div>
				</div>
				</div>



				<br>
				<div class="row">

					<div class="col-lg-6">
						<div class="row m-bot15">
							<label class="control-label col-lg-3">فقط تراک های دانلودی</label>
							<div class="">
								<input name="track_status" id="track_status" value="true" type="checkbox" />
							</div>

						</div>
					</div>


					<div class="col-lg-6">
						<button type="button" id="sendReportReq" onclick="requestReport();" class="btn btn-info btn-block" style="vertical-align: middle;"><span class="livicon shadowed" style="padding: 0 0 0 3px;" data-n="linechart" data-s="24" data-c="white" data-hc="0" data-onparent="true"></span></i>شروع گزارش گیری</button>
					</div>

				</div>
			</div>
	</div>
	</section>
</div>
</div>

<script>
	$('#fields').multiSelect();

	$(function () {
		$("#loading").hide();
	});

	function requestReport(){
		var fields = $('#fields').val();
		var track_status =$('#track_status').is(':checked');

		if (fields == null){
			swal('خطایی رخ داده است','هیچ فیلدی برای گزارش گیری انتخاب نشده است!','error');
		}else{
			iziToast.info({
				title: 'پردازش اطلاعات',
				message: 'در حال تهیه گزارش برای شما هستیم. به محض اتمام فرآیند به شما اطلاع خواهیم داد',
				icon: 'fa fa-get-pocket',
			});

			sendAjaxRequestReport(fields,track_status);
		}
	}
</script>



<script>
	function sendAjaxRequestReport(fields,track_s) {
		$("#loading").show();
		$("#loading").css('display','block');

		$.ajax('../requsetTrackReport',{
			type: 'POST',
			dataType: 'json',
			data:{
				field_req:fields,
				track_status: track_s,
			},
			success:function (date) {
				$("#loading").hide();
				$("#loading").css('display','none');

				if(date.status == true){
					iziToast.info({
						timeout: 50000,
						title: 'گزارش با موفقیت ایجاد شد',
						message: date.filePath ,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}else{
					iziToast.info({
						title: 'خطایی رخ داد!',
						message: date.result ,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}

			}
		});
	}
</script>
<script>

</script>