<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی برچسب های ثبت شده
			</header>
			<div id="list-content">
			</div>
		</section>
	</div>
</div>
<!-- page end-->

<script>

	$(function () {
		get_ajax_tag('1');
	});
	function get_ajax_tag(page_number) {
		$.ajax('../getTagAjax',{
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
