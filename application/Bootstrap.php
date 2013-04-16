<?php
class Bootstrap extends Cizgi_Bootstrap
{
	function __construct()
	{
		$urlDispatcher = new Cizgi_URLDispatcher();
		$urlDispatcher->setDefaultController(Configuration::$defaultController);
		parent::__construct($urlDispatcher);
		$this->setDeveloperMode(true);
	}
}