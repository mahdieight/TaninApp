<?php
class WebserviceController{
	public function album(){
		$taninAppConfig = new taninAppConfig();

		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		#بررسی اینکه آیا پارامتری تنظیم شده است یا خیر
		if(!isset($_GET['q']) OR empty($_GET['q'])){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}



		$query 			= $_GET['q'];
		if(!isset($_GET['size']) OR $_GET['size'] > 12 OR empty($_GET['size'])){
			$size  =  12;
		}else{
			$size  =  $_GET['size'] ;
		}

		if (!isset($_GET['page']) OR empty($_GET['page'])){
			$page_index = 1;
		}else{
			$page_index = $_GET['page'] ;
		}



		$start_index = ($page_index-1) * $size;
		$resutlAlbums= AlbumModel::serchStringInAlbum($query,$start_index,$size);


		#بررسی اینکه آیا جستجو نتیجه ای داشته است یا خیر
		if (empty($resutlAlbums)){
			$resutl = SetErrorSearchNoResultsFound($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}



		$count_all_albums= AlbumModel::serchStringInAlbumCount($query);
		$count_result_show = ($page_index) * $size;
		$count_exits_track = $count_all_albums - $count_result_show;
		$count_page_exits  = ceil($count_exits_track / $size);
		$newxt_page = $page_index + 1;


		if($count_page_exits > 0 OR ($page_index ==1 AND $count_all_albums > 0)) {
			$j = 0;
			foreach ($resutlAlbums as $resutl_check_exits_album) {
				$tagsAlbum = $resutl_check_exits_album['tags'];
				$listTagsAlbum = array();
				if (!empty($tagsAlbum)) {
					$tagsPartAlbum = explode(',', $tagsAlbum);
					if (isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)) {
						foreach ($tagsPartAlbum as $tagsID) {
							$listTagsAlbum[] = TagModel::get_tag_info($tagsID);
						}
					} else {
						$listTagsAlbum = TagModel::get_tag_info($tagsAlbum);
					}
				}
				/*------------------------------SET TAGS--------------------------------------*/


				/*------------------------------SET Genres------------------------------------*/
				$genresAlbum = $resutl_check_exits_album['genres'];
				$listGenresAlbum = array();
				if (!empty($genresAlbum)) {
					$tagsPartAlbum = explode(',', $genresAlbum);
					if (isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)) {
						foreach ($tagsPartAlbum as $genresID) {
							$listGenresAlbum[] = GenreModel::get_genre_info($genresID);
						}
					} else {
						$listGenresAlbum = GenreModel::get_genre_info($genresAlbum);
					}
				}
				/*------------------------------SET Genres------------------------------------*/

				/*------------------------------SET Owners------------------------------------*/
				$ownersAlbum = $resutl_check_exits_album['owners'];
				$listOwnersAlbum = array();
				if (!empty($ownersAlbum)) {
					$ownersPartAlbum = explode(',', $ownersAlbum);
					if (isset($ownersPartAlbum[1]) AND !empty($ownersPartAlbum)) {
						foreach ($ownersPartAlbum as $ownersID) {
							$listOwnersAlbum[] = OwnerModel::get_owner_info($ownersID);
						}
					} else {
						$listOwnersAlbum = OwnerModel::get_owner_info($ownersAlbum);
					}
				}
				/*------------------------------SET Owners------------------------------------*/


				/*------------------------------SET Composers---------------------------------*/
				$composersAlbum = $resutl_check_exits_album['composers'];
				$listComposersAlbum = array();
				if (!empty($composersAlbum)) {
					$composersPartAlbum = explode(',', $composersAlbum);
					if (isset($composersPartAlbum[1]) AND !empty($composersPartAlbum)) {
						foreach ($composersPartAlbum as $composersID) {
							$listComposersAlbum[] = OwnerModel::get_owner_info($composersID);
						}
					} else {
						$listComposersAlbum = OwnerModel::get_owner_info($composersAlbum);
					}
				}
				/*------------------------------SET Composers---------------------------------*/


				/*------------------------------SET Players-----------------------------------*/
				$playersAlbum = $resutl_check_exits_album['players'];
				$listplayersAlbum = array();
				if (!empty($playersAlbum)) {
					$playersPartAlbum = explode(',', $playersAlbum);
					if (isset($playersPartAlbum[1]) AND !empty($playersPartAlbum)) {
						foreach ($playersPartAlbum as $playersID) {
							$listplayersAlbum[] = OwnerModel::get_owner_info($playersID);
						}
					} else {
						$listplayersAlbum = OwnerModel::get_owner_info($playersAlbum);
					}
				}
				/*------------------------------SET Players-----------------------------------*/


				/*------------------------------SET Arrangers----------------------------------*/
				$arrangersAlbum = $resutl_check_exits_album['arrangers'];
				$listArrangersAlbum = array();
				if (!empty($arrangersAlbum)) {
					$arrangersPartAlbum = explode(',', $arrangersAlbum);
					if (isset($arrangersPartAlbum[1]) AND !empty($arrangersPartAlbum)) {
						foreach ($arrangersPartAlbum as $arrangersID) {
							$listArrangersAlbum[] = OwnerModel::get_owner_info($arrangersID);
						}
					} else {
						$listArrangersAlbum = OwnerModel::get_owner_info($arrangersAlbum);
					}
				}
				/*------------------------------SET Arrangers----------------------------------*/


				/*------------------------------SET Poets--------------------------------------*/
				$poetsAlbum = $resutl_check_exits_album['poets'];
				$listPoetsAlbum = array();
				if (!empty($poetsAlbum)) {
					$poetsPartAlbum = explode(',', $poetsAlbum);
					if (isset($poetsPartAlbum[1]) AND !empty($poetsPartAlbum)) {
						foreach ($poetsPartAlbum as $poetsID) {
							$listPoetsAlbum[] = OwnerModel::get_owner_info($poetsID);
						}
					} else {
						$listPoetsAlbum = OwnerModel::get_owner_info($poetsAlbum);
					}
				}
				/*------------------------------SET Poets--------------------------------------*/


				/*------------------------------SET Singers-------------------------------------*/
				$singersAlbum = $resutl_check_exits_album['singers'];
				$listSingersAlbum = array();
				if (!empty($singersAlbum)) {
					$singersPartAlbum = explode(',', $singersAlbum);
					if (isset($singersPartAlbum[1]) AND !empty($singersPartAlbum)) {
						foreach ($singersPartAlbum as $singersID) {
							$listSingersAlbum[] = OwnerModel::get_owner_info($singersID);
						}
					} else {
						$listSingersAlbum = OwnerModel::get_owner_info($singersAlbum);
					}
				}
				/*------------------------------SET Singers-------------------------------------*/


				/*------------------------------SET PublisherInfo---------------------------------*/
				$publisherName = PublisherModel::get_publisher_limit_info($resutl_check_exits_album['publisherID']);
				$publisher_info['id'] = $publisherName['id'];
				$publisher_info['name'] = $publisherName['name'];
				$publisher_info['displayName'] = $publisherName['displayName'];
				$publisher_info['description'] = $publisherName['description'];
				$publisher_image = json_decode($publisherName['picture'], true);
				$publisher_info['image'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . '/media/publisher/' . $publisher_image['name'] . '/' . $publisher_image['name'] . $publisher_image['ext'];
				/*------------------------------SET PublisherInfo---------------------------------*/


				/*------------------------------SET PrimaryImageHQ---------------------------------*/
				$primaryImagePathHQ = json_decode($resutl_check_exits_album['primaryImagePathHQ'], true);
				$primaryImageHQ = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $primaryImagePathHQ['path'] . '/' . $primaryImagePathHQ['name'] . $primaryImagePathHQ['ext'];
				/*------------------------------SET PrimaryImageHQ---------------------------------*/


				/*------------------------------SET Gallery---------------------------------*/
				$galleryAlbumPath = json_decode($resutl_check_exits_album['gallery'], true);
				if (!empty($galleryAlbumPath['name'])) {
					$galleryAlbum = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $galleryAlbumPath['path'] . '/' . $galleryAlbumPath['name'];
				} else {
					$galleryAlbum = array();
				}
				/*------------------------------SET PrimaryImageHQ---------------------------------*/


				$output['data'][$j]['id'] = $resutl_check_exits_album['id'];
				$output['data'][$j]['name'] = $resutl_check_exits_album['name'];
				$output['data'][$j]['englishName'] = $resutl_check_exits_album['engName'];
				$output['data'][$j]['description'] = $resutl_check_exits_album['description'];
				$output['data'][$j]['publisher'] = $publisher_info;
				$output['data'][$j]['marketPrice'] = $resutl_check_exits_album['marketPrice'];
				$output['data'][$j]['finalPrice'] = $resutl_check_exits_album['finalPrice'];
				$output['data'][$j]['publishData'] = $resutl_check_exits_album['publishData'];
				$output['data'][$j]['primaryImageHQ'] = $primaryImageHQ;
				$output['data'][$j]['albumGallery'] = $galleryAlbum;
				$output['data'][$j]['tags'] = $listTagsAlbum;
				$output['data'][$j]['genres'] = $listGenresAlbum;
				$output['data'][$j]['owners'] = $listOwnersAlbum;
				$output['data'][$j]['composers'] = $listComposersAlbum;
				$output['data'][$j]['players'] = $listplayersAlbum;
				$output['data'][$j]['arrangers'] = $listArrangersAlbum;
				$output['data'][$j]['poets'] = $listPoetsAlbum;
				$output['data'][$j]['singers'] = $listSingersAlbum;
				$output['data'][$j]['publishYear'] = $resutl_check_exits_album['publishYear'];
				$output['data'][$j]['publishMonth'] = $resutl_check_exits_album['publishMonth'];
				$output['data'][$j]['featured'] = $resutl_check_exits_album['featured'];
				$j++;
			}
		}else{
			$count_page_exits = 0;
			$newxt_page = 	0;
			$output['data'] = array();
		}
		$output['pagination']['pageNum'] = $count_page_exits;
		$output['pagination']['next']    = ($_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . "/webservice/album/?q=$query&page=$newxt_page&size=$size");

		SetSuccessSearchQuery($resutl_check_api['id'],$query);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);
		echo  json_encode($output);
		return;

	}



	public function track(){
		$taninAppConfig = new taninAppConfig();
		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		#بررسی اینکه آیا پارامتری تنظیم شده است یا خیر
		if(!isset($_GET['q']) OR empty($_GET['q'])){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}



		$query 			= $_GET['q'];
		if(!isset($_GET['size']) OR $_GET['size'] > 12 OR empty($_GET['size'])){
			$size  =  12;
		}else{
			$size  =  $_GET['size'] ;
		}

		if (!isset($_GET['page']) OR empty($_GET['page'])){
			$page_index = 1;
		}else{
			$page_index = $_GET['page'] ;
		}



		$start_index = ($page_index-1) * $size;
		$resutlTracks= TrackModel::serchStringInTrack($query,$start_index,$size);

		#بررسی اینکه آیا جستجو نتیجه ای داشته است یا خیر
		if (empty($resutlTracks)){
			$resutl = SetErrorSearchNoResultsFound($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}



		$count_all_track= TrackModel::serchStringInTrackCount($query);
		$count_result_show = ($page_index) * $size;
		$count_exits_track = $count_all_track - $count_result_show;
		$count_page_exits  = ceil($count_exits_track / $size);
		$newxt_page = $page_index + 1;


		if($count_page_exits > 0 OR ($page_index ==1 AND $count_all_track > 0)) {
			$j = 0;
			foreach ($resutlTracks as $resutl_check_exits_track) {
				#------------------------------------------------------------SET OWNER INFO
				$owner_info = explode(',',$resutl_check_exits_track['owners']);
				$owner_info = $owner_info[0];
				if(!empty($owner_info)){
					$owner_info = OwnerModel::get_owner_info($owner_info);
				}
				#------------------------------------------------------------SET OWNER INFO

				#-----------------------------------------------------------SET Genres INFO
				$genresAlbum = $resutl_check_exits_track['genres'];
				$listGenresAlbum = array();
				if(!empty($genresAlbum)){
					$tagsPartAlbum = explode(',',$genresAlbum);
					if(isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)){
						foreach ($tagsPartAlbum as $genresID){
							$listGenresAlbum[] = GenreModel::get_genre_info($genresID);
						}
					}else{
						$listGenresAlbum = GenreModel::get_genre_info($genresAlbum);
					}
				}
				#-----------------------------------------------------------SET Genres INFO

				#-----------------------------------------------------------SET Genres INFO
				$album_image = json_decode($resutl_check_exits_track['primaryImagePathHQ'],true);
				$album_image = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $album_image['path'] . '/' . $album_image['name'] . $album_image['ext'];
				#-----------------------------------------------------------SET Genres INFO


				#-----------------------------------------------------------SET Publisher INFO
				$publisherName = PublisherModel::get_publisher_limit_info($resutl_check_exits_track['publisherID']);
				$publisher_info['id'] = $publisherName['id'];
				$publisher_info['name'] = $publisherName['name'];
				$publisher_info['displayName'] = $publisherName['displayName'];
				$publisher_info['description'] = $publisherName['description'];
				$publisher_image = json_decode($publisherName['picture'],true);
				$publisher_info['image'] = getcwd() . '/media/publisher/' . $publisher_image['name'] . '/' . $publisher_image['name'] . $publisher_image['ext'];
				#-----------------------------------------------------------SET Publisher INFO

				$output['data'][$j]['id'] = $resutl_check_exits_track['track_id'];
				$output['data'][$j]['name'] = $resutl_check_exits_track['track_name'];
				$output['data'][$j]['englishName'] = $resutl_check_exits_track['track_eng_name'];
				$output['data'][$j]['albumId'] = $resutl_check_exits_track['album_id'];
				$output['data'][$j]['description'] = $resutl_check_exits_track['track_description'];
				$output['data'][$j]['trackDuration'] = $resutl_check_exits_track['track_duration'];
				$output['data'][$j]['trackPrice'] = $resutl_check_exits_track['track_price'];
				$output['data'][$j]['artist'] = $owner_info;

				$output['data'][$j]['album']['id'] = $resutl_check_exits_track['album_id'];
				$output['data'][$j]['album']['name'] = $resutl_check_exits_track['album_name'];
				$output['data'][$j]['album']['englishName'] = $resutl_check_exits_track['album_eng_name'];
				$output['data'][$j]['album']['publisher'] = $publisher_info;
				$output['data'][$j]['album']['image'] = $album_image;
				$output['data'][$j]['album']['artist'] = $owner_info;
				$output['data'][$j]['album']['genres'] = $listGenresAlbum;
				$output['data'][$j]['album']['finalPrice'] = $resutl_check_exits_track['finalPrice'];

				$j++;
			}
		}else{
			$count_page_exits = 0;
			$newxt_page = 	0;
			$output['data'] = array();
		}
		$output['pagination']['pageNum'] = $count_page_exits;
		$output['pagination']['next']    = ($_SERVER['SERVER_NAME'] . "/webservice/album/?q=$query&page=$newxt_page&size=$size");

		SetSuccessSearchQuery($resutl_check_api['id'],$query);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);
		echo  json_encode($output);
		return;
	}



	public function track_info($track_id){
		$taninAppConfig = new taninAppConfig();
		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		#بررسی اینکه پارامتری وارد شده است یا خیر
		if(empty($track_id)){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		$track_info = TrackModel::get_track_info_with_album_info($track_id);

		#بررسی اینکه آیا اطلاعات تراک پیدا شده است یا خیر
		if (empty($track_info)){
			$resutl = SetErrorInvalidTrack($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		#------------------------------------------------------------SET OWNER INFO
		$owner_info = explode(',',$track_info['owners']);
		$owner_info = $owner_info[0];
		if(!empty($owner_info)){
			$owner_info = OwnerModel::get_owner_info($owner_info);
		}
		#------------------------------------------------------------SET OWNER INFO

		#-----------------------------------------------------------SET Genres INFO
		$genresAlbum = $track_info['genres'];
		$listGenresAlbum = array();
		if(!empty($genresAlbum)){
			$tagsPartAlbum = explode(',',$genresAlbum);
			if(isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)){
				foreach ($tagsPartAlbum as $genresID){
					$listGenresAlbum[] = GenreModel::get_genre_info($genresID);
				}
			}else{
				$listGenresAlbum = GenreModel::get_genre_info($genresAlbum);
			}
		}
		#-----------------------------------------------------------SET Genres INFO

		#-----------------------------------------------------------SET Genres INFO
		$album_image = json_decode($track_info['primaryImagePathHQ'],true);
		$album_image = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $album_image['path'] . '/' . $album_image['name'] . $album_image['ext'];
		#-----------------------------------------------------------SET Genres INFO


		#-----------------------------------------------------------SET Publisher INFO
		$publisherName = PublisherModel::get_publisher_limit_info($track_info['publisherID']);
		$publisher_info['id'] = $publisherName['id'];
		$publisher_info['name'] = $publisherName['name'];
		$publisher_info['displayName'] = $publisherName['displayName'];
		$publisher_info['description'] = $publisherName['description'];
		$publisher_image = json_decode($publisherName['picture'],true);
		$publisher_info['image'] = getcwd() . '/media/publisher/' . $publisher_image['name'] . '/' . $publisher_image['name'] . $publisher_image['ext'];
		#-----------------------------------------------------------SET Publisher INFO

		$output['id'] = $track_info['track_id'];
		$output['name'] = $track_info['track_name'];
		$output['englishName'] = $track_info['track_eng_name'];
		$output['description'] = $track_info['track_description'];
		$output['price'] = $track_info['track_price'];
		$output['trackDuration'] = $track_info['track_duration'];
		$output['albumId'] = $track_info['album_id'];
		$output['artist'] = $owner_info;

		$output['album']['id'] = $track_info['album_id'];
		$output['album']['name'] = $track_info['album_name'];
		$output['album']['englishName'] = $track_info['album_eng_name'];
		$output['album']['publisher'] = $publisher_info;
		$output['album']['image'] = $album_image;
		$output['album']['artist'] = $owner_info;
		$output['album']['genres'] = $listGenresAlbum;
		$output['album']['finalPrice'] = $track_info['finalPrice'];

		SetSuccessTrackReq($resutl_check_api['id']);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);
		echo json_encode($output);
		return;
	}



	public function album_info($album_id = ''){
		$taninAppConfig = new taninAppConfig();
		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		#بررسی اینکه پارامتری وارد شده است یا خیر
		if(empty($album_id)){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			return json_encode($resutl);
		}

		#بررسی وجود آلبوم درخواستی
		$resutl_check_exits_album = AlbumModel::getInfo($album_id);
		if (empty($resutl_check_exits_album)){
			$resutl = SetErrorInvalidAlbum($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		/*------------------------------SET TAGS--------------------------------------*/
		$tagsAlbum = $resutl_check_exits_album['tags'];
		$listTagsAlbum = array();
		if(!empty($tagsAlbum)){
			$tagsPartAlbum = explode(',',$tagsAlbum);
			if(isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)){
				foreach ($tagsPartAlbum as $tagsID){
					$listTagsAlbum[] = TagModel::get_tag_info($tagsID);
				}
			}else{
				$listTagsAlbum = TagModel::get_tag_info($tagsAlbum);
			}
		}
		/*------------------------------SET TAGS--------------------------------------*/



		/*------------------------------SET Genres------------------------------------*/
		$genresAlbum = $resutl_check_exits_album['genres'];
		$listGenresAlbum = array();
		if(!empty($genresAlbum)){
			$tagsPartAlbum = explode(',',$genresAlbum);
			if(isset($tagsPartAlbum[1]) AND !empty($tagsPartAlbum)){
				foreach ($tagsPartAlbum as $genresID){
					$listGenresAlbum[] = GenreModel::get_genre_info($genresID);
				}
			}else{
				$listGenresAlbum = GenreModel::get_genre_info($genresAlbum);
			}
		}
		/*------------------------------SET Genres------------------------------------*/

		/*------------------------------SET Owners------------------------------------*/
		$ownersAlbum = $resutl_check_exits_album['owners'];
		$listOwnersAlbum = array();
		if(!empty($ownersAlbum)){
			$ownersPartAlbum = explode(',',$ownersAlbum);
			if(isset($ownersPartAlbum[1]) AND !empty($ownersPartAlbum)){
				foreach ($ownersPartAlbum as $ownersID){
					$listOwnersAlbum[] = OwnerModel::get_owner_info($ownersID);
				}
			}else{
				$listOwnersAlbum = OwnerModel::get_owner_info($ownersAlbum);
			}
		}
		/*------------------------------SET Owners------------------------------------*/


		/*------------------------------SET Composers---------------------------------*/
		$composersAlbum = $resutl_check_exits_album['composers'];
		$listComposersAlbum = array();
		if(!empty($composersAlbum)){
			$composersPartAlbum = explode(',',$composersAlbum);
			if(isset($composersPartAlbum[1]) AND !empty($composersPartAlbum)){
				foreach ($composersPartAlbum as $composersID){
					$listComposersAlbum[] = OwnerModel::get_owner_info($composersID);
				}
			}else{
				$listComposersAlbum = OwnerModel::get_owner_info($composersAlbum);
			}
		}
		/*------------------------------SET Composers---------------------------------*/


		/*------------------------------SET Players-----------------------------------*/
		$playersAlbum = $resutl_check_exits_album['players'];
		$listplayersAlbum = array();
		if(!empty($playersAlbum)){
			$playersPartAlbum = explode(',',$playersAlbum);
			if(isset($playersPartAlbum[1]) AND !empty($playersPartAlbum)){
				foreach ($playersPartAlbum as $playersID){
					$listplayersAlbum[] = OwnerModel::get_owner_info($playersID);
				}
			}else{
				$listplayersAlbum = OwnerModel::get_owner_info($playersAlbum);
			}
		}
		/*------------------------------SET Players-----------------------------------*/


		/*------------------------------SET Arrangers----------------------------------*/
		$arrangersAlbum = $resutl_check_exits_album['arrangers'];
		$listArrangersAlbum = array();
		if(!empty($arrangersAlbum)){
			$arrangersPartAlbum = explode(',',$arrangersAlbum);
			if(isset($arrangersPartAlbum[1]) AND !empty($arrangersPartAlbum)){
				foreach ($arrangersPartAlbum as $arrangersID){
					$listArrangersAlbum[] = OwnerModel::get_owner_info($arrangersID);
				}
			}else{
				$listArrangersAlbum = OwnerModel::get_owner_info($arrangersAlbum);
			}
		}
		/*------------------------------SET Arrangers----------------------------------*/


		/*------------------------------SET Poets--------------------------------------*/
		$poetsAlbum = $resutl_check_exits_album['poets'];
		$listPoetsAlbum = array();
		if(!empty($poetsAlbum)){
			$poetsPartAlbum = explode(',',$poetsAlbum);
			if(isset($poetsPartAlbum[1]) AND !empty($poetsPartAlbum)){
				foreach ($poetsPartAlbum as $poetsID){
					$listPoetsAlbum[] = OwnerModel::get_owner_info($poetsID);
				}
			}else{
				$listPoetsAlbum = OwnerModel::get_owner_info($poetsAlbum);
			}
		}
		/*------------------------------SET Poets--------------------------------------*/


		/*------------------------------SET Singers-------------------------------------*/
		$singersAlbum = $resutl_check_exits_album['singers'];
		$listSingersAlbum = array();
		if(!empty($singersAlbum)){
			$singersPartAlbum = explode(',',$singersAlbum);
			if(isset($singersPartAlbum[1]) AND !empty($singersPartAlbum)){
				foreach ($singersPartAlbum as $singersID){
					$listSingersAlbum[] = OwnerModel::get_owner_info($singersID);
				}
			}else{
				$listSingersAlbum = OwnerModel::get_owner_info($singersAlbum);
			}
		}
		/*------------------------------SET Singers-------------------------------------*/


		/*------------------------------SET PublisherInfo---------------------------------*/
		$publisherName = PublisherModel::get_publisher_limit_info($resutl_check_exits_album['publisherID']);
		$publisher_info['id'] = $publisherName['id'];
		$publisher_info['name'] = $publisherName['name'];
		$publisher_info['displayName'] = $publisherName['displayName'];
		$publisher_info['description'] = $publisherName['description'];
		$publisher_image = json_decode($publisherName['picture'],true);
		$publisher_info['image'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . '/media/publisher/' . $publisher_image['name'] . '/' . $publisher_image['name'] . $publisher_image['ext'];
		/*------------------------------SET PublisherInfo---------------------------------*/


		/*------------------------------SET PrimaryImageHQ---------------------------------*/
		$primaryImagePathHQ = json_decode($resutl_check_exits_album['primaryImagePathHQ'],true);
		$primaryImageHQ = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $primaryImagePathHQ['path'] . '/' . $primaryImagePathHQ['name'] . $primaryImagePathHQ['ext'];
		/*------------------------------SET PrimaryImageHQ---------------------------------*/


		/*------------------------------SET Gallery---------------------------------*/
		$galleryAlbumPath = json_decode($resutl_check_exits_album['gallery'],true);
		if(!empty($galleryAlbumPath['name'])){
			$galleryAlbum = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $galleryAlbumPath['path'] . '/' . $galleryAlbumPath['name'];
		}else{
			$galleryAlbum = array();
		}
		/*------------------------------SET PrimaryImageHQ---------------------------------*/



		$output['id'] 						= $resutl_check_exits_album['id'];
		$output['name'] 					= $resutl_check_exits_album['name'];
		$output['englishName'] 		= $resutl_check_exits_album['engName'];
		$output['description'] 		= $resutl_check_exits_album['description'];
		$output['publisher'] 			= $publisher_info;
		$output['marketPrice'] 		= $resutl_check_exits_album['marketPrice'];
		$output['finalPrice'] 		= $resutl_check_exits_album['finalPrice'];
		$output['publishData'] 		= $resutl_check_exits_album['publishData'];
		$output['primaryImageHQ'] = $primaryImageHQ;
		$output['albumGallery'] 	= $galleryAlbum;
		$output['tags'] 					= $listTagsAlbum;
		$output['genres'] 				= $listGenresAlbum;
		$output['owners'] 				= $listOwnersAlbum;
		$output['composers'] 			= $listComposersAlbum;
		$output['players'] 				= $listplayersAlbum;
		$output['arrangers'] 			= $listArrangersAlbum;
		$output['poets'] 					= $listPoetsAlbum;
		$output['singers'] 				= $listSingersAlbum;
		$output['publishYear'] 		= $resutl_check_exits_album['publishYear'];
		$output['publishMonth'] 	= $resutl_check_exits_album['publishMonth'];
		$output['featured'] 			= $resutl_check_exits_album['featured'];


		SetSuccessAlbumInfoReq($resutl_check_api['id']);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);
		echo json_encode($output);
		return;
	}



	public function track_download_link($track_id = ''){
		$taninAppConfig = new taninAppConfig();

		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		if(empty($track_id)){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		#بررسی وجود تراک درخواستی
		$resutl_check_exits_track = TrackModel::get_track_info($track_id);
		if (empty($resutl_check_exits_track)){
			$resutl = SetErrorInvalidTrack($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		SetSuccessTrackReq($resutl_check_api['id']);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);

		$album_crc = getAlbumCrcWithTrackCrc($resutl_check_exits_track['crc']);
		$file_info = $resutl_check_exits_track['fileInfo'];
		$file_info = json_decode($file_info,true);


		if($file_info['hqName']== '-hq.mp3'){
			$output ['trackHqFile'] = '';
			$output ['trackHqimage'] = '';
		}else{
			$output ['trackHqFile'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $file_info['hqPath'] . '/'. $file_info['hqName'];
			$output ['trackHqimage'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $file_info['hqPath'] . '/'. $album_crc . '-hq.jpg';
		}

		echo json_encode($output);
		return;
	}



	public function tracks_download_link($album_id = ''){
		$taninAppConfig = new taninAppConfig();

		# بررسی صحت وجود کلید برای دسترسی به api
		$resutl_check_api = CheckApiKey();
		if(empty($resutl_check_api)){
			$resutl = SetErrorInaccessibility();
			echo json_encode($resutl);
			return;
		}

		if(empty($album_id)){
			$resutl = setErrorNotSendParametr($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		#بررسی وجود آلبوم درخواستی
		$resutl_check_exits_album = AlbumModel::getInfo($album_id);
		if (empty($resutl_check_exits_album)){
			$resutl = SetErrorInvalidAlbum($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}

		#بررسی اینکه آیا آلبوم وارد شده دارای تراک می باشد یا خیر
		$all_track = TrackModel::getTotalTrackAlbum($resutl_check_exits_album['ex_id']);
		if (empty($resutl_check_exits_album)){
			$resutl = SetErrorAlbumIsNotTrack($resutl_check_api['id']);
			echo json_encode($resutl);
			return;
		}


		$output = array();
		$i = 0;
		foreach($all_track as $tracks){
			$album_crc = getAlbumCrcWithTrackCrc($tracks['crc']);
			$file_info = $tracks['fileInfo'];
			$file_info = json_decode($file_info,true);

			if($file_info['hqName']== '-hq.mp3'){
				$output [$i]['trackHqFile'] = '';
				$output [$i]['trackHqimage'] = '';
			}else{
				$output [$i]['trackHqFile'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $file_info['hqPath'] . '/'. $file_info['hqName'];
				$output [$i]['trackHqimage'] = $_SERVER['SERVER_NAME'] . $taninAppConfig->base_url . $file_info['hqPath'] . '/'. $album_crc . '-hq.jpg';
			}

			$i++;
		}

		SetSuccessAlbumTracksReq($resutl_check_api['id']);
		WebserviceModel::updateLastUsed($resutl_check_api['id']);

		echo json_encode($output);
		return;

	}
}