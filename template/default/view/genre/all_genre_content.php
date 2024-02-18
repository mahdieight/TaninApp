<div class="text-center">
	<ul class="pagination">
		<li><a onclick="get_ajax_genre('1');" href="#">«</a></li>

		<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
			if($i <=0){continue;}
			if($i >= $genre_count){continue;}
			?>
			<li><a onclick="get_ajax_genre(<?=$i?>);" href="#"><?=$i?></a></li>
		<?php }?>

		<li><a onclick="get_ajax_genre(<?=$genre_count?>);" href="#">»</a></li>
	</ul>
</div>

<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th>نام</th>

	</tr>
	</thead>
	<tbody>
	<?php foreach ($genre_info as $genre){
		?>
		<tr class="odd gradeX">
			<td><a href="<?=$taninAppConfig->base_url . 'genre/details/' .$genre['id']?>"><?=$genre['value']?></a> </td>
		</tr>
	<?php }?>
	</tbody>
</table>

<script>

</script>