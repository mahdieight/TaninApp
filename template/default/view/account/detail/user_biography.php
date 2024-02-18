<?php

if (isSupperAdmin() != true AND $user_info['id'] != $_SESSION['user_id']){
	$readOnly = true;
}else{
	$readOnly = false;
}

if ($user_info['blocked'] != 1){
	$blocked = false;
}else{
	$blocked = true;
}

if ($user_info['is_supperadmin'] !=1){
	$is_supperadmin = false;
}else{
	$is_supperadmin = true;
}
?>

<section class="panel">

	<div class="panel-body bio-graph-info">
		<h1>جزئیات حساب کاربری</h1>
		<div class="row">
			<div class="bio-row">
				<div class="form-group">
					<label for="fullname">نام و نام خانوادگی :</label>
					<?if($readOnly){?>
						<input type="text" id="fullname" class="form-control btn-block" value="<?=$user_info['fullname']?>" readonly>
					<?}else{?>
						<input type="text" id="fullname" class="form-control btn-block" value="<?=$user_info['fullname']?>">
					<?}?>
				</div>
			</div>
			<div class="bio-row">
				<div class="form-group">
					<label for="emailaddress">آدرس ایمیل :</label>
					<?if($readOnly){?>
						<input type="text" id="emailaddress" class="form-control btn-block" value="<?=$user_info['email']?>" readonly>
					<?}else{?>
						<input type="text" id="emailaddress" class="form-control btn-block" value="<?=$user_info['email']?>">
					<?}?>
				</div>
			</div>
			<div class="bio-row">
				<div class="form-group">
					<label for="phone">شماره همراه :</label>
					<?if($readOnly){?>
						<input type="text" id="phone" class="form-control btn-block" value="<?=$user_info['phone']?>" readonly>
					<?}else{?>
						<input type="text" id="phone" class="form-control btn-block" value="<?=$user_info['phone']?>">
					<?}?>
				</div>
				<?php if(isSupperAdmin()){?>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label class="label_check" for="is_blocked">
									<?php if($blocked){?>
										<input name="is_blocked" id="is_blocked" value="1" type="checkbox" checked>
									<?php }else{?>
										<input name="is_blocked" id="is_blocked" value="1" type="checkbox">
									<?php }?>
									مسدود سازی حساب کاربری
								</label>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group">
								<label class="label_check" for="isSupperAdminde">
									<?php if($is_supperadmin AND !isSupperAdmin()){?>
										<input name="isSupperAdminde" id="isSupperAdminde" value="1" type="checkbox" checked disabled>
									<?}else if($is_supperadmin AND isSupperAdmin()){?>
										<input name="isSupperAdminde" id="isSupperAdminde" value="1" type="checkbox" checked>
									<?}else{?>
										<input name="isSupperAdminde" id="isSupperAdminde" value="1" type="checkbox">
									<?}?>
									کاربر، کاربر ارشد است

								</label>
							</div>
						</div>
					</div>
				<?}?>
			</div>

			<? if (isSupperAdmin() == true OR $user_info['id'] == $_SESSION['user_id']){?>
				<div class="bio-row">
					<div class="form-group">
						<label for="password">تغییر گذرواژه :</label>
						<input type="password" id="new-password" class="form-control btn-block" placeholder="">
					</div>
					<? if ($user_info['id'] == $_SESSION['user_id']){?>
					<div id="hidden-field">
						<div class="form-group">
							<label for="re-password">تایید گذرواژه :</label>
							<input type="password" id="re-password" class="form-control btn-block" placeholder="">
						</div>

						<div class="form-group">
							<label for="use-password">گذرواژه کنونی :</label>
							<input type="password" id="use-password" class="form-control btn-block" placeholder="">
						</div>
						<?}?>


					</div>
				</div>
			<?}?>
		</div>
		<?if (isSupperAdmin() == true AND $user_info['id'] != $_SESSION['user_id']){?>

			<div class="row">
				<div class="col-lg-6">
					<span onclick="saveChanges(<?=$user_info['id']?>,false)" class="btn btn-success btn-block">ذخیره تغییرات</span>
				</div>

				<div class="col-lg-6">
					<span onclick="unLinkUser(<?=$user_info['id']?>)" class="btn btn-danger btn-block">حذف کاربر</span>
				</div>
			</div>
		<?}else if($user_info['id'] == $_SESSION['user_id']){?>
			<span onclick="saveChanges(<?=$user_info['id']?>,true)" class="btn btn-success btn-block">ذخیره تغییرات</span>
		<?}?>
	</div>
</section>