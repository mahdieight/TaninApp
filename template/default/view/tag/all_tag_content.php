<div class="text-center">
	<ul class="pagination">
		<li><a onclick="get_ajax_tag('1');" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $tag_count){continue;}
			?>
			<li><a onclick="get_ajax_tag(<?=$i?>);" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="get_ajax_tag(<?=$tag_count?>);" href="#">»</a></li>
	</ul>
</div>

<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>نام</th>

	</tr>
	</thead>
	<tbody>
	<?php foreach ($tag_info as $tag){
		?>
		<tr class="odd gradeX">
			<td><a href="<?=$taninAppConfig->base_url . 'tag/details/' .$tag['id']?>"><?=$tag['value']?></a> </td>
		</tr>
	<?php }?>
	</tbody>
</table>

<script>

</script>