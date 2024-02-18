<?if($owner_count !=1){?>
<div class="text-center">
	<ul class="pagination">
		<li><a onclick="get_ajax_owner('1',$('#search-owner-equeue').val());" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $owner_count){continue;}
			?>
			<li><a onclick="get_ajax_owner(<?=$i?>,$('#search-owner-equeue').val());" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="get_ajax_owner(<?=$owner_count?>,$('#search-owner-equeue').val());" href="#">»</a></li>
	</ul>
</div>
<?}?>

<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>نام</th>
		<th class="hidden-phone">نام هنری</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($owner_info as $owner){
		?>
		<tr class="odd gradeX">
			<td><a href="<?=$taninAppConfig->base_url . 'owner/details/' . $owner['id'] ?>" target="_blank"><?=$owner['firstName'] .' ' . $owner['lastName']?></a> </td>
			<td class="hidden-phone"><?=$owner['artisticName']?></td>

		</tr>
	<?php }?>
	</tbody>
</table>

<script>

</script>