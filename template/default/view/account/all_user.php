<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی کاربران
				<?if (isSupperAdmin() == true){?>
				<a href="<?=$taninAppConfig->base_url . 'account/add'?>" target="_blank" class="btn btn-success"><i class="fa fa-plus-circle"></i>کاربر جدید </a>
					<span onclick="unLinkUsers()"  class="btn btn-danger"><i class="fa fa-remove"></i>حذف کاربر</span>
				<?}?>
			</header>

			<script>
				function unLinkUsers(){
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
					var allVals = [];
					$('.user-check-id:checked').each(function() {
						allVals.push($(this).val());
					});

					$.ajax('../account/unlink_user',{
						type: 'POST',
						dataType: 'json',
						data:{
							userid:allVals,
						},
						success: function(mdata){
							if(mdata.status == true){

								iziToast.info({
									title: 'عملیات موفقیت آمیز بود!',
									message: mdata.msg,
									icon: 'fa fa-get-pocket',
								});
								getContentUsers();
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

			<div id="list-content">
			</div>
		</section>
	</div>
</div>
<!-- page end-->


<script>
	$(function () {
		getContentUsers();
	});


	function getContentUsers(pageIndex) {
		if (pageIndex == undefined){
			pageIndex = 1;
		}

		$.ajax('../get_users_ajax/',{
			type:'POST',
			dataType: 'json',
			data:{
				pageIndex:pageIndex,
			},
			success:function (date) {
				$('#list-content').empty();
				$('#list-content').append(date.content);
			}
		})
	}
</script>

