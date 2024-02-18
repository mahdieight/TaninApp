<?php
class ComposerModel{
	public static function get_composer($composersID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :composersID",array(
			'composersID' => $composersID,
		));
		return $result;
	}

	public static function insert_composer_info($composerID, $composerFirstName, $composerLastName, $composerArtisticName, $composerImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:composerID,:composerFirstName,:composerLastName,:composerArtisticName,:composerImage,:current_time,:current_time)",array(
			'composerID' 					 => $composerID,
			'composerFirstName' 		 => $composerFirstName,
			'composerLastName'		   => $composerLastName,
			'composerArtisticName'  => $composerArtisticName,
			'composerImage' 				 => $composerImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}

	public static function getCountComposersINAlbumWithOwnerID($owner_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total  FROM `x_album` WHERE composers IN (:ownerd_id) ",array(
			'ownerd_id' =>$owner_id,
		));
		return $records[0]['total'];
	}
}