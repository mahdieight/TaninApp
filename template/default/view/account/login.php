<?php
redirectTohome();
?>
<!DOCTYPE html>
<html lang="fa">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="طنین اپ - مدیریت بهترین آلبوم های سال">
	<meta name="keyword" content="طنین اپ,موزیک,آلبوم,پاپ,سنتی">

	<title>ورود به قسمت مدیریت</title>

	<!-- Bootstrap core CSS -->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/bootstrap-reset.css" rel="stylesheet">
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/sweetalert2.min.css" rel="stylesheet" />
	<!--external css-->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/font-awesome.css" rel="stylesheet" />
	<!-- Custom styles for this template -->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/style.css" rel="stylesheet">
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/style-responsive.css" rel="stylesheet" />
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.js"></script>


	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/sweetalert2.min.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/html5shiv.js"></script>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="login-body">

<div class="container">

	<form class="form-signin" action="">
		<h2 class="form-signin-heading">ورود به قسمت مدیریت</h2>
		<div class="login-wrap">
			<input type="text"     class="form-control" id="f_username" name="username" placeholder="نام کاربری" >
			<input type="password" class="form-control" id="f_password" name="password" placeholder="کلمه عبور" >
			<button class="btn btn-lg btn-login btn-block" type="button" onclick="login_check();">ورود</button>
		</div>
	</form>
</div>
</body>
</html>
<script>

	function login_check() {
		var fusername = $('#f_username').val();
		var fpassword = $('#f_password').val();


		$.ajax('../login',{
			type:'POST',
			dataType:'json',
			data:{
				username: fusername,
				password: fpassword,
			},
			success:function (date) {
				if(date.status == true){
					swal({
						type: 'success',
						title: date.result,
						text: 'تا 5 ثانیه دیگر به صفحه ورود هدایت خواهید شد.',
						timer: 5000,
						onOpen: function () {
							swal.showLoading()
						}
					}).then(
						function () {},
						function (dismiss) {}
					)
					setTimeout(function(){ window.location = date.redirect; }, date.time);
				}else{
					swal('خطایی رخ داده است',date.result,'error');
				}
			}
		})
	}
</script>
<script>
	$(document).keypress(function(e) {
		if(e.which == 13) {
			login_check();
		}
	});
</script>