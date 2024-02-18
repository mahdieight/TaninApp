<?php
class GenreModel{
	public static function get_genre($genreID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_genre` WHERE `ex_id` = :genreID",array(
			'genreID' => $genreID,
		));
		return $result;
	}

	public static function get_genre_info($genreID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `id`,`value` FROM `x_genre` WHERE `id` = :genreID",array(
			'genreID' => $genreID,
		));
		return $result;
	}

	public static function get_genre_name($genreID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `value` FROM `x_genre` WHERE `id` = :genreID",array(
			'genreID' => $genreID,
		));
		return $result['value'];
	}
	public static function insert_genre_info($genreID,$genreValue){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_genre` (`id`,`ex_id`,`value`,`created_at`,`updated_at`) VALUES (NULL,:genreID,:genreValue,:current_time,:current_time)",array(
			'genreID' 					 => $genreID,
			'genreValue'				 => $genreValue,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}

	public static function getGenreLimit($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_genre` ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}

	public static function getGenreInUseAlbum($genre_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  * FROM `x_album`  WHERE  `genres` IN (':genre_id') OR  `genres` LIKE ':genre_id,%' OR  `genres` LIKE '%,:genre_id,%' OR  `genres` LIKE '%,:genre_id' ",array(
			'genre_id' => $genre_id,
		));
		return $records;
	}

	public static function getGenreCountInUseAlbun($genre_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  COUNT(*) as total FROM `x_album`  WHERE  `genres` IN (':genre_id') OR  `genres` LIKE ':genre_id,%' OR  `genres` LIKE '%,:genre_id,%' OR  `genres` LIKE '%,:genre_id' ",array(
			'genre_id' => $genre_id,
		));
		return $records[0]['total'];
	}


	public static function getGenreCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_genre`",array());
		return $records[0]['total'];
	}





	public static function changeGenreName($genre_id,$new_genre_name,$updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_genre` SET `value` = :new_genre_name , `updated_at` = :updated_at WHERE `x_genre`.`id` = :genre_id",array(
			'new_genre_name' =>$new_genre_name,
			'genre_id' =>$genre_id,
			'updated_at' =>$updated_at,
		));
	}


	public static function deleteGenre($genre_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_genre` WHERE `x_genre`.`id` = :genre_id",array(
			'genre_id' =>$genre_id,
		));
	}
}