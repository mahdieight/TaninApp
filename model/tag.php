<?php
class TagModel{
	public static function get_tag($tagID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_tag` WHERE `ex_id` = :tagID",array(
			'tagID' => $tagID,
		));
		return $result;
	}


	public static function get_tag_info($tagID){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `id`,`value` FROM `x_tag` WHERE `id` = :tagID",array(
			'tagID' => $tagID,
		));
		return $result;
	}


	public static function get_tag_name($tagid){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `value` FROM `x_tag` WHERE `id` = :tagid",array(
			'tagid' => $tagid,
		));
		return $result['value'];
	}


	public static function insert_tag_info($tagID,$tagValue){
		$mycon = DB::getInstance();
		$current_time = get_current_time();
		return $mycon->insertRecord("INSERT INTO `x_tag` (`id`,`ex_id`,`value`,`created_at`,`updated_at`) VALUES (NULL,:tagID,:tagValue,:current_time,:current_time)",array(
			'tagID' 					 => $tagID,
			'tagValue'				 => $tagValue,
			'current_time' 			 => $current_time,
			'current_time' 			 => $current_time,
		));
	}


	public static function getAllTag(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_tag` ORDER BY `created_at` DESC",array());
		return $records;
	}

	public static function getTagLimit($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_tag` ORDER BY `created_at` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}


	public static function getTagCountInUseAlbun($tag_id){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  COUNT(*) as total FROM `x_album`  WHERE  `tags` IN (':tag_id') OR  `tags` LIKE ':tag_id,%' OR  `tags` LIKE '%,:tag_id,%' OR  `tags` LIKE '%,:tag_id' ",array(
			'tag_id' => $tag_id,
		));
		return $records[0]['total'];
	}


	public static function getTagInUseAlbum($tag_id){

		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT  * FROM `x_album`  WHERE  `tags` IN (':tag_id') OR  `tags` LIKE ':tag_id,%' OR  `tags` LIKE '%,:tag_id,%' OR  `tags` LIKE '%,:tag_id' ",array(
			'tag_id' => $tag_id,
		));
		return $records;
	}


	public static function getTagCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_tag`",array());
		return $records[0]['total'];
	}


	public static function changeTagName($tag_id, $new_tag_name,$updated_at){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_tag` SET `value` = :new_tag_name , `updated_at` = :updated_at WHERE `x_tag`.`id` = :tag_id",array(
			'new_tag_name' =>$new_tag_name,
			'tag_id' =>$tag_id,
			'updated_at' =>$updated_at,
		));
	}


	public static function editAlbumGenres($album_id,$new_genre){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_album` SET `genres` = :new_genre WHERE `x_album`.`id` = :album_id",array(
			'album_id' 	=> $album_id,
			'new_genre' => $new_genre,
		));
		return;
	}

	public static function deleteTag($tag_id){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("DELETE FROM `x_tag` WHERE `x_tag`.`id` = :tag_id",array(
			'tag_id' =>$tag_id,
		));
	}
}