<?if($track_count !=1){?>
<div class="text-center">
	<ul class="pagination">

		<li><a onclick="get_ajax_track('1',$('#search-album-equeue').val());" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $track_count){continue;}
			?>
			<li><a onclick="get_ajax_track(<?=$i?>,$('#search-album-equeue').val());" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="get_ajax_track(<?=$track_count?>,$('#search-album-equeue').val());" href="#">»</a></li>
	</ul>
</div>
<?}?>

<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>نام تراک</th>
		<th class="hidden-phone">مدت زمان</th>
		<th class="hidden-phone">وضعیت آلبوم</th>
	</tr>
	</thead>
	<tbody>
<?php foreach ($track_info as $track){?>
		<tr class="odd gradeX">
			<td><a href="<?=$taninAppConfig->base_url . 'track/details/' . $track['id']?>"><?=$track['name']?></a></td>
			<td class="center hidden-phone"><?=$track['trackDuration']?></td>
			<?php if($track['status'] != 1){?>
			<td class="hidden-phone"><span class="label label-danger">دریافت نشده</span></td>
			<?php }else{?>
				<td class="hidden-phone"><span class="label label-success">دریافت شده</span></td>
			<?}?>
		</tr>
	<?php }?>
	</tbody>
</table>

<script>

</script>