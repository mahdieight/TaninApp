<?php
class PoetModel{
	public static function get_poet($poetID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :poetID",array(
			'poetID' => $poetID,
		));
		return $result;
	}

	public static function insert_poet_info($poetID, $poetFirstName, $poetLastName, $poetArtisticName, $poetImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:poetID,:poetFirstName,:poetLastName,:poetArtisticName,:poetImage,:current_time,:current_time)",array(
			'poetID' 					 => $poetID,
			'poetFirstName' 		 => $poetFirstName,
			'poetLastName'		   => $poetLastName,
			'poetArtisticName'  => $poetArtisticName,
			'poetImage' 				 => $poetImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}

	public static function getCountPoetINAlbumWithOwnerID($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total  FROM `x_album` WHERE poets IN (:ownerd_id)  ",array(
			'ownerd_id' =>$owner_id,
		));
		return $records[0]['total'];
	}
}