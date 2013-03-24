<?php
class Test_Library_Controller extends PHPUnit_Framework_TestCase
{
	function setUp()
	{
		$this->controller = new Mock_Controller();
	}
	function testViewAsSameObject()
	{
		$view = new Test_View();
		$this->controller->setView($view);
		$this->assertSame($view, $this->controller->getView());
	}
	
	function testBootstrapAsSameObject()
	{
		$bootstrap = new Cizgi_Bootstrap();
		$this->controller->setBootstrap($bootstrap);
		$this->assertSame($bootstrap, $this->controller->getBootstrap($bootstrap));
	}
	
	function testInit()
	{
		
	}
}

class Mock_Controller extends Cizgi_Controller
{
	function init() {
		
	}
	function indexAction() {
	}

}
class Test_View extends Cizgi_View
{
	
}