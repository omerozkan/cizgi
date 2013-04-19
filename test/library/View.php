<?php
class Test_Library_View extends PHPUnit_Framework_TestCase
{
	private $url;
	public function setUp()
	{
		$this->view = new Test_Library_Mock_View();
		$this->url = "http://localhost/cizgi/";
	}
	public function testGetLink()
	{
		$this->assertEquals($this->url."omer/ozkan", 
				$this->view->getLink("omer", "ozkan"));
		$this->assertEquals($this->url, 
				$this->view->getLink());
		$this->assertEquals($this->url."controller/index/parameter1",
				$this->view->getLink("controller", "index", "parameter1"));
		
		$this->assertEquals($this->url."controller/index/parameter1/parameter2",
				$this->view->getLink("controller", "index", array("parameter1", "parameter2")));
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
	
	public function testHTMLData()
	{
		$this->view->setHTMLData('doctype', Cizgi_HTML::$HTML5);
		$this->assertEquals(Cizgi_HTML::$HTML5, $this->view->getHTMLData('doctype'));
		
	}
	
	public function testHTMLDataWithNonExistKey()
	{
		$this->assertNull($this->view->getHTMLData('nonexist'));
	}
	
	public function testGetControllerTplFile()
	{
		$this->view->setOutput('action', 'controller');
		$this->assertEquals(APPLICATION_PATH."/views/controller/action.".Cizgi_View::EXTENTION,
				$this->view->getViewFile());
	}
	
	public function testGetCacheDirAndCompileDir()
	{
		$this->assertEquals(ROOT_PATH.'/'.Cizgi_View::SMARTY_CACHE.'/', 
				$this->view->getCacheDir());
		$this->assertEquals(ROOT_PATH.'/'.Cizgi_View::SMARTY_COMPILE.'/', 
				$this->view->getCompileDir());
	}
	
	public function testRender()
	{
		$this->view->setOutput('action', 'controller');
		$this->view->render();
		$this->assertTrue($this->view->rendered);	
	}
}

class Test_Library_Mock_View extends Cizgi_View
{
	public $rendered = false;
	
	function getApplicationUrl()
	{
		return "http://localhost/cizgi";
	}
	
	function getApplicationDefaultExtention()
	{
		return "";
	}
	
	function display($fileName)
	{
		if($fileName == APPLICATION_PATH."/views/controller/action.".Cizgi_View::EXTENTION)
			$this->rendered = true;
	}
}