<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی آلبوم های شکسته
			</header>

			<script>
				$('#search-album-broken').on('keyup',function () {
					var txt_seach = $(this).val();
					getContentAlbumsBroken('1',txt_seach);
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
		getContentAlbumsBroken();
	});


	function getContentAlbumsBroken(pageIndex,value) {
		if (pageIndex == undefined){
			pageIndex = 1;
		}
		if (value == undefined){
			value = false;
		}

		$.ajax('../getAlbumBrokenAjax/',{
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