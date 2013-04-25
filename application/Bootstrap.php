<?php
class Bootstrap extends Cizgi_Bootstrap
{
	function __construct()
	{
		$urlDispatcher = new Cizgi_URLDispatcher();
		$urlDispatcher->setDefaultController(Configuration::$defaultController);
		$view = new Cizgi_View();
		$view->setHTMLData('title', 'Çizgi Uygulama Çatısı');
		parent::__construct($urlDispatcher, $view);
		$this->setDeveloperMode(true);
	}
}