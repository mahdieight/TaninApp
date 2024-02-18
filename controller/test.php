<?php
/**
 * Created by PhpStorm.
 * User: mahdiforu
 * Date: 10/27/2017
 * Time: 7:21 PM
 */


class TestController{

	public function getSelectionTrack(){
		//$tracksDown90 = AlbumModel::getLimitAlbumDown90();


		$tracksTop90	= AlbumModel::getLimitAlbumDown90();

		$baseFolder = '/media/tracksSelection/';
		if (!file_exists(getcwd() . $baseFolder)){
			createDir($baseFolder);
		}
		$j = 0;
		foreach ($tracksTop90 as $track_t_90){
			if ($j <=500){


				$album_crc 				= $track_t_90['album_crc'];

				# اسم پوشه آلبومی که باید داشته باشیم
				$album_folder 		= $baseFolder . $album_crc;

				#ایجاد فایل آلبوم در پوشه مد نظر
				if (!file_exists(getcwd() . $album_folder)){
					createDir($album_folder);
				}

				# گرفتن آدرس دسترسی ببه فایل برای دریافت فایل
				$albumAddress = getAddresByCRC($album_crc);
				$track_file = json_decode($track_t_90['track_file'],true);
				$file_ext_info = explode('.m',$track_file['hqName']);
				$file_ext = '.m' . end($file_ext_info);
				$trackFileAddress = $albumAddress . '/' . $track_t_90['album_crc'] . '-hq/' . $track_t_90['track_crc'] .'-hq'. $file_ext;
				$hqFileAddress		= $albumAddress . '/' . $track_t_90['album_crc'] . '-hq/' . $track_t_90['album_crc'] .'-hq.jpg';

				$sacn_dir_album_folder = scandir(getcwd() . $album_folder);

				if(count($sacn_dir_album_folder) <=5){
					copy($trackFileAddress, getcwd()  . $album_folder .'/' . $track_t_90['track_crc'] . $file_ext);

					if(!file_exists(getcwd() . $hqFileAddress)){
						copy($hqFileAddress, getcwd()  . $album_folder .'/' . $track_t_90['album_crc'] .'.jpg');
					}

					$j++;
					dump('File is Uploaded! : ' . $track_t_90['track_id']);
				}else{
					continue;
				}
			}else{
				break;
			}
		}#------------------------------------EndForEach





	}


	public function CreateZipFile(){
		$zip = new CompressionController();

		$direction = getcwd().'/media/tracksSelection/';
		$all_folders = scandir($direction);
		foreach ($all_folders as $total_folders){
			if($total_folders != '.' AND  $total_folders != '..'){
				$fileaddress = $direction .$total_folders. "/$total_folders.zip";
				$fileaddressToZip = $direction .$total_folders;

				$zip->createZipFile($fileaddress,$fileaddressToZip,'0');
			}
		}
	}


	public function CreateEXFileSong(){
		$exe = new ExportController();

		$direction = getcwd().'/media/tracksSelection/';
		$all_folders = scandir($direction);

		foreach ($all_folders as $total_folders){
			if($total_folders != '.' AND  $total_folders != '..'){

				$track_dir = scandir($direction . $total_folders);

				$j =1;
				foreach ($track_dir as $track_dir_file){
					if($track_dir_file != '.' AND  $track_dir_file != '..'){

						if (strHas('.mp3',$track_dir_file)){
							$track_file_info 		= explode('.mp',$track_dir_file);
							$track_file_name 		= $track_file_info[0];
							$track_crc_info 		= explode('-hq',$track_file_name);
							$track_crc				 	= $track_crc_info[0];
							$track_info = TrackModel::searchWithCrc($track_crc);

							if($j==1){
								$exe->get_info_song($track_info['album_id'],$j,$total_folders .'/' .$track_file_name,$track_info['name'],true);
							}else{
								$exe->get_info_song($track_info['album_id'],$j,$total_folders .'/' .$track_file_name,$track_info['name'],false);
							}

							dump('File Com');
							$j ++;
						}
					}else{
						continue;
					}


				}#------------------------------
				exit;
			}
		}
	}


	public function CreateEXFileAlbum(){
		$ext = new ExportController();

		$direction = getcwd().'/media/tracksSelection/';
		$all_folders = scandir($direction);
		foreach ($all_folders as $total_folders){
			if($total_folders != '.' AND  $total_folders != '..'){
				$result =AlbumModel::searchAlbumWithCrc($total_folders);
				if(!empty($result)){
					$ext->get_info_album($result['ex_id']);
				}

			}
		}
	}


	public function CreateEXFileReport(){
		$exe = new ExportController();

		$direction = getcwd().'/media/tracksSelection/';
		$all_folders = scandir($direction);

		foreach ($all_folders as $total_folders){
			if($total_folders != '.' AND  $total_folders != '..'){

				$track_dir = scandir($direction . $total_folders);

				foreach ($track_dir as $track_dir_file){
					if($track_dir_file != '.' AND  $track_dir_file != '..'){
						if (strHas('.mp3',$track_dir_file)){
							$track_file_info 		= explode('.mp',$track_dir_file);
							$track_file_name 		= $track_file_info[0];
							$track_crc_info 		= explode('-hq',$track_file_name);
							$track_crc				 	= $track_crc_info[0];

							$track_info = TrackModel::InnerJoinWithCrc($track_crc);
							$exe->get_info_track_report($track_info);
							dump('File Com');
						}
					}else{
						continue;
					}


				}#------------------------------
				exit;
			}
		}
	}


	public function test1(){


		$curl = curl_init();
		$addres = 'Newapi.taninapp.com/public/agent/album/tracks?id=454567201';
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:ab1m80fo29b3s9imb4722137ib'));
		curl_setopt($curl,CURLOPT_URL,$addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		dump(  $export);
	}
	public function test2(){


		$curl = curl_init();
		$addres = 'Newapi.taninapp.com/public/agent/track/info?id=463501859';
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:ab1m80fo29b3s9imb4722137ib'));
		curl_setopt($curl,CURLOPT_URL,$addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		dump(  $export);
	}


	public function test3(){
		$albumlist = array();
		$curl = curl_init();
		$addres = 'Newapi.taninapp.com/public/agent/search/album/';
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json','X-BT-AGENT-SECRET:ab1m80fo29b3s9imb4722137ib'));
		curl_setopt($curl,CURLOPT_URL,$addres);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$export = curl_exec($curl);
		curl_close($curl);
		$albumlist []= json_decode($export,true);


		dump(  $albumlist);
	}

	public function api(){


	}


	public function call_api($id){
		$curl = curl_init();
		$taninAppConfig = new taninAppConfig();
		$addres = 'localhost'.$taninAppConfig->base_url .'webservice/get_tracks_link_download_album/' . $id;
		curl_setopt($curl, CURLOPT_HTTPHEADER,array('X-TS-AGENT-SECRET: X6pRkvt3JSNeLXQGrpVyRJhdRztegzhn'));
		curl_setopt($curl,CURLOPT_URL,$addres);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$export = curl_exec($curl);
		curl_close($curl);
		$export = json_decode($export,true);
		dump($export);
	}

	public function test_pass(){
		$taninAppConfig = new taninAppConfig();
		echo md5('09121964276' . $taninAppConfig->salt_password);
	}

}