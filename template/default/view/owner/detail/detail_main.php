<?php
$imageowner = json_decode($owner_info['artistImage'],true);
?>
<div class="col-md-12 m-b-40">
	<button class="btn btn-success waves-effect waves-light" onclick="redirectOwnersShow('<?=$taninAppConfig->base_url?>');" type="button">
		<span class="btn-label"><i class="fa fa-reply"></i></span>
		بازگشت به صفحه هنرمندان</button>
</div>
<script>
	function redirectOwnersShow(url){
		window.location.href = url +'owner/all/' ;
	}
</script>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">

			<div class="user-heading round">
				<a>
					<img src="<?=$taninAppConfig->base_url . $imageowner['path'] . '/' . $imageowner['name'] . $imageowner['ext']?>" alt="">
				</a>
				<h1><?=$owner_info['artisticName']?></h1>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a onclick="showRelatyPage('biography','<?=$owner_info['id']?>');"><i class="fa fa-user"></i>اطلاعات هنرمند</a></li>
				<li><a onclick="showRelatyPage('edit','<?=$owner_info['id']?>');"><i class="fa fa-edit"></i>ویرایش هنرمند</a></li>
			</ul>

		</section>
	</aside>
	<div id="component"></div>
</div>

<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/jquery.counterup.min.js"></script>
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/waypoints.min.js"></script>
<script>


	showRelatyPage('biography','<?=$owner_info['id']?>');
	function showRelatyPage(page_name,owner_id) {
		$.ajax('../showOwnerPage/',{
			type:'POST',
			dataType: 'json',
			data:{
				page_name: page_name,
				owner_id: owner_id,
			},
			success:function (date) {
				$('#component').empty();
				$('#component').append(date.result);
			}
		})
	}


</script>

