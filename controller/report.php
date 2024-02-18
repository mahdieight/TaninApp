<?php
class ReportController{

	public function tracks(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'وارد صفحه گزارشگیری از تراک ها شد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}


		$data['page_title'] = 'گزارش گیری از تراک ها';
		view::render('report/report_all_tracks.php',$data);
	}

	public function requsetTrackReport(){

		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$act_des = 'یک درخواست برای گزارش گیری از تراک ها ارسال کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}



		$taninAppConfig = new taninAppConfig();

		$fields = $_POST['field_req'];
		$track_status = $_POST['track_status'];


		$request_complated = false;
		$only_track_success = false;

		if(count($fields) == 6 AND !empty($fields[5])){
			$request_complated = true;
		}

		if ($track_status == 'true'){
			$only_track_success = true;
		}
		#گزارش کامل فقط برای تراک های دریافت شده
		if($request_complated AND $only_track_success){
			$track_list = ReportModel::getAllTracksOnlyDownloaded();
		}else if ($request_complated AND !$only_track_success){ #گزارش کامل برای تمامی تراک ها
			$track_list = ReportModel::getAllTracks();
		}else if($only_track_success){
			$newfields = implode(',',$fields);
			$track_list = ReportModel::getSpecifiedTracksOnlyDownloaded($newfields);
		}else{
			$newfields = implode(',',$fields);
			$track_list = ReportModel::getSpecifiedTracks($newfields);
		}

		$array_alph = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$fidels_title_name = array();
		foreach ($fields AS $field_name){
			if($field_name == 'id'){
				$fidels_title_name[] = 'شناسه تراک';
			}
			if($field_name == 'name'){
				$fidels_title_name[] = 'نام تراک';
			}
			if($field_name == 'engName'){
				$fidels_title_name[] = 'نام انگلیسی تراک';
			}
			if($field_name == 'lyrics'){
				$fidels_title_name[] = 'توضیحات تراک';
			}
			if($field_name == 'trackDuration'){
				$fidels_title_name[] = 'مدت زمان تراک';
			}
			if($field_name == 'price'){
				$fidels_title_name[] = 'قیمت تراک';
			}
		}


		require_once(getcwd() . '/app/PHPExcel.php');
		if(!file_exists(getcwd() .'/media/report/track/')){
			createDir('/media/report/track/');
		}

		$filename = get_current_time('Ymdhi') . '.xlsx';
		$fileaddress = 'media/report/track/' . $filename;
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()
			->setCreator("Tanin App")
			->setTitle("Report Tracks TaninApp")
			->setSubject("Template excel")
			->setKeywords("Template excel");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$j =0;
		foreach ($fidels_title_name as $fidels_title){
			ini_set('max_execution_time', 600); //300 seconds = 5 minutes
			$objPHPExcel->getActiveSheet()->SetCellValue($array_alph[$j] . '1', $fidels_title);
			$j++;
		}


		foreach ($track_list as $track_info){
			ini_set('max_execution_time', 1800); //300 seconds = 5 minutes
			$f = 0;
			$row = $objPHPExcel->getActiveSheet(0)->getHighestRow()+1;

			foreach ($fields as $fieldname){
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($array_alph[$f]. $row, $track_info[$fieldname]);

				$f++;
			}

		}#---------------------------------------------------------------------------------END FOREACH
		$objWriter->save(getcwd() . '/' . $fileaddress);

		$output = array();
		if (file_exists(getcwd() . '/' . $fileaddress)){
			ReportModel::setHistoryTrackSuccessHistory($filename);
			$output['status'] = true;
			$output['filePath'] = "برای دریافت فایل  <a href=" .  $taninAppConfig->base_url . $fileaddress." target='_blank'> این لینک</a> کلیک کنید";
			$output['result'] = 'عملیات به پایان رسید';
		}else{
			ReportModel::setHistoryTrackFailedHistory();
			$output['status'] = false;
			$output['result'] = 'عملیات با خطا مواجه شد!';
		}

		echo json_encode($output);
		return;
	}

