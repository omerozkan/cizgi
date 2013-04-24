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
		$this->assertEquals(APPLICATION_PATH."/views/controller",
				$this->view->getViewDir());
		$this->assertEquals('action.'.Cizgi_View::GET_VIEW_EXTENTION(),
				$this->view->getViewFile());
	}
	
	public function testGetCacheDirAndCompileDir()
	{
		$this->assertEquals(ROOT_PATH.'/'.Cizgi_View::SMARTY_CACHE.'/', 
				$this->view->getCacheDir());
		$this->assertEquals(ROOT_PATH.'/'.Cizgi_View::SMARTY_COMPILE.'/', 
				$this->view->getCompileDir());
	}
	
	public function testRenderView()
	{
		$this->view->setOutput('action', 'controller');
		$this->view->renderView();
		$this->assertTrue($this->view->rendered);	
	}
	
	public function testTemplateDir()
	{
		$dir = $this->view->getTemplateDir();
		$this->assertEquals(APPLICATION_PATH.'/layouts/', $dir[0]);
	}
	
	public function testLayout()
	{
		$this->view->setLayout("index");
		$this->assertEquals('index.phtml', 
				$this->view->getLayout());
		
	}
	
	public function testLoadLayoutEnable()
	{
		$this->view->setLayout("index");
		$this->view->enableLayout();
		$this->view->render();
		$this->assertTrue($this->view->layoutLoaded);
	}
	
	public function testLoadLayoutDisable()
	{
		$this->view->setOutput('action', 'controller');
		$this->view->setLayout("index");
		$this->view->enableLayout();
		$this->view->disableLayout();
		$this->view->render();
		$this->assertFalse($this->view->layoutLoaded);
		$this->assertTrue($this->view->rendered);
	}
	
	
	public function testAssign()
	{
		$this->view->var = 'testerValue';
		$this->assertTrue($this->view->assigned);
	}
	
	/**
	 * @expectedException Cizgi_View_IllegalVariableException
	 */
	public function testAssignHTMLIllegal()
	{
		$this->view->html = 'Something';
	}
	
	/**
	 * @expectedException Cizgi_View_IllegalVariableException
	 */
	public function testAssignCizgiIllegal()
	{
		$this->view->cizgi = 'Something';
	}
	
	public function testInitHTML()
	{
		$this->view->setHTMLData('title', 'test');
		$this->view->render();
		$html = $this->view->getVariable('html')->value;
		$this->assertEquals('test', $html['title']);
	}
	
}

class Test_Library_Mock_View extends Cizgi_View
{
	public $rendered = false;
	public $layoutLoaded = false;
	public $assigned = false;
	public $htmlInitialized = false;
	
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
		if($fileName == "[v]action.".Cizgi_View::GET_VIEW_EXTENTION())
			$this->rendered = true;
		if($fileName == 'index.phtml')
			$this->layoutLoaded = true;
	}
	
	function assign($tpl_var, $value)
	{
		parent::assign($tpl_var, $value);
		if($value == 'testerValue' && $tpl_var == 'var')
		{
			$this->assigned = true;
		}
		if($value == 'html')
		{
			$this->htmlInitialized = true;
		}
	}
}