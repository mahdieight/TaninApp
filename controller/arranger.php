<?php
class ArrangerController{
	public function actsArranger($albumArrangers){

		$arrangersList = array();

		foreach ($albumArrangers as $arrangersinfo){
			$m_arrangersinfo = ArrangerModel::get_arranger($arrangersinfo['id']);

			if(empty($m_arrangersinfo)){


				$arrangersImg 			= @ckeckExit($arrangersinfo['artistImage']);
				$arrangersFName 		= @ckeckExit($arrangersinfo['firstName']);
				$arrangersLName 		= @ckeckExit($arrangersinfo['lastName']);
				$arrangersAName 		= @ckeckExit($arrangersinfo['artisticName']);

				createDir('media/artists/' . $arrangersinfo['id']);
				copyFile($arrangersImg , 'media/artists/' . $arrangersinfo['id'] .'/'. $arrangersinfo['id'] . '.jpg');

				$arrangersImage['path'] = 'media/artists/' . $arrangersinfo['id'];
				$arrangersImage['name'] = $arrangersinfo['id'];
				$arrangersImage['ext'] = '.jpg';
				$arrangersImager = json_encode($arrangersImage);


				ArrangerModel::insert_arranger_info($arrangersinfo['id'],$arrangersFName,$arrangersLName,$arrangersAName,$arrangersImager);

				$record = ArrangerModel::get_arranger($arrangersinfo['id']);
				$arrangersList[]= $record['id'];
			}else{
				$arrangersList[]= $m_arrangersinfo['id'];
			}
		}
		return $arrangersList;
	}
}