<?php
class PlayerModel{
	public static function get_player($playerID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_artist` WHERE `ex_id` = :playerID",array(
			'playerID' => $playerID,
		));
		return $result;
	}

	public static function insert_player_info($playerID, $playerFirstName, $playerLastName, $playerArtisticName, $playerImage){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_artist` (`id`,`ex_id`,`firstName`,`lastName`,`artisticName`,`artistImage`,`created_at`,`updated_at`) VALUES (NULL,:playerID,:playerFirstName,:playerLastName,:playerArtisticName,:playerImage,:current_time,:current_time)",array(
			'playerID' 					 => $playerID,
			'playerFirstName' 	 => $playerFirstName,
			'playerLastName'		 => $playerLastName,
			'playerArtisticName' => $playerArtisticName,
			'playerImage' 			 => $playerImage,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}
}