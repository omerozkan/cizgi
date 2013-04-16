<?php 
define("APPLICATION_PATH", "../application");
define("ROOT_PATH", "..");
define("LIBRARY_PATH", "../library");

require_once LIBRARY_PATH.'/cizgi/autoload.php';



try {
	if(!isset($_SERVER['PATH_INFO']))
		$request = null;
	else
		$request = $_SERVER['PATH_INFO'];
	$bootstrap = new Bootstrap();
	$bootstrap->run($request);
}

catch(Exception $ex)
{
	echo '<h3>'.$ex->getMessage().'</h3><hr>';
	echo $ex->getTraceAsString();
}