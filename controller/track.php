<?php
class TrackController
{

	#تد نمایش صفحه تمامی آلبوم ها
	public function allTrack(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'صفحه تمامی موزیک های ثبت شده را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'track',$act_des,get_current_time());
		}



		$data['page_title'] = 'فهرست تراک های ثبت شده';
		$data['search_id_name'] = 'search-alltrack';
		view::render('track/all_track.php', $data);
	}


	public function getSpecialTrack(){
		if(!userAdmined()){
			redirectToLogin();
		}

		if(!isSupperAdmin()){
			showErrorPage500();
		}

		$act_des = 'صفحه دریافت یک تراک را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'track',$act_des,get_current_time());
		}


		$data['page_title'] = 'دریافت اطلاعات تراک های یک آلبوم';
		view::render('track/get_special_track.php', $data);
	}


	public function get_special_track(){
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
			$output['result'] = 'دسترسی شا برای انجام این عملیات محدود می باشد';
			echo json_encode($output);
			return;
		}


		if (isset($_POST['album_id']) AND !empty($_POST['album_id'])){
			$album_id = $_POST['album_id'];
			$album_info = AlbumModel::searchByExternalID($album_id);

			if(empty($album_info)){
				$output['status'] = false;
				$output['result'] = 'این تراک دارای آلبوم در پیاگاه داده نمی باشد. ابتدا آلبوم را اضافه کنید!';
				echo json_encode($output);
				return;
			}

			$publisher_folder = 'media/albums/' . $album_info['publisherID'];
			$url_album_folder = $publisher_folder . '/' . $album_info['crc'];
			$url_album_gallery 	= $url_album_folder . '/' . $album_info['crc'] .'-Gall';
			$url_track_hq 			= $url_album_folder . '/' . $album_info['crc'] .'-hq';
			$url_track_lq 			= $url_album_folder . '/' . $album_info['crc'] .'-lq';

			$act_des = 'یک درخواست برای دریافت یک تراک جدید از سایت هدف ارسال کرد.';
			$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
			if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
				userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'track',$act_des,get_current_time());
			}

			$output = $this->run_get_track_full_info_by_album_id($album_id, $url_track_hq, $url_track_lq, $album_info['crc']);

		}else{
			$output['status'] = false;
			$output['result'] = 'شناسه آلبوم وارد شده نامعتبر می باشد!';
		}
		echo json_encode($output);
		return;
	}


	public function details($trackid){

		if(!userAdmined()){redirectToLogin();}

		if (!isset($trackid)) {showErrorPageAdmin();}

		$track_info = TrackModel::get_track_info_with_album_info($trackid);
		if (empty($track_info)) {
			showErrorPageAdmin();
		}

		$act_des = 'جزئیات تراک ' . $track_info['track_name'] . ' را مشاهده کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'track',$act_des,get_current_time());
		}

		$data['track_info'] = $track_info;
		$data['page_title'] =  'جزئیات تراک - ' . $track_info['track_name'];
		view::render('track/detail/detail_main.php', $data);
	}


	public function showTrackPage(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}
		if (!isset($_POST['showPage']) OR !isset($_POST['trackID']) OR empty($_POST['showPage']) OR empty($_POST['trackID'])){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$page_name = $_POST['showPage'];
		$track_id  = $_POST['trackID'];
		$data['track_info'] 	= TrackModel::get_track_info_with_album_info($track_id);;
		ob_start();
		view::render_part('track/detail/detail_' . $page_name . '.php',$data);
		$output['result'] = ob_get_clean();
		$output['status'] = true;
		echo json_encode($output);
		return;
	}

	public function getTrackAjax(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$count = 10;
		$page_index = @ckeckExit($_POST['page_index'], true);
		$startCount = ($page_index - 1) * $count;
		$vauleSearch = $_POST['valueSearch'];

		if ($vauleSearch == 'false'){
			$tracks_info = TrackModel::getTrackLimit($startCount, $count);
			$track_count = TrackModel::getTracksCount();
		}else{
			$tracks_info = TrackModel::getTrackLimitWithSearch($vauleSearch,$startCount, $count);
			$track_count = TrackModel::getTracksCountWithSearch($vauleSearch);
		}




		$data['track_info'] = $tracks_info;
		$data['pageIndex'] = $page_index;
		$data['track_count'] = ceil($track_count / $count);


		ob_start();
		view::render_part('track/all_track_content.php', $data);
		$output['result'] = ob_get_clean();
		echo json_encode($output);
	}

	#  گرفتن اطلاعات تمامی تراک های یک آلبوم
	public function new_get_album_tracks($album_id){
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
		$addres = 'Newapi.beeptunes.com/public/agent/album/tracks?id=' . $album_id;
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl, CURLOPT_URL, $addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export, true);
		return $export;
	}


	#گرفتم اطلاعات کامل یک تراک
	private function new_get_track_info($track_id){
		$curl = curl_init();
		$addres = 'Newapi.beeptunes.com/public/agent/track/info?id=' . $track_id;
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl, CURLOPT_URL, $addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export, true);
		return $export;
	}


	#گرفتن لینک های دانلود تراک
	public function new_get_track_download_link($track_id){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($track_id)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}
		$curl = curl_init();
		$addres = 'Newapi.beeptunes.com/public/agent/track/download?id=' . $track_id;
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-BT-AGENT-SECRET:KEY'));
		curl_setopt($curl, CURLOPT_URL, $addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export, true);
		return ($export);
	}


	#گرفتن اطلاعات تراک های یک البوم و افزودن ان به دیتابیس.
	public function run_get_all_track_album_g($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}
		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for ($i = $start; $i < $to; $i++) {
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$allbum_info = AlbumModel::getInfo($i);

			if (empty($allbum_info)) {
				dump('چنین آلبومی در پایگاه داده ثبت نشده است   ' . $i);
				continue;
			}

			$album_external_id = $allbum_info['ex_id'];


			$tracks_info = $this->new_get_album_tracks($album_external_id);
			$get_track_mdb = TrackModel::getTrackInfoByAlbumID($album_external_id);
			if (empty($get_track_mdb)) {
				foreach ($tracks_info as $track) {
					$track_external_id = $track['id'];
					$track_name = @ckeckExit($track['name']);
					$track_english_name = @ckeckExit($track['englishName']);
					$track_duration_minutes = @ckeckExit($track['durationMinutes']);
					$track_duration_seconds = @ckeckExit($track['durationSeconds']);
					$track_duration = $track_duration_minutes . '.' . $track_duration_seconds;

					TrackModel::insertTrackPreInfo($track_external_id, $album_external_id, $track_name, $track_english_name, $track_duration);
					dump('تراک های آلبوم ' . $album_external_id . ' با موفقیت درج شدند');

				}/*------------------------------------------------ ---End Foreach-------------------------------*/

			} else {
				dump('اطلاعات آلبوم ' . $album_external_id . ' از قبل وجود دارد');
				continue;
			}

		}/*------------------------------------------------------End For----------------------------------*/
		dump('عملیات به اتمام رسید.');
	}


	#دریافت اطلاعات کامل هر تراک و تزریق آن به پایگاه داده
	public function run_get_full_information_track_g($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for ($i = $start; $i < $to; $i++) {
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$track_info = TrackModel::get_track_info($i);


			$track_external_id = $track_info['ex_id'];

			$track_info_complate = $this->new_get_track_info($track_external_id);

			$track_info_description = @ckeckExit($track_info_complate['lyrics']);
			$track_info_price = @ckeckExit($track_info_complate['price']);

			TrackModel::insertTrackPreInfoTwo($track_external_id, $track_info_description, $track_info_price);
			dump('اطلاعات تراک ' . $track_external_id . ' با موفقیت بروزرسانی شد');

		}/*------------------------------------------------------End For----------------------------------*/
	}

	#set download link track -- gorup!
	public function run_get_download_link_track_by_id_g($start, $to){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}


		for ($i = $start; $i < $to; $i++) {
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$track_info = TrackModel::get_track_info($i);

			if (empty($track_info)) {
				continue;
			}

			$track_external_id = $track_info['ex_id'];


			$track_link_download = $this->new_get_track_download_link($track_external_id);

			$track_L64_link = @ckeckExit($track_link_download['L64']['url']);
			$track_L64_Size = @ckeckExit($track_link_download['L64']['size']);

			$track_L128_link = @ckeckExit($track_link_download['L128']['url']);
			$track_L128_Size = @ckeckExit($track_link_download['L128']['size']);

			$track_H320_link = @ckeckExit($track_link_download['H320']['url']);
			$track_H320_Size = @ckeckExit($track_link_download['H320']['size']);

			$album_crc = AlbumModel::searchByID($track_info['album_id']);
			$album_crc = $album_crc['crc'];

			$basefileAddress = getAddresByCRC($album_crc);
			$hqfileAddress = $basefileAddress . '/' . $album_crc . '-hq';
			$lqfileAddress = $basefileAddress . '/' . $album_crc . '-lq';

			if (isset($track_link_download['H320']['url'])) {
				$track_name = $track_link_download['H320']['url'];
				$track_name = explode('filename=', $track_name);
				$track_name = end($track_name);
				$track_etensions = explode('.mp',$track_name);
				$track_etensions = end($track_etensions);
				$track_ext = '.mp' . $track_etensions;
			} else if (isset($track_link_download['L128']['url'])) {
				$track_name = $track_link_download['L128']['url'];
				$track_name = explode('filename=', $track_name);
				$track_name = end($track_name);
				$track_etensions = explode('.mp',$track_name);
				$track_etensions = end($track_etensions);
				$track_ext = '.mp' . $track_etensions;
			}

			$track_name = $track_info['crc'] .'-hq'. $track_ext;
			$fileInfo['hqPath'] = $hqfileAddress;
			$fileInfo['hqName'] = $track_name;
			$fileInfo['hqSize'] = $track_H320_Size;

			$fileInfo['lqPath'] = $lqfileAddress;
			$fileInfo['lqName'] = $track_name;
			$fileInfo['lqSize'] = $track_L128_Size;

			$fileInfo['llqPath'] = $lqfileAddress;
			$fileInfo['llqName'] = $track_name;
			$fileInfo['llqSize'] = $track_L64_Size;


			$fileInfor = json_encode($fileInfo);


			TrackModel::updateDownloadLinkTrack($track_external_id, $fileInfor, $track_H320_link, $track_L128_link, $track_L64_link);
			dump('Track upgraded: ' . $track_external_id);
		}/*------------------------------------------------------End For----------------------------------*/
	}


	public function run_get_download_link_track_by_id_s($track_info){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($track_info)) {
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$track_external_id = $track_info['ex_id'];


		$track_link_download = $this->new_get_track_download_link($track_external_id);
		if(isset($track_link_download['error'])){
			return 'در دریافت اطلاعات تراک ناتوان بودیم.';
		}

		$track_L64_link = @ckeckExit($track_link_download['L64']['url']);
		$track_L64_Size = @ckeckExit($track_link_download['L64']['size']);

		$track_L128_link = @ckeckExit($track_link_download['L128']['url']);
		$track_L128_Size = @ckeckExit($track_link_download['L128']['size']);

		$track_H320_link = @ckeckExit($track_link_download['H320']['url']);
		$track_H320_Size = @ckeckExit($track_link_download['H320']['size']);

		$album_crc = AlbumModel::searchByID($track_info['album_id']);
		$album_crc = $album_crc['crc'];

		$basefileAddress = getAddresByCRC($album_crc);
		$hqfileAddress = $basefileAddress . '/' . $track_info['album_id'] . '-hq';
		$lqfileAddress = $basefileAddress . '/' . $track_info['album_id'] . '-lq';

		if (isset($track_link_download['H320']['url'])) {
			$track_name = $track_link_download['H320']['url'];
			$track_name = explode('filename=', $track_name);
			$track_name = end($track_name);
		} else if (isset($track_link_download['L128']['url'])) {
			$track_name = $track_link_download['L128']['url'];
			$track_name = explode('filename=', $track_name);
			$track_name = end($track_name);
		}

		$fileInfo['hqPath'] = $hqfileAddress;
		$fileInfo['hqName'] = $track_name;
		$fileInfo['hqSize'] = $track_H320_Size;

		$fileInfo['lqPath'] = $lqfileAddress;
		$fileInfo['lqName'] = $track_name;
		$fileInfo['lqSize'] = $track_L128_Size;

		$fileInfo['llqPath'] = $lqfileAddress;
		$fileInfo['llqName'] = $track_name;
		$fileInfo['llqSize'] = $track_L64_Size;


		$fileInfor = json_encode($fileInfo);


		TrackModel::updateDownloadLinkTrack($track_external_id, $fileInfor, $track_H320_link, $track_L128_link, $track_L64_link);
		return ('Track upgraded: ' . $track_external_id);
	}

	#پاک کردن CRC تراک آلبوم هایی که همه تراک ها crc ندارند
	public function run_clean_crc_track_by_id($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for ($i = $start; $i < $to; $i++) {
			$album_info = AlbumModel::getInfo($i);
			$album_external_id = $album_info['ex_id'];
			$count_track_album_with_crc = TrackModel::getTracksWithCrc($album_external_id);
			$count_track_album_without_crc = TrackModel::getTracksWithoutCrc($album_external_id);
			if ($count_track_album_with_crc > 0 && $count_track_album_without_crc > 0) {
				$tracks_info = TrackModel::getTotalTrackAlbum($album_external_id);
				foreach ($tracks_info as $track_info) {
					TrackModel::clearTrackCrc($track_info['id']);
				}
			}
		}/*------------------------------------------------------End For----------------------------------*/
	}


	#گرفتن فایل موزیک ها بر اساس گرفتن شماره آلبوم و گرفتن فایل تراکک های آن آلبوم
	public function run_get_file_music_track_by_id($start, $to){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}


		$exphp = new ExportController();
		$zip = new CompressionController();
		for ($i = $start; $i < $to; $i++) {
			ini_set('max_execution_time', 999); //300 seconds = 5 minutes
			$album_info = AlbumModel::getInfo($i);

			$album_external_id = $album_info['ex_id'];
			$album_crc = @ckeckExit($album_info['crc']);

			$all_track_album = TrackModel::getTotalTrackAlbum($album_external_id);
			if (empty($all_track_album)) {
				dump('آلبوم شماره ' . $album_external_id . 'دارای تراک نمی باشد');
				continue;
			} else {
				$j = 0;
				foreach ($all_track_album as $track_info) {
					if($track_info['status'] != '1'){
						if ($track_info['hqLink'] == null OR empty($track_info['hqLink'])) {
							dump('تراک شماره ' . $album_external_id . 'لینک دانلود ندارد!');
							continue;
						}
						$len = strlen($album_crc);
						$new_crc = substr($album_crc, 1, $len);


						$track_id = $track_info['id'];
						$basefileAddress = getAddresByCRC($album_crc);
						$hqfileAddress = $basefileAddress . '/' . $album_crc . '-hq';
						$hqLinkDownload = $track_info['hqLink'];

						$j++;
						$new_crc = $j . $new_crc;

						$ext = explode('.', $hqLinkDownload);
						$ext = end($ext);

						copyFile($hqLinkDownload, $hqfileAddress . '/' . $new_crc . '-hq' . '.' . $ext);
						TrackModel::updateFinalTrack($track_id, $new_crc);
						$exphp->get_info_song($album_external_id, $j, $album_crc . '-hq/' . $new_crc . '-hq', $track_info['name']);
					}else{
						dump('اطلاعات تراک آلبوم شماره ' . $i. ' در سیستم به صورت کامل وجود دارد');
					}
				}/*--------------------------------------------------End Foreach-------------------------------*/
				if ($track_info['status'] != '1') {
					$exphp->get_info_album($album_external_id);
					$zip->createZipFile($basefileAddress, $hqfileAddress, $album_crc);
					dump('اطلاعات آلبوم شماره ' . $i . 'در سیستم ذخیره شد.');
				}
			}
		}/*------------------------------------------------------End For----------------------------------*/
	}


	#گرفتن فایل موزیک ها بر اساس گرفتن شماره آلبوم و گرفتن فایل تراکک های آن آلبوم برای یک آلبوم خاص!
	public function run_get_file_music_track_by_album_id($album_info){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($album_info)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$exphp = new ExportController();
		$zip = new CompressionController();
		ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

		$album_external_id = $album_info['ex_id'];
		$album_crc = @ckeckExit($album_info['crc']);

		$all_track_album = TrackModel::getTotalTrackAlbum($album_external_id);
		if (empty($all_track_album)) {
			return dump('آلبوم شماره ' . $album_external_id . 'دارای تراک نمی باشد');
		} else {
			$j = 0;
			foreach ($all_track_album as $track_info) {
				#if($track_info['status'] != '1'){
				if ($track_info['hqLink'] == null OR empty($track_info['hqLink'])) {
					return dump('تراک شماره ' . $album_external_id . 'لینک دانلود ندارد!');
				}
				$len = strlen($album_crc);
				$new_crc = substr($album_crc, 1, $len);


				$track_id = $track_info['id'];
				$basefileAddress = getAddresByCRC($album_crc);
				$hqfileAddress = $basefileAddress . '/' . $album_crc . '-hq';
				$hqLinkDownload = $track_info['hqLink'];

				$j++;
				$new_crc = $j . $new_crc;

				$ext = explode('.', $hqLinkDownload);
				$ext = end($ext);

				copyFile($hqLinkDownload, $hqfileAddress . '/' . $new_crc . '-hq' . '.' . $ext);
				TrackModel::updateFinalTrack($track_id, $new_crc);
				$exphp->get_info_song($album_external_id, $j, $album_crc . '-hq/' . $new_crc . '-hq', $track_info['name']);
				/*}else{
					dump('اطلاعات تراک آلبوم شماره ' . $i. ' در سیستم به صورت کامل وجود دارد');
				}*/
			}/*--------------------------------------------------End Foreach-------------------------------*/
			$exphp->get_info_album($album_external_id);
			$zip->createZipFile($basefileAddress, $hqfileAddress, $album_crc);
			dump('اطلاعات آلبوم شماره ' . $album_info['id'] . 'در سیستم ذخیره شد.');
		}
	}

	#گرفتن اطلاعات کامل موزیک و ثبت آن در پایگاه داده و دریافت فایل های موزیک
	public function run_get_track_full_info_by_album_id($album_external_id, $hq_path, $lq_path, $album_crc){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}
		if (empty($album_external_id) OR empty($hq_path) OR empty($lq_path) OR empty($album_crc)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$taninAppConfig = new taninAppConfig();
		/*-------------------------------------GET TRACK INFO FROM DATABASE----------------------------------*/
		$track_info_db = TrackModel::getTotalTrackAlbum($album_external_id);
		if (!empty($track_info_db)) {
			$output['status'] = false;
			$output['result'] = 'اطلاعات تراک های آلبوم شماره: ' . $album_external_id . ' در سستم وجود دارد!';
			return $output;
		}

		/*-------------------------------------GET TRACK INFO FROM taninapp----------------------------------*/
		$track_info = $this->new_get_album_tracks($album_external_id);
		if (isset($track_info['error'])) {
			$output['status'] = false;
			$output['result'] = 'هنگام دریافت تراک های آلبوم: ' . $album_external_id . ' خطایی رخ داده است.شرح خطا: ' . $track_info['error']['message'];
			return $output;
		}

		$s = 0;
		$len = strlen($album_crc);
		$track_crc = substr($album_crc, 1, $len);


		$exphp = new ExportController();
		$zip = new CompressionController();

		foreach ($track_info as $track_information) {
			ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

			/*-------------------------------------GET & SET  TRACK INFO----------------------------------*/
			$s++;
			$new_trackcrc = $s . $track_crc;

			$track_external_id = $track_information['id'];
			$track_orgname = @ckeckExit($track_information['name']);
			$track_english_name = @ckeckExit($track_information['englishName']);
			$track_description = @ckeckExit($track_information['lyrics']);
			$track_price = @ckeckExit($track_information['price']);
			$track_duration_minutes = @ckeckExit($track_information['durationMinutes'], true);
			$track_duration_seconds = @ckeckExit($track_information['durationSeconds'], true);
			$track_duration = $track_duration_minutes . '.' . $track_duration_seconds;


			/*-------------------------------------GET & SET  TRACK INFO FILE----------------------------------*/
			$track_link_download = $this->new_get_track_download_link($track_external_id);

			$track_L64_link = @ckeckExit($track_link_download['L64']['url']);
			$track_L64_Size = @ckeckExit($track_link_download['L64']['size']);

			$track_L128_link = @ckeckExit($track_link_download['L128']['url']);
			$track_L128_Size = @ckeckExit($track_link_download['L128']['size']);

			$track_H320_link = @ckeckExit($track_link_download['H320']['url']);
			$track_H320_Size = @ckeckExit($track_link_download['H320']['size']);



			if (isset($track_link_download['H320']['url'])) {
				$track_name = $track_link_download['H320']['url'];
				$track_name = explode('filename=', $track_name);
				$track_name = end($track_name);
				$track_etensions = explode('.mp',$track_name);
				$track_etensions = end($track_etensions);
				$track_ext = '.mp' . $track_etensions;

			} else if (isset($track_link_download['L128']['url'])) {
				$track_name = $track_link_download['L128']['url'];
				$track_name = explode('filename=', $track_name);
				$track_name = end($track_name);
				$track_etensions = explode('.mp',$track_name);
				$track_etensions = end($track_etensions);
				$track_ext = '.mp' . $track_etensions;
			}

			$track_name = $new_trackcrc . '-hq'. $track_ext;
			$fileInfo['hqPath'] = $hq_path;
			$fileInfo['hqName'] = $track_name;
			$fileInfo['hqSize'] = $track_H320_Size;

			$fileInfo['lqPath'] = $lq_path;
			$fileInfo['lqName'] = $track_name;
			$fileInfo['lqSize'] = $track_L128_Size;

			$fileInfo['llqPath'] = $lq_path;
			$fileInfo['llqName'] = $track_name;
			$fileInfo['llqSize'] = $track_L64_Size;

			$fileInfor = json_encode($fileInfo);
			$track_extensions = explode('.',$track_name);
			$track_ext = end($track_extensions);

			TrackModel::insertAlbumInfoComplated($track_external_id, $new_trackcrc, $album_external_id, $track_orgname, $track_english_name, $track_description, $fileInfor, $track_price, $track_duration, $track_H320_link, $track_L128_link, $track_L64_link);
			copyFile($track_H320_link,$hq_path . '/' . $new_trackcrc . '-hq.' . $track_ext);

			if(file_exists(getcwd() . '/' . $hq_path . '/' . $new_trackcrc . '-hq.' . $track_ext)){
				TrackModel::updateStatusTrackWithTrackCrc($new_trackcrc);
			}

			$exphp->getInfoSongForNewAlbum($album_external_id, $s, $album_crc . '-hq/' . $new_trackcrc . '-hq', $track_orgname);

		}/*-------------------------------------END FOREACH-------------------------------------------------*/

		$basefileAddress = getAddresByCRC($album_crc);
		$hqfileAddress = $basefileAddress . '/' . $album_crc . '-hq';

		$exphp->getInfoAlbumForNewAlbum($album_external_id);
		$zip->createZipFile($basefileAddress, $hqfileAddress, $album_crc);

		$zipFileAddress = $basefileAddress . '/' . $album_crc . '-hq.zip';

		$output['status'] = true;
		$output['result'] = "تراک های آلبوم $album_external_id با موفقیت دریافت شد!</br> برای دریافت فایل روی   <a href=".$taninAppConfig->base_url . $zipFileAddress." target='_blank'> این لینک</a> کلیک کنید ";
		return $output;
	}


	public function checkAlbumTrackCount($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}


		for ($i = $start; $i < $to; $i++) {
			$album_info = AlbumModel::getInfo($i);
			$album_external_id = $album_info['ex_id'];
			$count_track_in_taninapp = count($this->new_get_album_tracks($album_external_id));

			$count_track_in_my_db = count(TrackModel::getTotalTrackAlbum($album_external_id));


			if ($count_track_in_taninapp != $count_track_in_my_db) {
				dump(' This Track not Complated! - Track ID in taninapp is: ' . $album_external_id . ' Track Count in DB And in Beep : ' . $count_track_in_my_db . ' -- ' . $count_track_in_taninapp);
			} else {
				dump($count_track_in_taninapp . '--' . $count_track_in_my_db);
			}
		}/*------------------------------------------------------End For----------------------------------*/
	}


	public function get_count_tracks_album($albumID){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		if (empty($albumID)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}



		$curl = curl_init();
		$addres = "http://api.beeptunes.com/service/album/list-tracks";

		curl_setopt($curl, CURLOPT_URL, $addres);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'X-Beeptunes-Agent-Key: KEY'));

		curl_setopt($curl, CURLOPT_POSTFIELDS, "album=" . $albumID);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export, true);

		return (count($export));
	}


