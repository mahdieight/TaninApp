<?php
class view{

  public static function render($path,$data){
    $taninAppConfig = new taninAppConfig();
    if(!empty($data)){
      extract($data);
    }

  ob_start();
  require_once(getcwd() . '/template/' . $taninAppConfig->template_name .'/view/'. $path );
  $component = ob_get_clean();
  require_once(getcwd() . '/template/' . $taninAppConfig->template_name .'/index.php');
  }


	public static function render_part($path,$data){
		$taninAppConfig = new taninAppConfig();
		if(!empty($data)){
			extract($data);
		}
		require_once(getcwd() . '/template/' . $taninAppConfig->template_name .'/view/'. $path );

	}

	public static function render_error($url){
		$taninAppConfig = new taninAppConfig();

		require_once(getcwd() . '/template/' . $taninAppConfig->template_name .$url );
	}
}
?>
