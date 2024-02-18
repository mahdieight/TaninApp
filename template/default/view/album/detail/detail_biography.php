<?php

$album_id 									= $album_info['id'];
$album_external_id 					= $album_info['ex_id'];
$album_name 								= $album_info['name'];
$album_eng_name 						= $album_info['engName'];
$album_crc 									= $album_info['crc'];
$album_description 					= $album_info['description'];
$album_final_price 					= $album_info['finalPrice'];
$album_primary_image_path 	= json_decode($album_info['primaryImagePathHQ'],true);
$album_gallery						 	= json_decode($album_info['gallery'],true);
$album_folder_path 					= getAddresByCRC($album_info['crc']);

$base_address = getAddresByCRC($album_info['crc']);
$zip_file_address = $base_address . '/'. $album_info['crc'] .'-hq.zip';
$excel_file_address = $base_address . '/'. $album_info['crc'] .'-TapSong.xlsx';



if(file_exists(getcwd() .'/' . $zip_file_address )){
	$zip_file_exits = true;
}else {
	$zip_file_exits = false;
}


if(file_exists(getcwd() .'/' .$excel_file_address )){
	$excel_file_exits = true;
}else {
	$excel_file_exits = false;
}

$album_image			= $base_address . '/'. $album_info['crc'] .'-Gall' ;

if (empty($album_gallery['name'])){
	$image_galler_exits = false;
}else{
	$image_gallery_address = $album_gallery['path'] . '/'.$album_gallery['name'];
	$image_galler_exits = true;
}

$part_div_number =12;
if ($excel_file_exits == true){
	$part_div_number -=3;
}

if ($zip_file_exits == true){
	$part_div_number -=3;
}

if ($image_galler_exits == true){
	$part_div_number -=3;
}

$publisher_id 							= $album_info['publisherID'];
$publisher_info 						=	 PublisherModel::get_publisher_info_by_id($publisher_id);
$publisher_name 						=  $publisher_info['displayName'];

$count_album_track 					= TrackModel::get_count_album_track_by_id($album_external_id);


$owners = explode(',',$album_info['owners']);
if (isset($owners[1])){
	$listOwners=array();
	foreach ($owners as $owner_info){
		$listOwners[] = OwnerModel::get_owner_name($owner_info);
	}
	$listOwners = implode('|',$listOwners);
}else{
	$listOwners = OwnerModel::get_owner_name($owners[0]);
}

?>

<aside class="profile-info col-lg-9">

	<section class="panel">
		<div class="bio-graph-heading">
			<?=$album_description?>

		</div>
		<div class="panel-body bio-graph-info">
			<h1>جزئیات آلبوم</h1>
			<div class="row">
				<div class="bio-row">
					<p><span>نام آلبوم  :</span> <?=$album_name?></p>
				</div>
				<div class="bio-row">
					<p><span>نام انگلیسی  :</span> <?=$album_eng_name?></p>
				</div>
				<div class="bio-row">
					<p><span>انتشارات :</span> <?=$publisher_name?></p>
				</div>
				<div class="bio-row">

					<p><span>قیمت آلبوم :</span> <?=$album_final_price?></p>
				</div>
				<div class="bio-row">
					<p><span>تعداد تراک آلبوم  :</span> <?=$count_album_track?> قطعه</p>
				</div>
				<div class="bio-row">
					<p><span>خواننده  :</span> <?=$listOwners?></p>
				</div>
				<div class="panel-body">
					<div class="col-lg-12">
						<?if ($zip_file_exits == true){?>
						<div class="col-lg-<?=$part_div_number?>">
							<a href="<?=$taninAppConfig->base_url .$zip_file_address?>" class="btn btn-success btn-block"><span class="fa fa-download"></span>دریافت فایل فشرده آلبوم</a>
						</div>
						<?} if($image_galler_exits == true){?>
						<div class="col-lg-<?=$part_div_number?>">
							<a href="<?=$taninAppConfig->base_url . $image_gallery_address?>" class="btn btn-danger btn-block"><span class="fa fa-download"></span> دریافت گالری تصویر آلبوم</a>
						</div>
						<?} if ($excel_file_exits == true){?>
							<div class="col-lg-<?=$part_div_number?>">
								<a href="<?=$taninAppConfig->base_url . $excel_file_address?>" class="btn btn-info btn-block"><span class="fa fa-download"></span> دریافت فایل اکسل آلبوم</a>
							</div>
						<?}?>
					</div>

				</div>
			</div>
		</div>
	</section>
	<section>
	</section>
</aside>

