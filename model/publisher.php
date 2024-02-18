<?php
class PublisherModel{

	public static function getAllPublisher(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_publisher`",array());
		return $result;
	}

	public static function get_publisher_info($id){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_publisher` WHERE `ex_id` = :id",array(
			'id' => $id,
		));
		return $result;
	}


	public static function get_publisher_info_by_id($id){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_publisher` WHERE `id` = :id",array(
			'id' => $id,
		));
		return $result;
	}
	public static function get_publisher_limit_info($id){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT `id`,`name`,`displayName`,`description`,`picture` FROM `x_publisher` WHERE `id` = :id",array(
			'id' => $id,
		));
		return $result;
	}

	public static function insert_publisher_info($publisherID, $publisherName, $publisherDisplayName, $publisherDescription, $publisherPicture, $publisherWebsite){
		$mycon = DB::getInstance();
		$currentTime = get_current_time();
		$mycon->insertRecord("INSERT INTO `x_publisher` (`id`,`ex_id`,`name`,`displayName`,`description`,`picture`,`website`,`created_at`,`updated_at`) VALUES (NULL,:publisherID,:publisherName,:publisherDisplayName,:publisherDescription,:publisherPicture,:publisherWebsite,:currentTime,:currentTime)",array(
			'publisherID' => $publisherID,
			'publisherName' =>$publisherName,
			'publisherDisplayName'=> $publisherDisplayName,
			'publisherDescription' =>$publisherDescription,
			'publisherPicture' =>$publisherPicture,
			'publisherWebsite' =>$publisherWebsite,
			'currentTime' =>$currentTime,
			'currentTime' => $currentTime
		));

	}
}