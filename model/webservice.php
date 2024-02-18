<?php
class WebserviceModel{
	public static function getApiKey($apliKey){
		$mycon  = DB::getInstance();
		$result = $mycon->getRocord("SELECT * FROM `x_api_key` WHERE `apiKey` = :myApi",array(
			'myApi' =>$apliKey,
		));
		return $result;
	}




	/*-----------------------------------------SET MODEL---------------------------------------*/


	public static function setApiHistoryWithoutUserInformation($ip,$error_code,$errorStatus = 1,$error_msg,$time){
		$mycon  = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_api_history` (`id`,`user_id`,`errorStatus`,`errorCode`,`errorMessage`,`ip`,`created_at`) VALUES (NULL,0,:errorStatus,:errorCode,:errorMsg,:userIP,:creatTime)",array(
			'userIP' => $ip,
			'errorCode' => $error_code,
			'errorStatus' => $errorStatus,
			'errorMsg' => $error_msg,
			'creatTime' => $time,
		));
		return;
	}

	public static function setApiHistoryWithUserInformation($user_id,$errorStatus = 1,$ip,$error_code,$error_msg,$stringReq = NULL,$time){
		$mycon  = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_api_history` (`id`,`user_id`,`errorStatus`,`errorCode`,`errorMessage`,`stringReq`,`ip`,`created_at`) VALUES (NULL,:user_id,:errorStatus,:errorCode,:errorMsg,:stringQuery,:userIP,:creatTime)",array(
			'userIP' => $ip,
			'user_id' => $user_id,
			'errorStatus' => $errorStatus,
			'errorCode' => $error_code,
			'errorMsg' => $error_msg,
			'stringQuery' => $stringReq,
			'creatTime' => $time,
		));
		return;
	}

	public static function updateLastUsed($myid){
		$mycon  = DB::getInstance();
		$currentTime = get_current_time();
		$mycon->modifyRecord("UPDATE `x_api_key` SET `lastUsed` = :currentTime WHERE `x_api_key`.`id` = :myid",array(
			'myid' =>$myid,
			'currentTime' =>$currentTime,
		));
	}

	public static function getLastUsedAPI(){
		$mycon  = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT `x_api_history`.`id`,`x_api_history`.`user_id`, `x_api_history`.`errorStatus`,`x_api_history`.`errorCode`, `x_api_history`.`created_at`, `x_api_history`.`ip`, `x_api_key`.`company` FROM `x_api_history` INNER JOIN `x_api_key` ON `x_api_history`.`user_id` = `x_api_key`.`id` ORDER BY `x_api_history`.`created_at` DESC LIMIT 0,5",array());
		return $result;
	}
}