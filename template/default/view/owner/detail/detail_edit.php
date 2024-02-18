<aside class="profile-info col-lg-9">
	<section class="panel">
		<div class="bio-graph-heading">

		</div>
		<div class="panel-body bio-graph-info">
			<h1>ویرایش اطلاعات هنرمند</h1>
			<form class="form-horizontal" role="form">

				<div class="form-group">
					<label class="col-lg-2 control-label">نام </label>
					<div class="col-lg-6">
						<input type="text" class="form-control" id="f-name" placeholder="<?=$owner_info['firstName']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">نام خانوادگی</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" id="l-name" placeholder="<?=$owner_info['lastName']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">نام هنری</label>
					<div class="col-lg-6">
						<input type="text" class="form-control" id="a-name" placeholder="<?=$owner_info['artisticName']?>">
					</div>
				</div>


				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button onclick="change_owner_info('<?=$owner_info['id']?>');" type="button" class="btn btn-success">بروز سازی اطلاعات</button>
						<button onclick="unlink_owner('<?=$owner_info['id']?>');" type="button" class="btn btn-danger">حذف هنرمند</button>
					</div>
				</div>
			</form>
		</div>
	</section>
</aside>

<script>

	function unlink_owner(owner_id) {
		$.ajax('../primitive_unlink_owner',{
			type: 'POST',
			dataType: 'json',
			data:{
				owner_id :owner_id,
			},
			success: function (output) {
				if(output.status == false){
					swal('مشکلی وجود دارد',output.result,'error');
				}else{
					swal({
						title: 'نیازمند تایید شما',
						text: output.result,
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
							message:'در حال حذف اطلاعات هنرمند هستیم، لطفا تا اتمام فرآیند از بستن صفحه خودداری نمایید.',
							icon: 'fa fa-spinner',
						});


						$.ajax('../secondary_unlink_owner',{
							type: 'POST',
							dataType: 'json',
							data:{
								owner_id :owner_id,
							},
							success: function (output) {
								if (output.status == false){
									swal('مشکلی در حذف ژانر وجود دارد',output.result,'error');
								}else {

									$("#loading").hide();
									$("#loading").css('display', 'none');
									iziToast.info({
										title: 'عملیات به اتمام رسید',
										message: 'اطلاعات ژانر با موفقیت حذف گردید، تا لحظاتی دیگر به صفحه ژانرها منتقل خواهید شد',
										icon: 'fa fa-get-pocket',
									});

									setTimeout(function(){ window.location = output.redirect; }, output.time);
								}
							}
						})

					}
				})
				}
			}
		})
	}
	function change_owner_info(owner_id) {
		var new_f_name = $('#f-name').val();
		var new_l_name = $('#l-name').val();
		var new_a_name = $('#a-name').val();
		$.ajax('../edit_owner',{
			type: 'POST',
			dataType: 'json',
			data:{
				owner_id : owner_id,
				new_f_name : new_f_name,
				new_l_name : new_l_name,
				new_a_name : new_a_name,
			},
			success: function (output) {
				if(output.status == false){
					swal('مشکلی وجود دارد',output.result,'error');
				}else{
					swal('موفقیت آمیز بود!',output.result,'success');
				}

			}
		});
	}
</script>