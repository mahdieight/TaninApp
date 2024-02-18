<div class="row">
	<div class="col-lg-12">
		<div id="loading">
			<div class="loading-img"><img class="img-responsive" src="<?=$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/loading.svg'?>" /></div>
		</div>
	</div>
</div>
<div class="col-md-12 m-b-40">
	<button class="btn btn-success waves-effect waves-light" onclick="redirectGenresShow('<?=$taninAppConfig->base_url?>');" type="button">
		<span class="btn-label"><i class="fa fa-reply"></i></span>
		بازگشت به صفحه ژانر ها</button>
</div>
<script>
	function redirectGenresShow(url){
		window.location.href = url +'genre/all/' ;
	}
</script>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">

			<div class="user-heading round">

				<p class="p-iran-sans">ژانر</p>
				<h1><?=$genre_info['value']?></h1>
					<p class="p-iran-sans">در</p>
					<h1 class="counter"><?=setDesimal($count_used_genre)?></h1>
					<p class="p-iran-sans">آلبوم استفاده شده است</p>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a> </a></li>
			</ul>

		</section>
	</aside>
	<aside class="profile-info col-lg-9">

		<section class="panel">

			<div class="panel-body bio-graph-info">

				<div class="row">


					<div class="col-lg-12">
						<section class="panel">
							<header class="panel-heading">
								اطلاعات ژانر
							</header>
							<br>
							<form class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-lg-2 control-label">نام آلبوم</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" id="genre-name" placeholder="<?=$genre_info['value']?>">
								</div>
							</div>
							</form>
							<button onclick="change_genre_name('<?=$genre_info['id']?>');" type="button" class="btn btn-success">تغییر نام</button>
							<button onclick="un_link_genre('<?=$genre_info['id']?>');" type="button" class="btn btn-danger">حذف ژانر</button>
						</section>
					</div>
				</div>
			</div>
		</section>
	</aside>
</div>

<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.counterup.min.js"></script>
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/waypoints.min.js"></script>
<script>

	function un_link_genre(genre_id) {
		$.ajax('../primitive_unlink_genre',{
			type: 'POST',
			dataType: 'json',
			data:{
				genre_id :genre_id,
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
							message:'در حال حذف اطلاعات ژانر هستیم، لطفا تا اتمام فرآیند از بستن صفحه خودداری نمایید.',
							icon: 'fa fa-spinner',
						});


						$.ajax('../secondary_unlink_genre',{
							type: 'POST',
							dataType: 'json',
							data:{
								genre_id :genre_id,
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


	function change_genre_name(genre_id) {
		var new_value = $('#genre-name').val();
		var old_value = $('#genre-name').attr('placeholder');
		if (new_value.length <= 0 || new_value == old_value){
			swal('مشکلی وجود دارد','اطلاعات ژانر هیچ تغییری پیدا نکره است','error');
		}else{
			$.ajax('../edit_genre',{
				type: 'POST',
				dataType: 'json',
				data:{
					genre_id :genre_id,
					new_value :new_value,
				},
				success: function (output) {
					if(output.status == false){
						swal('مشکلی وجود دارد',output.result,'error');
					}else{
						swal('موفقیت آمیز بود!',output.result,'success');
						$('#genre-name').attr('placeholder',new_value);
					}
				}
			})
		}

	}
	jQuery(document).ready(function( $ ) {
		$('.counter').counterUp({
			delay: 10,
			time: 1000
		});
	});
</script>