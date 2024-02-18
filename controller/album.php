<?php
class AlbumController{

	public function allAlbums(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه تمامی آلبوم های ثبت شده را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$data['page_title'] = 'تمامی آلبوم های ثبت شده';
		$data['search_id_name'] = 'search-allalbum';
		view::render('album/all_album.php',$data);
	}

	public function getAlbumAjax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$count = 10 ;
		$pageIndex = $_POST['pageIndex'];
		$startCount = ($pageIndex-1) * $count;

		$vauleSearch = $_POST['valueSearch'];

		if ($vauleSearch == 'false'){
			$albumInfo= AlbumModel::getAlbums($startCount,$count);
			$albumCount = AlbumModel::getAlbumsCount();
		}else{
			$albumInfo= AlbumModel::getAlbumsWithSearch($vauleSearch,$startCount,$count);
			$albumCount = AlbumModel::getAlbumsCountWithSearch($vauleSearch);
		}


		$data['records']  = $albumInfo;
		$data['pageIndex'] = $pageIndex;
		$data['albumCount'] = ceil($albumCount / $count);

		ob_start();
		view::render_part('album/all_album_content.php',$data);
		$result['content'] = ob_get_clean();
		echo json_encode($result);
		return;
	}

	public function singleTrack(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه تمامی آلبوم های تک تراک را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$data['page_title'] = 'تمامی آلبوم های تک تراک';
		$data['search_id_name'] = 'search-allalbum';
		view::render('album/singleTrack/all_album.php',$data);
	}

	public function getAlbumSingleTrackAjax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$count = 10 ;
		$pageIndex = $_POST['pageIndex'];
		$startCount = ($pageIndex-1) * $count;

		$vauleSearch = $_POST['valueSearch'];

		if ($vauleSearch == 'false'){
			$albumInfo= AlbumModel::getAlbumSingleTrackAjax($startCount,$count);
			$albumCount = AlbumModel::getAlbumsSingleTrackCount();
		}else{
			$albumInfo= AlbumModel::getAlbumsSingleTrackWithSearch($vauleSearch,$startCount,$count);
			$albumCount = AlbumModel::getAlbumsCountSingleTrackWithSearch($vauleSearch);
		}


		$data['records']  = $albumInfo;
		$data['pageIndex'] = $pageIndex;
		$data['albumCount'] = ceil($albumCount / $count);

		ob_start();
		view::render_part('album/singleTrack/all_album_content.php',$data);
		$result['content'] = ob_get_clean();
		echo json_encode($result);
		return;
	}

	public function addSingleTrack(){
		$data['page_title'] = 'تمامی آلبوم های تک تراک';
		$data['search_id_name'] = 'search-allalbum';
		$data['all_publisher'] = PublisherModel::getAllPublisher();
		$data['all_tags'] = TagModel::getAllTag();
		view::render('album/singleTrack/add_new_item.php',$data);
	}

	public function getSpecialAlbum(){
		if(!userAdmined()){
			redirectToLogin();
		}
		if(!isSupperAdmin()){
			showErrorPage500();
		}

		userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album','صفحه دریافت یک آلبوم خاص را مشاهده کرد.',get_current_time());
		$data['page_title'] = 'دریافت یک آلبوم خاص';
		view::render('album/get_special_album.php',$data);
	}

	public function queue(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه تمامی آلبوم های در انتظار را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$data['page_title'] = 'تمامی آلبوم های در انتظار';
		$data['search_id_name'] = 'search-album-equeue';
		view::render('album/queue_album.php',$data);
	}

	public function getAlbumQueueAjax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		$count = 10 ;
		$pageIndex = $_POST['pageIndex'];
		$startCount = ($pageIndex-1) * $count;

		$searchValue = $_POST['searchValue'] ;
		if ($searchValue == 'false'){
			$albumInfo= AlbumModel::getQueueAlbums($startCount,$count);
			$albumCount = AlbumModel::getAlbumsQueueCount();
		}else{
			$albumInfo= AlbumModel::getQueueAlbumsWithSearch($searchValue,$startCount,$count);
			$albumCount = AlbumModel::getAlbumsQueueCountWithSearch($searchValue);
		}


		$data['records']  = $albumInfo;
		$data['pageIndex'] = $pageIndex;
		$data['albumCount'] = ceil($albumCount / $count);

		ob_start();
		view::render_part('album/all_album_queue_content.php',$data);
		$result['content'] = ob_get_clean();
		echo json_encode($result);
		return;
	}

	public function getAlbumBrokenAjax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		$count = 10 ;
		$pageIndex = $_POST['pageIndex'];
		$startCount = ($pageIndex-1) * $count;

		$searchValue = $_POST['searchValue'] ;
		if ($searchValue == 'false'){
			$albumInfo= AlbumModel::getBrokenAlbums($startCount,$count);
			$albumCount = AlbumModel::getAlbumsBrokenCount();
		}else{
			$albumInfo= AlbumModel::getBrokenAlbumsWithSearch($searchValue,$startCount,$count);
			$albumCount = AlbumModel::getAlbumsBrokenCountWithSearch($searchValue);
		}


		$data['records']  = $albumInfo;
		$data['pageIndex'] = $pageIndex;
		$data['albumCount'] = ceil($albumCount / $count);

		ob_start();
		view::render_part('album/all_album_broken_content.php',$data);
		$result['content'] = ob_get_clean();
		echo json_encode($result);
		return;
	}

	public function broken(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه تمامی آلبوم های شکسته را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$data['page_title'] = 'تمامی آلبومی شکسته';
		$data['search_id_name'] = 'search-album-broken';
		view::render('album/broken_album.php',$data);
	}

	public function check_broken($start_album_id,$end_album_id){
		for ($i = $start_album_id ; $i <= $end_album_id ; $i++){
			$album_infp = AlbumModel::getInfo($i);
			if (empty($album_infp)){
				dump('album id :' . $i . ' not found');
			}else{
				$tracks_info = TrackModel::getTotalTrackAlbum($album_infp['ex_id']);
				$base_path = getcwd() . '/' . getAddresByCRC($album_infp['crc']) .'/' .  $album_infp['crc'] . '-hq/';

				if(!empty($tracks_info)){
					foreach ($tracks_info as $track_info){
						$file_info = json_decode($track_info['fileInfo'],true);
						$music_file_name = $file_info['hqName'];
						if (file_exists($base_path . $music_file_name)){
							if($track_info['status'] != '1'){
								TrackModel::updateStatusTrackWithTrackCrc($track_info['crc']);
								dump($track_info['crc'] . ' updated');
							}

						}else{
							dump('file : ' .$base_path . $music_file_name .  ' not exits');
						}
					}
				}
			}


		}
	}

	public function showLastAlbumQueue(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$lastAlbumQueue = AlbumModel::getLastAlbumQueue();
		$data['lastAlbumQueue'] = $lastAlbumQueue;

		ob_start();
		view::render_part('dashboard/album_queue.php',$data);
		$output['result'] = ob_get_clean();
		 echo json_encode($output);
		 return;
	}


	#تابع مادر برای دریافت اطلاعات آلبوم و تراک به صورت تکی
	public function get_special_album(){

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
			$output['redownload'] = false;
			$output['result'] = 'دسترسی شما برای انجام این عملیات محدود می باشد';
			echo json_encode($output);
			return;
		}

		if(isset($_POST['albumID']) AND !empty($_POST['albumID'])){
			$album_id = $_POST['albumID'];
		}else{
			$output['status'] = false;
			$output['redownload'] = false;
			$output['result'] = 'شماره آلبوم نامعتبر می باشد.';
			echo json_encode($output);
			return;
		}

		$act_des = 'یک درخواست برای دریافت یک آلبوم جدید از سایت هدف ارسال کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}


		$get_track_info = ckeckExit($_POST['trackDownload'],true);

		$output = $this->run_insert_album_info_o($album_id,$get_track_info);
		echo json_encode($output);
		return;
	}

	#نمایش صفحه اصلی جزئیات آلبوم
	public function details($album_id){
		if(!userAdmined()){
			redirectToLogin();
		}

		$album_info =  AlbumModel::getInfo($album_id);
		if (empty($album_info)){
			showErrorPageAdmin();
		}

		$act_des = 'جزئیات آلبوم  ' . $album_info['name'] . ' را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}



		$data['album_info'] =$album_info;
		$data['page_title'] = 'ویرایش آلبوم - ' . $album_info['name'];
		view::render('album/detail/detail_main.php',$data);
	}


	#نمایش سایر صفحات جزئیات آلبوم
	public function showAlbumPage(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$page_name = $_POST['showPage'];

		$album_id  = $_POST['albumID'];
		$album_info =  AlbumModel::getInfo($album_id);
		$data['album_info'] 	= $album_info;
		$data['tracks_info']  = TrackModel::getTotalTrackAlbum($album_info['ex_id']);


		if($page_name == 'edit'){
			$data['all_publisher'] = PublisherModel::getAllPublisher();
		}

		ob_start();
		view::render_part('album/detail/detail_' . $page_name . '.php',$data);
		$output['result'] = ob_get_clean();
		$output['status'] = true;
		echo json_encode($output);
		return;
	}

	public function change_album_info(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (!isset($_POST['album_id']) || !isset($_POST['album_dec']) || !isset($_POST['album_name']) || !isset($_POST['album_name_eng']) || !isset($_POST['album_publisher'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return;
		}

		$album_id 			= $_POST['album_id'];
		$album_name 		= $_POST['album_name'];
		$album_name_eng = $_POST['album_name_eng'];
		$album_dec 			= $_POST['album_dec'];
		$album_pubisher = $_POST['album_publisher'];
		$album_db_info 	= AlbumModel::getInfo($album_id);

		if (empty($album_dec) && empty($_POST['album_name']) && empty($_POST['album_name_eng']) && $album_pubisher == $album_db_info['publisherID'] ){
			$output['error']['status'] = true;
			$output['error']['message'] = 'اطلاعات آلبوم هیچ تغییری پیدا نکرده است';
			echo json_encode($output);
			return;
		}

		if(!empty($album_name) && $album_db_info['name'] != $album_name){
			$album_name_submit = $album_name;
		}else{
			$album_name_submit = $album_db_info['name'];
		}

		if(!empty($album_name_eng) && $album_db_info['album_name_eng'] != $album_name_eng){
			$album_name_eng_submit = $album_name_eng;
		}else{
			$album_name_eng_submit = $album_db_info['engName'];
		}

		if(!empty($album_dec)){
			$album_dec_submit = $album_dec;
		}else{
			$album_dec_submit = $album_db_info['description'];
		}

		if ($album_pubisher != $album_db_info['publisherID']){
			$album_publisher_submit = $album_pubisher;
		}else{
			$album_publisher_submit = $album_db_info['publisherID'];
		}

		AlbumModel::updateAlbumInfo($album_id,$album_name_submit,$album_name_eng_submit,$album_dec_submit,$album_publisher_submit);

		$output['error']['status'] = false;
		$output['error']['message'] = 'اطلاعات آلبوم با موفقیت ویرایش شد';
		echo json_encode($output);
		return;
	}

	public function newAlbum(){
		if(!userAdmined()){
			redirectToLogin();
		}

		if (!empty($_POST)){
			$this->check_new_album();
		}else{


			$data['all_publisher'] = '';
			$data['all_genre'] = '';
			$data['all_artist'] = OwnerModel::get_oweners_name_with_id();
			$data['all_tag'] = '';

			view::render('album/insert_new_album.php',$data);
		}
	}


	#گرفتن اطلاعات آلبوم از سایت بیپ تونز
	public function new_get_album_info_beep($album_id){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($album_id)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return;
		}

		$curl = curl_init();
		$addres = 'Newapi.beeptunes.com/public/agent/album/info?id='. $album_id;
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		return  $export;
	}


	#گرفتن اطلاعات آلبوم از سایت بیپ تونز
	public function get_album_info_beep($album_id){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($album_id)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return;
		}

		$curl = curl_init();
		$addres = "http://api.beeptunes.com/service/album/info";
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl,CURLOPT_POST,TRUE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-Beeptunes-Agent-Key: KEY'));
		curl_setopt($curl,CURLOPT_POSTFIELDS,"id=". $album_id);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$export = curl_exec($curl);
		curl_close($curl);
		$new_ex = json_decode($export,true);
		return  $new_ex;
	}


	#گرفتن فایل پیوست که شامل تصاویر است برای هر آلبوم بر اساس شماره آلبوم
	public function get_attachments($album_id){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($album_id)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}


		$curl = curl_init();
		$addres = "https://newapi.beeptunes.com/public/album/info/?albumId=" . $album_id;
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl,CURLOPT_POST,TRUE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-Beeptunes-Agent-Key: KEY'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$export = curl_exec($curl);
		curl_close($curl);
		$album = json_decode($export,true);

		if(!empty($album['attachments'])) {
			$attachments = array();
			foreach ($album['attachments'] as $file) {
				if ($file['name'] == 'مجموعه تصاویر آلبوم') {
					$attachments[] = $file;
				}
			}

			$attachmentInfo = "";
			if (empty($attachments[0])) {
				return;
			} else if(!isset($attachments[0]['url'])) {
				return;
			}else{
				$url = $attachments[0]['url'];
				$attachmentInfo['url'] = $url;
				$url = explode("/", $url);
				$attachmentInfo['name'] = end($url);
				return ($attachmentInfo);
			}

		}else{
			return;
		}
	}


	public function run_insert_album_info_o($external_id,$track_status_download){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($external_id)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$get_album_form_db = AlbumModel::searchByExternalID($external_id);
		if(!empty($get_album_form_db)){
			$output['status'] = false;
			$output['redownload'] = true;
			$output['result'] = 'قبلا آلبومی با شناسه ' .$external_id . ' در سیستم وارد شده است. شناسه این آلبوم در پایگاه داده عبارت است از:' . $get_album_form_db['id'];
			return $output;
		}

		$album_info = $this->get_album_info_beep($external_id);

		if(isset($album_info['error']) OR empty($album_info)){
			$output['status'] = false;
			$output['redownload'] = false;
			$output['result'] = 'خطایی رخ داد :' . $album_info['message'];
			return $output;
		}/*------------------------END IF album info error -------------------------------*/


		/*-------------------------GET & SET ALBUM INFO ----------------------------------*/
		$album_external_id 		= @ckeckExit($album_info['id']);
		$album_name 					= @ckeckExit($album_info['name']);
		$album_english_name 	= @ckeckExit($album_info['englishName']);
		$album_description 		= @ckeckExit($album_info['description']);
		$album_serial 				= @ckeckExit($album_info['serial']);
		$album_license 				= @ckeckExit($album_info['license']);
		$album_image 					= @ckeckExit($album_info['primaryImage']);
		$album_final_price 		= @ckeckExit($album_info['finalPrice']);
		$album_market_price 	= @ckeckExit($album_info['marketPrice']);
		$album_genre 					= @ckeckExit($album_info['genres']);
		$album_tags 					= @ckeckExit($album_info['tags']);
		$album_artists 				= @ckeckExit($album_info['artists']);
		$album_publisher 			= @ckeckExit($album_info['publisher']);
		$album_owners 				= @ckeckExit($album_info['owners']);
		$album_composers 			= @ckeckExit($album_info['composers']);
		$album_arrangers 			= @ckeckExit($album_info['arrangers']);
		$album_players 				= @ckeckExit($album_info['players']);
		$album_poets 					= @ckeckExit($album_info['poets']);
		$album_singers 				= @ckeckExit($album_info['singers']);
		$album_publish_date 	= @ckeckExit($album_info['publishDate'],true);
		$album_publish_year 	= @ckeckExit($album_info['publishYear'],true);
		$album_publish_month 	= @ckeckExit($album_info['publishMonth'],true);
		$album_featured 			= @ckeckExit($album_info['featured'],true);
		/*-------------------------GET & SET ALBUM INFO ----------------------------------*/
		if (empty($album_publish_date)){
			$album_publish_date = 'NULL';
		}

		if (empty($album_publish_year)){
			$album_publish_year = 0;
		}

		if (empty($album_publish_month)){
			$album_publish_month = 0;
		}

		if (empty($album_featured)){
			$album_featured = 0;
		}


		/*-------------------------GET & SET PUBLISHER INFO IN DATABASE-------------------*/
		if (isset($album_publisher)) {
			$instancePublisherController = new PublisherController();
			$albumPublisher = $instancePublisherController->actsPublisher($album_publisher);
			$publisher_code = implode(",", $albumPublisher);
		} else {
			$publisher_code = "";
		}

		/*-------------------------GET & SET GENRES INFO IN DATABASE-------------------*/
		if (isset($album_genre)) {
			$albumGenresInfo = $album_genre;
			$instanceGenreController = new GenreController();
			$albumGenres = $instanceGenreController->actsGenre($albumGenresInfo);
			$genres_code = implode(",", $albumGenres);
		} else {
			$genres_code = "";
		}

		/*-------------------------GET & SET TAGS INFO IN DATABASE-------------------*/
		if (isset($album_tags)) {
			$albumTagsInfo = $album_tags;
			$instanceTagController = new TagController();
			$albumTags = $instanceTagController->actsTag($albumTagsInfo);
			$tags_code = implode(",", $albumTags);
		} else {
			$tags_code = "";
		}

		/*-------------------------GET & SET OWNERS INFO IN DATABASE-------------------*/
		if (isset($album_owners)) {
			$albumOwnersInfo = $album_owners;
			$instanceOwnerController = new OwnerController();
			$albumOwners = $instanceOwnerController->actsOwner($albumOwnersInfo);
			$owners_code = implode(",", $albumOwners);
		} else {
			$owners_code = "";
		}

		/*-------------------------GET & SET COMPOSER INFO IN DATABASE-------------------*/
		if (isset($album_composers)) {
			$albumComposersInfo = $album_composers;
			$instanceComposersController = new ComposerController();
			$albumComposers = $instanceComposersController->actsComposer($albumComposersInfo);
			$composers_code = implode(",", $albumComposers);
		} else {
			$composers_code = "";
		}

		/*-------------------------GET & SET PLAYERS INFO IN DATABASE-------------------*/
		if (isset($album_players)) {
			$albumPlayersInfo = $album_players;
			$instancePlayerController = new PlayerController();
			$albumPlayers = $instancePlayerController->actsplayer($albumPlayersInfo);
			$players_code = implode(",", $albumPlayers);
		} else {
			$players_code = "";
		}

		/*-------------------------GET & SET ARRANGERS INFO IN DATABASE-------------------*/
		if (isset($album_arrangers)) {
			$albumArrangersInfo = $album_arrangers;
			$instanceArrangerController = new ArrangerController();
			$albumArrangers = $instanceArrangerController->actsarranger($albumArrangersInfo);
			$arrangers_code = implode(",", $albumArrangers);
		} else {
			$arrangers_code = "";
		}

		/*-------------------------GET & SET POETS INFO IN DATABASE-------------------*/
		if (isset($album_poets)) {
			$albumPoetsInfo = $album_poets;
			$instancePoetController = new PoetController();
			$albumPoets = $instancePoetController->actspoet($albumPoetsInfo);
			$poets_code = implode(",", $albumPoets);
		} else {
			$poets_code = "";
		}

		/*-------------------------GET & SET SINGRES INFO IN DATABASE-------------------*/
		if (isset($album_singers)) {
			$albumSingersInfo = $album_singers;
			$instanceSingerController = new SingerController();
			$albumSingers = $instanceSingerController->actssinger($albumSingersInfo);
			$singers_code = implode(",", $albumSingers);
		} else {
			$singers_code = "";
		}

		/*-------------------------SET ALBUM INFORMATION IN DATABASE-------------------*/
		AlbumModel::insertInfoAlbumPrimary($album_external_id, $publisher_code, $album_name, $album_english_name, $album_description, $album_serial, $album_license, $album_market_price, $album_final_price, $album_publish_date, $tags_code, $genres_code, $owners_code, $composers_code, $players_code, $arrangers_code, $poets_code, $singers_code, $album_publish_year, $album_publish_month, $album_featured);

		$album_info_db = AlbumModel::searchByExternalID($album_external_id);

		/*-------------------------GET OWNER INFORMATION FRON DATABASE-------------------*/
		$owner_name = implodForCRC($album_info_db['owners']);

		/*-------------------------SET OWNER FFOLDER -----------------------------------*/
		$artist_folder = setCRCOwner($owner_name);

		/*-------------------------SET ALBUM CRC -------------------------------------------------*/
		$album_crc = setCRC($album_info_db);


		/*-------------------------CREATE PUBLISHER FOLDER ---------------------------------------*/
		$publisher_folder = 'media/albums/' . $publisher_code;
		createDir($publisher_folder);

		/*-------------------------CREATE ALBBUM FOLDER -------------------------------------------*/
		$url_album_folder = $publisher_folder . '/' . $album_crc;
		createDir($url_album_folder);

		/*-------------------------SET & CREATE GALLERY & TRACK FOLDER -----------------------------*/
		$url_album_gallery 	= $url_album_folder . '/' . $album_crc .'-Gall';
		$url_track_hq 			= $url_album_folder . '/' . $album_crc .'-hq';
		$url_track_lq 			= $url_album_folder . '/' . $album_crc .'-lq';
		createDir($url_album_gallery);
		createDir($url_track_hq);
		createDir($url_track_lq);

		/*-------------------------COPY ALBUM IMAGE IN TRACK FOLDER ----------------------------------*/
		copyFile($album_image,$url_track_hq .'/' . $album_crc . '-hq.jpg');
		copyFile(getcwd() . '/' . $url_track_hq .'/' . $album_crc . '-hq.jpg',$url_track_lq .'/' . $album_crc . '-lq.jpg');

		/*-------------------------SET ALBUM IMAGE INFO FOR DATABASE --------------------------------*/
		$primary_image_hq['path'] = $url_track_hq;
		$primary_image_hq['name'] = $album_crc . '-hq';
		$primary_image_hq['ext'] = '.jpg';
		$primary_imager_hq = json_encode($primary_image_hq);

		$primary_image_lq['path'] = $url_track_lq;
		$primary_image_lq['name'] = $album_crc . '-lq';
		$primary_image_lq['ext'] = '.jpg';
		$primary_imager_lq = json_encode($primary_image_lq);

		/*-------------------------COPY ALBUM GALLERY IMAGE ----------------------------------------*/
		$attachmentInfo = $this->get_attachments($album_info_db['ex_id']);
		if(!empty($attachmentInfo)){
			copyFile($attachmentInfo['url'],$url_album_gallery .'/'.$attachmentInfo['name']);
		}


		/*-------------------------SET ALBUM GALLERY IMAGE INFO DATABES -----------------------------*/
		$gallery_file['path'] =$url_album_gallery;
		$gallery_file['name'] =$attachmentInfo['name'];
		$gallery_filer = json_encode($gallery_file);

		/*-------------------------INSER FINAL ALBUM INFO IN DATABASE-----------------------------------*/
		AlbumModel::insertInfoAlbumFinal($album_info_db['id'],$album_crc,$primary_imager_hq,$primary_imager_lq,$gallery_filer);


		/*-------------------------DOWNLOAD ALBUM TRACK-------------------------------------------------*/
		if($track_status_download == 'true') {
			$track_brige = new TrackController();
			$track_result = $track_brige->run_get_track_full_info_by_album_id($album_info_db['ex_id'],$url_track_hq,$url_track_lq,$album_crc);
			$output['track'] = true;
			$output['track_status'] = $track_result['status'];
			$output['track_result'] = $track_result['result'];
		}else{
			$output['track'] = false;
		}

		$output['status'] = true;
		$output['result'] = 'اطلاعات آلبوم ' . $external_id . ' به صورت کامل ذخیره شد. شناسه این آلبوم برابر است با: ' . $album_info_db['id'];

		$act_des = 'اطلاعات آلبوم جدیدی به نام  ' . $album_name . ' را از سایت هدف دریافت کرد';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		return( $output);
	}


	public function get_album_info(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		$curl = curl_init();
		$addres = "http://api.beeptunes.com/service/agent-services/list/";
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl,CURLOPT_POST,TRUE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-Beeptunes-Agent-Key: KEY'));

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		return ( ( $export['albums']));
	}

	#گرفتن تعداد صفحات آلبوم های در دسترس
	private function get_count_pagination_albums(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$curl = curl_init();
		$addres = "newapi.beeptunes.com/public/agent/search/album?page=1";
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		return (  $export['pagination']);
	}


	#گرفتن اطلاعات تمامی آلبوم های در دسترس بیپ تونز
	public function new_get_album_infor($pageNumber){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($pageNumber)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$curl = curl_init();
		$addres = "newapi.beeptunes.com/public/agent/search/album?page=$pageNumber";
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		return (  $export['data']);
	}


	public function check_new_api_get_album(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (!isSupperAdmin()){
			$output['result'] = 0;
			echo json_encode($output);
			return;
		}

		$count_pagination = $this->get_count_pagination_albums();

		$j = 0;
		$broken = 0;
		for($i = 1 ; $i <=$count_pagination['numPages'] ; $i++){
			ini_set('max_execution_time', 1800); //300 seconds = 5 minutes
			$album_info = $this->new_get_album_infor($i);
			foreach ($album_info as $new_album){
				$album_exits = AlbumModel::searchByExternalID($new_album['id']);
				$album_queue = AlbumModel::searchAlbumQueueByExternalID($new_album['id']);
				if(empty($album_exits) AND empty($album_queue)){
					$current_time = get_current_time();
					AlbumModel::netItemAlbumQueue($new_album['id'],$new_album['name'],$new_album['englishName'],$current_time);
					$j++;
				}
			}
		}

		$output['result'] = $j;
		echo json_encode($output);
		return;
	}


	public function getSlowlyAlbum(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$allalbum = $this->get_album_info();
		$listAlbums = array();
		foreach ($allalbum as $newalbum){
			$record = AlbumModel::searchByExternalID($newalbum['album']['id']);
			if(empty($record)){
				$listAlbums[] = $newalbum['album']['id'];
			}
		}
		return ($listAlbums);
	}


	#این متد برای آلبوم هایی مورد استفاده قرار می گیرد که اطلاعات آن ها در سیستم ناقص ثبت شده است. مثلا crc برای انها وجود نداشته است و بالطبع پوشه ای در سیستم برای آن ها ثبت نشده!
	public function run_complate_album_info($album_external_id,$publisher_code){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($album_external_id) OR empty($publisher_code)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$album_info_db = AlbumModel::searchByExternalID($album_external_id);
		$album_info = $this->get_album_info_beep($album_external_id);


		$album_image 					= @ckeckExit($album_info['primaryImage']);
		/*-------------------------GET OWNER INFORMATION FRON DATABASE-------------------*/
		$owner_name = implodForCRC($album_info_db['owners']);

		/*-------------------------SET OWNER FFOLDER -----------------------------------*/
		$artist_folder = setCRCOwner($owner_name);

		/*-------------------------SET ALBUM CRC -------------------------------------------------*/
		$album_crc = setCRC($album_info_db);


		/*-------------------------CREATE PUBLISHER FOLDER ---------------------------------------*/
		$publisher_folder = 'media/albums/' . $publisher_code;
		createDir($publisher_folder);
		dump('create folder: '. $publisher_folder);

		/*-------------------------CREATE ALBBUM FOLDER -------------------------------------------*/
		$url_album_folder = $publisher_folder . '/' . $album_crc;
		createDir($url_album_folder);
		dump('create folder: '. $url_album_folder);

		/*-------------------------SET & CREATE GALLERY & TRACK FOLDER -----------------------------*/
		$url_album_gallery 	= $url_album_folder . '/' . $album_crc .'-Gall';
		$url_track_hq 			= $url_album_folder . '/' . $album_crc .'-hq';
		$url_track_lq 			= $url_album_folder . '/' . $album_crc .'-lq';
		createDir($url_album_gallery);
		createDir($url_track_hq);
		createDir($url_track_lq);
		dump('create folder: '. $url_album_gallery);
		dump('create folder: '. $url_track_hq);
		dump('create folder: '. $url_track_lq);
		/*-------------------------COPY ALBUM IMAGE IN TRACK FOLDER ----------------------------------*/
		copyFile($album_image,$url_track_hq .'/' . $album_crc . '-hq.jpg');
		copyFile(getcwd() . '/' . $url_track_hq .'/' . $album_crc . '-hq.jpg',$url_track_lq .'/' . $album_crc . '-lq.jpg');

		/*-------------------------SET ALBUM IMAGE INFO FOR DATABASE --------------------------------*/
		$primary_image_hq['path'] = $url_track_hq;
		$primary_image_hq['name'] = $artist_folder . '-hq';
		$primary_image_hq['ext'] = '.jpg';
		$primary_imager_hq = json_encode($primary_image_hq);

		$primary_image_lq['path'] = $url_track_lq;
		$primary_image_lq['name'] = $artist_folder . '-lq';
		$primary_image_lq['ext'] = '.jpg';
		$primary_imager_lq = json_encode($primary_image_lq);

		/*-------------------------COPY ALBUM GALLERY IMAGE ----------------------------------------*/
		$attachmentInfo = $this->get_attachments($album_info_db['ex_id']);
		copyFile($attachmentInfo['url'],$url_album_gallery .'/'.$attachmentInfo['name']);

		/*-------------------------SET ALBUM GALLERY IMAGE INFO DATABES -----------------------------*/
		$gallery_file['path'] =$url_album_gallery;
		$gallery_file['name'] =$attachmentInfo['name'];
		$gallery_filer = json_encode($gallery_file);

		/*-------------------------INSER FINAL ALBUM INFO IN DATABASE-----------------------------------*/
		AlbumModel::insertInfoAlbumFinal($album_info_db['id'],$album_crc,$primary_imager_hq,$primary_imager_lq,$gallery_filer);

		/*-------------------------DOWNLOAD ALBUM TRACK-------------------------------------------------*/

		$output['result'] = 'اطلاعات آلبوم ' . $album_external_id . ' به صورت کامل ذخیره شد. شناسه این آلبوم برابر است با: ' . $album_info_db['id'];

		dump( $output);
	}


	public function renameprimaryImage($start,$to){
		if(!userAdmined()){
			redirectToLogin();
		}

		for($i = $start;$i < $to ; $i++){
			$records = AlbumModel::getprimaryImageInfo($i);
			if(empty($records)){
				dump('Album with id: ' . $i . ' not find');
				continue;
			}

			$imagq_hq_info = json_decode($records['primaryImagePathHQ'],true);
			$image_hq_path = explode('/',$imagq_hq_info['path']);
			$image_hq_new_name = end($image_hq_path);


			$renameprimaryImageHQ['ext'] = $imagq_hq_info['ext'];
			$renameprimaryImageHQ['path'] = $imagq_hq_info['path'];
			$renameprimaryImageHQ['name'] = $image_hq_new_name;

			$imagq_lq_info = json_decode($records['primaryImagePathLQ'],true);
			$image_lq_path = explode('/',$imagq_lq_info['path']);
			$image_lq_new_name = end($image_lq_path);

			$renameprimaryImageLQ['ext'] = $imagq_lq_info['ext'];
			$renameprimaryImageLQ['path'] = str_replace('hq','lq',$imagq_lq_info['path']);
			$renameprimaryImageLQ['name'] = $image_lq_new_name;

			$imqgeHqInfo = json_encode($renameprimaryImageHQ,true);
			$imqgeLqInfo = json_encode($renameprimaryImageLQ,true);
			AlbumModel::updateprimaryImageInfo($i,$imqgeHqInfo,$imqgeLqInfo);
			dump('Album Info :' . $i);
		}
	}


	public function copyIndexFileToalbumFolder($start,$to){
		if(!userAdmined()){
			redirectToLogin();
		}

		for($i = $start ; $i < $to ; $i++){
			$album_info = AlbumModel::getAlbumCrcByID($i);
			$album_dir    = '/media/albums/' . $album_info['publisherID'] . '/'  . $album_info['crc'];
			$hqFile_dir   = '/media/albums/' . $album_info['publisherID'] . '/'  . $album_info['crc'] . '/' . $album_info['crc']  . '-hq';
			$gallFile_dir = '/media/albums/' . $album_info['publisherID'] . '/'  . $album_info['crc'] . '/' . $album_info['crc']  . '-Gall';


			copy(getcwd() . '/media/index.html', getcwd() . $album_dir .'/index.html');
			copy(getcwd() . '/media/index.html', getcwd() . $hqFile_dir . '/index.html');
			copy(getcwd() . '/media/index.html', getcwd() . $gallFile_dir . '/index.html');
			dump('Copy Successfully: ' . $i);
		}
	}


	public function transfer(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$owner_slection = OwnerModel::getOwnerSelections();
		$exp = new ExportController();
		foreach ($owner_slection as $owner_slection_info){
			ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

			$ownerAlbums = AlbumModel::getAlbumWithOwnerId($owner_slection_info['owner_id']);

			foreach ($ownerAlbums as $all_albums) {
				$track_full_info = TrackModel::get_full_track_info_with_album_id($all_albums['ex_id']);
				if (count($track_full_info) <= 0) {
					dump($all_albums['ex_id'] . '    - Track Count 0');
				} else{
					$album_crc = $all_albums['crc'];
					$baseFolder = '/media/transfer/';
					$albumFolder = '/media/transfer/' . $album_crc;

					$hqFileAddress = '/media/albums/' . $all_albums['publisherID'] . '/' . $album_crc . '/' . $album_crc . '-hq';
					$hqPrimeryImage = '/media/albums/' . $all_albums['publisherID'] . '/' . $album_crc . '/' . $album_crc . '-hq' . '/' . $album_crc . '-hq.jpg';

					$publisher_info = PublisherModel::get_publisher_info_by_id($all_albums['publisherID']);

					#SET IMAGE PUBLISHER EXTENSIONS
					$publisher_image_info = json_decode($publisher_info['picture'], true);
					if (isset($publisher_image_info['ext']) AND !empty($publisher_image_info['ext'])) {
						$publisher_image_ext = $publisher_image_info['ext'];
					} else {
						$publisher_image_ext = '.jpg';
					}

					$publisherImage = '/media/publisher/' . $publisher_info['ex_id'] . '/' . $publisher_info['ex_id'] . $publisher_image_ext;


					#CREATE BASE FOLDER TRANSFET
					createDir($baseFolder);

					#CREATE ALBUM FOLDER(WITH CRC)
					createDir($albumFolder);


					//createDir($albumFolder . '/' .$album_crc);
					$hqfile = ($albumFolder . '/' . $album_crc . '-hq');

					createDir($hqfile);
					if (file_exists(getcwd() . $hqFileAddress)) {
						$mp3Files = scandir(getcwd() . $hqFileAddress);
					} else {
						$mp3Files = array();
					}

					if ($mp3Files > 2) {
						foreach ($mp3Files as $mp3File) {
							if ($mp3File != '.' AND '..' AND strHas('.mp', $mp3File)) {
								copy(getcwd() . $hqFileAddress . '/' . $mp3File, getcwd() . $hqfile . '/' . $mp3File);
							}
						}
					}


					#COPY HQ FOLDER
					//@copy(getcwd() .$hqFileAddress, getcwd() .  $hqfile );

					#COPY PRIMERY IMAGE
					@copy(getcwd() . $hqPrimeryImage, getcwd() . $albumFolder . '/' . $album_crc . '.jpg');

					#COPY PPUBLISHER IMAGE
					@copy(getcwd() . $publisherImage, getcwd() . $albumFolder . '/' . 'publisher-' . $publisher_info['id'] . $publisher_image_ext);


					#COPY OWNER IMAGES
					$owners = explode(',', $all_albums['owners']);
					if (isset($owners[1])) {
						foreach ($owners as $owner_id) {
							$owner_info = OwnerModel::get_ownerByID($owner_id);
							$owner_image_info = json_decode($owner_info['artistImage'], true);
							$ownerImage = '/' . $owner_image_info['path'] . '/' . $owner_image_info['name'] . $owner_image_info['ext'];
							@copy(getcwd() . "/" . $ownerImage, getcwd() . "/" . $albumFolder . '/' . 'artist-' . $owner_info['id'] . $owner_image_info['ext']);
						}
					} else {
						$owner_info = OwnerModel::get_ownerByID($owners[0]);
						$owner_image_info = json_decode($owner_info['artistImage'], true);
						$ownerImage = '/' . $owner_image_info['path'] . '/' . $owner_image_info['name'] . $owner_image_info['ext'];
						@copy(getcwd() . "/" . $ownerImage, getcwd() . "/" . $albumFolder . '/' . 'artist-' . $owner_info['id'] . $owner_image_info['ext']);
					}


					$exp->get_info_full_song($track_full_info);
					OwnerModel::setSuccessStatus($owner_slection_info['id']);

				}#----------------------------------- END ALL ALBUMS


			}#----------------------------End Foreach Main Owner
		}

	}


	public function transferEXFile(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$exe = new ExportController();


		$mainScan = '/media/transfer/';
		$direction = getcwd().'/media/tracksSelection/';

		$scanMainDir = scandir(getcwd() . $mainScan);
		foreach ($scanMainDir as $albumBaseFolder){

			if ($albumBaseFolder != '.' AND $albumBaseFolder !=  '..'){
				$hqFileAddress = $mainScan . $albumBaseFolder . '/' . $albumBaseFolder .'-hq';
				$scanHqFolder = scandir(getcwd() . $hqFileAddress);


				foreach ($scanHqFolder as $scanHqFile){
					if ($scanHqFile != '.' AND $scanHqFile !=  '..'){

						if (strHas('.mp3',$scanHqFile)){
							$track_file_info 		= explode('.mp',$scanHqFile);
							$track_file_name 		= $track_file_info[0];
							$track_crc_info 		= explode('-hq',$track_file_name);
							$track_crc				 	= $track_crc_info[0];

							$track_info = TrackModel::InnerJoinWithCrc($track_crc);
							$exe->get_info_track_report($track_info);
							dump('File Com');
						}

					}

				}#--------------------END FOREACH HQFILE SCAN
			}
		}#------------------------END FOREACH ALBUM FOLDER
	}


	public function updateStatusAlbumQueueItem(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}
		if (!isset($_POST['albumID']) OR empty($_POST['albumID'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '404';
			$output['error']['type'] = 'ENTITY_NOT_FOUND';
			$output['error']['message'] = 'Entity Not Found';
			echo json_encode($output);
			return ;
		}

		$album_exid = $_POST['albumID'];
		AlbumModel::deleteAlbumQueueItem($album_exid);
		$output['status'] = true;
		echo json_encode($output);
		return;
	}


	public function deleteAlbumQueueItem(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (!isset($_POST['albumID']) OR empty($_POST['albumID'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '404';
			$output['error']['type'] = 'ENTITY_NOT_FOUND';
			$output['error']['message'] = 'Entity Not Found';
			echo json_encode($output);
			return ;
		}

		$album_exid = $_POST['albumID'];
		$album_name = $_POST['albumName'];

		AlbumModel::deleteAlbumQueueItem($album_exid);

		$act_des = 'آلبوم ' . $album_name . ' را از فهرست آلبوم های در انتظار حذف کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$output['status'] = true;
		echo json_encode($output);
		return;
	}


	public function unlink_album(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (!isset($_POST['albumid']) OR empty($_POST['albumid'])){
			$output['status'] = false;
			$output['msg'] = 'هیچ پارامتری برای این درخواست شما تنظیم نشده است!';
			echo json_encode($output);
			return;
		}

		$album_id = $_POST['albumid'];
		if (is_array($album_id)){
			$album_id = implode(',',$album_id);
		}



		if(strHas(',',$album_id)){
			$album_sps = explode(',',$album_id);
			foreach ($album_sps as $album_sp){
				$album_info = AlbumModel::getInfo($album_sp);
				$album_tracks = TrackModel::getTrackByAlbumID($album_info['ex_id']);
				foreach ($album_tracks as $album_track_info){
					TrackModel::deleteTrackItem($album_track_info['id']);
				}
				delAlbumFolder($album_info['crc']);
			}

			AlbumModel::deleteAlbums($album_id);

			$act_des = 'اطلاعات آلبوم  ' . $album_info['name'] . ' را به صورت کامل حذف کرد.';
			$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
			if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
				userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
			}

			$output['msg'] = 'آلبوم ها با موفقیت حذف گردیدند.در حال بروزرسانی صفحه...';
		}else{
			#حذف تراک های آلبوم و پوشه آلبوم
			$album_info = AlbumModel::getInfo($album_id);
			$album_tracks = TrackModel::getTrackByAlbumID($album_info['ex_id']);
			foreach ($album_tracks as $album_track_info){
				TrackModel::deleteTrackItem($album_track_info['id']);
			}
			delAlbumFolder($album_info['crc']);


			AlbumModel::deleteAlbum($album_id);

			$act_des = 'اطلاعات آلبوم  ' . $album_info['name'] . ' را به صورت کامل حذف کرد.';
			$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
			if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
				userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
			}

			$output['msg'] = 'آلبوم با موفقیت حذف گردید. تا چند لحظه دیگر به مدیریت آلبوم ها منتقل می شوید.';
		}
		$taninAppConfig = new taninAppConfig();
		$output['status'] = true;
		$output['redirect'] = $taninAppConfig->base_url . 'album/allAlbums/';
		$output['time'] = 2000;
		echo json_encode($output);
		return;


	}


	public function check_tracks_one_album(){
		$album_id = $_POST['albumID'];
		if (empty($album_id)){
			$output['status'] = false;
			$output['msg'] = 'پارامتر های دریافتی نامعتبر می باشد';
		}
		$trackController = new TrackController();
		$album_info = AlbumModel::getInfo($album_id);

		$count_track_in_db 			= count( TrackModel::getTotalTrackAlbumDownloaded($album_info['ex_id']));
		$count_track_in_beep 		= count($trackController->new_get_album_tracks($album_info['ex_id']));
		if($count_track_in_db  != $count_track_in_beep){
			$output['broken'] 		= true;
			$output['album_id'] = $album_info['ex_id'];
		}else{
			$output['broken'] = false;
		}

		$act_des = 'اطلاعات آلبوم  ' . $album_info['name'] . ' را با سایت هدف مورد بررسی قرار داد';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		echo json_encode($output);
		return;

	}


	public function deleteAlbumBrokenItem(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}
		if (!isset($_POST['albumID']) OR empty($_POST['albumID'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '404';
			$output['error']['type'] = 'ENTITY_NOT_FOUND';
			$output['error']['message'] = 'Entity Not Found';
			echo json_encode($output);
			return ;
		}

		$album_exid = $_POST['albumID'];
		$album_name = $_POST['albumName'];

		AlbumModel::deleteAlbumBrokenItem($album_exid);

		$act_des = 'آلبوم ' . $album_name . ' را از فهرست آلبوم های شکسته حذف کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
		}

		$output['status'] = true;
		echo json_encode($output);
		return;
	}

	#حذف تمامی فایل ها و اطلاعات تراک های یک آلبوم
	public function deleteHardAllTracksAlbum($album_id_injection = '') {
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if(isset($_POST['albumID']) AND !empty($_POST['albumID'])){
			$album_id = $_POST['albumID'];
		}else{
			$album_id = $album_id_injection;
		}
		if (!empty($album_id)){



			$album_info_complate = AlbumModel::searchByExternalID($album_id);

			if(empty($album_info_complate)){
				$output['status'] = false;
				$output['result'] = 'این تراک دارای آلبوم در پیاگاه داده نمی باشد. ابتدا آلبوم را اضافه کنید!';
				echo json_encode($output);
				return;
			}



			$tracks_in_db = TrackModel::getTotalTrackAlbumWithID($album_id);
			$album_info = AlbumModel::getAlbumCrc($album_id);
			$album_file_zip_address = getcwd() . '/' . getAddresByCRC($album_info['crc']) . '/' . $album_info['crc'] . '.zip' ;
			$album_file_exl_address = getcwd() . '/' . getAddresByCRC($album_info['crc']) . '/' . $album_info['crc'] . '-TapSong.xlsx' ;



			foreach ($tracks_in_db as $tracks_in_db_info ){
				$track_file_info = json_decode($tracks_in_db_info['fileInfo'],true);
				$track_file_address = getcwd() . '/' . $track_file_info['hqPath'] . '/' .$track_file_info['hqName'];

				#حذف فایل های موزیک از پوشه البوم
				if (file_exists($track_file_address)){
					unlink($track_file_address);
				}
			}

			#حذف فایل zip آلبوم
			if (file_exists($album_file_zip_address)){
				unlink($album_file_zip_address);
			}

			#حذف فایل اکسل آلیوم
			if (file_exists($album_file_exl_address)){
				unlink($album_file_exl_address);
			}

			TrackModel::deleteAllTracksAlbum($album_id);

			$publisher_folder = 'media/albums/' . $album_info['publisherID'];
			$url_album_folder = $publisher_folder . '/' . $album_info['crc'];
			$url_album_gallery 	= $url_album_folder . '/' . $album_info['crc'] .'-Gall';
			$url_track_hq 			= $url_album_folder . '/' . $album_info['crc'] .'-hq';
			$url_track_lq 			= $url_album_folder . '/' . $album_info['crc'] .'-lq';

			$TrackBridge = new TrackController();
			$output = $TrackBridge->run_get_track_full_info_by_album_id($album_id, $url_track_hq, $url_track_lq, $album_info['crc']);


			$act_des = 'اطلاعات آلبوم  ' . $album_info['name'] . ' را مجدد از سایت هدف دریافت کرد';
			$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
			if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
				userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'album',$act_des,get_current_time());
			}

		}else{
			$output['status'] = false;
			$output['result'] = 'شناسه آلبوم وارد شده نامعتبر می باشد!';
		}
		echo json_encode($output);
		return;
	}


	public function check_broken_album(){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}



		$all_album_inserted_db = AlbumModel::getAllAlbums();
		$only_albums_need_check = array();

		foreach ($all_album_inserted_db as $album_inserted_db){
			$result_search_broken_album = AlbumModel::searchAlbumBrokenByExternalID($album_inserted_db['ex_id']);

			if (empty($result_search_broken_album)){
				$only_albums_need_check[] = $album_inserted_db;
			}
		}



		$broken =0;
		foreach ($only_albums_need_check as $album_info){
			ini_set('max_execution_time', 9800); //9000 seconds = 15 minutes

				$TrackBridge = new TrackController();
				$track_count_beep = count($TrackBridge->new_get_album_tracks($album_info['ex_id']));
				$track_count_tanin = count(TrackModel::getTotalTrackAlbumDownloaded($album_info['ex_id']));
				if ($track_count_beep != $track_count_tanin) {
					$current_time = get_current_time();
					AlbumModel::netItemAlbumBreak($album_info['ex_id'], $album_info['name'], $album_info['engName'], $current_time);
					$broken++;
				}
		}


		$output['broken'] = $broken;
		echo json_encode($output);
		return;
	}

	public function setAlbumTrackStatus($statr,$to){
		$change = 0;
		for ( $i = $statr ; $i <= $to ; $i++){
			$album_info = AlbumModel::getInfo($i);
			$all_album_track = TrackModel::getTotalTrackAlbum($album_info['ex_id']);
			foreach ($all_album_track as $album_track){
				$track_file_info = json_decode($album_track['fileInfo'],true);
				$track_file_address = getcwd() . $track_file_info['hqPath'] . '/' . $track_file_info['hqName'];
				if (file_exists($track_file_address)){
					TrackModel::setTrackStatus($album_track['id']);
					$change++;
				}else{
					TrackModel::setTrackStatusfail($album_track['id']);
				}
			}
		}

	}
}