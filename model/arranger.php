<?php
class ArrangerModel{
	public static function get_arranger($arrangersID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :arrangersID",array(
			'arrangersID' => $arrangersID,
		));
		return $result;
	}

	public static function insert_arranger_info($arrangersID, $arrangersFirstName, $arrangersLastName, $arrangersArtisticName, $arrangersImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:arrangersID,:arrangersFirstName,:arrangersLastName,:arrangersArtisticName,:arrangersImage,:current_time,:current_time)",array(
			'arrangersID' 					 => $arrangersID,
			'arrangersFirstName' 		 => $arrangersFirstName,
			'arrangersLastName'		   => $arrangersLastName,
			'arrangersArtisticName'  => $arrangersArtisticName,
			'arrangersImage' 				 => $arrangersImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}

	public static function getCountArrangersINAlbumWithOwnerID($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total  FROM `x_album` WHERE arrangers IN (:ownerd_id)  ",array(
			'ownerd_id' =>$owner_id,
		));
		return $records[0]['total'];
	}
}