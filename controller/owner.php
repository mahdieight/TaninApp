<?php
class OwnerController{

	public function all(){

		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه هنرمندان را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'owner',$act_des,get_current_time());
		}


		$data['page_title'] = 'فهرست تمامی هنرمندان';
		$data['search_id_name'] = 'search-owner';
		view::render('owner/all_owner.php',$data);
	}

	public function getOwnerAjax(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$count = 10;
		$page_index = @ckeckExit($_POST['page_index'], true);
		$startCount = ($page_index - 1) * $count;

		$vauleSearch = $_POST['valueSearch'];

		if ($vauleSearch == 'false'){
			$owner_info = OwnerModel::getOwnerLimit($startCount, $count);
			$owner_count = OwnerModel::getOwnerCount();
		}else{
			$owner_info= OwnerModel::getOwnerLimitWithSearch($vauleSearch,$startCount,$count);
			$owner_count = OwnerModel::getOwnerCountWithSearch($vauleSearch);
		}



		$data['owner_info'] = $owner_info;
		$data['pageIndex'] = $page_index;
		$data['owner_count'] = ceil($owner_count / $count);


		ob_start();
		view::render_part('owner/all_owner_content.php', $data);
		$output['result'] = ob_get_clean();
		echo json_encode($output);
	}

	public function details($owner_id){
		if(!userAdmined()){
			redirectToLogin();
		}

		if (!isset($owner_id) OR empty($owner_id)){
			showErrorPageAdmin();
		}

		$owner_info = OwnerModel::get_ownerByID($owner_id);
		if (empty($owner_info)){
			showErrorPageAdmin();
		}

		$data['count_as_owner'] = OwnerModel::getCountOwnerINAlbumWithOwnerID($owner_id);

		#آهنگساز
		$data['count_as_composers'] = ComposerModel::getCountComposersINAlbumWithOwnerID($owner_id);

		#تنظیم کننده
		$data['count_as_arrangers'] = ArrangerModel::getCountArrangersINAlbumWithOwnerID($owner_id);

		#شاعر
		$data['count_as_poet'] = PoetModel::getCountPoetINAlbumWithOwnerID($owner_id);

		$data['last_album_subscribed'] = AlbumModel::getLastAlbumSubscribedArtis($owner_id);

		$data['page_title'] = 'اطلاعات هنرمند - ' . $owner_info['artisticName'];
		$data['owner_info'] = $owner_info;

		$act_des = 'اطلاعات هنرمند ' . $owner_info['artisticName'] . ' را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'owner',$act_des,get_current_time());
		}

		view::render('owner/detail/detail_main.php',$data);

	}

	public function showOwnerPage(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$page_name = $_POST['page_name'];
		$owner_id  = $_POST['owner_id'];

		if ($page_name == 'biography'){
			$data['count_as_owner'] = OwnerModel::getCountOwnerINAlbumWithOwnerID($owner_id);

			#آهنگساز
			$data['count_as_composers'] = ComposerModel::getCountComposersINAlbumWithOwnerID($owner_id);

			#تنظیم کننده
			$data['count_as_arrangers'] = ArrangerModel::getCountArrangersINAlbumWithOwnerID($owner_id);

			#شاعر
			$data['count_as_poet'] = PoetModel::getCountPoetINAlbumWithOwnerID($owner_id);


			$data['last_album_subscribed'] = AlbumModel::getLastAlbumSubscribedArtis($owner_id);
		}


		$owner_info =  OwnerModel::get_owner_info($owner_id);
		$data['owner_info'] 	= $owner_info;


		ob_start();
		view::render_part('owner/detail/detail_' . $page_name . '.php',$data);
		$output['result'] = ob_get_clean();
		$output['status'] = true;
		echo json_encode($output);
		return;
	}

	public function edit_owner(){

		$owner_id = $_POST['owner_id'];

		if (empty($_POST['new_f_name']) && empty($_POST['new_l_name']) && empty($_POST['new_a_name']) ){
			$output['status'] = false;
			$output['result'] = 'اطلاعات هنرمند هیچ تغییری پیدا نکرده است!';
			echo json_encode($output);
			return;
		}

		$owner_info = OwnerModel::get_owner_info($owner_id);

		if ($owner_info['firstName'] == $_POST['new_f_name'] && $owner_info['lastName'] == $_POST['new_l_name'] && $owner_info['artisticName'] == $_POST['new_a_name']){
			$output['status'] = false;
			$output['result'] = 'اطلاعات هنرمند هیچ تغییری پیدا نکرده است!';
			echo json_encode($output);
			return;
		}

		if ((empty($_POST['new_f_name']) OR $owner_info['firstName'] == $_POST['new_f_name']) && (empty($_POST['new_l_name']) OR $owner_info['lastName'] == $_POST['new_l_name']) && (empty($_POST['new_a_name']) OR $owner_info['artisticName'] == $_POST['new_a_name'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات هنرمند هیچ تغییری پیدا نکرده است!';
			echo json_encode($output);
			return;
		}

		if (empty($_POST['new_f_name'])){
			$first_name = $owner_info['firstName'];
		}else{
			$first_name = $_POST['new_f_name'];
		}

		if (empty($_POST['new_l_name'])){
			$last_name = $owner_info['lastName'];
		}else{
			$last_name = $_POST['new_l_name'];
		}

		if (empty($_POST['new_a_name'])){
			$artistic_name = $owner_info['artisticName'];
		}else{
			$artistic_name = $_POST['new_a_name'];
		}


		OwnerModel::editOwnerPersonalInfo($owner_id,$first_name,$last_name,$artistic_name,get_current_time());

		$output['status'] = true;
		$output['result'] = 'اطلاعات هنرمند با موفقیت مورد ویرایش قرار گرفت';
		echo json_encode($output);
		return;

	}

	public function actsOwner($albumOwners){

		$ownerList = array();

		foreach ($albumOwners as $ownerinfo){

			$m_ownerinfo = OwnerModel::get_owners($ownerinfo['id']);

			if(empty($m_ownerinfo)){

				$ownerImg 				= @ckeckExit($ownerinfo['artistImage']);
				$ownerFName 			= @ckeckExit($ownerinfo['firstName']);
				$ownerLName 			= @ckeckExit($ownerinfo['lastName']);
				$ownerAName 			= @ckeckExit($ownerinfo['artisticName']);

				createDir('media/artists/' . $ownerinfo['id']);
				copyFile($ownerImg ,  'media/artists/' . $ownerinfo['id'] .'/'. $ownerinfo['id'] . '.jpg');
				$ownerImage['path'] ="media/artists/" . $ownerinfo['id'];
				$ownerImage['name'] = $ownerinfo['id'];
				$ownerImage['ext']  = ".jpg";
				$ownerImager = json_encode($ownerImage);

				OwnerModel::insert_owner_info($ownerinfo['id'],$ownerFName,$ownerLName,$ownerAName,$ownerImager);

				$record = OwnerModel::get_owners($ownerinfo['id']);
				$ownerList[]= $record['id'];
			}else{
				$ownerList[]= $m_ownerinfo['id'];
			}
		}
		return $ownerList;
	}

	public function primitive_unlink_owner(){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if(!isSupperAdmin()){
			$output['status'] = false;
			$output['result'] = 'دسترسی شما برای انجام این عملیات محدود می باشد';
			echo json_encode($output);
			return;
		}

		if (!isset($_POST['owner_id']) || empty($_POST['owner_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}


		$owner_id = $_POST['owner_id'];

		$owner_count_use = OwnerModel::getOwnerCountInUseAlbun($owner_id);
		$output['status'] = true;
		$output['result'] = 'از این هنرمند در ' . $owner_count_use . ' آلبوم استفاده شده است.آیا مایل به حذف آن هستید؟';
		echo json_encode($output);
		return;
	}

	public function secondary_unlink_owner(){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if(!isSupperAdmin()){
			$output['status'] = false;
			$output['result'] = 'دسترسی شما برای انجام این عملیات محدود می باشد';
			echo json_encode($output);
			return;
		}

		if (!isset($_POST['owner_id']) || empty($_POST['owner_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}

		$owner_id 						= $_POST['owner_id'];
		$owner_info 					= OwnerModel::get_ownerByID($owner_id);
		$owner_used_in_album 	= OwnerModel::getOwnerInUseAlbum($owner_id);

		$act_des = 'برچسب ' . $owner_info['firstName'] .' ' .$owner_info['lastName'] . ' را حذف نمود.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'tag',$act_des,get_current_time());
		}

		foreach ($owner_used_in_album as $owner_used){
			$tag_used_id	 	= $owner_used['id'];
			$all_owners 			= $owner_used['owners'];
			$all_owners 			= explode(',',$all_owners);

			$index = array_search($owner_id,$all_owners);
			if($index !== FALSE){
				unset($all_owners[$index]);
			}
			$all_owners = implode(',',$all_owners);


			AlbumModel::editAlbumOwners($tag_used_id,$all_owners,get_current_time());
		}

		$owner_img_info = json_decode($owner_info['artistImage'],true);
		$owner_folder_path = getcwd() . '/' . $owner_img_info['path'] . '/';
		$owner_file_name = $owner_img_info['name'] . $owner_img_info['ext'];

		if (file_exists($owner_folder_path . $owner_file_name)){
			unlink($owner_folder_path . $owner_file_name);
		}
		if (file_exists($owner_folder_path)){
			chown($owner_folder_path,777);
			@unlink($owner_folder_path);
		}

		OwnerModel::deleteOwner($owner_id);

		$taninAppConfig = new taninAppConfig();
		$output['status'] = true;
		$output['result'] = 'اطلاعات هنرمند  با موفقیت حذف گردید!';
		$output['redirect'] = $taninAppConfig->base_url . 'owner/all/';
		$output['time'] = 2000;
		echo json_encode($output);
		return;

	}
}