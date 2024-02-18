<?php

function isHomePage(){
	$taninAppConfig = new realEstateConfig();
	$request_url = $_SERVER['REQUEST_URI'];
	$request_url = str_replace($taninAppConfig->base_url ,'',$request_url);
	if(empty($request_url)){
		return true;
	}else{
		return false;
	}
}

function isSupperAdmin(){
	$user_id = $_SESSION['user_id'];
	$user_info = AccountModel::getUserById($user_id);

	if($user_info['is_supperadmin'] == 1){
		return true;
	}

	return false;
}


function dump($value,$return = false){
	if(is_array($value)){
		$output = print_r($value,true);
	}elseif (is_object($value)) {
		$output = var_export($value,true);
	}else {
		$output = $value;
	}

	if ($return) {
		return '<pre>' . $output . '</pre>';
	}else{
		echo   '<pre>' . $output . '</pre>';
		return;
	}
}


#function for check a spcial Ckarakter in subject
function strHas($search,$subject){
	if (strpos($subject, $search) !== false) {
		return true;
	}else{
		return false;
	}
}

function userAdmined(){
	if(isset($_SESSION['user_id'])){
		return true;
	}else{
		return false;
	}
}

function redirectTohome(){
	if(isset($_SESSION['user_id'])) {
		$taninAppConfig = new taninAppConfig();
		$url = $taninAppConfig->base_url . 'page/dashboard';
		header("Location: " . $url);
	}
}

function redirectToLogin(){
	$taninAppConfig = new taninAppConfig();
	$url = $taninAppConfig->base_url . 'account/login/';
	header("Location: " . $url);
}

#function for show eroro404
function showErrorPage($data){
	view::render('/error.php',$data);
	exit;
}


#function for show eroro500
function showErrorPageAdmin(){
	view::render_error('/error.php');
	exit;
}

#function for show eroro500
function showErrorPage500(){
	view::render_error('/500.php');
	exit;
}



function checkValidEmail($email){
	$regex = "/(^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$)/";
	if (preg_match($regex, $email)) {
		return true;
	} else {
		return false;
	}
}

function checkValidPhone($phone){
	$regex = "/(^09[1-3][0-9]{8}$)/";
	if (preg_match($regex, $phone)) {
		return true;
	} else {
		return false;
	}
}

function checkPasswordStrength($password){
	$regex = "/((?=.*[!@#$%^&*]+)(?=.*[1-9]+)(?=.*[a-z]).*$)/";
	if (preg_match($regex, $password)) {
		return true;
	} else {
		return false;
	}
}

function createDir($path,$mode = '755'){

	if(is_dir(getcwd() . "/" . $path)){
		chmod(getcwd() . "/" . $path, 0755);
		return;
	}else{
		mkdir(getcwd() . "/" . $path, $mode);
		chmod(getcwd() . "/" . $path, 0755);
	}
}

function copyFile($source,$path){

	if(!file_exists(getcwd() . "/" . $path)){

		$retuen = @copy($source, getcwd() . "/" . $path);
		if (!$retuen){
			copy(getcwd() . '/media/images/system/error-404.jpg', getcwd() . "/" . $path);
		}
	}else{
		return;
	}

}



function setCRC($record){
	$albumTrackID = 0;
	$ownerID = implodForCRC($record['owners']);

	$ownerPart = explode('_',$ownerID);
	if (count($ownerPart) >=5){
		$ownerID = array();
		for ($i = 0 ; $i<4 ; $i++){
			if(empty($ownerID)){
				$ownerID = $ownerPart[$i];
			}else{
				$ownerID .= '_'. $ownerPart[$i];
			}
		}
	}


	$albumID = $record['id'] . '-';
	$ganreID = implodForCRC($record['genres']);
	$eventID = 0 . '-';
	$territoryID = 0 . '-';
	$publisherID = implodForCRC($record['publisherID']) .'-';
	$publishYear = $record['publishYear'] .'-';
	$publishMonth = $record['publishMonth'];
	$CRC = $albumTrackID . '-' . $ownerID .'-' . $albumID . $ganreID  .'-'. $eventID . $territoryID . $publisherID . $publishYear . $publishMonth;
	return $CRC;
}
function getAddresByCRC($crc){
	$new_crc = explode('-',$crc);
	$address = 'media/albums/' . $new_crc[6] . '/' . $crc;
	return $address;
}

