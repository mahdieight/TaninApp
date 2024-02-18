<?php
$imageuser = json_decode($user_info['img'],true);
if (file_exists(getcwd() . '/media/images/avatar/medium/' . $imageuser['name']  .'_medium'. $imageuser['ext'])){
	$img_user_address = $taninAppConfig->base_url . 'media/images/avatar/medium/' . $imageuser['name']  .'_medium'. $imageuser['ext'];
}else{
	$img_user_address = $taninAppConfig->base_url . 'media/images/avatar/medium/default_medium.png';
}
?>
<div class="col-md-12 m-b-40">
	<button class="btn btn-success waves-effect waves-light" onclick="redirectUsersShow('<?=$taninAppConfig->base_url?>');" type="button">
		<span class="btn-label"><i class="fa fa-reply"></i></span>
		بازگشت به صفحه کاربران</button>
</div>
<script>
	function redirectUsersShow(url){
		window.location.href = url +'account/users/' ;
	}
</script>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="#">
					<img src="<?=$img_user_address?>" alt="">
				</a>
				<h1><?=$user_info['fullname']?></h1>
				<p><?=$user_info['email']?></p>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a onclick="showRelatyPage('biography','<?=$user_info['id']?>');"><i class="fa fa-user"></i>اطلاعات کاربر</a></li>
				<li><a onclick="showRelatyPage('activaty','<?=$user_info['id']?>');"><i class="fa fa-history"></i>فعالیت های کاربر</a></li>


			</ul>

		</section>
	</aside>
	<aside class="profile-info col-lg-9">
		<div id="component"></div>
	</aside>
</div>

<script>

	$(function () {
		showRelatyPage('biography','<?=$user_info['id']?>');
	});

	function showRelatyPage(paga_name,user_id) {
		$.ajax('../showUserPage/',{
			type:'POST',
			dataType: 'json',
			data:{
				showPage: paga_name,
				userID: user_id,
			},
			success:function (date) {
				$('#component').empty();
				$('#component').append(date.result);
			}
		})
	}
</script>




