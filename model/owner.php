<?php
class OwnerModel{
	public static function getAllOwners(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_artist`",array(
		));
		return $result;
	}


	public static function get_owners($ownerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :ownerID",array(
			'ownerID' => $ownerID,
		));
		return $result;
	}
	public static function get_owner_info($ownerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `id`,`firstName`,`lastName`,`artisticName` FROM `x_artist` WHERE `id` = :ownerID",array(
			'ownerID' => $ownerID,
		));
		return $result;
	}

	public static function get_oweners_name_with_id(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT id,artisticName FROM `x_artist`",array(
		));
		return $result;
	}


	public static function get_ownerByID($ownerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `id` = :ownerID",array(
			'ownerID' => $ownerID,
		));
		return $result;
	}

	public static function get_owner_name ($ownerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `artisticName` FROM `x_artist` WHERE `id` = :ownerID",array(
			'ownerID' => $ownerID,
		));
		return $result['artisticName'];
	}

	public static function insert_owner_info($ownerID,$ownerFirstName,$ownerLastName,$ownerArtisticName,$ownerImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:ownerID,:ownerFirstName,:ownerLastName,:ownerArtisticName,:ownerImage,:current_time,:current_time)",array(
			'ownerID' 					 => $ownerID,
			'ownerFirstName' 		 => $ownerFirstName,
			'ownerLastName'		   => $ownerLastName,
			'ownerArtisticName'  => $ownerArtisticName,
			'ownerImage' 				 => $ownerImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));

	}

	public static function getOwnerLimit($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_artist` ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getOwnerLimitWithSearch($value,$start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_artist` WHERE `artisticName` LIKE '%$value%' ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getOwnerCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_artist`",array());
		return $records[0]['total'];
	}

	public static function getOwnerCountWithSearch($value){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_artist` WHERE `artisticName` LIKE '%$value%'",array());
		return $records[0]['total'];
	}

	public static function getOwnerSelections(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_artist_selections` WHERE `status` !=1",array());
		return $records;
	}

	public static function setSuccessStatus($track_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_artist_selections` SET `status` = '1' WHERE `x_artist_selections`.`id` = :myID",array(
			"myID" => $track_id,
		));
		return;
	}

	public static function getCountOwnerINAlbumWithOwnerID($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total  FROM `x_album` WHERE `owners` IN (:ownerd_id) ",array(
			'ownerd_id' =>$owner_id,
		));
		return $records[0]['total'];
	}

	public static function getOwnerInUseAlbum($owner_id){

		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  * FROM `x_album`  WHERE  `owners` IN (':owner_id') OR  `owners` LIKE ':owner_id,%' OR  `owners` LIKE '%,:owner_id,%' OR  `owners` LIKE '%,:owner_id' ",array(
			'owner_id' => $owner_id,
		));
		return $records;
	}

	public static function getOwnerCountInUseAlbun($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  COUNT(*) as total FROM `x_album`  WHERE  `owners` IN (':owner_id') OR  `owners` LIKE ':owner_id,%' OR  `owners` LIKE '%,:owner_id,%' OR  `owners` LIKE '%,:owner_id' ",array(
			'owner_id' => $owner_id,
		));
		return $records[0]['total'];
	}

	public static function editOwnerPersonalInfo($owner_id,$owner_f_name,$owner_l_name,$owner_a_name,$updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_artist` SET `firstName` = :f_name , `lastName` = :l_name , `artisticName` = :a_name, `updated_at` = :updated_at WHERE `id` = :owner_id",array(
			"owner_id" => $owner_id,
			"f_name" => $owner_f_name,
			"l_name" => $owner_l_name,
			"a_name" => $owner_a_name,
			"updated_at" => $updated_at,
		));
		return;
	}


	public static function deleteOwner($owner_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_artist` WHERE `x_artist`.`id` = :owner_id",array(
			'owner_id' =>$owner_id,
		));
		return;
	}
}