<?php
class TrackModel{
	public static function insertTrackInfo($trackD,$crc,$albumID,$fileInfor,$trackPrice){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_track` (`id`,`ex_id`,`crc`,`album_id`,`fileInfo`,`price`) VALUES (NULL,:trackD,:crc,:albumID,:fileInfor,:trackPrice)",array(
			'trackD' =>$trackD,
			'crc' =>$crc,
			'albumID' =>$albumID,
			'fileInfor' =>$fileInfor,
			'trackPrice' =>$trackPrice,
		));
		return;
	}


	public static function getTrackLimit($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_track` ORDER BY `id` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getTrackLimitWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `name` LIKE '%$value%' ORDER BY `id` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getTrackByAlbumID($albumID){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `album_id`=:albumid",array(
			'albumid' => $albumID,
		));
		return $record;
	}

	public static function getAlbum($myalbumid){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `ex_id` FROM `x_album` WHERE `id`=:myalbumid",array(
			'myalbumid' => $myalbumid,
		));
		return $record;
	}

	public static function insertAlbumInfoComplated($track_external_id,$track_crc,$album_id,$track_name,$track_name_eng,$track_des,$file_info,$track_price,$track_duration,$hq_link,$lq_link,$llq_link){


		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_track` (`id`,`ex_id`,`crc`,`album_id`,`name`,`engName`,`lyrics`,`fileinfo`,`price`,`trackDuration`,`hqLink`,`lqLink`,`lqLink64`,`status`) VALUES (NULL,:track_external_id,:track_crc,:album_id,:track_name,:track_eng_name,:track_des,:file_info,:track_price,:track_duration,:hq_link,:lq_link,:llq_link,0)",array(
			'track_external_id'=>$track_external_id,
			'track_crc' =>$track_crc,
			'album_id' =>$album_id,
			'track_name' =>$track_name,
			'track_eng_name' =>$track_name_eng,
			'track_des' =>$track_des,
			'file_info' =>$file_info,
			'track_price' =>$track_price,
			'track_duration' =>$track_duration,
			'hq_link' =>$hq_link,
			'lq_link' =>$lq_link,
			'llq_link' => $llq_link,
		));
		return;
	}

	public static function insertTrackPreInfo($trackID,$trackAlbumID,$trackName,$trackEngName,$trackDuration){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_track` (`id`,`ex_id`,`album_id`,`name`,`engName`,`trackDuration`,`status`) VALUES (NULL,:trackID,:trackAlbumID,:trackName,:trackEngName,:trackDuration,0)",array(
			'trackID'=> $trackID,
			'trackAlbumID'=> $trackAlbumID,
			'trackName'=> $trackName,
			'trackEngName'=> $trackEngName,
			'trackDuration' =>$trackDuration,
		));
		return;
	}




	public static  function insertTrackPreInfoTwo($track_external_id,$track_description,$track_price){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `lyrics` = :track_description , `price` = :track_price WHERE `x_track`.`ex_id` = :track_external_id",array(
			'track_external_id' => $track_external_id,
			'track_description' => $track_description,
			'track_price' => $track_price,
		));
		return;
	}

	public static  function updateDownloadLinkTrack($track_external_id,$fileInfor,$hqlink,$lqlink,$llqlink){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `fileInfo`=:fileInfor, `hqLink` = :hqlink,`lqLink` = :lqlink,`lqLink64` = :llqlink WHERE `x_track`.`ex_id` = :track_external_id",array(
			'track_external_id' => $track_external_id,
			'hqlink' => $hqlink,
			'fileInfor' => $fileInfor,
			'lqlink' => $lqlink,
			'llqlink' => $llqlink,
		));
		return;
	}

	public static  function insertTrackFinal($crctrack,$fileinfor,$tprice,$trackid,$linkhqfile,$lqlinkfile){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `crc` = :crctrack, `fileinfo` = :fileinfor,`price` =:tprice ,`hqLink` = :linkhqfile , `lqLink`=:lqlinkfile ,`status` ='0' WHERE `x_track`.`ex_id` = :trackid",array(
			'crctrack' => $crctrack,
			'fileinfor' => $fileinfor,
			'tprice' => $tprice,
			'trackid' => $trackid,
			'linkhqfile' => $linkhqfile,
			'lqlinkfile' => $lqlinkfile,
		));
		return;
	}

	public static  function getTrackInfoByEXID($exID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_track` WHERE `ex_id`=:exID",array(
			'exID' => $exID,
		));
		return $record;
	}

	public static  function getTrackInfoByAlbumID($albumID){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_track` WHERE `album_id`=:albumID",array(
			'albumID' => $albumID,
		));
		return $record;
	}

	public static function get_track_info($track_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_track` WHERE `id`=:myid",array(
			'myid' => $track_id,
		));
		return $record;
	}

	public static function get_track_info_with_album_info($track_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("
		SELECT 
		`x_track`.`id` AS 'track_id',
		`x_track`.`album_id` AS 'track_album_id',
		`x_track`.`price` AS 'track_price',
		`x_track`.`name` AS 'track_name',
		`x_track`.`engName` AS 'track_eng_name',
		`x_track`.`trackDuration` AS 'track_duration',
		`x_track`.`lyrics` AS 'track_description',
		`x_track`.`fileInfo`,
		`x_track`.`status`,
		
		`x_album`.`id` AS 'album_id',
		`x_album`.`publisherID`,
		`x_album`.`name` AS 'album_name',
		`x_album`.`engName` AS 'album_eng_name',
		`x_album`.`primaryImagePathHQ`,
		`x_album`.`owners`,
		`x_album`.`finalPrice`,
		`x_album`.`genres`
		
 		FROM `x_track`  INNER JOIN `x_album` ON `x_track`.`album_id` = `x_album`.`ex_id` WHERE `x_track`.`id`=:myid
		",array(
			'myid' => $track_id,
		));
		return $record;
	}

	public static function get_full_track_info_with_album_id($albumID){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("
		SELECT 
		`x_track` .`id` AS 'track_id',
		`x_track` .`crc` AS 'track_crc',
		`x_track` .`name` AS 'track_name',
		`x_track` .`engName` AS 'track_engName',
		`x_track` .`lyrics` AS 'track_des',
		`x_track` .`fileInfo` AS 'track_fileInfo',
		`x_track` .`price` AS 'track_price',
		`x_track` .`trackDuration` as 'track_duration',
		
		`x_album`.`id` AS 'album_id',
		`x_album`.`crc` AS 'album_crc',
		`x_album`.`name` AS 'album_name',
		`x_album`.`engName` AS 'album_engName' ,
		`x_album`.`description` AS 'album_des',
		`x_album`.`publisherID` AS 'publisher_id',
		`x_album`.`finalPrice` AS 'album_price' ,
		`x_album`.`publishData` AS 'album_publish_data',
		`x_album`.`primaryImagePathHQ` AS 'album_image',
		`x_album`.`tags` AS 'album_tags',
		`x_album`.`genres` AS 'album_genres' ,
		`x_album`.`owners` AS 'album_owners',
		`x_album`.`composers` AS 'album_composers',
		`x_album`.`players` AS 'album_players',
		`x_album`.`arrangers` AS 'album_arrangers',
		`x_album`.`poets` AS 'album_poets',
		`x_album`.`singers` AS 'album_singers',
		`x_album`.`publishYear` AS 'album_publish_year',
		`x_album`.`publishMonth` AS 'album_publish_month'
		FROM `x_track` INNER JOIN `x_album` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_track`.`album_id` = :myalbum_id AND `x_track`.`status` =1
		",array(
			'myalbum_id' => $albumID,
		));
		return $record;
	}


	public static function get_track_exits_info($track_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_track` WHERE `id`=:myid AND `crc` !='' ",array(
			'myid' => $track_id,
		));
		return $record;
	}

	public static function get_crc_album($albumid){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `crc` FROM `x_album` WHERE `ex_id`=:albumid",array(
			'albumid' => $albumid,
		));
		return $record['crc'];
	}

	public static function getTotalTrackAlbum($albumid){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT * FROM `x_track` WHERE `album_id`=:albumid",array(
			'albumid' =>$albumid,
		));
		return $result;
	}

	public static function getTotalTrackAlbumDownloaded($albumid){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT * FROM `x_track` WHERE `album_id`=:albumid AND `status`= 1",array(
			'albumid' =>$albumid,
		));
		return $result;
	}

	public static function getTotalTrackAlbumWithID($albumid){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT * FROM `x_track` WHERE `album_id`=:albumid",array(
			'albumid' =>$albumid,
		));
		return $result;
	}

	public static  function clearTrackCrc($id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `crc` =NULL,`status` =NULL WHERE `x_track`.`id` = :id",array(
			'id' => $id,
		));
		return;
	}

	public static  function setTrackStatus($id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `status` ='1' WHERE `x_track`.`id` = :id",array(
			'id' => $id,
		));
		return;
	}
	public static  function setTrackStatusfail($id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `status` ='0' WHERE `x_track`.`id` = :id",array(
			'id' => $id,
		));
		return;
	}

	public static function getTracksWithCrc($album_id){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT Count(*) AS total FROM `x_track` WHERE `album_id`=:albumid AND `crc` IS NOT NULL",array(
			'albumid' =>$album_id,
		));
		return $result[0]['total'];
	}

	public static  function updateFinalTrack($id,$new_crc){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `crc` = :newcrc , `status` ='1' WHERE `x_track`.`id` = :id",array(
			'newcrc' => $new_crc,
			'id' => $id,
		));
		return;
	}

	public static  function updateStatusTrackWithTrackCrc($track_crc){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `status` ='1' WHERE `x_track`.`crc` = :track_crc",array(
			'track_crc' => $track_crc,
		));
		return;
	}



	public static function getTracksWithoutCrc($album_id){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT Count(*) AS total FROM `x_track` WHERE `album_id`=:albumid AND `crc` IS NULL",array(
			'albumid' =>$album_id,
		));
		return $result[0]['total'];
	}

	public static function get_count_album_track_by_id($album_id){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT Count(*) AS total FROM `x_track` WHERE `album_id`=:album_id",array(
			'album_id' =>$album_id,
		));
		return $result[0]['total'];
	}

	public static function get_count_album_track_full_by_id($album_id){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT Count(*) AS total FROM `x_track` WHERE `album_id`=:album_id AND hqLink !='' ",array(
			'album_id' =>$album_id,
		));
		return $result[0]['total'];
	}


	public static function getAlbumid($ex_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `id` FROM `x_album` WHERE `ex_id`=:myalbumid",array(
			'myalbumid' => $ex_id,
		));
		return $record['id'];
	}



	public static function get_album_by_publisher_id($publisher_id){
		$mycom = DB::getInstance();
		$result = $mycom->getAllRecords("SELECT * FROM `x_album` WHERE `publisherID`=:publisher",array(
			'publisher' =>$publisher_id,
		));
		return $result;
	}

	public static function getTracksCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_track`",array());
		return $records[0]['total'];
	}
	public static function getTracksCountWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_track` WHERE `name` LIKE '%$value%'",array());
		return $records[0]['total'];
	}

	public static function getDownloadTracksCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_track` WHERE `status` = 1",array());
		return $records[0]['total'];
	}

	public static function getTracksHqLinkEmpty(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_track` WHERE hqLink='' ",array());
		return $records;
	}

	public static function gethqLinkTrack($track_id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT `hqLink`,`ex_id` FROM `x_track` WHERE `id`=:track_id",array(
			'track_id' => $track_id,
		));
		return $record;
	}

	public static function updateFileInfo($track_id,$file_info){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_track` SET `fileInfo` = :newInfo WHERE `x_track`.`id` = :track_id",array(
			'track_id' => $track_id,
			'newInfo' => $file_info
		));
		return;
	}

	public static function serchStringInTrack($string,$start,$to){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT 
 		`x_track`.`id` AS 'track_id',
		`x_track`.`price` AS 'track_price',
		`x_track`.`name` AS 'track_name',
		`x_track`.`engName` AS 'track_eng_name',
		`x_track`.`trackDuration` AS 'track_duration',
		`x_track`.`lyrics` AS 'track_description',
		`x_album`.`id` AS 'album_id',
		`x_album`.`publisherID`,
		`x_album`.`name` AS 'album_name',
		`x_album`.`engName` AS 'album_eng_name',
		`x_album`.`primaryImagePathHQ`,
		`x_album`.`owners`,
		`x_album`.`finalPrice`,
		`x_album`.`genres`
		
		FROM `x_track` INNER JOIN `x_album` ON `x_track`.`album_id` = `x_album`.`ex_id` WHERE `x_track`.`name` LIKE :string OR `x_track`.`engName` LIKE :string OR `x_track`.`lyrics` LIKE :string ORDER BY `x_track`.`id` DESC  LIMIT :start,:to",array(
			'string' => '%'. $string .'%',
			'start'  => $start,
			'to'  => $to,
		));
		return $record;
	}

	public static function serchStringInTrackCount($string){
		$mycon = DB::getInstance();
		$record = $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_track` WHERE `x_track`.`name` LIKE :string OR `x_track`.`engName` LIKE :string OR `x_track`.`lyrics` LIKE :string",array(
			'string' => '%'. $string .'%',
		));
		return $record[0]['total'];
	}

	public static function getfileInfoTrack($id){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT crc,album_id,fileInfo FROM `x_track` WHERE `id` =:myid",array(
			'myid' =>	$id,
		));
		return $record;
	}

	public static function updateTrackFileInfo($myid,$fileInfor){
		$mycon = DB::getInstance();
		$record = $mycon->modifyRecord("UPDATE `x_track` SET `fileInfo` = :fileInfor WHERE `id` = :trackID",array(
			'trackID' => $myid,
			'fileInfor' => $fileInfor,
		));
		return $record;
	}

	public static function searchWithCrc($crc){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("SELECT * FROM `x_track` WHERE `crc` =:mycrc",array(
			'mycrc' =>	$crc,
		));
		return $record;
	}

	public static function InnerJoinWithCrc($crc){
		$mycon = DB::getInstance();
		$record = $mycon->getRocord("
		SELECT 
`x_track`.`name` AS 'track_name',
`x_track`.`crc`,

`x_album`.`name` AS `album_name`,
`x_album`.`owners`,
`x_album`.`publisherID`,
`x_album`.`publishMonth`,
`x_album`.`publishYear`
FROM `x_track` INNER JOIN `x_album` ON `x_track`.`album_id` = `x_album`.`ex_id` WHERE `x_track`.`crc` = :mycrc
		",array(
			'mycrc' =>	$crc,
		));
		return $record;
	}


	public static function deleteTrackItem($track_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_track` WHERE `id`=:track_id ",array(
			'track_id' => $track_id,
		));
		return;
	}

	public static function deleteAllTracksAlbum($album_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_track` WHERE `album_id`=:albumID ",array(
			'albumID' => $album_id,
		));
		return;
	}
}