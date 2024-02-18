<?php
class PlayerController{

	public function actsplayer($albumplayer){
		$playerList = array();

		foreach ($albumplayer as $playerinfo){

			$m_playerinfo = PlayerModel::get_player($playerinfo['id']);

			if(empty($m_playerinfo)){

				createDir('media/artists/' . $playerinfo['id']);
				if (isset($playerinfo['artistImage'])){
					$artistImage = $playerinfo['artistImage'];
				}else{
					$artistImage ="";
				}

				copyFile($artistImage , 'media/artists/' . $playerinfo['id'] .'/'. $playerinfo['id'] . '.jpg');


				$playerImage['path'] = 'media/artists/' . $playerinfo['id'];
				$playerImage['name'] = $playerinfo['id'];
				$playerImage['ext'] = '.jpg';
				$playerImager = json_encode($playerImage);

				$playerFName = @ckeckExit($playerinfo['firstName']);
				$playerLName = @ckeckExit($playerinfo['lastName']);
				$playerAName = @ckeckExit($playerinfo['artisticName']);

				PlayerModel::insert_player_info($playerinfo['id'],$playerFName,$playerLName,$playerAName,$playerImager);

				$record = PlayerModel::get_player($playerinfo['id']);
				$playerList[]= $record['id'];
			}else{
				$playerList[]= $m_playerinfo['id'];
			}
		}
		return $playerList;
	}
}