
	<!--work progress start-->
	<section class="panel">
		<div class="panel-body progress-panel">
			<div class="task-progress">
				<h1>آلبوم های در انتظار</h1>
				<p>عملیات بر روی 5 آلبوم در انتظار</p>
			</div>
			<?if (isSupperAdmin()){?>
				<div onclick="getLastAlbums();" class="left-btn-queue btn btn-success fa fa-refresh"></div>
				<div onclick="getBrokenAlbums();" class="left-btn-queue btn btn-success fa fa-unlink"></div>
			<?}?>
<script>
	function getBrokenAlbums() {
		$("#loading").show();
		$("#loading").css('display','block');
		$.ajax('../album/check_broken_album',{
			type: 'POST',
			cache: false,

			dataType: 'json',
			success:function (date) {
				iziToast.info({
					title: 'عملیات به اتمام رسید',
					message: 'مجموعا ' + date.broken + ' آلبوم به آلبوم های شکسته اضافه گردید',
					icon: 'fa fa-get-pocket',
				});
				getLastAlbumQueue();
				$("#loading").hide();
				$("#loading").css('display','none');
			},
			    timeout: 1800000
		});
	}


	function getLastAlbums() {
		$("#loading").show();
		$("#loading").css('display','block');
		$.ajax('../album/check_new_api_get_album',{
			type: 'POST',
			dataType: 'json',
			success:function (date) {
				iziToast.info({
					title: 'عملیات به اتمام رسید',
					message: 'مجموعا ' + date.result + ' آلبوم به آلبوم های در انتظار اضافه شد',
					icon: 'fa fa-get-pocket',
				});
				getLastAlbumQueue();
				$("#loading").hide();
				$("#loading").css('display','none');
			}
		});
	}
</script>
		</div>
		<table class="table table-hover">
			<tbody>
			<?if(!empty($lastAlbumQueue)){?>
			<td>ردیف</td>
			<td>نام آلبوم</td>
			<td>تاریخ درج</td>
			<td>عملیات</td>
			<?}?>
			<?php
			$jadate = new JdateController();
			if(!empty($lastAlbumQueue)){
				$j =1;
				foreach ($lastAlbumQueue as $last_album_queue){?>
					<tr>
						<td><?=$j?></td>
						<td>
							<?=$last_album_queue['name']?>
						</td>
						<td>
							<?=JdateController::converDate($last_album_queue['created_at'])?>
						</td>
					<?if (isSupperAdmin()){?>
						<td>
							<span onclick="getAlbumQueue('<?=$last_album_queue['ex_id']?>');" class="btn btn-success btn-xs"><i class="fa fa-check"></i></span>
							<span onclick="delAlbumQueue('<?=$last_album_queue['ex_id']?>','<?=$last_album_queue['name']?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash "></i></span>
						</td>
						<?}else{?>
						<td>
						<span  class="btn btn-warning btn-xs"><i class="fa fa-check"></i></span>
						<span  class="btn btn-warning btn-xs"><i class="fa fa-trash "></i></span>
						</td>
					<?}?>
					</tr>
					<?
					$j++;
				}
			}else{?>
				<p style="position: relative;right: 50%;">هورا! هیچ آلبومی برای دریافت وجود ندارد!</p>
			<?}?>
			</tbody>

		</table>
	</section>
	<!--work progress end-->

<script>
	function getAlbumQueue(album_exid) {
		$("#loading").show();
		$("#loading").css('display','block');
		$.ajax('../album/get_special_album',{

			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_exid,
				trackDownload:true,
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

					iziToast.info({
						title: 'اطلاعات آلبوم با موفقیت ذخیره شد!',
						message: date.result,
						icon: 'fa fa-get-pocket',
					});
					if(date.track == true){
						if (date.track_status == false) {
							iziToast.info({
								title: 'دریافت تراک ناموفقیت آمیز!',
								message: date.track_result,
								icon: 'fa fa-exclamation-circle ',
								iconColor: '#e74c3c',
							});
						} else {
							iziToast.info({
								title: 'موفقیت آمیز بود!',
								message: date.track_result,
								icon: 'fa fa-get-pocket',
							});
						}
					}

					/*START SET STATUS AJAX REQUEST*/
					$.ajax('../album/updateStatusAlbumQueueItem/',{
						type: 'POST',
						dataType: 'json',
						data:{
							albumID:album_exid,
						},
						success:function (data) {
							if(data.status == true){
								getLastAlbumQueue();
							}

						}
					});
					/*END SET STATUS AJAX REQUEST*/

				}
			}
		});
	}

	function delAlbumQueue(album_exid,album_name) {

		$.ajax('album/deleteAlbumQueueItem',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumID:album_exid,
				albumName:album_name,
			},
			success:function (data) {
				if(data.status = true){
					getLastAlbumQueue();
					iziToast.info({
						title: 'آلبوم با موفقیت حذف شد',
						message: 'آلبوم مورد نظر با موفقیت از فهرست آلبوم های در انتظار حذف گردید',
						icon: 'fa fa-exclamation-circle ',
						iconColor: '#e74c3c',
					});
				}

			}
		});
	}
</script>