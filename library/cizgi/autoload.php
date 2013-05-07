<?php
/**
 * @package Cizgi
 * @version 0.1
 */
require ROOT_PATH."/library/cizgi/Autoloader.php";
spl_autoload_register("__autoload");
$AUTOLOADER = null;

function __autoload($name)
{
	global $AUTOLOADER;
	initializeAutoLoader ( $AUTOLOADER );
	$file = $AUTOLOADER->getClassFile($name);
	if(file_exists($file))
		require $file;
	else
	{
	//	throw new Cizgi_Class_Not_Found_Exception("class: $name\n<br> file: $file has not found!");
	}
}

function initializeAutoLoader() {
	global $AUTOLOADER;
	if(is_null($AUTOLOADER))
	{
		$AUTOLOADER = new Cizgi_Autoloader();
	}
}
/**
 * @package Cizgi
 */
class Cizgi_Class_Not_Found_Exception extends RuntimeException{}