<script>
	function unLinkUser(user_id) {
		swal({
			title: 'آیا شما اطمینان دارید؟',
			text: "این عمل غیر قابل بازگشت است!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'خیر، منصرف شدم',
			confirmButtonText: 'بله، حذف کن!'
		}).then((result) => {
			$.ajax('../unlink_user',{
			type: 'POST',
			dataType: 'json',
			data:{
				userid:user_id,
			},
			success: function(mdata){
				if(mdata.status == true){
					setTimeout(function(){ window.location = mdata.redirect; }, mdata.time);

					iziToast.info({
						title: 'عملیات موفقیت آمیز بود!',
						message: mdata.msg,
						icon: 'fa fa-get-pocket',
					});

				}else{
					iziToast.info({
						title: 'خطایی رخ داد!',
						message: mdata.msg,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
					return;
				}
			}
		});
	})
	}
</script>
<script>

	function saveChanges(user_id,used_status) {

		var new_val_fullname = $('#fullname').val();
		var new_val_email = $('#emailaddress').val();
		var new_val_phone = $('#phone').val();
		var new_val_password = $('#new-password').val();
		var new_val_user_blocked = $('#is_blocked:checked').val();
		if (new_val_user_blocked == undefined){
			new_val_user_blocked = "0";
		}

		var new_val_user_admin = $('#isSupperAdminde:checked').val();
		if (new_val_user_admin == undefined){
			new_val_user_admin = "0";
		}

		var val_confirm_password = $('#re-password').val();
		var val_provided_password = $('#use-password').val();


		var curren_val_fullname 			= '<?=$user_info['fullname']?>';
		var curren_val_email 					= '<?=$user_info['email']?>';
		var curren_val_phone 					= '<?=$user_info['phone']?>';
		var curren__val_user_blocked 	= '<?=$user_info['blocked']?>';
		var curren_val_user_admin 	= '<?=$user_info['is_supperadmin']?>';
		if (curren_val_user_admin != new_val_user_admin || curren__val_user_blocked != new_val_user_blocked || curren_val_fullname != new_val_fullname || curren_val_email != new_val_email || curren_val_phone !=new_val_phone || new_val_password.length >0 ){

			if(new_val_password.length > 0 && new_val_password == val_confirm_password && used_status == true){
				$.ajax('../checkMatchPassword/',{
					type: 'POST',
					dataType: 'json',
					data:{
						pass_provided: val_provided_password,
						user_id:'<?=$user_info['id']?>',
					},
					success: function (checkpass) {
						if(checkpass.error['status'] == true){
							iziToast.info({
								title: 'خطایی در عملیات وجود دارد',
								message: date.error['message'],
								icon: 'fa fa-get-pocket',
							});
						}

						if (checkpass.result == true){
							$.ajax('../editUserInformation/',{
								type: 'POST',
								dataType: 'json',
								data:{
									user_id:'<?=$user_info['id']?>',
									fullname: new_val_fullname,
									email: 		new_val_email,
									phone: 		new_val_phone,
									password: new_val_password,
									blocked:  new_val_user_blocked,
									is_admin:  new_val_user_admin,
								},
								success:function (date) {
									if(date.status == true){
										iziToast.info({
											title: 'عملیات موفقیت آمیز بود!',
											message: date.result,
											icon: 'fa fa-get-pocket',
										});
									}else{
										iziToast.info({
											title: 'خطایی رخ داد!',
											message: date.result,
											icon: 'fa fa-exclamation-circle ',
											iconColor: '#e74c3c',
										});
									}
								}
							});
						}else{
							iziToast.info({
								title: 'خطایی رخ داده است!',
								message: 'گذروازه ارائه شده با گذرواژه فعلی شما مطابقت ندارد!',
								icon: 'fa fa-exclamation-circle ',
								iconColor: '#e74c3c',
							});
						}
					}
				});
				/*******--------------END WITH PASS---------------*******/
			}else if(new_val_password != val_confirm_password && used_status == true){
				iziToast.info({
					title: 'خطایی رخ داده است!',
					message: 'گذرواژه ها با یکدیگر مطابقت ندارند! لطفا دوباره سعی کنید',
					icon: 'fa fa-exclamation-circle ',
					iconColor: '#e74c3c',
				});
			}else if (new_val_password.length > 0){
				$.ajax('../editUserInformation/',{
					type: 'POST',
					dataType: 'json',
					data:{
						user_id:'<?=$user_info['id']?>',
						fullname: new_val_fullname,
						email: 		new_val_email,
						phone: 		new_val_phone,
						blocked:  new_val_user_blocked,
						is_admin:  new_val_user_admin,
						password: new_val_password,
					},
					success:function (date) {
						if(date.status == true){
							iziToast.info({
								title: 'عملیات موفقیت آمیز بود!',
								message: date.result,
								icon: 'fa fa-get-pocket',
							});
						}else{
							iziToast.info({
								title: 'خطایی رخ داد!',
								message: date.result,
								icon: 'fa fa-exclamation-circle ',
								iconColor: '#e74c3c',
							});
						}
						return;
					}
				});
				/*******--------------END WITHOUT PASS-------------*******/
			}else{
				$.ajax('../editUserInformation/',{
					type: 'POST',
					dataType: 'json',
					data:{
						user_id:'<?=$user_info['id']?>',
						fullname: new_val_fullname,
						email: 		new_val_email,
						phone: 		new_val_phone,
						blocked:  new_val_user_blocked,
						is_admin:  new_val_user_admin,
					},
					success:function (date) {
						if(date.status == true){
							iziToast.info({
								title: 'عملیات موفقیت آمیز بود!',
								message: date.result,
								icon: 'fa fa-get-pocket',
							});
						}else{
							iziToast.info({
								title: 'خطایی رخ داد!',
								message: date.result,
								icon: 'fa fa-exclamation-circle ',
								iconColor: '#e74c3c',
							});
						}
					}
				});
			}
		}else{
			iziToast.info({
				title: 'خطایی رخ داد!',
				message: 'هیچ تغییری در فرم ایجاد نشده است!',
				icon: 'fa fa-exclamation-circle ',
				iconColor: '#e74c3c',
			});
		}
	}
</script>

