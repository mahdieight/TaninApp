<?if($pageIndex !=1){?>
<div class="text-center">
	<ul class="pagination">
		<li><a onclick="getContentAlbums('1');" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $usersCount){continue;}
			?>
		<li><a onclick="getContentUsers(<?=$i?>);" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="getContentUsers(<?=$usersCount?>);" href="#">»</a></li>
	</ul>
</div>
<?}?>
<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>
			<input type="checkbox" id="all-user-check-id" >
		</th>
		<th>نام کاربری</th>
		<th class="hidden-phone">آدرس ایمیل</th>
		<th class="hidden-phone">شماره همراه</th>
		<th class="hidden-phone">تاریخ عضویت</th>
		<th class="hidden-phone"></th>
	</tr>
	</thead>
	<tbody>
<? foreach ($records AS $users) {?>

	<tr class="odd gradeX">
		<td class="hidden-phone">
			<input type="checkbox" class="user-check-id" value="<?=$users['id']?>" >
		</td>
		<td class="hidden-phone"><a href="<?=$taninAppConfig->base_url . 'account/details/' .$users['id']?>"><?=$users['fullname']?></a> </td>
		<td class="hidden-phone"><?=$users['email']?></td>
		<td class="hidden-phone"><?=$users['phone']?></td>
		<td class="hidden-phone"><?=JdateController::converDate($users['created_at'])?></td>
		<?if ($users['is_supperadmin'] == 1){?>
		<td class="hidden-phone"><span class="fa fa-check-circle" style="color: #1caadc;"></span> </td>
		<?}else{?>
			<td class="hidden-phone"> </td>
		<?}?>
	</tr>
<?}?>
	</tbody>
</table>

<script>
	$('#all-user-check-id').change(function () {
		var isChecked = $('#all-user-check-id').attr('checked')?true:false;
		if (isChecked == true){
			$('.user-check-id').each(function() {
				$(this).attr('checked','checked');
			});
		}else{
			$('.user-check-id').each(function() {

				$(this).removeAttr('checked');
			});
		}

	});
</script>