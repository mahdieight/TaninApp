<?php
class AccountController{

	public function users(){
		if(!userAdmined()){
			redirectToLogin();
		}

		if(!isSupperAdmin()){
			showErrorPage500();
		}

		$act_activaty = 'صفحه مدیریت کاربران را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if (checkActivatyStatus($last_activaty_user['description'],$act_activaty)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_activaty,get_current_time());
		}


		$data['page_title'] = 'تمامی کاربران';
		view::render('account/all_user.php',$data);
	}

	public function add(){
		if(!userAdmined()){
			redirectToLogin();
		}

		if(!isSupperAdmin()){
			showErrorPage500();
		}

		if(!empty($_POST)){
			$this->check_add();
		}else{
			$data['page_title'] = 'افزودن مدیر جدید';
			view::render('account/insert_new_admin.php',$data);
		}

	}

	private function check_add(){
		$tananAppConfig = new taninAppConfig();

		$name = @ckeckExit($_POST['firstname']);
		$family = @ckeckExit($_POST['lastname']);
		$fullname = $name . ' ' . $family;

		$email = @ckeckExit($_POST['email']);
		$phone = @ckeckExit($_POST['phone']);
		$password = @ckeckExit($_POST['password']);
		$repassword = @ckeckExit($_POST['re-password']);

		if(isset($_POST['is_supperadmin'])){
			$supper_admin = '1';
		}else{
			$supper_admin = '0';
		}

		$cutime = get_current_time();

		if(empty($name) OR empty($family) OR empty($email) OR empty($phone) OR empty($password) OR empty($repassword)){
			$output['status']  = false;
			$output['msg']  = 'اطلاعات فرم ناقص می باشد';
			echo json_encode($output);
			return;
		}

		if ($password != $repassword){
			$output['status']  =false;
			$output['msg']  = 'گذرواژه های وارد شده با یکدیگر تطابق ندارند!';
			echo json_encode($output);
			return;
		}


		$getUserByEmail = AccountModel::getUserByEmail($email);

		if (!empty($getUserByEmail)){
			$output['status']  =false;
			$output['msg']  = 'ایمیل وارد شده، قبلا توسط کاربر دیگیری استفاده شده است';
			echo json_encode($output);
			return;
		}


		$getUserByPhone = AccountModel::getUserByPhone($phone);
		if (!empty($getUserByPhone)){
			$output['status']  =false;
			$output['msg']  = 'شماره موبال وارد شده تکراری می باشد!';
			echo json_encode($output);
			return;
		}

		$hash_password = md5($password . $tananAppConfig->salt_password);
		if (isset($_FILES['user-profile']) AND !empty($_FILES['user-profile']) AND $_FILES['user-profile']['error'] == 0 ){
			$base_img_name = get_current_time('Ymdis');
			$file = $_FILES['user-profile'];
			$image_size = $file['size'];
			$image_ext = explode('/' ,$file['type']);
			$image_ext = '.' . end($image_ext);


			$image_name_org = $base_img_name . '_org' . $image_ext;

			$image_name_medium = $base_img_name . '_medium' . $image_ext;
			$image_name_medium_w_size = '140';
			$image_name_medium_h_size = '140';

			$image_name_small = $base_img_name . '_small' . $image_ext;
			$image_name_small_w_size = '40';
			$image_name_small_h_size = '40';

			$target_file_medium = getcwd() .  '/media/images/avatar/medium/' . $image_name_medium;
			$target_file_small = getcwd() .  '/media/images/avatar/small/' .$image_name_small;
			$target_file_org = getcwd() .  '/media/images/avatar/org/' .$image_name_org;

			move_uploaded_file($_FILES['user-profile']["tmp_name"], $target_file_org);


			if(!extension_loaded('gd')&&!extension_loaded('gd2'))  {
				die("GD is not installed!");
			}


			if($image_ext == '.png'){
				$im = imagecreatefrompng($target_file_org);
			}elseif ($image_ext == '.jpg' OR $image_ext == '.jpeg'){
				$im = imagecreatefromjpeg($target_file_org);
			}else{
				$im = imagecreatefromgif($target_file_org);
			}


			$width = imagesx($im);
			$height = imagesy($im);

			$x = $image_name_small_w_size;
			$y = $image_name_small_h_size;

			$new_img = imagecreate($x,$y);
			imagecopyresized($new_img,$im,0,0,0,0,$x,$y,$width,$height);

			if($image_ext == '.png'){
				imagepng($new_img,$target_file_small);
			}elseif ($image_ext == '.jpg' OR $image_ext == '.jpeg'){
				imagejpeg($new_img,$target_file_small);
			}else{
				imagegif($new_img,$target_file_small);
			}


			/*************************/
			if($image_ext == '.png'){
				$im = imagecreatefrompng($target_file_org);
			}elseif ($image_ext == '.jpg' OR $image_ext == '.jpeg'){
				$im = imagecreatefromjpeg($target_file_org);
			}else{
				$im = imagecreatefromgif($target_file_org);
			}


			$width = imagesx($im);
			$height = imagesy($im);

			$x = $image_name_medium_w_size;
			$y = $image_name_medium_h_size;

			$new_img = imagecreate($x,$y);
			imagecopyresized($new_img,$im,0,0,0,0,$x,$y,$width,$height);

			if($image_ext == '.png'){
				imagepng($new_img,$target_file_medium);
			}elseif ($image_ext == '.jpg' OR $image_ext == '.jpeg'){
				imagejpeg($new_img,$target_file_medium);
			}else{
				imagegif($new_img,$target_file_medium);
			}

			$img_i['ext'] = $image_ext;
			$img_i['name'] = $base_img_name;
			$img_i['alt'] = $base_img_name;

			$imginfo = json_encode($img_i);
			AccountModel::insertNewAdminWithImageInfo($fullname,$email,$hash_password,$phone,$imginfo,$supper_admin,$cutime);
		}else{
			AccountModel::insertNewAdminWithoutImageInfo($fullname,$email,$hash_password,$phone,$supper_admin,$cutime);
		}

		$getCurrentUserByEmail = AccountModel::getUserByEmail($email);
		$output['status']  	= true;
		$output['msg']  		= 'اطلاعات کاربر با موفقیت ذخیره شد';
		$output['redirect'] = $tananAppConfig->base_url . 'account/details/' . $getCurrentUserByEmail['id'];
		echo json_encode($output);
		return;

	}

	public function get_users_ajax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($_POST['pageIndex'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$count = 10 ;
		$pageIndex = $_POST['pageIndex'];
		$startCount = ($pageIndex-1) * $count;

		$users= AccountModel::getUsers($startCount,$count);
		$usersCount = AccountModel::getUsersCount();

		$data['records']  = $users;
		$data['pageIndex'] = $pageIndex;
		$data['usersCount'] = ceil($usersCount / $count);

		ob_start();
		view::render_part('account/all_users_content.php',$data);
		$result['content'] = ob_get_clean();
		echo json_encode($result);
		return;
	}

	public function details($userID){
		if(!userAdmined()){
			redirectToLogin();
		}

		$user_info = AccountModel::getUserById($userID);
		if(empty($user_info)){
			showErrorPageAdmin();
		}

		if($user_info['id'] == $_SESSION['user_id']){
			$act_des = 'جزئیات حساب کاربری خودش را مشاهده کرد';
		}else{
			$act_des = 'جزئیات حساب کاربری ' . $user_info['fullname'] . ' را مشاهده کرد.';
		}

		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] ,$act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_des,get_current_time());
		}


		$data['page_title']  = 'جزئیات حساب کاربری';
		$data['user_info']  = $user_info;
		view::render('account/detail/detail_main.php',$data);

	}

	public function showUserPage(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$page_name = $_POST['showPage'];
		$user_id  = $_POST['userID'];
		$user_info =  AccountModel::getUserById($user_id);
		$data['user_info'] 	= $user_info;

		if($page_name == 'activaty'){

			$data['all_activaty'] = userActivityModel::getCountAllActivatyByUserId($user_id);
			$data['album_activaty'] = userActivityModel::getCountALbumActivatyByUserId($user_id);
			$data['track_activaty'] = userActivityModel::getCountTrackActivatyByUserId($user_id);
			$data['report_activaty'] = userActivityModel::getCountReportActivatyByUserId($user_id);
			$data['account_activaty'] = userActivityModel::getCountAccountActivatyByUserId($user_id);
		}

		ob_start();
		view::render_part('account/detail/user_' . $page_name . '.php',$data);
		$output['result'] = ob_get_clean();
		$output['status'] = true;
		echo json_encode($output);
		return;
	}

	public function get_activaty_content(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (!isset($_POST['pageIndex'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$user_id = $_POST['userID'];
		$page_index = $_POST['pageIndex'];

		$count = 5;
		$count_get_content = $page_index * $count;

		$content = userActivityModel::getLimitActivatyContent($user_id,$page_index,$count_get_content);
		if (empty($content)){
			$output['status'] = false;
			echo  json_encode($output);
			return;
		}
		$data['content'] = $content;
		ob_start();
		view::render_part('account/detail/user_activaty_content.php',$data);
		$output['content'] = ob_get_clean();

		$output['next_page'] = $page_index + 1;
		$output['status'] = true;
		echo  json_encode($output);
		return;




	}

	public function checkMatchPassword(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (!isset($_POST['pass_provided']) OR empty($_POST['pass_provided']) ){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$pro_pass = $_POST['pass_provided'];
		$user_id = $_POST['user_id'];

		$user_info = AccountModel::getUserById($user_id);

		if (empty($user_info)){
			$output['error']['status'] = true;
			$output['error']['code'] = '404';
			$output['error']['type'] = 'ENTITY_NOT_FOUND';
			$output['error']['message'] = 'Entity Not Found';
			echo json_encode($output);
			return ;
		}

		$cur_pass = $user_info['password'];

		$taninAppConfig = new taninAppConfig();
		$new_pass_hashed= md5($pro_pass . $taninAppConfig->salt_password);

		if($new_pass_hashed == $cur_pass){
			$output['result'] = true;
		}else{
			$output['result'] = false;
		}
		echo json_encode($output);
		return;

	}

	public function unlink_user(){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (!isset($_POST['userid']) OR empty($_POST['userid'])){
			$output['status'] = false;
			$output['msg'] = 'هیچ پارامتری برای این درخواست شما تنظیم نشده است!';
			echo json_encode($output);
			return;
		}

		$user_id = $_POST['userid'];
		if (is_array($user_id)){
			$user_id = implode(',',$user_id);
		}



		if(strHas(',',$user_id)){
			if (strHas($_SESSION['user_id'],$user_id)){
				$output['status'] = false;
				$output['msg'] = 'شما نمی توانید حساب کاربری خود را حذف نمایید!';
				echo json_encode($output);
				return;
			}else{
				$act_des = 'صفحه تمامی آلبوم های ثبت شده را مشاهده کرد.';

				$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
				if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
					userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_des,get_current_time());
				}

				AccountModel::deleteUsers($user_id);
			}

		}else{
			if($user_id== $_SESSION['user_id']){
				$output['status'] = false;
				$output['msg'] = 'شما نمی توانید حساب کاربری خود را حذف نمایید!';
				echo json_encode($output);
				return;
			}else{
				$user_info = AccountModel::getUserById($user_id);

				$act_des = ' حساب کاربری ' . $user_info['fullname'] . ' را حذف کرد.';

				$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
				if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
					userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_des,get_current_time());
				}

				AccountModel::deleteUser($user_id);
			}
		}

		$taninAppConfig = new taninAppConfig();
		$output['status'] = true;
		$output['msg'] = 'کاربر با موفقیت حذف گردید. تا چند لحظه دیگر به مدیریت کاربرا منتقل می شوید.';
		$output['redirect'] = $taninAppConfig->base_url . 'account/users';
		$output['time'] = 5000;
		echo json_encode($output);
		return;


	}

	public function editUserInformation(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (isset($_POST['user_id'])){

			$user_id 			= $_POST['user_id'];
			$fullname 		= $_POST['fullname'];
			$email 				= $_POST['email'];
			$phone 				= $_POST['phone'];
			$blocked 			=  $_POST['blocked'];
			$supper_admin =  $_POST['is_admin'];


			$act_des = 'جزئیات حساب کاربری ' . $fullname . ' را ویرایش کرد.';
			$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);

			if (isset($_POST['password'])){
				$taninAppConfig = new taninAppConfig();
				$password= md5($_POST['password'] . $taninAppConfig->salt_password);


				if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
					userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_des,get_current_time());
				}
				AccountModel::updateUserInfoWithPassword($user_id,$fullname,$email,$phone,$blocked,$supper_admin,$password);
			}else{
				if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
					userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'account',$act_des,get_current_time());
				}
				AccountModel::updateUserInfoWithoutPassword($user_id,$fullname,$email,$phone,$blocked,$supper_admin);
			}

			$output['status'] = true;
			$output['result'] = 'اطلاعات با موفقیت بروزرسانی شدند!';
		}else {
			$output['status'] = false;
			$output['result'] = 'شناسه کاربری مشخصی وجود ندارد!';
		}

		echo json_encode($output);
		return;
	}

	public function login(){

		if (empty($_POST)) {
			$data['title_page'] = 'ورود به حساب کاربری';
			view::render_part('account/login.php', $data);
		} else {
			$this->loginCheck();
		}
	}

	private function get_user_broken_status($user_ip){
		$count_broken_trying = AccountModel::getLastUserLoginBrokenWithIP($user_ip);

		if(count($count_broken_trying) < 3){
			$output['status'] = false;
			return $output;
		}

		if (empty($count_broken_trying)){
			$output['status'] = false;
			return $output;
		}
		$broken_count = 0;
		$step = 0;
		$last_time = 0;
		foreach ($count_broken_trying as $broken_trying){
			$created_at = getTimeElapsed($broken_trying['created_at']);
			if($created_at->y == 0 AND $created_at->m == 0 AND $created_at->d == 0 AND $created_at->h == 0){
				if($created_at->i <=10){
					$broken_count++;
					if($step ==0 ){
						$last_time = $created_at->i;
					}
				}

			}
		}

		if($broken_count >=3){
			$output['status'] = true;
			$output['time'] = (10 - $last_time) +1;
		}else{
			$output['status'] = false;
		}
		return $output;
	}

	private function loginCheck(){
		$broken_status =  $this->get_user_broken_status(get_client_ip_env());
		if ($broken_status['status'] == true){
			$output['status'] = false;
			$output['result'] = 'شما بیش از حد مجاز در ورود اطلاعات اشتابه کرده اید. لطفا '  . $broken_status['time'] . 'دقیقه دیگر تلاش نمایید.';
			echo json_encode($output);
			return;
		}
		if(isset($_POST['username']) && $_POST['password']){
			$taninAppConfig = new taninAppConfig();

			$username = $_POST['username'];
			$password = md5($_POST['password'] . $taninAppConfig->salt_password);
			$username_status = AccountModel::getUserByEmail($username);
			if(empty($username_status)){
				$output['status'] = false;
				$output['result'] = 'حساب کاربری نامعتبر است';
				$currentTime = get_current_time();
				AccountModel::LoginBrokenHistory($_POST['username'],get_client_ip_env(),getOS(),getBrowser(),$currentTime);
			}else if($username_status['password'] != $password) {
				$output['status'] = false;
				$output['result'] = 'نام کاربری یا رمز عبور اشتباه می باشد';
				$currentTime = get_current_time();
				AccountModel::LoginBrokenHistory($_POST['username'],get_client_ip_env(),getOS(),getBrowser(),$currentTime);
			}else if ($username_status['blocked'] == 1) {
				$output['status'] = false;
				$output['result'] = 'حساب کاربری شما مسدود شده است. لطفا با مدیریت تماس بگیرید';
			}else{
				$_SESSION['user_id'] 				= $username_status['id'];
				$_SESSION['user_fullname'] 	= $username_status['fullname'];
				$_SESSION['user_email']			= $username_status['email'];
				$_SESSION['user_img']				= $username_status['img'];


				#SET USER LOGIN HISTORY
				AccountModel::LoginHistory($username_status['id'],$username_status['fullname'],getOS(),getBrowser(),get_current_time());
				userActivityModel::activityCycle($username_status['id'],get_client_ip_env(),getBrowser(),'account','وارد سیستم شد.',get_current_time());

				$output['status'] = true;
				$output['result'] = 'حساب تایید شد';
				$output['redirect'] = $taninAppConfig->base_url . 'page/dashboard';
				$output['time'] = 5000;
			}

		}else{
			$output['status'] = false;
			$output['result'] = 'اطلاعات فرم اشتباه می باشد';
		}

		echo json_encode($output);
		return;
	}

	public function logout(){
		session_destroy();
		redirectToLogin();
	}
}
