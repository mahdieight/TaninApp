<?php
function __autoload($classname) {

  $realEstateConfig = new taninAppConfig();
  if(strHas('Controller',$classname)){
/*    if($classname == "ExportController"){
			require_once(getcwd() . '/app/PHPExcel.php');
    }*/
    $filename = str_replace('Controller','',$classname);
    $filename = '/' . strtolower($filename) . '.php';

    if(file_exists(getcwd() . $realEstateConfig->controller_path . $filename)){
      require_once(getcwd() . $realEstateConfig->controller_path . $filename);
    }else{
			showErrorPageAdmin();
    }
  }elseif (strHas('Model',$classname)) {
    $filename = str_replace('Model','',$classname);
    $filename = '/' . strtolower($filename) . '.php';
    require_once(getcwd() . $realEstateConfig->method_path . $filename);
  }
}
 ?>
