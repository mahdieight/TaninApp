<?php
class PublisherController{

	public function actsPublisher($publisherinfo){
		$publisherList = array();
		$m_publisher = PublisherModel::get_publisher_info($publisherinfo['id']);
		if(empty($m_publisher)){

			$publisherImage 				= @ckeckExit($publisherinfo['picture']);
			$publisherWebsite 			= @ckeckExit($publisherinfo['website']);
			$publisherDescription 	= @ckeckExit($publisherinfo['description']);
			$publisherFName 				= @ckeckExit($publisherinfo['name']);
			$publisherDName 				= @ckeckExit($publisherinfo['displayName']);

			createDir('media/publisher/' . $publisherinfo['id']);
			copyFile($publisherImage ,'media/publisher/' . $publisherinfo['id'] . '/' . $publisherinfo['id'] . '.jpg');

			$publisher_image['path'] = $publisherImage . $publisherinfo['id'] . '/';
			$publisher_image['name'] = $publisherinfo['id'];
			$publisher_image['ext'] = '.jpg';
			$publisherPicture = json_encode($publisher_image);


			PublisherModel::insert_publisher_info($publisherinfo['id'],$publisherFName,$publisherDName , $publisherDescription, $publisherPicture, $publisherWebsite);

			$record = PublisherModel::get_publisher_info($publisherinfo['id']);
			$publisherList[] = $record['id'];
		}else{
			$publisherList[] = $m_publisher['id'];
		}
		return $publisherList;
	}
}