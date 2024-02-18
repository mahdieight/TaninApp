<!-- page start-->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				تمامی موزیک های ثبت شده
			</header>


			<script>
				$('#search-alltrack').on('keyup',function () {
					var txt_seach = $(this).val();
					get_ajax_track('1',txt_seach);
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
		get_ajax_track('1');
	});
	function get_ajax_track(page_number,value) {
		if (page_number == undefined){
			page_number = 1;
		}
		if (value == undefined){
			value = false;
		}

		$.ajax('../getTrackAjax',{
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
