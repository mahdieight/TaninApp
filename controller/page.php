<?php
class PageController
{
  public function dashboard(){

    if(!userAdmined()){
			redirectToLogin();
    }

		$count_all_album_in_db = AlbumModel::getAlbumsCount();
		$count_all_track_in_db = TrackModel::getTracksCount();
		$count_all_track_dl_db = TrackModel::getDownloadTracksCount();
		$count_all_track_queue = AlbumModel::getAlbumsQueueCountSuccess();

		$lastApiUsed 				= WebserviceModel::getLastUsedAPI();
		$lastReport	 				= ReportModel::getLastReport();
		$lastUserLogin	 		= AccountModel::getLastUserLogin();
		$lastAlbumInserted	= AlbumModel::getLastAlbums(0,5);


    $data['page_title'] = 'طنین اپ - مدیریت';
    $data['count_album_db'] = $count_all_album_in_db;
    $data['count_track_db'] = $count_all_track_in_db;
    $data['count_track_dl'] = $count_all_track_dl_db;
    $data['count_track_qu'] = $count_all_track_queue;
    $data['lastApiUsed'] 		= $lastApiUsed;
    $data['lastReport'] 		= $lastReport;
    $data['lastUserLogin'] 	= $lastUserLogin;
    $data['lastAlbumInserted'] 	= $lastAlbumInserted;

    $act_des = 'داشبور مدیریت را مشاهده کرد';
		$last_activaty_user = userActivityModel::getLastActivaty($_SESSION['user_id']);
		if(checkActivatyStatus($last_activaty_user['description'] , $act_des)){
			userActivityModel::activityCycle($_SESSION['user_id'],get_client_ip_env(),getBrowser(),'dashboard',$act_des,get_current_time());
		}


    view::render('dashboard/dashboard.php',$data);
  }


}

 ?>
