<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				آلبوم های تک تراک
				<?if (isSupperAdmin() == true){?>
					<span onclick="unLinkAlbums()"  class="btn btn-danger"><i class="fa fa-remove"></i>حذف آلبوم (ها)</span>
					<span onclick="redirectAddNewSingleTrack('<?=$taninAppConfig->base_url?>')"  class="btn btn-success"><i class="fa fa-plus-circle"></i>افزودن آلبوم تک ترک</span>
				<?}?>
			</header>

			<script>
				function redirectAddNewSingleTrack(url){
					window.location.href = url +'album/addSingleTrack/' ;
				}


				$('#search-allalbum').on('keyup',function () {
					var txt_seach = $(this).val();
					getContentAlbums('1',txt_seach);
				});


			</script>
			<div id="list-content">
			</div>
		</section>
	</div>
</div>
<!-- page end-->


<script>
	$(function () {
		getContentAlbums();
	});


	function getContentAlbums(pageIndex,value) {
		if (pageIndex == undefined){
			pageIndex = 1;
		}
		if (value == undefined){
			value = false;
		}

		$.ajax('../getAlbumSingleTrackAjax',{
			type:'POST',
			dataType: 'json',
			data:{
				pageIndex:pageIndex,
				valueSearch: value,
			},
			success:function (date) {
				$('#list-content').empty();
				$('#list-content').append(date.content);
			}
		})
	}
</script>
<script>
	function unLinkAlbums(){
	swal({
		title: 'آیا شما اطمینان دارید؟',
		text: "این عمل غیر قابل بازگشت است!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'خیر، منصرف شدم',
		confirmButtonText: 'بله، حذف کن!'
	}).then((results) => {
		var allVals = [];
		$('.album-check-id:checked').each(function() {
			allVals.push($(this).val());
		});
		$.ajax('../unlink_album',{
			type: 'POST',
			dataType: 'json',
			data:{
				albumid:allVals,
			},
			success: function(mdata){
				if(mdata.status == true){

					iziToast.info({
						title: 'عملیات موفقیت آمیز بود!',
						message: mdata.msg,
						icon: 'fa fa-get-pocket',
					});
					getContentAlbums();
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



</script>
