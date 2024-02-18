<div class="row">
	<div class="col-lg-12">
		<div id="loading">
			<div class="loading-img"><img class="img-responsive" src="<?=$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/loading.svg'?>" /></div>
		</div>
	</div>
</div>
<?if($albumCount !=1){?>
<div class="text-center">
	<ul class="pagination">
		<li><a onclick="getContentAlbumsBroken('1');" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $albumCount){continue;}
			?>
		<li><a onclick="getContentAlbumsBroken(<?=$i?>);" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="getContentAlbumsBroken(<?=$albumCount?>);" href="#">»</a></li>
	</ul>
</div>
<?}?>

<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>نام آلبوم</th>
		<th class="hidden-phone">تاریخ درج</th>
		<?if (isSupperAdmin()){?>
		<th class="hidden-phone">عملیات</th>
		<?}?>
	</tr>
	</thead>
	<tbody>
<? foreach ($records AS $album) {?>

	<tr class="odd gradeX">
		<td><?=$album['name'] ?></td>
		<td class="center hidden-phone"><?=JdateController::converDate($album['created_at'])?></td>
		<?if(isSupperAdmin()){?>
		<td class="hidden-phone">

			<span onclick="getAlbumBroken('<?=$album['ex_id']?>','<?=$album['name']?>');" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span>
			<span onclick="delAlbumBroken('<?=$album['ex_id']?>','<?=$album['name']?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash "></i></span>

		</td>
		<?}?>
	</tr>
<?}?>
	</tbody>
</table>

<script>
	function getAlbumBroken(album_exid,album_name){
		$("#loading").show();
		$("#loading").css('display','block');
		$.ajax('../deleteHardAllTracksAlbum',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_exid,
			},
			success: function (date) {

				$("#loading").hide();
				$("#loading").css('display','none');


				if(date.status == false){
					iziToast.info({
						title: 'خطایی رخ داد!',
						message: date.result ,
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}else {
					delAlbumBroken(album_exid,album_name);
					iziToast.info({
						title: 'اطلاعات آلبوم با موفقیت ذخیره شد!',
						message: date.result,
						icon: 'fa fa-get-pocket',
					});

				}
			}
		});
	}


	function delAlbumBroken(album_exid,album_name) {
		$.ajax('../deleteAlbumBrokenItem',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_exid,
				albumName:album_name,
			},
			success:function (data) {
				if(data.status == true){
					getContentAlbumsBroken();
					iziToast.info({
						title: 'آلبوم با موفقیت حذف شد',
						message: 'آلبوم مورد نظر با موفقیت از فهرست آلبوم های در شکسته حذف گردید',
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}

			}
		});
	}
</script>