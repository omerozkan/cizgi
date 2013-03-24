<?php
define('ROOT_PATH', ".");
define('APPLICATION_PATH', "./application");
require "library/cizgi/Autoloader.php";

spl_autoload_register('testAutoload');

function testAutoload($name)
{
	$loader = new Cizgi_Autoloader;
	$file = $loader->getClassFile($name);
	if(file_exists($file))
		require $file;
}