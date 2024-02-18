<?php
class userActivityModel{
	public static function activityCycle($user_id,$user_ip,$user_browser,$section,$description,$created_at){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_user_activity` (`id`,`user_id`,`user_ip`,`user_browser`,`section`,`description`,`created_at`) VALUES (NULL,:userid,:userip,:userbrowser,:section,:description,:createdat)",array(
			'userid' => $user_id,
			'userip' => $user_ip,
			'userbrowser' => $user_browser,
			'section' => $section,
			'description' => $description,
			'createdat' =>$created_at,
		));
		return;
	}

	public static function getLimitActivatyContent($user_id,$start,$to){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_user_activity` WHERE `user_id` = :userID ORDER BY `x_user_activity`.`id` DESC LIMIT :gostart, :goto ",array(
			'userID' =>$user_id,
			'gostart' =>$start,
			'goto' =>$to,
		));
		return $result;
	}

	public static function getLastActivaty($user_id){
		$mycon = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_user_activity` WHERE `user_id` = :userID ORDER BY `id` DESC ",array(
			'userID'=>$user_id,
		));
		return $result;
	}

	public static function getCountAllActivatyByUserId($user_id){
		$mycon = DB::getInstance();
		$count = $mycon->getRocord("SELECT COUNT(*) as total FROM `x_user_activity` WHERE `user_id` = :userID",array(
			'userID' =>$user_id,
		));
		return $count['total'];
	}

	public static function getCountALbumActivatyByUserId($user_id){
		$mycon = DB::getInstance();
		$count = $mycon->getRocord("SELECT COUNT(*) as total FROM `x_user_activity` WHERE `section` = 'album' AND `user_id` = :userID",array(
			'userID' =>$user_id,
		));
		return $count['total'];
	}

	public static function getCountReportActivatyByUserId($user_id){
		$mycon = DB::getInstance();
		$count = $mycon->getRocord("SELECT COUNT(*) as total FROM `x_user_activity` WHERE `section` = 'report' AND `user_id` = :userID",array(
			'userID' =>$user_id,
		));
		return $count['total'];
	}

	public static function getCountAccountActivatyByUserId($user_id){
		$mycon = DB::getInstance();
		$count = $mycon->getRocord("SELECT COUNT(*) as total FROM `x_user_activity` WHERE `section` = 'account' AND `user_id` = :userID",array(
			'userID' =>$user_id,
		));
		return $count['total'];
	}

	public static function getCountTrackActivatyByUserId($user_id){
		$mycon = DB::getInstance();
		$count = $mycon->getRocord("SELECT COUNT(*) as total FROM `x_user_activity` WHERE `section` = 'track' AND `user_id` = :userID",array(
			'userID' =>$user_id,
		));
		return $count['total'];
	}
}