#متدی برای اینکه متوجه بشیم آیا تعداد تراک های دریافت شده با تراک های موجود در دیتابیس برابر است یا خیر. برای هر آلبوم! در صورت نابرابری موارد از نو دریافت خواهند شد!
	public function check_track_count($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for ($i = $start; $i < $to; $i++) {

			$album_info 				= AlbumModel::getInfo($i);
			$album_external_id 	= $album_info['ex_id'];
			$album_crc 					= $album_info['crc'];
			$track_cont_db 			= TrackModel::get_count_album_track_full_by_id($album_external_id);
			$path 							= getcwd() . '/' . getAddresByCRC($album_crc) . '/' . $album_crc . '-hq';
			$track_cont_file 		= getTrackCount($path);

			if ($track_cont_db != $track_cont_file) {
				dump('album id is: ' . $i . ' track in db :' . $track_cont_db . ' file is: ' . $track_cont_file);
				$files = getTrackCount($path, false);

				#حذف تراک های آلبوم ناقص دریافت شده!
				deletMp3Files($files);
				$zipfile = getcwd() . '/' . getAddresByCRC($album_crc) . '/' . $album_crc . '-hq.zip';
				$excfile = getcwd() . '/' . getAddresByCRC($album_crc) . '/' . $album_crc . '-TapSong.xlsx';

				# حذف فایل اکسل و فایل فشرده آلبومی که تراک آن ناقص دریافت شده است!
				deletSpecialFile($zipfile);
				deletSpecialFile($excfile);

				$this->run_get_file_music_track_by_album_id($album_info);
				dump('عملیات برای آلبوم شماره: ' . $i . ' به پایان رسید');
			} else {
				dump('اطلاعات آلبوم با شناسه :' . $i . ' تکمیل است!');
			}

		}

	}

	#متدی برای اینکه متوجه بشیم آیا تعداد تراک های دریافت شده با تراک های موجود در دیتابیس برابر است یا خیر. برای هر آلبوم!
	public function checkAlbumTrackCountOnly($start, $to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}
		for ($i = $start; $i < $to; $i++) {
			$album_info = AlbumModel::getInfo($i);
			$album_external_id = $album_info['ex_id'];
			$album_crc = ($album_info['crc']);
			$track_cont_db = TrackModel::get_count_album_track_full_by_id($album_external_id);
			$path = getcwd() . '/' . getAddresByCRC($album_crc) . '/' . $album_crc . '-hq';
			$track_cont_file = getTrackCount($path);

			if ($track_cont_db != $track_cont_file) {
				dump('album id is: ' . $i . ' track in db :' . $track_cont_db . ' file is: ' . $track_cont_file);
			}
		}

	}


	#ایجاد فایل اکسل جدید برای آلبوم ها بر اساس شماره آلبوم
	public function create_new_excel_file($start,$to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$exphp = new ExportController();

		for($i = $start ; $i < $to ; $i++){
			$album_info = AlbumModel::getInfo($i);
			$album_external_id = $album_info['ex_id'];
			$album_crc = ($album_info['crc']);

			$excfile = getcwd() . '/' . getAddresByCRC($album_crc) . '/' . $album_crc . '-TapSong.xlsx';

			# حذف فایل اکسل
			deletSpecialFile($excfile);

			$j = 0;
			$len = strlen($album_crc);
			$new_crc = substr($album_crc, 1, $len);

			$all_track_album = TrackModel::getTotalTrackAlbum($album_external_id);
			foreach ($all_track_album as $track_info) {
				$j++;
				$crc_new = $j . $new_crc;
				$exphp->get_info_song($album_external_id, $j, $album_crc . '-hq/' . $crc_new . '-hq', $track_info['name']);
			}
			$exphp->get_info_album($album_external_id);
		}
	}


	public function get_download_link_for_old_track(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$emptyTrack = TrackModel::getTracksHqLinkEmpty();
		foreach ($emptyTrack as $track){
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$status = $this->run_get_download_link_track_by_id_s($track);
			dump($status);
		}#--------------End For Each
	}

	#گرفتن آیدی تراک هایی که لینک دانلود آن ها دارای اشکال است.بر اساس آیدی تراک
	public function get_bad_link_track($strat,$to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		$badList = array();
		for($i = $strat ; $i< $to;$i++ ){
			$track_info = TrackModel::gethqLinkTrack($strat);
			if (empty($track_info)){
				continue;
			}
			$hqLink 	= $track_info['hqLink'];
			$track_id = $track_info['ex_id'];

			if(strHas('clodd',$hqLink)){
				$badList[] = $track_id;
			}
		}#End For!
		dump($badList);
	}


	public function update_track_file_info($start,$to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for ($i = $start ; $i <$to;$i++){
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$track_info = TrackModel::get_track_exits_info($i);
			if (empty($track_info)){
				continue;
			}



			$ext_file = explode('.mp',$track_info['hqLink']);
			$ext_file = end($ext_file);
			if($ext_file !='3' OR $ext_file !='4'){
				$ext_file = '3';
			}
			$ext_file = '.mp' . $ext_file;
			$album_crc = getAlbumCrcWithTrackCrc($track_info['crc']);
			$publisher_id = getPublisherIdWithAlbumId($album_crc);

			$hqfilename = $track_info['crc'] . '-hq' . $ext_file;
			$lqfilename = $track_info['crc'] . '-lq' . $ext_file;
			$llqfilename = $track_info['crc'] . '-llq' . $ext_file;

			$hqfileAddress = 'media/albums/' . $publisher_id . '/' .$album_crc . '/' . $album_crc .'-hq';
			$lqfileAddress = 'media/albums/' . $publisher_id . '/' .$album_crc . '/' . $album_crc .'-lq';
			$llqfileAddress = 'media/albums/' . $publisher_id . '/' .$album_crc . '/' . $album_crc .'-llq';

			$resutl_check_exits_track = json_decode($track_info['fileInfo'],true);
			$track_H320_Size = $resutl_check_exits_track['hqSize'];
			$track_L128_Size = $resutl_check_exits_track['lqSize'];
			$track_L64_Size = $resutl_check_exits_track['llqSize'];

			$fileInfo['hqPath'] = $hqfileAddress;
			$fileInfo['hqName'] = $hqfilename;
			$fileInfo['hqSize'] = $track_H320_Size;

			$fileInfo['lqPath'] = $lqfileAddress;
			$fileInfo['lqName'] = $lqfilename;
			$fileInfo['lqSize'] = $track_L128_Size;

			$fileInfo['llqPath'] = $llqfileAddress;
			$fileInfo['llqName'] = $llqfilename;
			$fileInfo['llqSize'] = $track_L64_Size;

			$fileInfor = json_encode($fileInfo);

			TrackModel::updateFileInfo($i,$fileInfor);
		}#--------------------END FOR
	}


	public function renameFilePathinfoTrack($start,$to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for($i = $start ; $i<$to ; $i++){
			$track_info = TrackModel::getfileInfoTrack($i);

			if(empty($track_info)){
				dump('Track not find: ' . $i);
				continue;
			}
			$file_info = json_decode($track_info['fileInfo'],true);

			$baseFolderTrack = explode('/',$file_info['hqPath']);

			$album_info = AlbumModel::getAlbumCrc($track_info['album_id']);
			if ($baseFolderTrack[3] ==0){
				continue;
			}

			if($baseFolderTrack[3] != $album_info['crc']){
				$newfileinfo['hqName'] = $file_info['hqName'];
				$newfileinfo['hqPath'] = 'media/albums/' . $album_info['publisherID']  . '/' . $album_info['crc'] . '/' . $album_info['crc'] . '-hq';
				$newfileinfo['hqSize'] = $file_info['hqSize'];

				$newfileinfo['lqName'] = $file_info['lqName'];
				$newfileinfo['lqPath'] = 'media/albums/' . $album_info['publisherID']  . '/' . $album_info['crc'] . '/' . $album_info['crc'] . '-lq';
				$newfileinfo['lqSize'] = $file_info['lqSize'];

				$newfileinfo['llqName'] = $file_info['llqName'];
				$newfileinfo['llqPath'] = 'media/albums/' . $album_info['publisherID']  . '/' . $album_info['crc'] . '/' . $album_info['crc'] . '-llq';
				$newfileinfo['llqSize'] = $file_info['llqSize'];

				$fileinfor = json_encode($newfileinfo);
				TrackModel::updateTrackFileInfo($i,$fileinfor);
				dump('Track Updated: ' . $i);
			}

		}
	}

	public function renameFileNameinfoTrack($start,$to){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}


		if (empty($start) OR empty($to)){
			$output['error']['status'] = true;
			$output['error']['code'] = '400';
			$output['error']['type'] = 'INVALID_PARAMETERS';
			$output['error']['message'] = 'Invalid Parameters';
			echo json_encode($output);
			return ;
		}

		for($i = $start ; $i<$to ; $i++){
			$track_info = TrackModel::getfileInfoTrack($i);

			if(empty($track_info)){
				dump('Track not find: ' . $i);
				continue;
			}
			$file_info = json_decode($track_info['fileInfo'],true);
			$example_track_filename = $track_info['crc'] . '.mp3';
			if($file_info['hqName'] ==$example_track_filename){
				$hqfilename = $track_info['crc'] . '-hq.mp3';
				$lqfilename = $track_info['crc'] . '-lq.mp3';
				$llqfilename = $track_info['crc'] . '-llq.mp3';
				$newfileinfo['hqName'] = $hqfilename;
				$newfileinfo['hqPath'] = $file_info['hqPath'];
				$newfileinfo['hqSize'] = $file_info['hqSize'];

				$newfileinfo['lqName'] = $lqfilename;
				$newfileinfo['lqPath'] = $file_info['lqPath'];
				$newfileinfo['lqSize'] = $file_info['lqSize'];

				$newfileinfo['llqName'] = $llqfilename;
				$newfileinfo['llqPath'] = $file_info['llqPath'];
				$newfileinfo['llqSize'] = $file_info['llqSize'];
				$fileinfor = json_encode($newfileinfo);
				TrackModel::updateTrackFileInfo($i,$fileinfor);
				dump('Track Updated: ' . $i);
			}
		}
	}
}