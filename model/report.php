<?php
class ReportModel{
	public static function getLastReport(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_report_history` WHERE `status` = 1  ORDER BY `created_at` DESC LIMIT 0 ,5",array());
		return $result;
	}


	#------------------------------------------------------------------------------------  Track Start
	public static function getAllTracks(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_track`",array());
		return $result;
	}


	public static function getAllTracksWithDate($start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function getAllTracksOnlyDownload(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `status` =1",array());
		return $result;
	}

	public static function getAllTracksOnlyDownloadWithDate($start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `status` =1 AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}


	public static function getAllTracksOnlyDownloaded(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_track` WHERE `status` =1",array());
		return $result;
	}


	public static function getSpecifiedTracks($fields){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_track`",array(
		));
		return $result;
	}


	public static function getSpecifiedTracksOnlyDownloaded($fields){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_track` WHERE `status` =1",array());
		return $result;
	}

	#------------------------------------------------------------------------------------  Track End


	#------------------------------------------------------------------------------------Album Start

	public static function getAllAlbums(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album`",array());
		return $result;
	}

	public static function getAllAlbumsWithDate($startdate,$enddate){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE `created_at` BETWEEN :startDate AND :endDate",array(
			'startDate' => $startdate,
			'endDate' => $enddate,
		));
		return $result;
	}


	public static function getSpecifiedAlbums($fields){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album`",array());
		return $result;
	}


	public static function getSpecifiedAlbumsWithDate($fields,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}


	public static function getSpecifiedAlbumsFilterByPublisher($fields,$publisher){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher ",array());
		return $result;
	}

	public static function getSpecifiedAlbumsFilterByPublisherWithDate($fields,$publisher,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher AND `created_at` BETWEEN  :startDate AND :endDate ",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function getSpecifiedAlbumsFilterByOwner($fields,$owner){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE owners IN $owner ",array());
		return $result;
	}


	public static function getSpecifiedAlbumsFilterByOwnerWithDate($fields,$owner,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE owners IN $owner AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function getComplateAlbumFilterByPublisher($fields,$publisher){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher ",array(
		));
		return $result;
	}

	public static function getComplateAlbumFilterByPublisherWithDate($fields,$publisher,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate'=>$end_date
		));
		return $result;
	}


	public static function getSpecifiedAlbumsFilterByPublisherAndOwner($fields,$publisher,$owner){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher AND owners IN $owner ",array(
		));
		return $result;
	}

	public static function getSpecifiedAlbumsFilterByPublisherAndOwnerWithDate($fields,$publisher,$owner,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` WHERE publisherID IN $publisher AND owners IN $owner AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function getComplateAlbumFilterByOwner($owner){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE owners IN $owner ",array(
		));
		return $result;
	}

	public static function getComplateAlbumFilterByOwnerWithDate($owner,$startdate,$enddate){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE owners IN $owner AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $startdate,
			'endDate' => $enddate,
		));
		return $result;
	}

	public static function getComplateAlbumFilterByPublisherAndOwner($publisher,$owner){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE publisherID IN $publisher AND owners IN $owner ",array(
		));
		return $result;
	}


	public static function getComplateAlbumFilterByPublisherAndOwnerWithDate($publisher,$owner,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_album` WHERE publisherID IN $publisher AND owners IN $owner AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	#------------------------------------------------------------------------------------  Album End

	#------------------------------------------------------------------------------------  InnerJoin
	public static function innerJoinComplateWithoutFilter($fields){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` ",array());
		return $result;
	}


	public static function innerJoinComplateWithoutFilterWithDate($fields,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function innerJoinComplateWithoutFilterOnlyDownload($fields){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `status` =1",array());
		return $result;
	}


	public static function innerJoinComplateWithoutFilterOnlyDownloadWithDate($fields,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `status` =1 AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function innerJoinComplateWithFilterByPublisher($fields,$publisherFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter ",array());
		return $result;
	}

	public static function innerJoinComplateWithFilterByPublisherWithDate($fields,$publisherFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}



	public static function innerJoinComplateWithFilterByPublisherOnlyDownload($fields,$publisherFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `status` =1",array());
		return $result;
	}


	public static function innerJoinComplateWithFilterByPublisherOnlyDownloadWithDate($fields,$publisherFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `status` =1 AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}

	public static function innerJoinComplateWithFilterByOwner($fields,$ownerFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`owners` IN $ownerFilter ",array());
		return $result;
	}

	public static function innerJoinComplateWithFilterByOwnerWithDate($fields,$ownerFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`owners` IN $ownerFilter AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}


	public static function innerJoinComplateWithFilterByOwnerOnlyDownload($fields,$ownerFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`owners` IN $ownerFilter AND `status` =1",array());
		return $result;
	}

	public static function innerJoinComplateWithFilterByOwnerOnlyDownloadWithDate($fields,$ownerFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`owners` IN $ownerFilter AND `status` =1 AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}


	public static function innerJoinComplateWithFilterByPublisherAndOwner($fields,$publisherFilter,$ownerFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `x_album`.`owners` IN $ownerFilter ",array());
		return $result;
	}


	public static function innerJoinComplateWithFilterByPublisherAndOwnerWithDate($fields,$publisherFilter,$ownerFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `x_album`.`owners` IN $ownerFilter AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}


	public static function innerJoinComplateWithFilterByPublisherAndOwnerOnlydownload($fields,$publisherFilter,$ownerFilter){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `x_album`.`owners` IN $ownerFilter  AND `status` =1",array());
		return $result;
	}

	public static function innerJoinComplateWithFilterByPublisherAndOwnerOnlydownloadWithDate($fields,$publisherFilter,$ownerFilter,$start_date,$end_date){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT $fields FROM `x_album` INNER JOIN `x_track` ON `x_album`.`ex_id` = `x_track`.`album_id` WHERE `x_album`.`publisherID` IN $publisherFilter AND `x_album`.`owners` IN $ownerFilter  AND `status` =1 AND `created_at` BETWEEN  :startDate AND :endDate",array(
			'startDate' => $start_date,
			'endDate' => $end_date,
		));
		return $result;
	}
	#------------------------------------------------------------------------------------  InnerJoin

	#------------------------------------------------------------------------------------  SET HISTORY
	public static function setHistoryTrackSuccessHistory($fileinfo){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,:fileEX,'TRACK',1,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'fileEX' =>$fileinfo,
			'currentTime' =>$time,
		));
		return;
	}

	public static function setHistoryTrackFailedHistory(){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,NULL,'ALBUM',0,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'currentTime' =>$time,
		));
		return;
	}

	public static function setHistoryAlbumSuccessHistory($fileinfo){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,:fileEX,'ALBUM',1,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'fileEX' =>$fileinfo,
			'currentTime' =>$time,
		));
		return;
	}

	public static function setHistoryAlbumFailedHistory(){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,NULL,'ALBUM',0,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'currentTime' =>$time,
		));
		return;
	}

	public static function setHistoryAlbumTrackSuccessHistory($fileinfo){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,:fileEX,'ALBUMTRACK',1,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'fileEX' =>$fileinfo,
			'currentTime' =>$time,
		));
		return;
	}

	public static function setHistoryAlbumTrackFailedHistory(){
		$time = get_current_time();
		$user_id = $_SESSION['user_id'];

		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_report_history` (`id`,`user_id`,`fileName`,`type`,`status`,`created_at`,`updated_at`) VALUES (NULL,:userID,NULL,'ALBUM',0,:currentTime,:currentTime)",array(
			'userID' =>	$user_id,
			'currentTime' =>$time,
		));
		return;
	}

	#------------------------------------------------------------------------------------  SET HISTORY



}