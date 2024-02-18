
<section class="panel">
	<header class="panel-heading summary-head">
		<p>فعالیت های محیط مدیریت</p>
	</header>
	<div class="panel-body">
		<ul class="summary-list">
			<li>
				<a href="javascript:;">
					<i class="fa fa-eye"></i>
					<?=$all_activaty?>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<i class="fa fa-file-archive-o"></i>
					<?=$report_activaty?>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<i class="fa fa-play-circle"></i>
					<?=$album_activaty?>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<i class="fa fa-music"></i>
					<?=$track_activaty?>
				</a>
			</li>
			<li>
				<a href="javascript:;">
					<i class="fa fa-user"></i>
					<?=$account_activaty?>
				</a>
			</li>
		</ul>
	</div>
</section>


<section class="panel">

	<div class="panel-body profile-activity">

<div id="activaty-content"></div>
		<div class="text-center">
			<spam class="btn btn-danger" id="loadactivaty">بارگذاری فعالیت بیشتر</spam>
		</div>

	</div>
</section>

<script>

	$(function () {
		getActivatyContent(1);
	});


	function getActivatyContent(page_index) {
		$.ajax('../get_activaty_content',{
			type: 'POST',
			dataType: 'json',
			data:{
				pageIndex:page_index,
				userID: '<?=$user_info['id']?>',
			},
			success: function (data) {

				$('#loadactivaty').attr('onclick','getActivatyContent(' + data.next_page + ');');
				if (data.status == true){
				$('#activaty-content').append(data.content);

				}else {
					swal('محتوایی وجود ندارد','تمامی آیتم ها بارگذاری شده اند','error');
				}

			}
		});
	}
</script>