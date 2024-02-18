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
				گزارش گیری از تراک ها و آلبوم ها
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
			<header class="panel-heading">
				فیلترهای گزارش گیری :
				<span class="filtertools">
					<i class="fa fa-angle-down"></i>
				</span>
			</header>
			<br>
			<script>
				$('.filtertools').on('click',function () {
					var status_filtertools = $('#filteerTools').css('display');


					if (status_filtertools == 'none'){
						$('.filtertools i').removeClass("fa fa-angle-down");
						$('.filtertools i').addClass("fa fa-angle-up");


						$('#filteerTools').show(1000);
					$('#filteerTools').css('display','block');

					}else{
						$('#filteerTools').hide(1000);
						$('.filtertools i').removeClass("fa fa-angle-up");
						$('.filtertools i').addClass("fa fa-angle-down");
					}
				});
			</script>
			<div id="filteerTools">

			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-6">
						<label for="frompdpGregorian">گزارش گیری از تاریخ :</label>
						<input type="text" class="form-control" id="frompdpGregorian" placeholder="انتخاب تاریخ">
					</div>

					<div class="col-lg-6">
						<label for="topdpGregorian">گزارش گیری تا تاریخ :</label>
						<input type="text" class="form-control" id="topdpGregorian" placeholder="انتخاب تاریخ">
					</div>
				</div>

			</div>

			<div class="row">
				</br>
				<div class="col-lg-6">
					<select id="publisher_item" name="character" multiple="multiple">
						<?php foreach ($publishers as $publisher){?>
						<option value="<?=$publisher['id']?>"><?=$publisher['displayName']?></option>
						<?php }?>
					</select>
				</div>

				<div class="col-lg-6">
					<select id="owner_item" name="character" multiple="multiple">
						<?php foreach ($owners as $owner){?>
							<option value="<?=$owner['id']?>"><?=$owner['artisticName']?></option>
						<?php }?>
					</select>
				</div>

			</div><!--End Row-->
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="panel">
						<div class="col-lg-12">

							<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.multi-select.js"></script>

							<!-- start -->
							<label >فیلد های در دسترسی برای آلبوم ها</label>
							<select id='album_fields' class="selectpicker"  multiple='multiple'>
								<option value='album_id'>شناسه آلبوم</option>
								<option value='album_name'>نام آلبوم</option>
								<option value='album_engName'>نام انگلیسی آلبوم</option>
								<option value='album_publisherID'>نام انتشارات</option>
								<option value='album_description'>توضیحات آلبوم</option>
								<option value='album_tags'>برچسب ها</option>
								<option value='album_genres'>ژانر ها</option>
								<option value='album_owners'>خوانندگان</option>
								<option value='album_composers'>آهنگسازان</option>
								<option value='album_arrangers'>تنظیم کنندگان</option>
								<option value='album_poets'>شاعران</option>
								<option value='album_finalPrice'>قیمت آلبوم</option>
								<option value='album_publishMonth'>ماه انتشار</option>
								<option value='album_publishYear'>سال انتشار</option>
								<option value='album_publishData'>تاریخ انتشار</option>
							</select>
							<!-- ends -->

						</div>

						<div class="col-lg-12">

							<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.multi-select.js"></script>

							<!-- start -->
							<label >فیلد های در دسترسی برای تراک ها</label>
							<select id='track_fields' class="selectpicker"  multiple='multiple'>
								<option value='track_id'>شناسه تراک</option>
								<option value='track_name'>نام تراک</option>
								<option value='track_engName'>نام انگلیسی تراک</option>
								<option value='track_lyrics'>توضیحات تراک</option>
								<option value='track_price'>قیمت تراک</option>
								<option value='track_trackDuration'>مدت زمان تراک</option>
							</select>
							<!-- ends -->

						</div>
					</div>
				</div>


				<div class="col-lg-12">
					<div class="row m-bot15">
						<label class="control-label col-lg-3">فقط تراک های دانلودی
							<input name="track_status" id="track_status" value="true" type="checkbox" />
						</label>
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
		var album_fields = $('#album_fields').val();
		var track_fields = $('#track_fields').val();

		var track_status =$('#track_status').is(':checked');
		var setdate = false;

		var fromDate = $('#frompdpGregorian').val();
		var toDate = $('#topdpGregorian').val();

		if (fromDate == '' && toDate == ''){
			setdate = false;
		}else if ((fromDate == '' && toDate != '') || (fromDate != '' && toDate == '')){
			setdate = 'error';
		}else{
			setdate = true;
		}

		if (setdate == 'error'){
			swal('خطایی رخ داده است','فرم دارای اشکالاتی است. تاریخ شروع و پایان گزارش گیری را بررسی نمایید.','error');
			return;
		}

		var fields = album_fields + track_fields;

		if(track_fields == null){
			var fields = album_fields;
		}else if (album_fields == null){
			var fields = track_fields;
		}else{
			var fields = album_fields.concat(track_fields);
		}

		var publisherFilter = $('#publisher_item').val();
		var ownerFilter = $('#owner_item').val();

		if (fields == null){
			swal('خطایی رخ داده است','هیچ فیلدی برای گزارش گیری انتخاب نشده است!','error');
		}else{
			iziToast.info({
				title: 'پردازش اطلاعات',
				message: 'ما در حال تهیه گزارش هستیم. این گزارش ممکن است دقاقی طول بکشد. لذا از بسته صفحه خود داری نمایید!',
				icon: 'fa fa-get-pocket',
			});

			if(setdate == true){
				sendAjaxRequestReportTracksAlbums(fields,publisherFilter,ownerFilter,track_status,fromDate,toDate);
			}else{
				sendAjaxRequestReportTracksAlbums(fields,publisherFilter,ownerFilter,track_status);
			}

		}
	}
</script>

<script type="text/javascript">
	$('#album_fields').multiSelect();
	$('#track_fields').multiSelect();
	$(function () {
		$("#loading").hide();
	});
</script>


<script>
	function sendAjaxRequestReportTracksAlbums(fields,publisherFilter,ownerFilter,track_s,fromDate,toDate) {

		$("#loading").show();
		$("#loading").css('display','block');

		if(fromDate != undefined && toDate != undefined){
			var startEndDate = fromDate + '||' + toDate;
		}else{
			startEndDate = false;
		}


		$.ajax('../requestTracksAlbumsReport',{
			type: 'POST',
			dataType: 'json',
			data:{
				field_req					: fields,
				publisher_filter	: publisherFilter,
				owner_filter			: ownerFilter,
				track_status			: track_s,
				reportDate 				:startEndDate,
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


<script type="text/javascript">
	$(function() {
		// initialize sol
		$('#publisher_item').searchableOptionList();
		$('#owner_item').searchableOptionList();
	});
</script>
<script>
	$("#topdpGregorian").persianDatepicker({
		showGregorianDate: true,
		formatDate: "YYYY-MM-DD hh:mm:ss",

	});
	$("#frompdpGregorian").persianDatepicker({
		showGregorianDate: true,
		formatDate: "YYYY-MM-DD hh:mm:ss",

	});
</script>