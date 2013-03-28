<?php
/**
 * Sadece bootstrap değil aynı zamanda View ve Controller sınıflarını da test eder
 * @author Ömer Özkan <omer@ozkan.info>
 *
 */
class Test_Library_Boostrap extends PHPUnit_Framework_TestCase
{ 
	private $urlDispatcher;
	private $defaultController, $indexController;
	private $view;
	private $bootstrap;
	
	function setUp()
	{
		$this->urlDispatcher = new Cizgi_URLDispatcher();
		$this->view = new Mock_View();
		$this->bootstrap = new Mock_Bootstrap($this->urlDispatcher);
		$this->bootstrap->mockView = $this->view;
		$this->defaultController = new Controller_Mock($this->bootstrap, $this->view);
		$this->indexController = new Controller_Index($this->bootstrap, $this->view);
		$this->urlDispatcher->setDefaultController("mock");
	}
	
	function testRunWithDefaultController()
	{
		$bootstrap = $this->bootstrap;
		$bootstrap->run();
		$this->assertEquals($this->defaultController, $bootstrap->getController());
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
	function xtestRunWithControllerAndNoDefClass()
	{
		$this->bootstrap->run("/ozkan");
	}
	
	/**
	 * @expectedException Cizgi_Bootstrap_Action_Not_Found
	 */
	function xtestActionNotFound()
	{
		$this->bootstrap->run("/index/notfound");
	}
	
	function testActionMethodInvoked()
	{
		$this->bootstrap->run("/index/invoked");
		$this->assertTrue($this->bootstrap->getController()->invoked);
		$this->bootstrap->run("/index/param/parameter");
		$this->assertTrue($this->bootstrap->getController()->invoked);
	}

	function testErrorController()
	{
		$this->bootstrap->run("/foo/none");
		$this->assertEquals("error", $this->bootstrap->getController()->name);
		$this->assertTrue($this->bootstrap->getController()->invoked);
	}
	
	function testRedirection()
	{
		$this->bootstrap->run("/index/redirect");
		$this->assertTrue($this->defaultController->equals($this->bootstrap->getController()));
		$this->assertEquals("redirectedpageAction", $this->bootstrap->getAction());
	}
	
	function testRedirectionWithParameters()
	{
		$this->bootstrap->run("/index/redirectparam/parameter");
		$this->assertTrue($this->indexController->equals($this->bootstrap->getController()));
		$this->assertEquals("paramAction", $this->bootstrap->getAction());
		$this->assertTrue($this->bootstrap->getController()->invokedParam);
	}
	
}

class Mock_Bootstrap extends Cizgi_Bootstrap
{
	public $mockView;
	
	public function getErrorController()
	{
		return "error";
	}
	
	protected function getView()
	{
		return $this->mockView;
	}
}

class Controller_Mock extends Cizgi_Controller
{
	
	function init() {
	}
	
	public function indexAction()
	{
		
	}
	
	public function redirectedpageAction()
	{
		
	}
}

class Controller_Error extends Cizgi_Controller
{
	public $name = "error";
	public  $invoked = false;
	
	public function init()
	{
		
	}
	
	public function indexAction()
	{
		$this->invoked = true;
	}
	
}

class Controller_Index extends Cizgi_Controller
{
	public $invoked = false;
	public $invokedParam = false;
	
	function init() {
	}
	
	public function indexAction()
	{
	
	}
	
	public function anotherAction()
	{
		
	}
	
	public function invokedAction()
	{
		$this->invoked = true;
	}
	
	public function paramAction($parameters)
	{
		if($parameters[0] == "parameter")
		{
			$this->invoked = true;
		}
		if($parameters[0] == "invoked")
		{
			$this->invokedParam = true;
		}
	}
	
	public function redirectAction()
	{
		$this->redirect("mock", "redirectedpage");
	}
	
	public function redirectparamAction($parameters)
	{
		$this->redirect("index", "param", array('invoked'));
	}
}

class Mock_View extends Cizgi_View
{
}