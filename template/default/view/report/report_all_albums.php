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
				گزارش گیری از آلبوم ها
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
						<label >فیلد های در دسترسی </label>
						<select id='fields' class="selectpicker"  multiple='multiple'>
							<option value='id'>شناسه آلبوم</option>
							<option value='name'>نام آلبوم</option>
							<option value='engName'>نام انگلیسی آلبوم</option>
							<option value='publisherID'>نام انتشارات</option>
							<option value='description'>توضیحات آلبوم</option>
							<option value='tags'>برچسب ها</option>
							<option value='genres'>ژانر ها</option>
							<option value='owners'>خوانندگان</option>
							<option value='composers'>آهنگسازان</option>
							<option value='arrangers'>تنظیم کنندگان</option>
							<option value='poets'>شاعران</option>
							<option value='finalPrice'>قیمت آلبوم</option>
							<option value='publishMonth'>ماه انتشار</option>
							<option value='publishYear'>سال انتشار</option>
							<option value='publishData'>تاریخ انتشار</option>
						</select>
						<!-- ends -->

					</div>
				</div>
				</div>



				<br>
				<div class="row">




					<div class="col-lg-12">
						<button type="button" id="sendReportReq" onclick="requestReport();" class="btn btn-info btn-block" style="vertical-align: middle;"><span class="livicon shadowed" style="padding: 0 0 0 3px;" data-n="linechart" data-s="24" data-c="white" data-hc="0" data-onparent="true"></span></i>شروع گزارش گیری</button>
					</div>

				</div>
			</div>
	</div>
	</section>
</div>
</div>

<script>
	function requestReport(){
		var fields = $('#fields').val();

		if (fields == null){
			swal('خطایی رخ داده است','هیچ فیلدی برای گزارش گیری انتخاب نشده است!','error');
		}else{
			iziToast.info({
				title: 'پردازش اطلاعات',
				message: 'در حال تهیه گزارش برای شما هستیم. به محض اتمام فرآیند به شما اطلاع خواهیم داد',
				icon: 'fa fa-get-pocket',
			});

			sendAjaxRequestReportAlbums(fields);
		}
	}
</script>

<script type="text/javascript">
	$('#fields').multiSelect();

	$(function () {
		$("#loading").hide();
	});

</script>



<script>
	function sendAjaxRequestReportAlbums(fields) {
		$("#loading").show();
		$("#loading").css('display','block');

		$.ajax('../requsetAlbumReport',{
			type: 'POST',
			dataType: 'json',
			data:{
				field_req:fields,
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