	public function albums(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'وارد صفحه گزارش گیری شد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}


		$data['page_title'] = 'گزارش گیری از آلبوم ها';
		view::render('report/report_all_albums.php',$data);
	}

	public function requsetAlbumReport(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$act_des = 'یک درخواست برای گزارش گیری از آلبوم ها ارسال کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}


		$taninAppConfig = new taninAppConfig();

		$fields = $_POST['field_req'];
		$request_complated = false;

		if(count($fields) == 15 AND !empty($fields[14])){
			$request_complated = true;
		}


		if($request_complated){
			$list_albums = ReportModel::getAllAlbums();
		}else{
			$newfields = implode(',',$fields);
			$list_albums = ReportModel::getSpecifiedAlbums($newfields);
		}

		$array_alph = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		$fidels_title_name = array();

#تنظیم نام فیلد ها
		foreach ($fields AS $field_name){
			if($field_name == 'id'){
				$fidels_title_name[] = 'شناسه آلبوم';
			}
			if($field_name == 'name'){
				$fidels_title_name[] = 'نام آلبوم';
			}
			if($field_name == 'engName'){
				$fidels_title_name[] = 'نام انگلیسی آلبوم';
			}
			if($field_name == 'description'){
				$fidels_title_name[] = 'توضیحات آلبوم';
			}
			if($field_name == 'publisherID'){
				$fidels_title_name[] = 'انتشارات';
			}
			if($field_name == 'tags'){
				$fidels_title_name[] = 'برچسب ها';
			}
			if($field_name == 'genres'){
				$fidels_title_name[] = 'ژانر ها';
			}
			if($field_name == 'owners'){
				$fidels_title_name[] = 'خوانندگان';
			}
			if($field_name == 'composers'){
				$fidels_title_name[] = 'آهنگسازان';
			}
			if($field_name == 'arrangers'){
				$fidels_title_name[] = 'تنظیم کنندگان';
			}
			if($field_name == 'poets'){
				$fidels_title_name[] = 'شاعران';
			}
			if($field_name == 'finalPrice'){
				$fidels_title_name[] = 'قیمت آلبوم';
			}
			if($field_name == 'publishMonth'){
				$fidels_title_name[] = 'ماه انتشار';
			}
			if($field_name == 'publishYear'){
				$fidels_title_name[] = 'سال انتشار';
			}
			if($field_name == 'publishData'){
				$fidels_title_name[] = 'تاریخ انتشار';
			}
		}

		require_once(getcwd() . '/app/PHPExcel.php');
		if(!file_exists(getcwd() .'/media/report/album/')){
			createDir('/media/report/album/');
		}

		$filename = get_current_time('Ymdhi') . '.xlsx';
		$fileaddress = 'media/report/track/' . $filename;
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()
			->setCreator("Tanin App")
			->setTitle("Report Albums TaninApp")
			->setSubject("Template excel")
			->setKeywords("Template excel");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$j =0;
		foreach ($fidels_title_name as $fidels_title){
			$objPHPExcel->getActiveSheet()->SetCellValue($array_alph[$j] . '1', $fidels_title);
			$j++;
		}



		foreach ($list_albums as $album_info){
			$f = 0;
			$row = $objPHPExcel->getActiveSheet(0)->getHighestRow()+1;
			foreach ($fields as $fieldname){
				ini_set('max_execution_time', 3600); //300 seconds = 5 minutes

				#تنظیم نام انتشارات
				if ($fieldname == 'publisherID'){
					$album_info[$fieldname] = PublisherModel::get_publisher_info_by_id($album_info['publisherID']);
					$publisher_name = $album_info['publisherID']['displayName'];
				}

				#تنظیم تگ ها
				if ($fieldname == 'tags'){
					if (empty($album_info['tags'])){
						$listTags = '';
					}else{
						$album_tags = explode(',',$album_info['tags']);
						if (isset($album_tags[1]) AND !empty($album_tags[1])){
							$listTags = array();
							foreach ($album_tags as $tagss){
								$listTags[] = filterAlbumName(TagModel::get_tag_name($tagss));
							}
							$listTags = implode('|',$listTags);
						}else {
							$listTags = filterAlbumName(TagModel::get_tag_name($album_tags[0]));
						}
					}
				}

				#تنظیم ژانرها
				if ($fieldname == 'genres'){
					if (empty($album_info['genres'])){
						$listGenres = '';
					}else {
						$album_genres = explode(',', $album_info['genres']);
						if (isset($album_genres[1])) {
							$listGenres = array();
							foreach ($album_genres as $genres) {
								$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres));
							}
							$listGenres = implode('|', $listGenres);
						} else {
							$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres[0]));
						}
					}
				}

				#تنظیم خواننده ها
				if ($fieldname == 'owners'){
					if (empty($album_info['owners'])){
						$listOwners = '';
					}else {
						$album_owners = explode(',',$album_info['owners']);
						if (isset($album_owners[1])){
							$listOwners=array();
							foreach ($album_owners as $Owners){
								$listOwners[] = OwnerModel::get_owner_name($Owners);
							}
							$listOwners = implode('|',$listOwners);
						}else{
							$listOwners = OwnerModel::get_owner_name($album_owners[0]);
						}
					}
				}

				#تنظیم آهنگسازان - composers
				if ($fieldname == 'composers'){
					if (empty($album_info['composers'])){
						$listComposers = '';
					}else {
						$album_composers = explode(',', $album_info['composers']);
						if (isset($album_composers[1])) {
							$listComposers = array();
							foreach ($album_composers as $composers) {
								$listComposers[] = OwnerModel::get_owner_name($composers);
							}
							$listComposers = implode('|', $listComposers);
						} else {
							$listComposers = OwnerModel::get_owner_name($album_composers[0]);
						}
					}
				}

				#تنظیم تنظیم کنندگان - arrangers
				if ($fieldname == 'arrangers'){
					if (empty($album_info['arrangers'])){
						$listArrangers = '';
					}else {
						$album_arrangers = explode(',', $album_info['arrangers']);
						if (isset($album_arrangers[1])) {
							$listArrangers = array();
							foreach ($album_arrangers as $arrangers) {
								$listArrangers[] = OwnerModel::get_owner_name($arrangers);
							}
							$listArrangers = implode('|', $listArrangers);
						} else {
							$listArrangers = OwnerModel::get_owner_name($album_arrangers[0]);
						}
					}
				}

				#تنظیم شاعران - poets
				if ($fieldname == 'poets'){
					if (empty($album_info['poets'])){
						$listPoets = '';
					}else {
						$album_poets = explode(',', $album_info['poets']);
						if (isset($album_poets[1]) AND !empty($album_poets[1])) {
							$listPoets = array();
							foreach ($album_poets as $poets) {
								$listPoets[] = OwnerModel::get_owner_name($poets);
							}
							$listPoets = implode('|', $listPoets);
						} else {
							$listPoets = OwnerModel::get_owner_name($album_poets[0]);
						}
					}
				}


				if ($fieldname == 'publisherID') {
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $publisher_name);
				}else if ($fieldname == 'tags'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listTags);
				}else if($fieldname == 'genres'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listGenres);
				}else if ($fieldname == 'owners'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listOwners);
				}else if ($fieldname == 'composers'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listComposers);
				}else if ($fieldname == 'arrangers'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listArrangers);
				}else if ($fieldname == 'poets'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listPoets);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $album_info[$fieldname]);
				}
				$f++;
			}

		}#---------------------------------------------------------------------------------END FOREACH
		$objWriter->save(getcwd() . '/'. $fileaddress);
		$output = array();
		if (file_exists(getcwd() . '/' . $fileaddress)){
			ReportModel::setHistoryAlbumSuccessHistory($filename);
			$output['status'] = true;
			$output['filePath'] = "برای دریافت فایل  <a href=" .  $taninAppConfig->base_url . $fileaddress ." target='_blank'> این لینک</a> کلیک کنید";
			$output['result'] = 'عملیات به پایان رسید';
		}else{
			ReportModel::setHistoryAlbumFailedHistory();
			$output['status'] = false;
			$output['result'] = 'عملیات با خطا مواجه شد!';
		}

		echo json_encode($output);
		return;
	}

	public function tracksAlbums(){
		if(!userAdmined()){
			redirectToLogin();
		}

		$act_des = 'وارد صفحه گزارشگیری از تراک ها و آلبوم ها شد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}

		$data['page_title'] = 'گزارش گیری از آلبوم ها و تراک ها';
		$data['publishers'] = PublisherModel::getAllPublisher();
		$data['owners'] 		= OwnerModel::getAllOwners();
		view::render('report/report_tracks_albums.php',$data);
	}

	public function requestTracksAlbumsReport(){
		if(!userAdmined()){
			$output['error']['status'] = true;
			$output['error']['code'] = '500';
			$output['error']['type'] = 'NO_ACCESS_PERMISSIOM';
			$output['error']['message'] = 'No Access Permission';
			echo json_encode($output);
			return ;
		}

		$act_des = 'یک درخواست برای گزارش گیری از آلبوم ها و تراک ها ارسال کرد.';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'report',$act_des,get_current_time());
		}


		if($_POST['reportDate'] != 'false'){
			$report_date = explode('||',$_POST['reportDate']);
			$start_date = $report_date[0];
			$end_date = $report_date[1];
			$report_date_status = true;
		}else{
			$report_date_status = false;
		}


		$taninAppConfig = new taninAppConfig();

		$fields 			= $_POST['field_req'];
		$publishers 	= $_POST['publisher_filter'];
		$owners 			= $_POST['owner_filter'];
		$request_complated 	= false;
		$track_exits 				= false;
		$album_exits				= false;
		$publisher_filter 	= false;
		$owner_filter 			= false;
		$only_track_success = false;

		$track_status = $_POST['track_status'];

		if ($track_status == 'true'){
			$only_track_success = true;
		}


		if (count($fields) == 21 AND !empty($fields[20])) {
			$request_complated =true;
		}

		if($publishers != null){
			$publisher_filter = true;
			$publishers = '(' .implode(',',$publishers) . ')';
		}

		if($owners != null){
			$owner_filter = true;
			$owners 		= '(' . implode(',',$owners) . ')';
		}


		$Realfields = setAlbumVailidIndex('album_',$fields);
		$Realfields = setTrackValidIndex('track_',$Realfields);
		$Realfields = implode(',',$Realfields);


		#بررسی اینکه آیا در انتخاب ها، فیلدی از تراک ها وجود دارد یا خیر
		foreach ($fields as $fieldsValue){
			if(strHas('track',$fieldsValue)){
				$track_exits = true;
			}
			if(strHas('album',$fieldsValue)){
				$album_exits = true;
			}
		}
		if(count($fields) == 15 AND !empty($fields[14]) AND $request_complated == false AND $track_exits == false AND $publisher_filter == false AND $owner_filter == false ){
			if ($report_date_status == false){
				$returnList = ReportModel::getAllAlbums();
			}else{
				$returnList = ReportModel::getAllAlbumsWithDate($start_date,$end_date);
			}


			//dump('Complate Album Onluy - Without filter');
		}elseif (count($fields) == 15 AND !empty($fields[14]) AND $request_complated == false AND $track_exits == false AND $publisher_filter == false AND $owner_filter == true ){
			if ($report_date_status == false){
				$returnList = ReportModel::getComplateAlbumFilterByOwner($owners);
			}else{
				$returnList = ReportModel::getComplateAlbumFilterByOwnerWithDate($owners,$start_date,$end_date);
			}

			//dump('Complate Album - with Owner Filter');
		}elseif (count($fields) == 15 AND !empty($fields[14]) AND $request_complated == false AND $track_exits == false AND $publisher_filter == true AND $owner_filter == false){
			if ($report_date_status == false){
				$returnList = ReportModel::getComplateAlbumFilterByPublisher($publishers);
			}else{
				$returnList = ReportModel::getComplateAlbumFilterByPublisherWithDate($publishers,$start_date,$end_date);
			}

			//dump('Complate Album Only - with Publisher Filter');
		}elseif (count($fields) == 15 AND !empty($fields[14]) AND $request_complated == false AND $track_exits == false AND $publisher_filter == true AND $owner_filter == true) {
			if ($report_date_status == false){
				$returnList = ReportModel::getComplateAlbumFilterByPublisherAndOwner($publishers,$owners);
			}else{
				$returnList = ReportModel::getComplateAlbumFilterByPublisherAndOwnerWithDate($publishers,$owners,$start_date,$end_date);
			}

			//dump('Complate Album Only - with Publisher Filter And Owner Filter');
		}elseif ($album_exits == true AND $track_exits == false AND $publisher_filter == false AND $owner_filter == false){
			if ($report_date_status == false){
				$returnList = ReportModel::getSpecifiedAlbums($Realfields);
			}else{
				$returnList = ReportModel::getSpecifiedAlbumsWithDate($Realfields,$start_date,$end_date);
			}

			//dump('Album Onluy - without filter');
		}elseif($album_exits == true AND $track_exits == false AND $publisher_filter == true AND $owner_filter == false) {
			if ($report_date_status == false){
				$returnList = ReportModel::getSpecifiedAlbumsFilterByPublisher($Realfields,$publishers);
			}else{
				$returnList = ReportModel::getSpecifiedAlbumsFilterByPublisherWithDate($Realfields,$publishers,$start_date,$end_date);
			}

			//dump('Album Onluy - Publisher filter');
		}elseif($album_exits == true AND $track_exits == false AND $publisher_filter == false AND $owner_filter == true) {
			if ($report_date_status == false){
				$returnList = ReportModel::getSpecifiedAlbumsFilterByOwner($Realfields,$publishers);
			}else{
				$returnList = ReportModel::getSpecifiedAlbumsFilterByOwnerWithDate($Realfields,$publishers,$start_date,$end_date);
			}

			//dump('Album Onluy - Owner filter');
		}elseif($album_exits == true AND $track_exits == false AND $publisher_filter == true AND $owner_filter == true) {
			if ($report_date_status == false){
				$returnList = ReportModel::getSpecifiedAlbumsFilterByPublisherAndOwner($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::getSpecifiedAlbumsFilterByPublisherAndOwnerWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

			//dump('Album Onluy - Complate filter');


		}elseif (count($fields) == 8 AND !empty($fields[7]) AND $album_exits == false AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::getAllTracks($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::getAllTracksWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

			//dump('Track Only without filter');
		}elseif ($request_complated == true AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithoutFilter($Realfields);
			}else{
				$returnList = ReportModel::innerJoinComplateWithoutFilterWithDate($Realfields,$start_date,$end_date);
			}

			//dump('Complate INNER JOIN - Without filter');
		}elseif ($request_complated == true AND $publisher_filter == true AND $owner_filter == false AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisher($Realfields,$publishers);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherWithDate($Realfields,$publishers,$start_date,$end_date);
			}

			//dump('Complate INNER JOIN - Publisher filter');
		}elseif ($request_complated == true AND $publisher_filter == false AND $owner_filter == true AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByOwner($Realfields,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerWithDate($Realfields,$owners,$start_date,$end_date);
			}

			//dump('Complate INNER JOIN - Owner filter');
		}elseif ($request_complated == true AND $publisher_filter == true AND $owner_filter == true AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwner($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

			//dump('Complate INNER JOIN - With Complate Filter');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithoutFilter($Realfields);
			}else{
				$returnList = ReportModel::innerJoinComplateWithoutFilterWithDate($Realfields,$start_date,$end_date);
			}

			//dump('INNER JOIN - Without filter');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == true AND $owner_filter == false AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisher($Realfields,$publishers);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherWithDate($Realfields,$publishers,$start_date,$end_date);
			}

			//dump('INNER JOIN - Publisher filter');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == false AND $owner_filter == true AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByOwner($Realfields,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerWithDate($Realfields,$owners,$start_date,$end_date);
			}

			//dump('INNER JOIN - Owner filter');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == true AND $owner_filter == true AND $only_track_success == false){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwner($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

			//dump('INNER JOIN - With Complate Filter');


		}elseif (count($fields) == 8 AND !empty($fields[7]) AND $album_exits == false AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::getAllTracksOnlyDownload();
			}else{
				$returnList = ReportModel::getAllTracksOnlyDownloadWithDate($start_date,$end_date);
			}

			//dump('Track Only without filter - Download Only');
		}elseif ($request_complated == true AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithoutFilterOnlyDownload($Realfields);
			}else{
				$returnList = ReportModel::innerJoinComplateWithoutFilterOnlyDownloadWithDate($Realfields,$start_date,$end_date);
			}

		//dump('Complate INNER JOIN - Without filter - - Download Only');
		}elseif ($request_complated == true AND $publisher_filter == true AND $owner_filter == false AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherOnlyDownload($Realfields,$publishers);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherOnlyDownloadWithDate($Realfields,$publishers,$start_date,$end_date);
			}

		//dump('Complate INNER JOIN - Publisher filter' - Download Only);
		}elseif ($request_complated == true AND $publisher_filter == false AND $owner_filter == true AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerOnlyDownload($Realfields,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerOnlyDownloadWithDate($Realfields,$owners,$start_date,$end_date);
			}

		//dump('Complate INNER JOIN - Owner filter' - Download Only);
		}elseif ($request_complated == true AND $publisher_filter == true AND $owner_filter == true AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerOnlydownload($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerOnlydownloadWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

		//dump('Complate INNER JOIN - With Complate Filter - Download Only');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == false AND $owner_filter == false AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithoutFilterOnlyDownload($Realfields);
			}else{
				$returnList = ReportModel::innerJoinComplateWithoutFilterOnlyDownloadWithDate($Realfields,$start_date,$end_date);
			}

		//dump('INNER JOIN - Without filter - Download Only');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == true AND $owner_filter == false AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherOnlyDownload($Realfields,$publishers);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherOnlyDownloadWithDate($Realfields,$publishers,$start_date,$end_date);
			}

		//dump('INNER JOIN - Publisher filter - Download Only');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == false AND $owner_filter == true AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerOnlyDownload($Realfields,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByOwnerOnlyDownloadWithDate($Realfields,$owners,$start_date,$end_date);
			}

		//dump('INNER JOIN - Owner filter - Download Only');
		}elseif ($track_exits == true AND $album_exits == true AND $publisher_filter == true AND $owner_filter == true AND $only_track_success == true){
			if ($report_date_status == false){
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerOnlydownload($Realfields,$publishers,$owners);
			}else{
				$returnList = ReportModel::innerJoinComplateWithFilterByPublisherAndOwnerOnlydownloadWithDate($Realfields,$publishers,$owners,$start_date,$end_date);
			}

		//dump('INNER JOIN - With Complate Filter - Download Only');
		}

		$array_alph = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$fields_title_name = array();
		foreach ($fields as $newFields){

			if($newFields == 'album_id'){
				$fidels_title_name[] = 'شناسه آلبوم';
			}

			if($newFields == 'album_name'){
				$fidels_title_name[] = 'نام آلبوم';
			}

			if($newFields == 'album_engName'){
				$fidels_title_name[] = 'نام انگلیسی آلبوم';
			}


			if($newFields == 'album_publisherID'){
				$fidels_title_name[] = 'انتشارات';
			}


			if($newFields == 'album_description'){
				$fidels_title_name[] = 'توضیحات آلبوم';
			}


			if($newFields == 'album_tags'){
				$fidels_title_name[] = 'برچسب ها';
			}


			if($newFields == 'album_genres'){
				$fidels_title_name[] = 'ژانرها';
			}


			if($newFields == 'album_owners'){
				$fidels_title_name[] = 'خوانندگان';
			}

			if($newFields == 'album_composers'){
				$fidels_title_name[] = 'آهنگسازان';
			}

			if($newFields == 'album_arrangers'){
				$fidels_title_name[] = 'تنظیم کنندگان';
			}

			if($newFields == 'album_poets'){
				$fidels_title_name[] = 'شاعران';
			}

			if($newFields == 'album_finalPrice'){
				$fidels_title_name[] = 'قیمت آلبوم';
			}

			if($newFields == 'album_publishMonth'){
				$fidels_title_name[] = 'ماه انتشار آلبوم';
			}

			if($newFields == 'album_publishYear'){
				$fidels_title_name[] = 'سال انتشار آلبوم';
			}

			if($newFields == 'album_publishData'){
				$fidels_title_name[] = 'تاریخ انتشار آلبوم';
			}


			if($newFields == 'track_id'){
				$fidels_title_name[] = 'شناسه تراک';
			}


			if($newFields == 'track_name'){
				$fidels_title_name[] = 'نام تراک';
			}


			if($newFields == 'track_engName'){
				$fidels_title_name[] = 'نام انگلیسی تراک';
			}


			if($newFields == 'track_lyrics'){
				$fidels_title_name[] = 'توضیحات تراک';
			}


			if($newFields == 'track_price'){
				$fidels_title_name[] = 'قیمت تراک';
			}


			if($newFields == 'track_trackDuration'){
				$fidels_title_name[] = 'مدت زمان تراک';
			}




		}

		require_once(getcwd() . '/app/PHPExcel.php');
		if(!file_exists(getcwd() .'/media/report/tracksAlbum/')){
			createDir('/media/report/tracksAlbum/');
		}

		$filename = get_current_time('Ymdhi') . '.xlsx';
		$fileaddress = 'media/report/track/' . $filename;
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()
			->setCreator("Tanin App")
			->setTitle("Report TracksAlbums TaninApp")
			->setSubject("Template excel")
			->setKeywords("Template excel");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		$j =0;
		foreach ($fidels_title_name as $fidels_title){
			$objPHPExcel->getActiveSheet()->SetCellValue($array_alph[$j] . '1', $fidels_title);
			$j++;
		}
		$fields_valid = removeAlbumIndexes('album_',$fields);


		#----------------------------------------------------------------------------------------

		foreach ($returnList as $album_info){
			ini_set('memory_limit', '-1');
			$f = 0;
			$row = $objPHPExcel->getActiveSheet(0)->getHighestRow()+1;
			foreach ($fields_valid as $fieldname){
				ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

				#تنظیم نام انتشارات
				if ($fieldname == 'publisherID'){
					$publisher_name = PublisherModel::get_publisher_info_by_id($album_info[$fieldname]);
					$publisher_name = $publisher_name['displayName'];
				}



				#تنظیم تگ ها
				if ($fieldname == 'tags'){
					if (empty($album_info['tags'])){
						$listTags = '';
					}else{
						$album_tags = explode(',',$album_info['tags']);
						if (isset($album_tags[1]) AND !empty($album_tags[1])){
							$listTags = array();
							foreach ($album_tags as $tagss){
								$listTags[] = filterAlbumName(TagModel::get_tag_name($tagss));
							}
							$listTags = implode('|',$listTags);
						}else {
							$listTags = filterAlbumName(TagModel::get_tag_name($album_tags[0]));
						}
					}
				}

				#تنظیم ژانرها
				if ($fieldname == 'genres'){
					if (empty($album_info['genres'])){
						$listGenres = '';
					}else {
						$album_genres = explode(',', $album_info['genres']);
						if (isset($album_genres[1])) {
							$listGenres = array();
							foreach ($album_genres as $genres) {
								$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres));
							}
							$listGenres = implode('|', $listGenres);
						} else {
							$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres[0]));
						}
					}
				}

				#تنظیم خواننده ها
				if ($fieldname == 'owners'){
					if (empty($album_info['owners'])){
						$listOwners = '';
					}else {
						$album_owners = explode(',',$album_info['owners']);
						if (isset($album_owners[1])){
							$listOwners=array();
							foreach ($album_owners as $Owners){
								$listOwners[] = OwnerModel::get_owner_name($Owners);
							}
							$listOwners = implode('|',$listOwners);
						}else{
							$listOwners = OwnerModel::get_owner_name($album_owners[0]);
						}
					}
				}

				#تنظیم آهنگسازان - composers
				if ($fieldname == 'composers'){
					if (empty($album_info['composers'])){
						$listComposers = '';
					}else {
						$album_composers = explode(',', $album_info['composers']);
						if (isset($album_composers[1])) {
							$listComposers = array();
							foreach ($album_composers as $composers) {
								$listComposers[] = OwnerModel::get_owner_name($composers);
							}
							$listComposers = implode('|', $listComposers);
						} else {
							$listComposers = OwnerModel::get_owner_name($album_composers[0]);
						}
					}
				}

				#تنظیم تنظیم کنندگان - arrangers
				if ($fieldname == 'arrangers'){
					if (empty($album_info['arrangers'])){
						$listArrangers = '';
					}else {
						$album_arrangers = explode(',', $album_info['arrangers']);
						if (isset($album_arrangers[1])) {
							$listArrangers = array();
							foreach ($album_arrangers as $arrangers) {
								$listArrangers[] = OwnerModel::get_owner_name($arrangers);
							}
							$listArrangers = implode('|', $listArrangers);
						} else {
							$listArrangers = OwnerModel::get_owner_name($album_arrangers[0]);
						}
					}
				}

				#تنظیم شاعران - poets
				if ($fieldname == 'poets'){
					if (empty($album_info['poets'])){
						$listPoets = '';
					}else {
						$album_poets = explode(',', $album_info['poets']);
						if (isset($album_poets[1]) AND !empty($album_poets[1])) {
							$listPoets = array();
							foreach ($album_poets as $poets) {
								$listPoets[] = OwnerModel::get_owner_name($poets);
							}
							$listPoets = implode('|', $listPoets);
						} else {
							$listPoets = OwnerModel::get_owner_name($album_poets[0]);
						}
					}
				}


				if ($fieldname == 'publisherID') {
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $publisher_name);
				}else if ($fieldname == 'tags'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listTags);
				}else if($fieldname == 'genres'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listGenres);
				}else if ($fieldname == 'owners'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listOwners);
				}else if ($fieldname == 'composers'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listComposers);
				}else if ($fieldname == 'arrangers'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listArrangers);
				}else if ($fieldname == 'poets'){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $listPoets);
				}else{
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue($array_alph[$f]. $row, $album_info[$fieldname]);
				}

				$f++;
			}
		}#---------------------------------------------------------------------------------END FOREACH
		$objWriter->save(getcwd() .'/' . $fileaddress);
		$output = array();
		if (file_exists(getcwd() . '/'. $fileaddress)){
			ReportModel::setHistoryAlbumTrackSuccessHistory($filename);
			$output['status'] = true;
			$output['filePath'] = "برای دریافت فایل  <a href=" .  $taninAppConfig->base_url . $fileaddress ." target='_blank'> این لینک</a> کلیک کنید";
			$output['result'] = 'عملیات به پایان رسید';
		}else{
			ReportModel::setHistoryAlbumTrackFailedHistory();
			$output['status'] = false;
			$output['result'] = 'عملیات با خطا مواجه شد!';
		}

		echo json_encode($output);
		return;

		#----------------------------------------------------------------------------------------
	}






















}