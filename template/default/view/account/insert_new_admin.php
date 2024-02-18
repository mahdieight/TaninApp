<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				درج کاربر جدید
			</header>

		</section>

	</div>
</div>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				اضافه کردن یک کاربر جدید
			</header>
			<div class="panel-body">
				<form method="post"  id="form-add-user" enctype="multipart/form-data" accept=".jpg, .jpeg, .png">
					<div class="row">
						<div class="col-lg-6">
							<label for="firstname">نام :</label>
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="نام کاربر را وارد کنید">
						</div>

						<div class="col-lg-6">
							<label for="lastname"> نام خانوادگی :</label>
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="نام خانوادگی کاربر را وارد کنید">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-6">
							<label for="email">ایمیل :</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="ایمیل کاربر را وارد کنید">
						</div>

						<div class="col-lg-6">
							<label for="phone">شماره موبایل :</label>
							<input type="tel" class="form-control" id="phone" name="phone" placeholder="شماره موبایل کاربر را وارد کنید">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-6">
							<label for="password"> گذرواژه :</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="گذرواژه کاربر را وارد کنید">
						</div>

						<div class="col-lg-6">
							<label for="re-password"> تایید گذرواژه :</label>
							<input type="password" class="form-control" id="re-password" name="re-password" placeholder="گذرواژه کاربر را مجددا وارد کنید">
						</div>
					</div>

					<br>
					<div class="row">
						<div class="col-lg-3">
							<label class="label_check" for="is_supperadmin">
								<input name="is_supperadmin" id="is_supperadmin" value="1" type="checkbox" />
								کاربر، یک مدیر ارشد می باشد
							</label>
						</div>
						<div class="col-lg-3">
							<label for="user-profile"> تصویر نمایه :</label>
							<input type="file" id="user-profile" name="user-profile" multiple />
						</div>

						<div class="col-lg-3">
							<button type="reset" class="btn btn-danger btn-block"><i class="fa fa-remove"></i>نو کردن فرم </button>
						</div>
						<div class="col-lg-3">
							<button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i>ثبت کاربر </button>
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