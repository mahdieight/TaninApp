<?php
class ExportController{

	public function getInfoAlbumForNewAlbum($albumID){
		require_once(getcwd() . '/app/PHPExcel.php');

		$record = AlbumModel::searchByID($albumID);
		$album_name = filterAlbumName($record['name']);
		$album_crc = $record['crc'];
		$album_genres = $record['genres'];
		$album_owners = $record['owners'];

		$inputFileName = getcwd() . '/media/export/TapSong.xlsx';
		$exportFileName =getAddresByCRC($album_crc) . '/' . $album_crc  . '-TapSong.xlsx';

		$baseAddress = getAddresByCRC($album_crc);
		$hqaddress = filterSongFileName($album_crc .'-hq' .'/' .$album_crc .'-hq.jpg');

		$album_genres = explode(',',$album_genres);
		if (isset($album_genres[1])){
			$listGenres=array();
			foreach ($album_genres as $genres){
				$listGenres[] = GenreModel::get_genre_name($genres);
			}
			$listGenres = implode('|',$listGenres);
		}else{
			$listGenres = GenreModel::get_genre_name($album_genres[0]);
		}


		$album_owners = explode(',',$album_owners);

		if (isset($album_owners[1])){
			$listOwners=array();
			foreach ($album_owners as $Owners){
				$listOwners[] = OwnerModel::get_owner_name($Owners);
			}
			$listOwners = implode('|',$listOwners);
		}else{
			$listOwners = OwnerModel::get_owner_name($album_owners[0]);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		if(!file_exists($exportFileName)){
			copyFile($inputFileName,$exportFileName);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($exportFileName);

		$row = 1;
// Change the file
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' .$row, '1')
			->setCellValue('B'. $row, $album_name)
			->setCellValue('C'. $row, $hqaddress)
			->setCellValue('D'. $row, $listGenres)
			->setCellValue('E'. $row, '')
			->setCellValue('F'. $row, '')
			->setCellValue('G'. $row, $listOwners)
			->setCellValue('H'. $row, '')
			->setCellValue('I'. $row, 'JEE')
			->setCellValue('J'. $row, '')
			->setCellValue('K'. $row, '')
			->setCellValue('L'. $row, '')
			->setCellValue('M'. $row, 'IRN');

// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($exportFileName);


	}


	public function getInfoSongForNewAlbum($albumID,$trackNumber,$SongFileName,$trackName){

		require_once(getcwd() . '/app/PHPExcel.php');

		$record = AlbumModel::searchByID($albumID);
		$album_crc = $record['crc'];

		$inputFileName = getcwd() . '/media/export/TapSong.xlsx';
		$exportFileName =getAddresByCRC($album_crc) . '/' . $album_crc  . '-TapSong.xlsx';

		$trackNumber = $trackNumber;
		$SongFileName = filterSongFileName($SongFileName);

		$albumName = filterAlbumName($record['name']);
		$trackName = filterAlbumName($trackName);
		$album_genres = $record['genres'];
		$album_owners = $record['owners'];


		$album_genres = explode(',',$album_genres);
		if (isset($album_genres[1])){
			$listGenres=array();
			foreach ($album_genres as $genres){
				$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres));
			}
			$listGenres = implode('|',$listGenres);
		}else{
			$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres[0]));
		}



		$album_owners = explode(',',$album_owners);
		if (isset($album_owners[1])){
			$listOwners=array();
			foreach ($album_owners as $Owners){
				$listOwners[] = OwnerModel::get_owner_name($Owners);
			}
			$listOwners = implode('|',$listOwners);
		}else{
			$listOwners = OwnerModel::get_owner_name($album_owners[0]);
		}




		if(!file_exists($exportFileName)){
			copyFile($inputFileName,$exportFileName);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($exportFileName);
		$row = $objPHPExcel->getActiveSheet(1)->getHighestRow()+1;
// Change the file
		$objPHPExcel->setActiveSheetIndex(1)
			->setCellValue('A' .$row, $trackNumber)
			->setCellValue('B'. $row, $albumName)
			->setCellValue('C'. $row, $trackName)
			->setCellValue('D'. $row, $SongFileName)
			->setCellValue('E'. $row, $listGenres)
			->setCellValue('F'. $row, '')
			->setCellValue('G'. $row, '')
			->setCellValue('H'. $row, '')
			->setCellValue('I'. $row, $listOwners)
			->setCellValue('J'. $row, '')
			->setCellValue('K'. $row, '')
			->setCellValue('L'. $row, '')
			->setCellValue('M'. $row, '')
			->setCellValue('N'. $row, '')
			->setCellValue('O'. $row, '')
			->setCellValue('P'. $row, '')
			->setCellValue('Q'. $row, '0')
			->setCellValue('R'. $row, '30')
			->setCellValue('S'. $row, '');

// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($exportFileName);
	}


	public function get_info_song($albumID,$trackNumber,$SongFileName,$trackName,$row_act){

		require_once(getcwd() . '/app/PHPExcel.php');

		$record = AlbumModel::searchByID($albumID);
		$album_crc = $record['crc'];

		$exportFileName ='media/tracksSelection' . '/' . $album_crc .'/'. $album_crc  . '.xlsx';

		$trackNumber = $trackNumber;
		$SongFileName = filterSongFileName($SongFileName);

		$albumName = filterAlbumName($record['name']);
		$trackName = filterAlbumName($trackName);
		$album_genres = $record['genres'];
		$album_owners = $record['owners'];


		$album_genres = explode(',',$album_genres);
		if (isset($album_genres[1])){
			$listGenres=array();
			foreach ($album_genres as $genres){
				$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres));
			}
			$listGenres = implode('|',$listGenres);
		}else{
			$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres[0]));
		}



		$album_owners = explode(',',$album_owners);
		if (isset($album_owners[1])){
			$listOwners=array();
			foreach ($album_owners as $Owners){
				$listOwners[] = OwnerModel::get_owner_name($Owners);
			}
			$listOwners = implode('|',$listOwners);
		}else{
			$listOwners = OwnerModel::get_owner_name($album_owners[0]);
		}






// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($exportFileName);
		if ($row_act == true){
			$row = 2;
		}else{
			$row = $objPHPExcel->getActiveSheet(1)->getHighestRow()+1;
		}



// Change the file
		$objPHPExcel->setActiveSheetIndex(1)
			->setCellValue('A' .$row, $trackNumber)
			->setCellValue('B'. $row, $albumName)
			->setCellValue('C'. $row, $trackName)
			->setCellValue('D'. $row, $SongFileName)
			->setCellValue('E'. $row, $listGenres)
			->setCellValue('F'. $row, '')
			->setCellValue('G'. $row, '')
			->setCellValue('H'. $row, '')
			->setCellValue('I'. $row, $listOwners)
			->setCellValue('J'. $row, '')
			->setCellValue('K'. $row, '')
			->setCellValue('L'. $row, '')
			->setCellValue('M'. $row, '')
			->setCellValue('N'. $row, '')
			->setCellValue('O'. $row, '')
			->setCellValue('P'. $row, '')
			->setCellValue('Q'. $row, '0')
			->setCellValue('R'. $row, '600')
			->setCellValue('S'. $row, '');

// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($exportFileName);

	}


	public function get_info_album($albumID){
		require_once(getcwd() . '/app/PHPExcel.php');

		$record = AlbumModel::searchByID($albumID);
		$album_name = filterAlbumName($record['name']);
		$album_crc = $record['crc'];
		$album_genres = $record['genres'];
		$album_owners = $record['owners'];

		$inputFileName = getcwd() . '/media/export/TapSong.xlsx';
		$exportFileName ='media/tracksSelection' . '/' . $album_crc .'/'. $album_crc  . '.xlsx';

		$baseAddress = getAddresByCRC($album_crc);
		$hqaddress = filterSongFileName($album_crc .'-hq' .'/' .$album_crc .'-hq.jpg');

		$album_genres = explode(',',$album_genres);
		if (isset($album_genres[1])){
			$listGenres=array();
			foreach ($album_genres as $genres){
				$listGenres[] = GenreModel::get_genre_name($genres);
			}
			$listGenres = implode('|',$listGenres);
		}else{
			$listGenres = GenreModel::get_genre_name($album_genres[0]);
		}


		$album_owners = explode(',',$album_owners);

		if (isset($album_owners[1])){
			$listOwners=array();
			foreach ($album_owners as $Owners){
				$listOwners[] = OwnerModel::get_owner_name($Owners);
			}
			$listOwners = implode('|',$listOwners);
		}else{
			$listOwners = OwnerModel::get_owner_name($album_owners[0]);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		if(!file_exists($exportFileName)){
			copyFile($inputFileName,$exportFileName);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($exportFileName);

		$row = $objPHPExcel->getActiveSheet(0)->getHighestRow()+1;
// Change the file
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' .$row, '1')
			->setCellValue('B'. $row, $album_name)
			->setCellValue('C'. $row, $hqaddress)
			->setCellValue('D'. $row, $listGenres)
			->setCellValue('E'. $row, '')
			->setCellValue('F'. $row, '')
			->setCellValue('G'. $row, $listOwners)
			->setCellValue('H'. $row, '')
			->setCellValue('I'. $row, 'JEE')
			->setCellValue('J'. $row, '')
			->setCellValue('K'. $row, '')
			->setCellValue('L'. $row, '')
			->setCellValue('M'. $row, 'IRN');

// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($exportFileName);


	}


	public function get_info_track_report($track_info){
		require_once(getcwd() . '/app/PHPExcel.php');

		$album_name = filterAlbumName($track_info['album_name']);
		$track_name = filterAlbumName($track_info['track_name']);
		$album_owners = $track_info['owners'];
		$publish_month = $track_info['publishMonth'];
		$publish_year  = $track_info['publishYear'] ;

		$publisher_id = $track_info['publisherID'];
		$publisher_info = PublisherModel::get_publisher_info_by_id($publisher_id);
		$publisher_name = $publisher_info['displayName'];



		$inputFileName = getcwd() . '/media/export/SelectionRecords.xlsx';
		$exportFileName ='media/transfer/SelectionRecords.xlsx';


		$album_owners = explode(',',$album_owners);

		if (isset($album_owners[1])){
			$listOwners=array();
			foreach ($album_owners as $Owners){
				$listOwners[] = OwnerModel::get_owner_name($Owners);
			}
			$listOwners = implode('|',$listOwners);
		}else{
			$listOwners = OwnerModel::get_owner_name($album_owners[0]);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		if(!file_exists($exportFileName)){
			copyFile($inputFileName,$exportFileName);
		}


// Read the file
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($exportFileName);

		$row = $objPHPExcel->getActiveSheet(0)->getHighestRow()+1;
// Change the file
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A' .$row, '')
			->setCellValue('B'. $row, $album_name)
			->setCellValue('C'. $row, $track_name)
			->setCellValue('D'. $row, $listOwners)
			->setCellValue('E'. $row, $publisher_name)
			->setCellValue('F'. $row, $publish_month)
			->setCellValue('G'. $row, $publish_year);

// Write the file
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($exportFileName);


	}


	public function get_info_full_song($track_info){

		require_once(getcwd() . '/app/PHPExcel.php');
		if (count($track_info) <= 0) {
			return;
		} else {
			$album_sp_info = $track_info[0];
			$inputFileName = getcwd() . '/media/export/transfer.xlsx';
			$exportFileName = 'media/transfer/' . $album_sp_info['album_crc'] . '/' . $album_sp_info['album_crc'] . '.xlsx';

			if (!file_exists($exportFileName)) {
				copyFile($inputFileName, $exportFileName);
			}
			// Read the file
			$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objReader->load($exportFileName);


			$alphaColumnName = array('B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ');
			$alphaColumnINDEX = 0;
			$alphaColumnTagsINDEX = 0;
			$alphaColumnGenersINDEX = 0;
			$alphaColumnOwnersINDEX = 0;
			$alphaColumnartistIconINDEX =0;

			$tag_status = false;
			$gener_status = false;
			$owner_status = false;
			$artistIcon_status = false;

			$album_propert_status = false;


			foreach ($track_info as $new_track_info) {

				$album_id = $new_track_info['album_id'];
				$album_crc = $new_track_info['album_crc'];
				$album_name = $new_track_info['album_name'];
				$album_engName = $new_track_info['album_engName'];
				$album_tags = $new_track_info['album_tags'];
				$album_genres = $new_track_info['album_genres'];
				$album_owners = $new_track_info['album_owners'];
				$album_publish_year = $new_track_info['album_publish_year'];
				$album_publish_month = $new_track_info['album_publish_month'];

				$publisher_id = $new_track_info['publisher_id'];

				$track_crc = $new_track_info['track_crc'];
				$track_name = $new_track_info['track_name'];
				$track_engName = $new_track_info['track_engName'];
				$track_icon =  $album_crc . '.jpg';
				$track_file_info = json_decode($new_track_info['track_fileInfo'],true);
				$track_file_name = $track_file_info['hqName'];


				$publisher_info = PublisherModel::get_publisher_info_by_id($publisher_id);
				#SET IMAGE PUBLISHER EXTENSIONS
				$publisher_image_info = json_decode($publisher_info['picture'], true);
				if (isset($publisher_image_info['ext']) AND !empty($publisher_image_info['ext'])) {
					$publisher_image_ext = $publisher_image_info['ext'];
				} else {
					$publisher_image_ext = '.jpg';
				}


				$publisher_dname = $publisher_info['displayName'];
				$publisher_icon =  'publisher-' . $publisher_info['id'] . $publisher_image_ext;

				#تنظیم تگ ها
				if (empty($album_tags)) {
					$listTags = '';
				} else {
					$album_tags_part = explode(',', $album_tags);
					if (isset($album_tags_part[1]) AND !empty($album_tags_part[1])) {
						$listTags = array();
						foreach ($album_tags_part as $tags_part) {
							$listTags[] = filterAlbumName(TagModel::get_tag_name($tags_part));
						}
					} else {
						$listTags = filterAlbumName(TagModel::get_tag_name($album_tags_part[0]));
					}
				}

				#تنظیم ژانرها
				if (empty($album_genres)) {
					$listGenres = '';
				} else {
					$album_genres_part = explode(',', $album_genres);
					if (isset($album_genres_part[1])) {
						$listGenres = array();
						foreach ($album_genres_part as $genres_part) {
							$listGenres[] = filterAlbumName(GenreModel::get_genre_name($genres_part));
						}

					} else {
						$listGenres = filterAlbumName(GenreModel::get_genre_name($album_genres_part[0]));
					}
				}

				#تنظیم خواننده ها
				if (empty($album_owners)) {
					$listOwners = '';
				} else {
					$album_owners_part = explode(',', $album_owners);
					if (isset($album_owners_part[1])) {
						$listOwners = array();
						$artisIcons = array();
						foreach ($album_owners_part as $owners_part) {

							$owner_infor = OwnerModel::get_ownerByID($owners_part);
							$owner_image_infor = json_decode($owner_infor['artistImage'], true);

							$artisIcons[] =  'artist-' . $owners_part . $owner_image_infor['ext'];
							$listOwners[] = OwnerModel::get_owner_name($owners_part);
						}

					} else {
						$listOwners = OwnerModel::get_owner_name($album_owners_part[0]);

						$owner_infor = OwnerModel::get_ownerByID($album_owners_part[0]);
						$owner_image_infor = json_decode($owner_infor['artistImage'], true);

						$artisIcons = 'artist-' . $album_owners_part[0] . $owner_image_infor['ext'];
					}
				}

				if ($tag_status == false){
					if (is_array($listTags)){
						foreach ($listTags as $list_tag){
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($alphaColumnName[$alphaColumnTagsINDEX] . '12', $list_tag);
							$alphaColumnTagsINDEX++;
						}
						$tag_status = true;
					}else{
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B' . '12', $listTags);
						$tag_status = true;
					}
				}


				if ($owner_status == false){
					if (is_array($listOwners)){
						foreach ($listOwners as $list_owner){
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($alphaColumnName[$alphaColumnOwnersINDEX] . '7', $list_owner);
							$alphaColumnOwnersINDEX++;
						}
						$owner_status = true;
					}else{
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B' . '7', $listOwners);
						$owner_status = true;
					}
				}


				if ($gener_status == false){
					if (is_array($listGenres)){
						foreach ($listGenres as $list_genere){
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($alphaColumnName[$alphaColumnGenersINDEX] . '9', $list_genere);
							$alphaColumnGenersINDEX++;
						}
						$gener_status = true;
					}else{
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B' . '9', $listGenres);
						$gener_status = true;
					}
				}


				if ($artistIcon_status == false){
					if (is_array($artisIcons)){
						foreach ($artisIcons as $list_artistIcon){
							$objPHPExcel->setActiveSheetIndex(0)
								->setCellValue($alphaColumnName[$alphaColumnartistIconINDEX] . '8', $list_artistIcon);

							$alphaColumnartistIconINDEX++;
						}
						$artistIcon_status = true;
					}else{
						$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B' . '8', $artisIcons);
						$artistIcon_status = true;
					}
				}


				if ($album_propert_status == false){
					$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('B1', $album_crc)
						->setCellValue('B2', $album_name)
						->setCellValue('B3', $album_engName)
						->setCellValue('B4', $album_publish_year)
						->setCellValue('B5', $album_publish_month)
						->setCellValue('B6', $track_icon)
						->setCellValue('B10', $publisher_dname)
						->setCellValue('B11', $publisher_icon);

						$album_propert_status = true;
				}

// Change the file
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($alphaColumnName[$alphaColumnINDEX] . '13', $track_name)
					->setCellValue($alphaColumnName[$alphaColumnINDEX] . '14', $track_engName)
					->setCellValue($alphaColumnName[$alphaColumnINDEX] . '15', $track_crc)
					->setCellValue($alphaColumnName[$alphaColumnINDEX] . '16', $track_file_name);

				$alphaColumnINDEX++;
			}

			// Write the file
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save($exportFileName);
		}
	}
}

