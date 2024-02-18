<?php
class AlbumModel{

	public static function getAlbums($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` ORDER BY `id` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getAlbumSingleTrackAjax($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `single_track` = 1 ORDER BY `id` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getLastAlbums($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` ORDER BY `updated_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getAllAlbums(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` ORDER BY `id` DESC ",array());
		return $records;
	}

	public static function getAlbumsWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `name` LIKE '%$value%' ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getAlbumsSingleTrackWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `name` LIKE '%$value%' AND `single_track` = 1 ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getQueueAlbums($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album_queue` WHERE `status` !=1 ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}
	public static function getQueueAlbumsWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album_queue` WHERE `status` !=1  AND `name` LIKE '%$value%' ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getBrokenAlbums($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album_broken` WHERE `status` !=1 ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getAlbumsBrokenCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album_broken`",array());
		return $records[0]['total'];
	}

	public static function getBrokenAlbumsWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album_broken` WHERE `status` !=1  AND `name` LIKE '%$value%' ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getAlbumsBrokenCountWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album_broken` WHERE `name` LIKE '%$value%' ",array());
		return $records[0]['total'];
	}


	public static function getAlbumsCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album`",array());
		return $records[0]['total'];
	}

	public static function getAlbumsSingleTrackCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album` WHERE `single_track` = 1",array());
		return $records[0]['total'];
	}


	public static function getAlbumsCountWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album` WHERE `name` LIKE '%$value%'",array());
		return $records[0]['total'];
	}

	public static function getAlbumsCountSingleTrackWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album` WHERE `name` LIKE '%$value%' AND `single_track` = 1",array());
		return $records[0]['total'];
	}

	public static function getAlbumsQueueCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album_queue`",array());
		return $records[0]['total'];
	}
	public static function getAlbumsQueueCountSuccess(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album_queue` WHERE `status` !=1",array());
		return $records[0]['total'];
	}

	public static function getAlbumsQueueCountWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album_queue` WHERE `name` LIKE '%$value%' ",array());
		return $records[0]['total'];
	}


	public static function getAlbumWithOwnerId($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_album` WHERE owners IN (:ownerd_id) AND  publisherID != 1  AND  publisherID != 26 ",array(
			'ownerd_id' =>$owner_id,
		));
		return $records;
	}


	public static function getLimitAlbumTop90(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT

`x_track`.`id` AS 'track_id',
`x_track`.`ex_id` AS 'track_exid',
`x_track`.`name` AS 'track_name',
`x_track`.`crc` AS 'track_crc',
`x_track`.`fileInfo` AS 'track_file',
`x_track`.`status`,

`x_album`.`id` AS 'album_id',
`x_album`.`ex_id` AS 'album_ex_id',
`x_album`.`name` AS 'album_name',
`x_album`.`crc` AS 'album_crc',
`x_album`.`publisherID`,
`x_album`.`owners` ,
`x_album`.`publishMonth`,
`x_album`.`publishYear`
FROM `x_track` INNER JOIN `x_album` ON `x_track`.`album_id` = `x_album`.`ex_id` WHERE `x_album`.`publishYear` > '1390' AND `x_track`.`status` =1 AND `x_album`.`publisherID` !=3 AND `x_album`.`publisherID` !=20 AND `x_album`.`publisherID` !=26 AND `x_album`.`publisherID` !=7 AND `x_album`.`publisherID` !=1");
		return $result;
	}


	public static function getLimitAlbumDown90(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT

`x_track`.`id` AS 'track_id',
`x_track`.`ex_id` AS 'track_exid',
`x_track`.`name` AS 'track_name',
`x_track`.`crc` AS 'track_crc',
`x_track`.`fileInfo` AS 'track_file',
`x_track`.`status`,

`x_album`.`id` AS 'album_id',
`x_album`.`ex_id` AS 'album_ex_id',
`x_album`.`name` AS 'album_name',
`x_album`.`crc` AS 'album_crc',
`x_album`.`publisherID`,
`x_album`.`owners` ,
`x_album`.`publishMonth`,
`x_album`.`publishYear`
FROM `x_track` INNER JOIN `x_album` ON `x_track`.`album_id` = `x_album`.`ex_id` WHERE `x_album`.`publishYear` < '1390' AND `x_track`.`status` =1 AND `x_album`.`publisherID` !=3 AND `x_album`.`publisherID` !=20 AND `x_album`.`publisherID` !=26 AND `x_album`.`publisherID` !=7 AND `x_album`.`publisherID` !=1");
		return $result;
	}


	public static function insertInfoAlbumPrimary($ex_id,$publisherID,$name,$engName,$description,$serial,$license,$marketPrice,$finalPrice,$publishData,$tags,$genres,$owners,$composers,$players,$arrangers,$poets,$singers,$publishYear,$publishMonth,$featured){

		$mycon = DB::getInstance();
		$curretn_time = Date('Y-m-d h:s:i');
		$return = $mycon->insertRecord("INSERT INTO `x_album` (`id`,`single_track`,`ex_id`,`publisherID`,`name`,`engName`,`description`,`serial`,`license`,`marketPrice`,`finalPrice`,`publishData`,`tags`,`genres`,`owners`,`composers`,`players`,`arrangers`,`poets`,`singers`,`publishYear`,`publishMonth`,`featured`,`created_at`,`updated_at`) VALUES (NULL,0,:ex_id,:publisherID,:name,:engName,:description,:serial,:license,:marketPrice,:finalPrice,:publisherData,:tags,:genres,:owners,:composers,:players,:arrangers,:poets,:singers,:publishYear,:publishMonth,:featured,:curretn_time,:updated_time)",array(
			'ex_id' 				=> $ex_id,
			'publisherID' 	=> $publisherID,
			'name' 					=> $name,
			'engName' 			=> $engName,
			'description' 	=> $description,
			'serial' 				=> $serial,
			'license' 			=> $license,
			'marketPrice' 	=> $marketPrice,
			'finalPrice' 		=> $finalPrice,
			'publisherData' => $publishData,
			'tags' 					=> $tags,
			'genres' 				=> $genres,
			'owners' 				=> $owners,
			'composers' 		=> $composers,
			'players' 			=> $players,
			'arrangers' 		=> $arrangers,
			'poets' 				=> $poets,
			'singers' 			=> $singers,
			'publishYear' 	=> $publishYear,
			'publishMonth'	=> $publishMonth,
			'featured' 			=> $featured,
			'curretn_time'	=> $curretn_time,
			'updated_time'	=>$curretn_time,
		));
		return $return;
	}


	public static function searchByExternalID($exID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album` WHERE `ex_id` =:externalID",array(
			'externalID' =>	$exID,
		));
		return $record;
	}


	public static function searchByID($exID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `name`,`crc`,`genres`,`owners` FROM `x_album` WHERE `ex_id` =:exID",array(
			'exID' =>	$exID,
		));
		return $record;
	}


	public static function insertInfoAlbumFinal($albumID,$crcAlbum,$primaryImagerHQ,$primaryImagerLQ,$galleryFile){
		$mycon = DB::getInstance();
		$record = $mycon->modifyRecord("UPDATE `x_album` SET `crc` = :crcAlbum, `primaryImagePathHQ` = :primaryImagerHQ,`primaryImagePathLQ` = :primaryImagerLQ ,`gallery` =:galleryFile WHERE `x_album`.`id` = :albumID",array(
			'crcAlbum' => $crcAlbum,
			'primaryImagerHQ' => $primaryImagerHQ,
			'primaryImagerLQ' => $primaryImagerLQ,
			'galleryFile' => $galleryFile,
			'albumID' => $albumID,
		));
		return $record;
	}


	public static function getInfo($id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album` WHERE `id` =:id",array(
			'id' =>	$id,
		));
		return $record;
	}


	public static function getAlbunInfoWithTrackInfo() {
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT `x_album`.`name` AS 'AlbumName',`x_album`.`owners` , `x_track`.`name` AS 'TrackName' ,`x_album`.`id` AS 'AlbumID' FROM `x_album` INNER JOIN `x_track` ON `x_track`.`album_id` = `x_album`.`ex_id` ",array(

		));
		return $record;
	}


	public static function getAlbumInfoByPublisherID($publisher_id){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `publisherID` =:publisher",array(
			'publisher' =>	$publisher_id,
		));
		return $record;
	}


	public static function serchStringInAlbum($string,$start,$to){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `x_album`.`name` LIKE :string OR `x_album`.`engName` LIKE :string OR `x_album`.`description` LIKE :string ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'string' => '%'. $string .'%',
			'start' 	=> $start,
			'to' 		=> $to,
		));
		return $record;
	}


	public static function serchStringInAlbumCount($string){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_album` WHERE `x_album`.`name` LIKE :string OR `x_album`.`engName` LIKE :string OR `x_album`.`description` LIKE :string",array(
			'string' => '%'. $string .'%',
		));
		return $record[0]['total'];
	}


	public static function getprimaryImageInfo($myid){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT primaryImagePathHQ,primaryImagePathLQ FROM `x_album` WHERE `id` =:myid",array(
			'myid' =>	$myid,
		));
		return $record;
	}


	public static function updateprimaryImageInfo($myid,$hqinfo,$lqinfo){
		$mycon = DB::getInstance();
		$record = $mycon->modifyRecord("UPDATE `x_album` SET `primaryImagePathHQ` = :primaryImagerHQ, `primaryImagePathLQ` = :primaryImagerLQ WHERE `id` = :myid",array(
			'myid' => $myid,
			'primaryImagerHQ' => $hqinfo,
			'primaryImagerLQ' => $lqinfo,
		));
		return $record;
	}


	public static function updateAlbumInfo($album_id,$album_name_submit,$album_name_eng_submit,$album_dec_submit,$album_publisher_submit){
		$mycon = DB::getInstance();
		$record = $mycon->modifyRecord("UPDATE `x_album` SET `name` = :album_name, `engName` = :album_engName ,`description` = :album_dec , `publisherID` = :publisher_id  WHERE `id` = :album_id",array(
			'album_id' => $album_id,
			'album_name' => $album_name_submit,
			'album_engName' => $album_name_eng_submit,
			'album_dec' => $album_dec_submit,
			'publisher_id' => $album_publisher_submit,
		));
		return $record;
	}


	public static function getAlbumCrc ($album_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album` WHERE `ex_id` =:albumID",array(
			'albumID' =>	$album_id,
		));
		return $record;
	}


	public static function getAlbumCrcByID ($id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `publisherID`,`crc` FROM `x_album` WHERE `id` =:myID",array(
			'myID' =>	$id,
		));
		return $record;
	}


	public static function searchAlbumWithCrc($crc){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album` WHERE `crc` =:mycrc",array(
			'mycrc' =>	$crc,
		));
		return $record;
	}


	public static function netItemAlbumQueue($album_ex_id,$album_name,$album_eng_name,$current_time){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_album_queue` (`id`,`ex_id`,`name`,`eng_name`,`status`,`created_at`,`updated_at`) VALUES (NULL,:exID,:albumName,:albumEngName,0,:createTime,:updateTime)",array(
			'exID' 					=> $album_ex_id,
			'albumName' 		=> $album_name,
			'albumEngName' 	=> $album_eng_name,
			'createTime' 		=> $current_time,
			'updateTime'	 	=> $current_time
		));
		return;
	}

	public static function netItemAlbumBreak($album_ex_id,$album_name,$album_eng_name,$current_time){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_album_broken` (`id`,`ex_id`,`name`,`eng_name`,`status`,`created_at`,`updated_at`) VALUES (NULL,:exID,:albumName,:albumEngName,0,:createTime,:updateTime)",array(
			'exID' 					=> $album_ex_id,
			'albumName' 		=> $album_name,
			'albumEngName' 	=> $album_eng_name,
			'createTime' 		=> $current_time,
			'updateTime'	 	=> $current_time
		));
		return;
	}


	public static function searchAlbumQueueByExternalID($exID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album_queue` WHERE `ex_id` =:externalID",array(
			'externalID' =>	$exID,
		));
		return $record;
	}

	public static function searchAlbumBrokenByExternalID($exID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_album_broken` WHERE `ex_id` =:externalID",array(
			'externalID' =>	$exID,
		));
		return $record;
	}


	public static function updateStatusAlbumQueueItem($album_exid){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_album_queue` SET `status` = '1' WHERE `x_album_queue`.`ex_id` = :exID",array(
			'exID' => $album_exid,
		));
		return;
	}


	public static function deleteAlbumQueueItem($album_exid){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_album_queue` WHERE `x_album_queue`.`ex_id` =:exID ",array(
			'exID' => $album_exid,
		));
		return;
	}

	public static function deleteAlbumBrokenItem($album_exid){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_album_broken` WHERE `x_album_broken`.`ex_id` =:exID ",array(
			'exID' => $album_exid,
		));
		return;
	}

	public static function editAlbumGenres($album_id,$new_genre,$updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_album` SET `genres` = :new_genre , `updated_at` = :updated_at WHERE `x_album`.`id` = :album_id",array(
			'album_id' 	=> $album_id,
			'new_genre' => $new_genre,
			'updated_at' => $updated_at
		));
		return;
	}

	public static function editAlbumTags($album_id, $new_tag,$updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_album` SET `tags` = :new_tag  , `updated_at` = :updated_at WHERE `x_album`.`id` = :album_id",array(
			'album_id' 	=> $album_id,
			'new_tag' => $new_tag,
			'updated_at' => $updated_at
		));
		return;
	}

	public static function editAlbumOwners($album_id, $new_owners, $updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_album` SET `owners` = :new_owners  , `updated_at` = :updated_at WHERE `x_album`.`id` = :album_id",array(
			'album_id' 	=> $album_id,
			'new_owners' => $new_owners,
			'updated_at' => $updated_at
		));
		return;
	}

	public static function getLastAlbumQueue(){
		$mycon  = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album_queue` WHERE `status` !=1 ORDER BY `created_at` DESC LIMIT 0,5",array());
		return $result;
	}

	public static function getLastAlbumSubscribedArtis($owner_id){
		$mycon  = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album`  WHERE `owners` IN (:ownerd_id) OR `composers` IN (:ownerd_id) OR `arrangers` IN (:ownerd_id) OR `poets` IN (:ownerd_id)  ORDER BY `id` DESC LIMIT 0,5",array(
			'ownerd_id' => $owner_id,
		));
		return $result;
	}

	public static function deleteAlbum($album_id){
		$mycon = DB::getInstance();
		$status = $mycon->modifyRecord("DELETE FROM `x_album` WHERE `x_album`.`id` = :albumid",array(
			'albumid' => $album_id,
		));
		return $status;
	}
	public static function deleteAlbums($album_id){
		$mycon = DB::getInstance();
		$status = $mycon->modifyRecord("DELETE FROM `x_album` WHERE id IN ($album_id) ",array());
		return $status;
	}
}