<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی آلبوم های در انتظار

			</header>

			<script>
				$('#search-album-equeue').on('keyup',function () {
					var txt_seach = $(this).val();
					getContentAlbumsQueue('1',txt_seach);
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
		getContentAlbumsQueue();
	});


	function getContentAlbumsQueue(pageIndex,value) {
		if (pageIndex == undefined){
			pageIndex = 1;
		}
		if (value == undefined){
			value = false;
		}

		$.ajax('../getAlbumQueueAjax',{
			type:'POST',
			dataType: 'json',
			data:{
				pageIndex:pageIndex,
				searchValue:value,
			},
			success:function (date) {
				$('#list-content').empty();
				$('#list-content').append(date.content);
			}
		})
	}
</script>