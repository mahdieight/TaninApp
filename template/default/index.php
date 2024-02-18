<?php
$imageuser = json_decode($_SESSION['user_img'],true);

if (empty($imageuser)){
	$img_profile_user_address = $taninAppConfig->base_url . 'media/images/avatar/small/default_small.png';
}else{
	if (file_exists(getcwd() . '/media/images/avatar/small/' . $imageuser['name']  .'_small'. $imageuser['ext'])){
		$img_profile_user_address = $taninAppConfig->base_url . 'media/images/avatar/small/' . $imageuser['name']  .'_small'. $imageuser['ext'];
}else{
		$img_profile_user_address = $taninAppConfig->base_url . 'media/images/avatar/small/default_small.png';
	}
}

?>
<!DOCTYPE html>
<html lang="fa">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="طنین اپ - مدیریت بهترین آلبوم های سال">
	<meta name="keyword" content="طنین اپ,موزیک,آلبوم,پاپ,سنتی">

	<title><?=$page_title?></title>

	<!-- Bootstrap core CSS -->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/bootstrap-reset.css" rel="stylesheet">
	<!--external css-->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/font-awesome.css" rel="stylesheet" />


	<!-- Custom styles for this template -->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/style.css" rel="stylesheet">
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/style-responsive.css" rel="stylesheet" />
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/sweetalert2.min.css" rel="stylesheet" />

	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/iziToast.min.css" rel="stylesheet" />
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/jquery.dropdown.css" rel="stylesheet" />


	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/multi-select.css" rel="stylesheet" />

	<!--searchable list optinal-->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/searchoptinallist.css" rel="stylesheet" />


	<!--Player-->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/audioplayer.css" rel="stylesheet" />

	<!--DatePicker-->
	<link href="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/css/datepicker-de.css" rel="stylesheet" />

	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.js"></script>



	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/sweetalert2.min.js"></script>


	<!--Player-->
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/iziToast.min.js"></script>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.dropdown.js"></script>

	<!-- LIVICON -->
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/livicon/raphael-min.js"></script>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/livicon/livicons-1.3.min.js"></script>

	<!--searchable list optinal-->
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/searchoptinallist.js"></script>


	<!--datePicker-->
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/datepicker.min.js"></script>



	<!--[if lt IE 8]>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/livicon/json2.min.js"></script>
	<![endif]-->
	<!-- LIVICON -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
	<!--[if lt IE 9]>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/html5shiv.js"></script>
	<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body>
<section id="container" class="">
	<!--header start-->
	<header class="header white-bg">
		<div class="sidebar-toggle-box">
			<div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-reorder tooltips"></div>
		</div>
		<!--logo start-->
		<a href="#" class="logo">طنین <span>اپ </span></a>
		<!--logo end-->
		<div class="top-nav ">
			<!--search & user info start-->

			<ul class="nav pull-right top-menu">
				<?if (isset($search_id_name)){?>
				<li>
					<input type="text" id="<?=$search_id_name?>" class="form-control search" placeholder="جست و جو">
				</li>
				<?}?>

				<!-- user login dropdown start-->
				<li class="dropdown">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<img  src="<?=$img_profile_user_address?>">
						<span class="username"><?=$_SESSION['user_fullname']?></span>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu extended logout">
						<div class="log-arrow-up"></div>
						<li><a href="<?=$taninAppConfig->base_url . 'account/logout/'?>"><i class="fa fa-key"></i> خروج</a></li>
						<li><a href="<?=$taninAppConfig->base_url . 'account/details/' . $_SESSION['user_id']?>"><i class="fa fa-suitcase"></i>پروفایل</a></li>

					</ul>
				</li>
				<!-- user login dropdown end -->
			</ul>
			<!--search & user info end-->
		</div>
	</header>
	<!--header end-->
	<!--sidebar start-->
	<aside>
		<div id="sidebar"  class="nav-collapse ">
			<!-- sidebar menu start-->
			<ul class="sidebar-menu">
				<li class="active">
					<a class="" href="<?=$taninAppConfig->base_url?>">
						<i class="livicon" data-name="dashboard" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>صفحه اصلی</span>
					</a>
				</li>

				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="users" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>کاربران</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'account/users/'?>">مدیریت کاربران</a></li>
					</ul>

				</li>


				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="albums" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>آلبوم ها</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'album/allAlbums/'?>">آلبوم های ثبت شده</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'album/singleTrack/'?>">آلبوم های تک تراک</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'album/getSpecialAlbum/'?>">دریافت آلبوم جدید</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'album/queue/'?>">آلبوم های در انتظار</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'album/broken/'?>">آلبوم های شکسته</a></li>
					</ul>

				</li>
				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="music" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>موزیک ها</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'track/allTrack/'?>">تمامی موزیک های ثبت شده</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'track/getSpecialTrack/'?>">دریافت تراک های یک آلبوم</a></li>
					</ul>
				</li>



				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="medal" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>هنرمندان</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'owner/all/'?>">تمامی هنرمندان ثبت شده</a></li>
					</ul>
				</li>


				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="tags" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>برچسب ها</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'tag/all/'?>">تمامی برچسب های ثبت شده</a></li>
					</ul>
				</li>


				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="camera-alt" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>ژانر ها</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'genre/all/'?>">تمامی ژانر های ثبت شده</a></li>
					</ul>
				</li>


				<li class="sub-menu">
					<a href="javascript:;" class="">
						<i class="livicon" data-name="notebook" data-eventtype="hover" data-color="#8b9193" data-hovercolor="#ff6c60" data-size="24"></i>
						<span>گزارش گیری</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub">
						<li><a class="" href="<?=$taninAppConfig->base_url . 'report/albums/'?>">گزارش از آلبوم ها</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'report/tracks/'?>">گزارش از موزیک ها</a></li>
						<li><a class="" href="<?=$taninAppConfig->base_url . 'report/tracksAlbums/'?>">گزارش از موزیک ها و آلبوم ها</a></li>
					</ul>
				</li>

			</ul>
			<!-- sidebar menu end-->
		</div>
	</aside>
	<!--sidebar end-->
	<!--main content start-->
	<section id="main-content">
		<section class="wrapper">
			<?php echo $component?>
		</section>
	</section>
	<!--main content end-->
</section>

<!-- js placed at the end of the document so the pages load faster -->

<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/bootstrap.min.js"></script>
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.scrollTo.min.js"></script>

<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.customSelect.min.js" ></script>

<!--common script for all pages-->
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/common-scripts.js"></script>




<script>

	$(function () {
		iziToast.settings({
			rtl: true,
			timeout: 5000,
			backgroundColor: '#565c70',
			titleColor: '#f6f6f7',
			messageColor: '#cccdd3',
			iconColor: '#00feb7',
			layout:'2',
			animateInside: true,
			titleLineHeight:'27px',
			titleSize: '20px',
			progressBarColor: '#00feb7',
			theme: 'dark', // dark
			transitionIn: 'bounceInUp',
			transitionOut: 'fadeOut',
			transitionInMobile: 'fadeInUp',
			transitionOutMobile: 'fadeOutDown',
		});


	});


</script>

</body>
</html>

