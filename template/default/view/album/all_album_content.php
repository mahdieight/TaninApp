<?if($albumCount !=1){?>
	<div class="text-center">
		<ul class="pagination">
			<li><a onclick="getContentAlbums('1',$('#search-album-equeue').val());" href="#">«</a></li>
			<?php for ($i = $pageIndex-3 ; $i<=$pageIndex+3;$i++){
				if($i <=0){continue;}
				if($i >= $albumCount){continue;}
				?>
				<li><a onclick="getContentAlbums(<?=$i?>,$('#search-album-equeue').val());" href="#"><?=$i?></a></li>
			<?php }?>

			<li><a onclick="getContentAlbums(<?=$albumCount?>,$('#search-album-equeue').val());" href="#">»</a></li>
		</ul>
	</div>
<?}?>
<table class="table table-striped border-top" id="sample_1">

	<thead>
	<tr>
		<th style="width: 8px;">
			<input type="checkbox" id="all-album-check-id"  /></th>
		<th>نام آلبوم</th>
		<th class="hidden-phone">خواننده</th>
		<th class="hidden-phone">ژانر</th>
		<th class="hidden-phone">تاریخ درج</th>
		<th class="hidden-phone">وضعیت آلبوم</th>
	</tr>
	</thead>
	<tbody>
	<? foreach ($records AS $album) {

		if (!empty($album_genres)){
			$album_genres = explode(',',$album['genres']);
			if (isset($album_genres[1])){
				$listGenres=array();
				foreach ($album_genres as $genres){
					$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres));
				}
				$listGenres = implode('|',$listGenres);
			}else{
				$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres[0]));
			}
		}else{
			$listGenres = 'فاقد ژانر';
		}

		if (!empty($album_owners)){
			$album_owners = explode(',',$album['owners']);
			if (isset($album_owners[1])){
				$listOwners=array();
				foreach ($album_owners as $Owners){
					$listOwners[] = OwnerModel::get_owner_name($Owners);
				}
				$listOwners = implode('|',$listOwners);
			}else{
				$listOwners = OwnerModel::get_owner_name($album_owners[0]);
			}
		}else{
			$listOwners = 'فاقد خواننده';
		}


		?>

		<tr class="odd gradeX">
			<td>
				<input type="checkbox" class="album-check-id" value="<?=$album['id']?>" /></td>
			<td><a href="<?=$taninAppConfig->base_url?>album/details/<?=$album['id']?>"> <?=$album['name']?></a></td>
			<td class="hidden-phone"><?=$listOwners?></td>
			<td class="hidden-phone"><?=$listGenres?></td>
			<td class="center hidden-phone"><?=JdateController::converDate($album['created_at'])?></td>
			<td class="hidden-phone"><span class="label label-success">دریافت شده</span></td>
		</tr>
	<?}?>
	</tbody>
</table>

<script>
	$('#all-album-check-id').change(function () {
		var isChecked = $('#all-album-check-id').attr('checked')?true:false;
		if (isChecked == true){
			$('.album-check-id').each(function() {
				$(this).attr('checked','checked');
			});
		}else{
			$('.album-check-id').each(function() {

				$(this).removeAttr('checked');
			});
		}

	});
</script>