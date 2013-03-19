<?php 
defined('LIBRARY_PATH') or die("GET OUT");
defined('APPLICATION_PATH') or die("GET OUT");
require_once LIBRARY_PATH.'/ozkan/main.php';
class Application_Bootstrap extends Ozkan_Bootstrap
{
	public function initTitle()
	{
		$this->view->setTitle("Rehber - Mku Proje");	
	}
	
	public function initDescription()
	{
		$this->view->setDescription("Internet Programlama Dersi - Rehber Uygulaması");
	}
}