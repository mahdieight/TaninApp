<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی ژانر های ثبت شده
			</header>
			<div id="list-content">
			</div>
		</section>
	</div>
</div>
<!-- page end-->

<script>

	$(function () {
		get_ajax_genre('1');
	});
	function get_ajax_genre(page_number) {
		$.ajax('../getGenreAjax/',{
			type:'POST',
			dataType:'json',
			data:{
				page_index: page_number,
			},
			success:function (date) {
				$('#list-content').empty();
				$('#list-content').append(date.result);
			}
		})
	}
</script>
