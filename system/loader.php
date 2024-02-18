<?php
session_start();
require_once(getcwd() . '/config.php');

$taninAppConfig = new taninAppConfig();


require_once(getcwd() . '/system/core.php');
require_once(getcwd() . '/system/DB.php');
require_once(getcwd() . '/system/functions.php');
require_once(getcwd() . '/system/view.php');

date_default_timezone_set('Asia/Tehran');
?>