function setCRCOwner($ownerID){
	$ownerID 				 = $ownerID ;
	$CRC = '0-'. $ownerID . '-0-0-0-0-0-0-0';
	return $CRC;
}

function getAlbumCrcWithTrackCrc ($track_crc){
	$len = strlen($track_crc);
	$new_crc = substr($track_crc, 1, $len);
	$new_crc = '0' . $new_crc;

	return $new_crc;
}

function getPublisherIdWithAlbumId($album_crc){
	$parts = explode('-',$album_crc);
	return $parts[6];
}
function implodForCRC($value){
	$value  = explode(',' , $value);

	$newName = array();
	foreach ($value as $new_value){
		if(empty($newName)){
			$newName = $new_value  ;
		}else{
			$newName .= '_'.$new_value ;
		}

	}
	return $newName;
}


function getArtistName($persian_name,$english_name){

	$persian = explode(" ",$persian_name);
	$englisher = explode("-",$english_name);
	$english = explode("_",$englisher[0]);

	$count_name = count($english) - count($persian);

	$artist_name = array();
	for($i=0;$i<$count_name;$i++){
		if(empty($artist_name)){
			$artist_name = $english[$i];
		}else{
			$artist_name .='_'. $english[$i];
		}
	}
	return $artist_name;
}
function getFolderName ($name){
	return strtolower(substr($name,0,1));
}
function get_current_time($format = 'Y-m-d h:i:s'){
	return Date($format);
}



function ckeckExit($value){
	if(isset($value)){
		return $value;
	}else{
			return "";
	}
}

function setZero($value){
	if(empty($value)){
		return 0 ;
	}else{
		return $value;
	}
}


function filterSongFileName($song_name){
	$words = array( '[','^',':','*', '|','?', '"','<','>','$','!','`', ']' );
	return str_replace($words,'_',$song_name);
}


function filterAlbumName($song_name){
	$words = array( '[','^', '|', '#', ']' );
	return str_replace($words,'_',$song_name);
}

function getTrackCount($path,$count = true){
	if (!file_exists($path)){
		return 'floder not finde '. $path;
	}

	$filse = scandir($path);
	$mp3_file = array();
	foreach ($filse as $file){
		if(strHas('.mp3',$file)  OR strHas('.mp4',$file)){
			$mp3_file[] = $path .'/' .  $file;
		}
	}

	if($count == true){
		return count($mp3_file);
	}else{
		return $mp3_file;
	}

}

function getTrackName($path){
	if (!file_exists($path)){
		return 'floder not finde '. $path;
	}

	$filse = scandir($path);
	$mp3_file = array();
	foreach ($filse as $file){
		if(strHas('.mp3',$file)  OR strHas('.mp4',$file)){
			$mp3_file[] = str_replace('.mp3','',$file);
		}
	}
	sort($mp3_file);
	return $mp3_file;
}

function deletMp3Files($files){
	foreach($files as $file){ // iterate files
		if(is_file($file))
			unlink($file); // delete file
	}
}

function deletSpecialFile($file){
	if (!file_exists($file)){
		return 'file not finde: ' . $file;
	}

	if(is_file($file))
		unlink($file); // delete file
}

function CheckApiKey(){
	$result = array();
	foreach (apache_request_headers() as $key =>$value){
		if($key == 'X-TS-AGENT-SECRET'){
			$result = WebserviceModel::getApiKey($value);
		}
	}
	return $result;
}

function CheckApiKey1($key){
	$result = WebserviceModel::getApiKey($key);
	return $result;
}

