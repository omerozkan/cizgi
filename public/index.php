<?php 
define("APPLICATION_PATH", "../application");
define("LIBRARY_PATH", "../library");

require_once APPLICATION_PATH.'/bootstrap.php';

$bootstrap = new Application_Bootstrap();

try {
$bootstrap->execute();

}

catch(Exception $ex)
{
	echo $ex->getMessage().'<br>';
	echo $ex->getTraceAsString();
}