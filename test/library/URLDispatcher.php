<?php
class Test_Library_URLDispatcher extends PHPUnit_Framework_TestCase {
	private $bootstrap;
	
	function setUp()
	{
		$this->bootstrap = new Cizgi_URLDispatcher();
	}
	
	function testDispatchUrlController()
	{
		$this->bootstrap->dispatch("/controller");
		$this->assertEquals("controller", $this->bootstrap->getController());
		$this->assertEquals("index", $this->bootstrap->getAction());
		$this->assertCount(0, $this->bootstrap->getParameters());
	}
	
	function testDispatchUrlAction()
	{
		$this->bootstrap->dispatch("/controller/action");
		$this->assertEquals("controller", $this->bootstrap->getController());
		$this->assertEquals("action", $this->bootstrap->getAction());
		$this->assertCount(0, $this->bootstrap->getParameters());
	}
	
	function testDispatchUrlEmptyUrl()
	{
		$this->bootstrap->dispatch();
		$this->bootstrap->setDefaultController("controller");
		$this->assertEquals("controller",$this->bootstrap->getController());
		$this->assertEquals("index", $this->bootstrap->getAction());
		$this->assertCount(0, $this->bootstrap->getParameters());
	}
	
	function testDispatchUrlParameter()
	{
		$this->bootstrap->dispatch("/controller/action/parameter");
		$this->assertEquals("controller", $this->bootstrap->getController());
		$this->assertEquals("action", $this->bootstrap->getAction());
		$parameters = $this->bootstrap->getParameters();
		$this->assertCount(1, $parameters);
		$this->assertEquals("parameter", $parameters[0]);
	}
	
}