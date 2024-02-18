<?php
class SingerModel{
	public static function get_singer($singerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :singerID",array(
			'singerID' => $singerID,
		));
		return $result;
	}

	public static function insert_singer_info($singerID, $singerFirstName, $singerLastName, $singerArtisticName, $singerImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:singerID,:singerFirstName,:singerLastName,:singerArtisticName,:singerImage,:current_time,:current_time)",array(
			'singerID' 					 => $singerID,
			'singerFirstName' 		 => $singerFirstName,
			'singerLastName'		   => $singerLastName,
			'singerArtisticName'  => $singerArtisticName,
			'singerImage' 				 => $singerImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}
}