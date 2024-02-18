<?php
class ComposerController{

	public function actsComposer($albumComposers){

		$composersList = array();

		foreach ($albumComposers as $composersinfo){
			$m_composersinfo = ComposerModel::get_composer($composersinfo['id']);

			if(empty($m_composersinfo)){

				$composersImg 				= @ckeckExit($composersinfo['artistImage']);
				$composersFName 			= @ckeckExit($composersinfo['firstName']);
				$composersLName 			= @ckeckExit($composersinfo['lastName']);
				$composersAName 			= @ckeckExit($composersinfo['artisticName']);

				createDir('media/artists/' . $composersinfo['id']);
				copyFile($composersImg , 'media/artists/' . $composersinfo['id'] .'/'. $composersinfo['id'] . '.jpg');

				$composerImage['path'] = 'media/artists/' . $composersinfo['id'];
				$composerImage['name'] = $composersinfo['id'];
				$composerImage['ext'] = '.jpg';
				$composerImager = json_encode($composerImage);

				ComposerModel::insert_composer_info($composersinfo['id'],$composersFName,$composersLName,$composersAName,$composerImager);

				$record = ComposerModel::get_composer($composersinfo['id']);
				$composersList[]= $record['id'];
			}else{
				$composersList[]= $m_composersinfo['id'];
			}
		}
		return $composersList;
	}
}