<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				افزودن تک آهنگ
			</header>

		</section>

	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				اضافه کردن یک آلبوم تک آهنگ
			</header>
			<div class="panel-body">
				<form method="post"  id="form-add-user" enctype="multipart/form-data" accept=".jpg, .jpeg, .png">
					<div class="row">
						<div class="col-lg-6">
							<label for="firstname">نام آلبوم :</label>
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="نام آلبوم  را وارد کنید">
						</div>

						<div class="col-lg-6">
							<label for="lastname"> نام انگلیسی آلبوم :</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="نام انگلیسی آلبوم را وارد کنید">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-6">
							<label for="email">توضیحات آلبوم :</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="توضیحات آلبوم را وارد نمایید">
						</div>

						<div class="form-horizontal form-material">
							<div class="form-group">
								<label class="col-lg-2 control-label">انتشارات آلبوم</label>
								<div class="col-lg-6">
									<select id="album-publisher" class="col-md-12">
										<option value="0" selected>انتشارات آلبوم</option>
										<?php foreach ($all_tags as $tag_info){?>
												<option value="<?=$tag_info['id']?>"><?=$tag_info['name']?></option>
											<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<label for="email">توضیحات آلبوم :</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="توضیحات آلبوم را وارد نمایید">
						</div>

						<div class="form-horizontal form-material">
							<div class="form-group">
								<label class="col-lg-2 control-label">برچسب های آلبوم</label>
								<div class="col-lg-6 dropdown-mul-2">
									<select style="display:none"  name="" id="mul-2" multiple placeholder="انتخاب کنید">
										<?php foreach ($all_tags as $tag_info){?>
												<option value="<?=$tag_info['id']?>"><?=$tag_info['value']?></option>
											<?php }?>
									</select>
								</div>
							</div>
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-6">
							<label for="password"> قیمت آلبوم :</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="گذرواژه کاربر را وارد کنید">
						</div>

						<div class="col-lg-6">
							<label for="re-password"> تاریخ انتشار آلبوم :</label>
							<input type="password" class="form-control" id="re-password" name="re-password" placeholder="گذرواژه کاربر را مجددا وارد کنید">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-3">
							<label for="user-profile"> فایل موزیک :</label>
							<input type="file" id="user-profile" name="user-profile" multiple />
						</div>
						<div class="col-lg-3">
							<label for="user-profile"> تصویر آلبوم :</label>
							<input type="file" id="user-profile" name="user-profile" multiple />
						</div>

						<div class="col-lg-3">
							<button type="reset" class="btn btn-danger btn-block"><i class="fa fa-remove"></i>نو کردن فرم </button>
						</div>
						<div class="col-lg-3">
							<button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i>ثبت کاربر </button>
						</div>
					</div>
					<div class="row">
						<div class="dropdown-mul-2">
							<select style="display:none"  name="" id="mul-2" multiple placeholder="Select">
								<option value="1" selected>1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="3" selected>Selected</option>
								<option value="4" disabled>4</option>
								<option value="5">5</option>
								<option value="6">6</option>
							</select>
						</div>
					</div>
			</div>
			</form>


		</section>
	</div>
</div>

<script>
	$("form#form-add-user").submit(function(e) {
		var formData = new FormData(this);
		e.preventDefault();
		$.ajax({
			url: '../account/add',
			type: 'POST',
			dataType: 'json',
			data: formData,
			success: function (date) {
				if(date.status == true){
					iziToast.info({
						title: 'موفقیت آمیز بود!.تا لحظاتی دیگر به صفحه کاربری هدایت خواهید شد.',
						message: date.msg,
						icon: 'fa fa-get-pocket',
					});
					setTimeout(function(){ window.location = date.redirect; }, '3000');
				}else{
					iziToast.info({
						title: 'هنگام افزودن کاربر، خطایی رخ داد!',
						message: date.msg,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	});
</script>

<script>


	$('.dropdown-mul-2').dropdown({
		limitCount: 5,
		searchable: false
	});

</script>