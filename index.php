<?php

require_once(getcwd() . '/system/loader.php');
$taninAppConfig = new taninAppConfig();

//$password_mahdi = '0912@mahdi@0922';
//$password_asgharian = 'abcd$8l4123'; //Hassan Chobin - level1 - Hashempor
//$password_rajabi = 'jol$3+9856!)kwj';

//$n_m = md5($password_mahdi . $taninAppConfig->salt_password);
//$n_a = md5($password_asgharian . $taninAppConfig->salt_password);
//$n_r = md5($password_rajabi . $taninAppConfig->salt_password);

#GET THE URL Entered
$request_url = $_SERVER['REQUEST_URI'];

#Delete The Base Url From Uri
$request_url = str_replace($taninAppConfig->base_url ,'',$request_url);

#set the page home; for show home page in empty url;
if(empty($request_url)){
	$request_url = 'page/dashboard/';
}

#Explode The URI By '/' For Get Contoller,method,...
$request_url = explode('/',$request_url);

#Srt Method And Controller Name
$controller_name  = ucfirst($request_url[0]) . 'Controller';
if(isset($request_url[1])){
	$method_name = $request_url[1];
}else{
	$method_name = '';
}

#SET The Params for Method
$params = array();
if(isset($request_url[2]) && !empty($request_url[2])){
	$countParams = count($request_url);
	for($i = 2; $i<$countParams; $i++){
		$params[] = $request_url[$i];
	}
}

$controller_instance = new $controller_name;
if (!method_exists($controller_instance,$method_name)) {
	showErrorPageAdmin();
}

call_user_func_array(array($controller_instance, $method_name), $params);

?>
