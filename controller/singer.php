<?php
class SingerController{


	public function actsSinger($albumSinger){
		$singerList = array();
		foreach ($albumSinger as $singerinfo){

			$m_singerinfo = SingerModel::get_singer($singerinfo['id']);
			if(empty($m_singerinfo)){


				$singerImg 				= @ckeckExit($singerinfo['artistImage']);
				$singerFName 			= @ckeckExit($singerinfo['firstName']);
				$singerLName 			= @ckeckExit($singerinfo['lastName']);
				$singerAName 			= @ckeckExit($singerinfo['artisticName']);

				createDir('media/artists/' . $singerinfo['id']);
				copyFile($singerImg , 'media/artists/' . $singerinfo['id'] .'/'. $singerinfo['id'] . '.jpg');

				$singerImage['path'] = 'media/artists/' . $singerinfo['id'];
				$singerImage['name'] = $singerinfo['id'];
				$singerImage['ext'] = '.jpg';
				$singerImager = json_encode($singerImage);

				SingerModel::insert_singer_info($singerinfo['id'],$singerFName,$singerLName,$singerAName,$singerImager);

				$record = SingerModel::get_singer($singerinfo['id']);
				$singerList[]= $record['id'];
			}else{
				$singerList[]= $m_singerinfo['id'];
			}
		}
		return $singerList;
	}
}