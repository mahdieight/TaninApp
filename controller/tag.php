<?php
class TagController{

	public function all(){

		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه برچسب ها را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'tag',$act_des,get_current_time());
		}

		$data['page_title'] = 'فهرست تمامی برچسب ها';
		view::render('tag/all_tags.php',$data);
	}

	public function getTagAjax(){
		$count = 10;
		$page_index = @ckeckExit($_POST['page_index'], true);
		$startCount = ($page_index - 1) * $count;

		$tag_info = TagModel::getTagLimit($startCount, $count);
		$tag_count = TagModel::getTagCount();

		$data['tag_info'] = $tag_info;
		$data['pageIndex'] = $page_index;
		$data['tag_count'] = ceil($tag_count / $count);


		ob_start();
		view::render_part('tag/all_tag_content.php', $data);
		$output['result'] = ob_get_clean();
		echo json_encode($output);
	}

	public function actsTag($albumTag){
		$tagList = array();
		foreach ($albumTag as $taginfo){
			$m_taginfo = TagModel::get_tag($taginfo['id']);
			if(empty($m_taginfo)){
				TagModel::insert_tag_info($taginfo['id'],$taginfo['value']);
				$record = TagModel::get_tag($taginfo['id']);
				$tagList[]= $record['id'];
			}else{
				$tagList[]= $m_taginfo['id'];
			}
		}
		return $tagList;
	}

	public function details($tag_id){
		if(!userAdmined()){
			redirectToLogin();
		}

		if (!isset($tag_id) OR empty($tag_id)){
			showErrorPageAdmin();
		}

		$tag_info = TagModel::get_tag_info($tag_id);
		if (empty($tag_info)){
			showErrorPageAdmin();
		}



		$data['page_title'] = 'اطلاعات برچسب - ' . $tag_info['value'];
		$data['tag_info'] = $tag_info;
		$data['count_used_tag'] = TagModel::getTagCountInUseAlbun($tag_id);

		$act_des = 'اطلاعات برچسب ' . $tag_info['value'] . ' را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'owner',$act_des,get_current_time());
		}

		view::render('tag/detail/detail_main.php',$data);

	}

	public function edit_tag(){

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


		if (!isset($_POST['tag_id']) || empty($_POST['tag_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}
		if (!isset($_POST['new_value']) || empty($_POST['new_value'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}


		$tag_id			=	$_POST['tag_id'];
		$new_value 	= $_POST['new_value'];

		$tag_info = TagModel::get_tag_info($tag_id);

		if (empty($tag_info)){
			$output['status'] = false;
			$output['result'] = 'برچسب  مورد نظر در سیستم وجود ندارد! دوباره تلاش کنید';
			echo json_encode($output);
			return;
		}

		if ($new_value == $tag_info['value'] || empty($new_value)){
			$output['status'] = false;
			$output['result'] = 'اطلاعات برچسب هیچ تغییری پیدا نکرده است';
			echo json_encode($output);
			return;
		}


		$act_des = ' برچسب ' . $tag_info['value'] . ' را به ' . $new_value . ' تغییر نام داد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'tag',$act_des,get_current_time());
		}


		TagModel::changeTagName($tag_id,$new_value,get_current_time());

		$output['status'] = true;
		$output['result'] = 'اطلاعات برچسب با موفقیت مورد ویرایش قرار گرفت.';
		echo json_encode($output);
		return;
	}

	public function primitive_unlink_tag(){

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

		if (!isset($_POST['tag_id']) || empty($_POST['tag_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}


		$tag_id = $_POST['tag_id'];

		$tag_count_use = TagModel::getTagCountInUseAlbun($tag_id);
		$output['status'] = true;
		$output['result'] = 'از این برچسب در ' . $tag_count_use . ' آلبوم استفاده شده است.آیا مایل به حذف آن هستید؟';
		echo json_encode($output);
		return;
	}

	public function secondary_unlink_tag(){

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

		if (!isset($_POST['tag_id']) || empty($_POST['tag_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}

		$tag_id 						= $_POST['tag_id'];
		$tag_info 					= TagModel::get_tag_info($tag_id);
		$tag_used_in_album 	= TagModel::getTagInUseAlbum($tag_id);


		$act_des = 'برچسب ' . $tag_info['value'] . ' را حذف نمود.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'tag',$act_des,get_current_time());
		}

		foreach ($tag_used_in_album as $tag_used){
			$tag_used_id	 	= $tag_used['id'];
			$all_tags 			= $tag_used['tags'];
			$all_tags 			= explode(',',$all_tags);

			$index = array_search($tag_id,$all_tags);
			if($index !== FALSE){
				unset($all_tags[$index]);
			}
			$all_tags = implode(',',$all_tags);


			AlbumModel::editAlbumTags($tag_used_id,$all_tags,get_current_time());
		}

		TagModel::deleteTag($tag_id);

		$taninAppConfig = new taninAppConfig();
		$output['status'] = true;
		$output['result'] = 'اطلاعات برچسب  با موفقیت حذف گردید!';
		$output['redirect'] = $taninAppConfig->base_url . 'tag/all/';
		$output['time'] = 2000;
		echo json_encode($output);
		return;

	}
}