function SetErrorInaccessibility(){
	$output['error']['code'] = '401';
	$output['error']['message'] = 'YOUR_ACCESS_IS_INVALID';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];

	WebserviceModel::setApiHistoryWithoutUserInformation(get_client_ip_env(),$error_code,1,$error_msge,get_current_time());
	return $output;

}

function SetErrorInvalidTrack($user_id){
	$output['error']['code'] = '404';
	$output['error']['message'] = 'TRACK_NOT_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}

function SetSuccessTrackReq($user_id){
	$output['error']['code'] = '1';
	$output['error']['message'] = 'TRACK_IS_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,0,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}

function SetSuccessSearchQuery($user_id,$query){
	$output['error']['code'] = '1';
	$output['error']['message'] = 'TRACK_IS_FOUND_WITH_QUERT';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,0,get_client_ip_env(),$error_code,$error_msge,$query,'',get_current_time());
	return json_encode($output);
}

function SetSuccessAlbumTracksReq($user_id){
	$output['error']['code'] = '1';
	$output['error']['message'] = 'ALBUM_TRACKS_IS_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}

function SetSuccessAlbumInfoReq($user_id){
	$output['error']['code'] = '1';
	$output['error']['message'] = 'ALBUM_IS_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,0,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}

function SetErrorInvalidAlbum($user_id){
	$output['error']['code'] = '404';
	$output['error']['message'] = 'ALBUM_NOT_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}


function SetErrorSearchNoResultsFound($user_id){
	$output['error']['code'] = '404';
	$output['error']['message'] = 'SEARCH_NOT_RESULTS_FOUND';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}


function SetErrorAlbumIsNotTrack($user_id){
	$output['error']['code'] = '404';
	$output['error']['message'] = 'ALBUM_IS_NOT_TRACK';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return json_encode($output);
}


function setErrorNotSendParametr($user_id){
	$output['error']['code'] = '400';
	$output['error']['message'] = 'PARAMETERS_IS_INVALID';

	$error_code = $output['error']['code'];
	$error_msge = $output['error']['message'];
	WebserviceModel::setApiHistoryWithUserInformation($user_id,1,get_client_ip_env(),$error_code,$error_msge,'',get_current_time());
	return ($output);
}

function get_client_ip_env() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}


function setDesimal($number){
	return (number_format($number,-2,',',','));

}

function removeAlbumIndexes($str,$value){

	$newarray = array();
	foreach ($value as $myvalue){
		if(strHas($str,$myvalue)){
			$removed = str_replace($str,'',$myvalue);
			$newarray[] =  $removed ;
		}else{
			$newarray[] =$myvalue;
		}

	}
	return $newarray;
}

function setAlbumVailidIndex($str,$value){

	$newarray = array();
	foreach ($value as $myvalue){
		if(strHas($str,$myvalue)){
			$removed = str_replace($str,'',$myvalue);
			$newarray[] = '`x_album`.' . '`' . $removed . '`';
		}else{
			$newarray[] =$myvalue;
		}

	}
	return $newarray;
}

function setTrackValidIndex($str,$value){
	$newarray = array();
	foreach ($value as $myvalue){
		if(strHas($str,$myvalue)) {
			$removed = str_replace($str, '', $myvalue);

			if($removed == 'id'){
				$removed = $removed . ' AS \'track_id\' ';
			}

			if($removed == 'name'){
				$removed = $removed . ' AS \'track_name\' ';
			}

			if($removed == 'engName'){
				$removed = $removed . ' AS \'track_engName\' ';
			}

			if($removed == 'engName'){
				$removed = $removed . ' AS \'track_engName\' ';
			}

			if($removed == 'lyrics'){
				$removed = $removed . ' AS \'track_lyrics\' ';
			}

			if($removed == 'price'){
				$removed = $removed . ' AS \'track_price\' ';
			}
			if($removed == 'trackDuration'){
				$removed = $removed . ' AS \'track_trackDuration\' ';
			}

			$newarray[] = '`x_track`.' . $removed;
		}else{
			$newarray[] = $myvalue;
		}
	}
	return $newarray;
}

function delAlbumFolder($album_crc){
	$album_folder = getAddresByCRC($album_crc);
	$fileaddress = getcwd() . '/' . $album_folder . '/';
	if (is_dir($fileaddress)){
		$scan_dir = scandir($fileaddress);
	}else{
		$scan_dir = '';
	}

	if ($scan_dir !=''){
		$folder_name = array();
		foreach($scan_dir as $sp_scan_dir){
			if ($sp_scan_dir == '.' OR $sp_scan_dir == '..'){
				continue;
			}
			if (strHas('.jpg',$sp_scan_dir) OR strHas('.jpeg',$sp_scan_dir)){
				unlink($fileaddress . '/' . $sp_scan_dir);
			}else if (strHas('.xlsx',$sp_scan_dir) ){
				unlink($fileaddress . '/' . $sp_scan_dir);
			}else if (strHas('.mp3',$sp_scan_dir) ){
				unlink($fileaddress . '/' . $sp_scan_dir);
			}else if (strHas('.zip',$sp_scan_dir) ){
				unlink($fileaddress . '/' . $sp_scan_dir);
			}else if (strHas('.mp4',$sp_scan_dir) ){
				unlink($fileaddress . '/' . $sp_scan_dir);
			}else{
				$folder_name []= $sp_scan_dir;
			}
		}
		foreach($folder_name as $sp_folder_name){
			$scan_dir = scandir($fileaddress . '/' .$sp_folder_name);
			foreach($scan_dir as $sp_scan_dir) {
				if ($sp_scan_dir == '.' OR $sp_scan_dir == '..'){
					continue;
				}
				unlink($fileaddress .$sp_folder_name . '/'  . $sp_scan_dir);
			}
			rmdir($fileaddress .$sp_folder_name);
		}

		rmdir($fileaddress);
	}





}




function getOS() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$os_platform =   "Unknow";
	$os_array =   array(
		'/windows nt 10/i'      =>  'Windows 10',
		'/windows nt 6.3/i'     =>  'Windows 8.1',
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
	);
	foreach ( $os_array as $regex => $value ) {
		if ( preg_match($regex, $user_agent ) ) {
			$os_platform = $value;
		}
	}
	return $os_platform;
}

function getBrowser() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$browser        = "Bilinmeyen Tarayıcı";
	$browser_array  = array(
		'/msie/i'       =>  'Internet Explorer',
		'/firefox/i'    =>  'Firefox',
		'/safari/i'     =>  'Safari',
		'/chrome/i'     =>  'Chrome',
		'/edge/i'       =>  'Edge',
		'/opera/i'      =>  'Opera',
		'/netscape/i'   =>  'Netscape',
		'/maxthon/i'    =>  'Maxthon',
		'/konqueror/i'  =>  'Konqueror',
		'/mobile/i'     =>  'Handheld Browser'
	);
	foreach ( $browser_array as $regex => $value ) {
		if ( preg_match( $regex, $user_agent ) ) {
			$browser = $value;
		}
	}
	return $browser;
}

function setOsIcon($os_name){
	$taninAppConfig = new taninAppConfig();
	$os_platform =   '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-unknow.png' .'" with="16" height="16" alt="Unknow" />';
	$os_array =   array(
		'Windows 10'      =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows10.png' .'" with="16" height="16" alt="Windows 10" />',
		'Windows 8.1'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows10.png' .'" with="16" height="16" alt="Windows 8.1" />',
		'Windows 8'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows10.png' .'" with="16" height="16" alt="Windows 8" />',
		'Windows 7'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows 7" />',
		'Windows Vista'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows Vista" />',
		'Windows Server 2003/XP x64'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows Server 2003/XP x64" />',
		'Windows XP'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows XP" />',
		'Windows XP'         =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows XP" />',
		'Windows 2000'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows 2000" />',
		'Windows ME'         =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows ME" />',
		'Windows 98'              =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows 98" />',
		'Windows 95'              =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows 95" />',
		'Windows 3.11'              =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-windows7.png' .'" with="16" height="16" alt="Windows 3.11" />',
		'Mac X' =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-apple.png' .'" with="16" height="16" alt="Mac X" />',
		'Mac 9'        =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-apple.png' .'" with="16" height="16" alt="Mac 9" />',
		'Linux'              =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-linux.png' .'" with="16" height="16" alt="Linux" />',
		'Ubuntu'             =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-ubuntu.png' .'" with="16" height="16" alt="Ubuntu" />',
		'iPhone'             =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-iphone.png' .'" with="16" height="16" alt="iPhone" />',
		'iPod'               =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-ipad.png' .'" with="16" height="16" alt="iPod" />',
		'iPad'               =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-ipad.png' .'" with="16" height="16" alt="iPad" />',
		'Android'            =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-android.png' .'" with="16" height="16" alt="Android" />',
		'BlackBerry'         =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-blackberry.png' .'" with="16" height="16" alt="BlackBerry" />',
		'Mobile'              =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-mobile.png' .'" with="16" height="16" alt="Mobile" />'
	);
	foreach ( $os_array as $key => $value ) {
		if ( $os_name == $key ) {
			$os_platform = $value;
		}
	}
	return $os_platform;
}

function setBrowserIcon($browser_name) {
	$taninAppConfig = new taninAppConfig();
	$browser        = '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/os-icon/os-unknow.png' .'" with="16" height="16" alt="Unknow" />';
	$browser_array  = array(
		'Internet Explorer'       =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-internet-explorer.png' .'" with="16" height="16" alt="Internet Explorer" />',
		'Firefox'    =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-firefox.png' .'" with="16" height="16" alt="Firefox" />',
		'Safari'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-safari.png' .'" with="16" height="16" alt="Safari" />',
		'Chrome'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-chrome.png' .'" with="16" height="16" alt="Chrome" />',
		'Edge'       =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-edge.png' .'" with="16" height="16" alt="Edge" />',
		'Opera'      =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-opera.png' .'" with="16" height="16" alt="Opera" />',
		'Netscape'   =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-netscape.png' .'" with="16" height="16" alt="Netscape" />',
		'Maxthon'    =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-metroui-maxthon.png' .'" with="16" height="16" alt="Maxthon" />',
		'Konqueror'  =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-konqueror.png' .'" with="16" height="16" alt="Konqueror" />',
		'Handheld Browser'     =>  '<img src="'.$taninAppConfig->base_url . 'template/'.$taninAppConfig->template_name . '/assets/images/browser-icon/16/browser-handheld-browser.png' .'" with="16" height="16" alt="Handheld Browser" />',
	);
	foreach ( $browser_array as $key => $value ) {
		if ($browser_name == $key  ) {
			$browser = $value;
		}
	}
	return $browser;
}

function getTimeElapsed($time) {
	$currentTime = get_current_time();

	$time = new DateTime($time);
	$currentTime = new DateTime($currentTime);

	$interval = $currentTime->diff($time);



	return $interval;

}


function getUserActivatyIcon($section){
	if ($section == 'album'){
		return 'fa fa-play-circle';
	}elseif ($section == 'account'){
		return 'fa fa-user';
	}elseif ($section == 'report'){
		return 'fa fa-file-archive-o';
	}elseif ($section == 'dashboard'){
		return 'fa fa-dashboard';
	}elseif ($section == 'track'){
		return 'fa fa-music';
	}elseif ($section == 'tag'){
		return 'fa fa-tags';
	}elseif ($section == 'owner'){
		return 'fa fa-id-card-o';
	}elseif ($section == 'genre'){
		return 'fa fa-camera-retro';
	}else{
		return 'fa fa-question-circle-o';
	}
}

function checkActivatyStatus($last_des,$curent_des){
	if($last_des == $curent_des){
		return false;
	}else{
		return true;
	}
}
?>
