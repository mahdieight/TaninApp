<?php
$album_publisher = $album_info['publisherID'];
?>
<aside class="profile-info col-lg-9">
	<section class="panel">
		<div class="bio-graph-heading">
			<?=$album_info['description']?>

		</div>
		<div class="panel-body bio-graph-info">
			<h1>ویرایش آلبوم</h1>
			<div class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-lg-2 control-label">توضیحات آلبوم</label>
					<div class="col-lg-10">
						<textarea  id="album-dec" class="form-control" cols="30" rows="10"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">نام آلبوم</label>
					<div class="col-lg-6">
						<input type="text" id="album-name" class="form-control"  placeholder="<?=$album_info['name']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-lg-2 control-label">نام انگلیسی آلبوم</label>
					<div class="col-lg-6">
						<input type="text" id="album-name-eng" class="form-control"  placeholder="<?=$album_info['engName']?>">
					</div>
				</div>
				<div class="form-horizontal form-material">
					<div class="form-group">
						<label class="col-lg-2 control-label">انتشارات آلبوم</label>
						<div class="col-lg-6">
							<select id="album-publisher" class="col-md-12">
								<?php foreach ($all_publisher as $publishers_info){
									if ($album_publisher == $publishers_info['id']){?>
										<option value="<?=$publishers_info['id']?>" selected><?=$publishers_info['name']?></option>
									<?php } else{?>
										<option value="<?=$publishers_info['id']?>"><?=$publishers_info['name']?></option>
									<?php }}?>
							</select>
						</div>
					</div>
				</div>


				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<button type="submit" onclick="changeAlbunInfo('<?=$album_info['id']?>');" class="btn btn-success">ذخیره سازی اطلاعات</button>
					</div>
				</div>
			</form>
		</div>
	</section>
	<!--
	<section>
		<div class="panel panel-primary">
			<div class="panel-heading">Sets New Password & Avatar</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-lg-2 control-label">Current Password</label>
						<div class="col-lg-6">
							<input type="password" class="form-control" id="c-pwd" placeholder=" ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">New Password</label>
						<div class="col-lg-6">
							<input type="password" class="form-control" id="n-pwd" placeholder=" ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">Re-type New Password</label>
						<div class="col-lg-6">
							<input type="password" class="form-control" id="rt-pwd" placeholder=" ">
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Change Avatar</label>
						<div class="col-lg-6">
							<input type="file" class="file-pos" id="exampleInputFile">
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-info">Save</button>
							<button type="button" class="btn btn-default">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	-->
</aside>

<script>
	function changeAlbunInfo(albumID) {
		var album_dec 			= $('#album-dec').html();
		var album_name 			= $('#album-name').val();
		var album_name_eng 	= $('#album-name-eng').val();
		var album_publisher = $('#album-publisher').val();

		$.ajax('../change_album_info',{
			type: 'POST',
			dataType: 'json',
			data :{
				album_id :	albumID,
				album_dec :	album_dec,
				album_name :	album_name,
				album_name_eng :	album_name_eng,
				album_publisher :	album_publisher,
			},
			success: function (result) {
				if(result['error']['status'] == true){
					swal('خطایی رخ داد',result['error']['message'],'error');
					return;
				}else{
					swal('موفقیت آمیز بود',result['error']['message'],'success');
					showRelatyPage('edit',albumID);
				}
			}
		});
	}
</script>