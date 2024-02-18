<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی هنرمندان ثبت شده
			</header>



			<script>
				$('#search-owner').on('keyup',function () {
					var txt_seach = $(this).val();
					get_ajax_owner('1',txt_seach);
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
		get_ajax_owner('1');
	});
	function get_ajax_owner(page_number,value) {
		if (page_number == undefined){
			page_number = 1;
		}
		if (value == undefined){
			value = false;
		}

		$.ajax('../getOwnerAjax',{
			type:'POST',
			dataType:'json',
			data:{
				page_index: page_number,
				valueSearch: value,
			},
			success:function (date) {
				$('#list-content').empty();
				$('#list-content').append(date.result);
			}
		})
	}
</script>
