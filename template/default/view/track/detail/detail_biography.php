<?php

$fileInfo = json_decode($track_info['fileInfo'],true);
if (!empty($fileInfo['hqName'])){
	$fileType = explode('.mp',$fileInfo['hqName']);
	$fileType = end($fileType);
}

$track_name 		= $track_info['track_name'];
$track_engName 	= $track_info['track_eng_name'];
$track_price 		= $track_info['track_price'];
$track_duration = $track_info['track_duration'];

$album_name 			= $track_info['album_name'];
$album_publisher 	= $track_info['publisherID'];
$album_owners 		= $track_info['owners'];


$publisher_info 						=	 PublisherModel::get_publisher_info_by_id($album_publisher);
$publisher_name 						=  $publisher_info['displayName'];

$owners = explode(',',$track_info['owners']);
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
<script src="<?=$taninAppConfig->base_url. 'template/' . $taninAppConfig->template_name?>/assets/js/audioplayer.js"></script>
<aside class="profile-info col-lg-9">
	<section class="panel">
		<? if($track_info['status'] ==1){?>
		<div class="cu-bg-heading-player">
			<?php if($fileType == 4){?>

				<video width="320" height="240" controls>
					<source src="<?='../../'. $fileInfo['hqPath'] . '/' .$fileInfo['hqName']  ?>" type="video/mp4">
				</video>
			<?php }else{?>

				<!--MP3 Player-->
				<div id="ap23" class="audioplayer-tobe skin-wave auto-init" style="width:100%; margin-top: 70px; "  data-scrubbg="<?=$taninAppConfig->base_url . 'template/' . $taninAppConfig->template_name .'/assets/images/waves/scrubbg.png' ?>" data-scrubprog="<?=$taninAppConfig->base_url . 'template/' . $taninAppConfig->template_name .'/assets/images/waves/scrubprog.png' ?>" data-videoTitle="Audio Video" data-type="normal" data-source="<?='../../'. $fileInfo['hqPath'] . '/' .$fileInfo['hqName']  ?>" data-options='{
            autoplay: "off"
            ,cue: "on"
            ,disable_volume: "on"
            ,skinwave_mode: "small"
            }'>

				</div>
				<!--MP3 Player-->
			<?php }?>
		</div>
		<?}?>
		<div class="panel-body bio-graph-info">
			<h1>جزئیات تراک</h1>
			<div class="row">
				<div class="bio-row">
					<p><span>نام تراک</span>: <?=$track_name?></p>
				</div>
				<div class="bio-row">
					<p><span>نام انگلیسی </span>: <?=$track_engName?></p>
				</div>
				<div class="bio-row">
					<p><span>نام آلبوم </span>: <?=$album_name?></p>
				</div>
				<div class="bio-row">
					<p><span>انتشارات </span>: <?=$publisher_name?></p>
				</div>
				<div class="bio-row">
					<p><span>قیمت تراک</span>: <?=$track_price?></p>
				</div>
				<div class="bio-row">
					<p><span>مدت زمان تراک </span>: <?=$track_duration?></p>
				</div>
				<div class="bio-row">
					<p><span>خواننده </span>: <?=$listOwners?></p>
				</div>

			</div>
		</div>
	</section>
	<section>
	</section>
</aside>

