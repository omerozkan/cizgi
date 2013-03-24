<?php
/**
 * Sadece bootstrap değil aynı zamanda View ve Controller sınıflarını da test eder
 * @author Ömer Özkan <omer@ozkan.info>
 *
 */
class Test_Library_Boostrap extends PHPUnit_Framework_TestCase
{ 
	private $urlDispatcher;
	private $controller;
	private $view;
	private $bootstrap;
	
	function setUp()
	{
		$this->urlDispatcher = new Cizgi_URLDispatcher();
		$this->controller = new Controller_Mock();
		$this->indexController = new Controller_Index();
		$this->urlDispatcher->setDefaultController("mock");
		$this->view = new Mock_View();
		$this->bootstrap = new Mock_Bootstrap($this->urlDispatcher);
	}
	
	function testRunWithDefaultController()
	{
		$bootstrap = $this->bootstrap;
		$bootstrap->run();
		$this->assertEquals($this->controller, $bootstrap->getController());
		$this->assertEquals("indexAction", $bootstrap->getAction());
		
		$this->bootstrap->run("/index/another");
		$this->assertEquals($this->indexController, $bootstrap->getController());
		$this->assertEquals("anotherAction", $bootstrap->getAction());
		
		$this->bootstrap->run("/index");
		$this->assertEquals($this->indexController, $bootstrap->getController());
		$this->assertEquals("indexAction", $bootstrap->getAction());
	}
	
	/**
	 * @expectedException Cizgi_Bootstrap_Controller_Not_Found
	 */
	function testRunWithControllerAndNoDefClass()
	{
		$this->bootstrap->run("/ozkan");
	}
	
	/**
	 * @expectedException Cizgi_Bootstrap_Action_Not_Found
	 */
	function testActionNotFound()
	{
		$this->bootstrap->run("/index/notfound");
	}
	
}


class Controller_Mock extends Cizgi_Controller
{
	function init() {
	}
	
	public function indexAction()
	{
		
	}
}

class Controller_Index extends Cizgi_Controller
{
	function init() {
	}
	
	public function indexAction()
	{
	
	}
	
	public function anotherAction()
	{
		
	}
}

class Mock_Bootstrap extends Cizgi_Bootstrap
{
	
}

class Mock_View extends Cizgi_View
{
	
}