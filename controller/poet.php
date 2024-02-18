<?php
class PoetController{

	public function actsPoet($albumPoet){
		$PoetList = array();

		foreach ($albumPoet as $poetinfo){
			$m_poetinfo = PoetModel::get_poet($poetinfo['id']);

			if(empty($m_poetinfo)){

				$poetImg 	 = @ckeckExit($poetinfo['artistImage']);
				$poetFName = @ckeckExit($poetinfo['firstName']);
				$poetLName = @ckeckExit($poetinfo['lastName']);
				$poetAName = @ckeckExit($poetinfo['artisticName']);

				createDir('media/artists/' . $poetinfo['id']);
				copyFile($poetImg , 'media/artists/' . $poetinfo['id'] .'/'. $poetinfo['id'] . '.jpg');

				$poetImage['path'] = 'media/artists/' . $poetinfo['id'];
				$poetImage['name'] = $poetinfo['id'];
				$poetImage['ext'] = '.jpg';
				$poetImager = json_encode($poetImage);

				PoetModel::insert_poet_info($poetinfo['id'],$poetFName,$poetLName,$poetAName,$poetImager);

				$record = PoetModel::get_poet($poetinfo['id']);
				$PoetList[]= $record['id'];
			}else{
				$PoetList[]= $m_poetinfo['id'];
			}
		}
		return $PoetList;
	}
}