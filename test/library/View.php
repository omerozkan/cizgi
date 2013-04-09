<?php
class Test_Library_View extends PHPUnit_Framework_TestCase
{
	private $url;
	public function setUp()
	{
		$this->view = new Test_Library_Mock_View();
		$this->url = "http://localhost/cizgi/";
	}
	public function testGetLinkRegular()
	{
		$this->assertEquals($this->url."omer/ozkan", 
				$this->view->getLink("omer", "ozkan"));
	}
	
	public function testGetLinkWithoutController()
	{
		$this->assertEquals($this->url, 
				$this->view->getLink());
	}
	
	public function testGetLinkWithParameters()
	{
		$this->assertEquals($this->url."controller/index/parameter1",
				$this->view->getLink("controller", "index", "parameter1"));
		
		$this->assertEquals($this->url."controller/index/parameter1/parameter2",
				$this->view->getLink("controller", "index", array("parameter1", "parameter2")));
	}
	
	public function testGetLinkWithExtention()
	{
		$this->assertEquals($this->url."controller/index/parameter.pdf", 
				$this->view->getLink("controller", "index", "parameter", "pdf"));
	}
	
	public function testFrontEndDir()
	{
		$this->assertEquals($this->url."public/images", $this->view->getImagesDir());
		$this->assertEquals($this->url."public/js", $this->view->getScriptsDir());
		$this->assertEquals($this->url."public/css", $this->view->getStylesDir());
		$this->assertEquals($this->url."public/css/style.css", $this->view->getStyle());
	}
	
}

class Test_Library_Mock_View extends Cizgi_View
{
	function getApplicationUrl()
	{
		return "http://localhost/cizgi";
	}
	
	function getApplicationDefaultExtention()
	{
		return "";
	}
}