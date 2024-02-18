<?php
class AccountModel{
	public static function getUsers($start,$to){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT * FROM `x_admin` ORDER BY `id` DESC  LIMIT :start,:to ",array(
			'start' =>$start,
			'to' =>$to,
		));
		return $records;
	}


	public static function getUsersCount(){
		$mycon = DB::getInstance();
		$records =  $mycon->getAllRecords("SELECT COUNT(*) as total FROM `x_admin`",array());
		return $records[0]['total'];
	}

	public static function getUserByEmail($email){
		$mycon   = DB::getInstance();
		$records = $mycon->getRocord("SELECT * FROM `x_admin` WHERE email=:email",array(
			'email' => $email,
		));
		return $records;
	}

	public static function getUserByPhone($phone){
		$mycon   = DB::getInstance();
		$records = $mycon->getRocord("SELECT * FROM `x_admin` WHERE phone=:phone",array(
			'phone' => $phone,
		));
		return $records;
	}

	public static function getUserById($id){
		$mycon   = DB::getInstance();
		$records = $mycon->getRocord("SELECT * FROM `x_admin` WHERE id=:id",array(
			'id' => $id,
		));
		return $records;
	}

	public static function registerUser($fullname,$alias,$email,$password,$phone,$current_time){
		$mycon  = DB::getInstance();
		$result = $mycon->insertRecord("INSERT INTO `x_user` (`id`, `fullname`, `alias`, `email`,`password`,`phone`, `is_block`, `is_validation`, `created_at`, `updated_at`) VALUES (NULL,:fullname,:alias,:email,:password,:phone,0,0,:current_time,:current_time)",array(
			'fullname' => $fullname,
			'alias' => $alias,
			'email' => $email,
			'password' => $password,
			'phone' => $phone,
			'current_time' => $current_time,

		));
		return $result;
	}

	public static function LoginHistory($user_id,$fullname,$os_name,$browser_name,$currentTime){
		$mycon  = DB::getInstance();
		$result = $mycon->insertRecord("INSERT INTO `x_user_history` (`id`, `user_id`,`fullname`,`os_name`,`browser_name`, `created_at`, `updated_at`) VALUES (NULL,:userID,:fullName,:osname,:browsername,:currentTime,:currentTime)",array(
			'userID' => $user_id,
			'fullName' => $fullname,
			'osname' =>$os_name,
			'browsername' => $browser_name,
			'currentTime' => $currentTime,

		));
		return $result;
	}

	public static function LoginBrokenHistory($useremail,$userip,$os_name,$browser_name,$currentTime){
		$mycon  = DB::getInstance();
		$result = $mycon->insertRecord("INSERT INTO `x_login_broken_history` (`id`, `used_email`,`ip`,`os`,`browser`, `created_at`) VALUES (NULL,:useremail,:userip,:osname,:browsername,:currentTime)",array(
			'useremail' => $useremail,
			'userip' => $userip,
			'osname' =>$os_name,
			'browsername' => $browser_name,
			'currentTime' => $currentTime,

		));
		return $result;
	}

	public static function  getLastUserLoginBrokenWithIP($userip){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_login_broken_history` WHERE `ip` = :user_ip ORDER BY `id` DESC LIMIT 0 ,3",array(
			'user_ip' => $userip,
		));
		return $result;
	}


	public static function getLastUserLogin(){
		$mycon = DB::getInstance();
		$result = $mycon->getAllRecords("SELECT * FROM `x_user_history` ORDER BY `id` DESC LIMIT 0 ,5",array());
		return $result;
	}


	public static function updateUserInfoWithPassword($user_id,$fullname,$email,$phone,$blocked,$supper_admin,$password){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_admin` SET `fullname` = :newfullname,`email` = :newemail ,`password` = :newpassword , `phone` = :newphone , `blocked` =:blocked , `is_supperadmin` =:supper_admin WHERE `x_admin`.`id` = :user_id",array(
			'user_id' => $user_id,
			'newfullname' => $fullname,
			'newemail' => $email,
			'newphone' => $phone,
			'newpassword' => $password,
			'blocked' =>$blocked,
			'supper_admin' =>$supper_admin,
		));
		return;
	}

	public static function updateUserInfoWithoutPassword($user_id,$fullname,$email,$phone,$blocked,$supper_admin){
		$mycon = DB::getInstance();
		$mycon->modifyRecord("UPDATE `x_admin` SET `fullname` = :newfullname,`email` = :newemail , `phone` = :newphone , `blocked` =:blocked , `is_supperadmin` =:supper_admin WHERE `x_admin`.`id` = :user_id",array(
			'user_id' => $user_id,
			'newfullname' => $fullname,
			'newemail' => $email,
			'newphone' => $phone,
			'blocked' =>$blocked,
			'supper_admin' =>$supper_admin,
		));
		return;
	}

	public static function insertNewAdminWithImageInfo($fullname,$email,$password,$phone,$imgInfo,$issupper,$time){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_admin` (`id`,`fullname`,`email`,`password`,`phone`,`img`,`is_supperadmin`,`created_at`,`updated_at`) VALUES (NULL,:fullname,:email,:hash_pass,:phone,:imgfo,:suppered,:cu_time,:cu_time)",array(
			'fullname' => $fullname,
			'email'=> $email,
			'hash_pass'=> $password,
			'phone'=> $phone,
			'imgfo'=> $imgInfo,
			'suppered'=> $issupper,
			'cu_time'=> $time,
			'cu_time'	=> $time,
		));
	}

	public static function insertNewAdminWithoutImageInfo($fullname,$email,$password,$phone,$issupper,$time){
		$mycon = DB::getInstance();
		$mycon->insertRecord("INSERT INTO `x_admin` (`id`,`fullname`,`email`,`password`,`phone`,`is_supperadmin`,`created_at`,`updated_at`) VALUES (NULL,:fullname,:email,:hash_pass,:phone,:suppered,:cu_time,:cu_time)",array(
			'fullname' => $fullname,
			'email'=> $email,
			'hash_pass'=> $password,
			'phone'=> $phone,
			'suppered'=> $issupper,
			'cu_time'=> $time,
			'cu_time'	=> $time,
		));
	}

	public static function deleteUser($user_id){
		$mycon = DB::getInstance();
		$status = $mycon->modifyRecord("DELETE FROM `x_admin` WHERE `x_admin`.`id` = :userID",array(
			'userID' => $user_id,
		));
		return $status;
	}
	public static function deleteUsers($users_id){
		$mycon = DB::getInstance();
		$status = $mycon->modifyRecord("DELETE FROM `x_admin` WHERE id IN ($users_id) ",array());
		return $status;
	}
}
