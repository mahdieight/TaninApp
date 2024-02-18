<?php
class GenreController{

	public function all(){

		if(!userAdmined()){
			redirectToLogin();
		}


		$act_des = 'صفحه ژانرها را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'genre',$act_des,get_current_time());
		}


		$data['page_title'] = 'فهرست تمامی ژانرها';
		view::render('genre/all_genres.php',$data);
	}

	public function details($genre_id){
		if(!userAdmined()){
			redirectToLogin();
		}

		if (!isset($genre_id) OR empty($genre_id)){
			showErrorPageAdmin();
		}

		$genre_info = GenreModel::get_genre_info($genre_id);
		if (empty($genre_info)){
			showErrorPageAdmin();
		}



		$data['page_title'] = 'اطلاعات ژانر - ' . $genre_info['value'];
		$data['genre_info'] = $genre_info;
		$data['count_used_genre'] =GenreModel::getGenreCountInUseAlbun($genre_id);
		$act_des = 'اطلاعات ژانر ' . $genre_info['value'] . ' را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'owner',$act_des,get_current_time());
		}

		view::render('genre/detail/detail_main.php',$data);

	}

	public function edit_genre(){

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


		if (!isset($_POST['genre_id']) || empty($_POST['genre_id'])){
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


		$genre_id		=	$_POST['genre_id'];
		$new_value 	= $_POST['new_value'];

		$genre_info = GenreModel::get_genre_info($genre_id);

		if (empty($genre_info)){
			$output['status'] = false;
			$output['result'] = 'زانر مورد نظر در سیستم وجود ندارد! دوباره تلاش کنید';
			echo json_encode($output);
			return;
		}

		if ($new_value == $genre_info['value'] || empty($new_value)){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ژانر هیچ تغییری پیدا نکرده است';
			echo json_encode($output);
			return;
		}


		$act_des = ' ژانر ' . $genre_info['value'] . ' را به ' . $new_value . ' تغییر نام داد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'genre',$act_des,get_current_time());
		}


		GenreModel::changeGenreName($genre_id,$new_value,get_current_time());

		$output['status'] = true;
		$output['result'] = 'اطلاعات ژانر با موفقیت مورد ویرایش قرار گرفت.';
		echo json_encode($output);
		return;
	}

	public function primitive_unlink_genre(){

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

		if (!isset($_POST['genre_id']) || empty($_POST['genre_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}


		$genre_id = $_POST['genre_id'];

		$genre_count_use = GenreModel::getGenreCountInUseAlbun($genre_id);
		$output['status'] = true;
		$output['result'] = 'از این ژانر در ' . $genre_count_use . ' آلبوم استفاده شده است.آیا مایل به حذف آن هستید؟';
		echo json_encode($output);
		return;
	}

	public function secondary_unlink_genre(){

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

		if (!isset($_POST['genre_id']) || empty($_POST['genre_id'])){
			$output['status'] = false;
			$output['result'] = 'اطلاعات ارسالی دارای اشکالاتی است! لطفا مجدد تلاش کنید';
			echo json_encode($output);
			return;
		}

		$genre_id = $_POST['genre_id'];
		$genre_info = GenreModel::get_genre_info($genre_id);
		$genre_used_in_album = GenreModel::getGenreInUseAlbum($genre_id);


		$act_des = 'زانر ' . $genre_info['value'] . ' را حذف نمود.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'genre',$act_des,get_current_time());
		}

		foreach ($genre_used_in_album as $genre_used){
			$genre_used_id = $genre_used['id'];
			$all_genres = $genre_used['genres'];
			$all_genres = explode(',',$all_genres);

			$index = array_search($genre_id,$all_genres);
			if($index !== FALSE){
				unset($all_genres[$index]);
			}
			$all_genres = implode(',',$all_genres);

			AlbumModel::editAlbumGenres($genre_used_id,$all_genres,get_current_time());
		}

		GenreModel::deleteGenre($genre_id);

		$taninAppConfig = new taninAppConfig();
		$output['status'] = true;
		$output['result'] = 'اطلاعات ژانر با موفقیت حذف گردید!';
		$output['redirect'] = $taninAppConfig->base_url . 'genre/all/';
		$output['time'] = 2000;
		echo json_encode($output);
		return;

	}

	public function getGenreAjax(){
		$count = 10;
		$page_index = @ckeckExit($_POST['page_index'], true);
		$startCount = ($page_index - 1) * $count;

		$genre_info = GenreModel::getGenreLimit($startCount, $count);
		$genre_count = GenreModel::getGenreCount();

		$data['genre_info'] = $genre_info;
		$data['pageIndex'] = $page_index;
		$data['genre_count'] = ceil($genre_count / $count);


		ob_start();
		view::render_part('genre/all_genre_content.php', $data);
		$output['result'] = ob_get_clean();
		echo json_encode($output);
	}

	public function actsGenre($albumGenre){

		$genreList = array();

		foreach ($albumGenre as $genreinfo){

			$m_genreinfo = GenreModel::get_genre($genreinfo['id']);

			if(empty($m_genreinfo)){

				$genreName 			= @ckeckExit($genreinfo['name']);

				GenreModel::insert_genre_info($genreinfo['id'],$genreName);

				$record = GenreModel::get_genre($genreinfo['id']);
				$genreList[]= $record['id'];

			}else{
				$genreList[]= $m_genreinfo['id'];
			}
		}
		return $genreList;
	}
}