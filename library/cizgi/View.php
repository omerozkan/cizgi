<?php
class Cizgi_View extends Smarty {
	
	const GET_PUBLIC_DIR = "public";
	const VIEW_DIR = "views";
	const LAYOUT_DIR = "layouts";
	const SMARTY_CACHE = 'cache';
	const SMARTY_COMPILE = "cache";
	const VIEW_TEMPLATE_PREFIX = "[v]";
	protected $imagesDir = "images";
	protected $scriptsDir = "js";
	protected $stylesDir = "css";
	protected $defaultStyle = "style.css";
	protected $htmlData = array();
	protected $controller;
	protected $action;
	protected $layoutFile;
	protected $layoutEnabled;
	private $illegalVariables = array('html', 'cizgi');
	
	static function GET_VIEW_EXTENTION()
	{
		return Configuration::$viewDefaultExtention;
	}
	
	static function GET_PUBLIC_DIR()
	{
		return Configuration::$publicDirectory;
	}
	
	public function __construct()
	{
		parent::__construct();
		$this->setCacheDir(ROOT_PATH.'/'.self::SMARTY_CACHE);
		$this->setCompileDir(ROOT_PATH.'/'.self::SMARTY_CACHE);
		$this->setTemplateDir(APPLICATION_PATH.'/'.self::LAYOUT_DIR);
		$this->layoutEnabled = Configuration::$viewLayout == 1;
		$this->setLayout(Configuration::$viewDefaultLayout);
	}
	
	/**
	 * Girilen parametrelere göre bir url oluşturur
	 * @param string $controller
	 * @param string $action
	 * @param string or array $parameters
	 * @param string $ext uzantı
	 * @return string
	 */
	public function getLink($controller = null, $action = null, $parameters = null, $ext = null) {
		if (is_null ( $controller )) {
			return $this->getApplicationUrl () . "/";
		} else {
			$link = "";
			$link .= sprintf ( "%s/%s/%s", $this->getApplicationUrl (), $controller, $action );
			$link = $this->addParameters ( $parameters, $link );
			
			if(is_null($ext))
			{
				$ext = $this->getApplicationDefaultExtention();
			}
			if(!empty($ext))
			{
				$link .= '.'.$ext;
			}
			return $link;
		}
	}
	
	/**
	 * link değerine parametreleri ekler ve geri dönderir
	 * @param string or array $parameters
	 * @param string $link
	 * @return string
	 */
	private function addParameters($parameters, $link) {
		if (is_string ( $parameters )) {
			$link = $this->mergeParameters ( $parameters, $link );
		}
		if (is_array ( $parameters )) {
			$parameters = implode ( '/', $parameters );
			$link = $this->mergeParameters ( $parameters, $link );
		}
		return $link;
	}
	/**
	 * Parametreleri url bağlantısına ekler
	 * @param string $parameters
	 * @param string $link
	 * @return string
	 */
	private function mergeParameters($parameters, $link) {
		$link .= sprintf ( "/%s", $parameters );
		return $link;
	}
	
	/**
	 * Uygulamanın URL'i
	 */
	public function getApplicationUrl() {
		return Configuration::$url;
	}
	
	/**
	 * Uygulamanın varsayılan uzantısı
	 */
	public function getApplicationDefaultExtention()
	{
		return Configuration::$defaultExtention;
	}
	
	public function getImagesDir()
	{
		return $this->getApplicationUrl()."/".self::GET_PUBLIC_DIR()."/".$this->imagesDir;
	}
	
	public function getScriptsDir()
	{
		return $this->getApplicationUrl()."/".self::GET_PUBLIC_DIR()."/".$this->scriptsDir;
	}
	
	public function getStylesDir()
	{
		return $this->getApplicationUrl()."/".self::GET_PUBLIC_DIR()."/".$this->stylesDir;
	}
	
	public function getStyle()
	{
		return $this->getApplicationUrl()."/".self::GET_PUBLIC_DIR()."/"
				.$this->stylesDir."/".$this->defaultStyle;
	}
	
	/**
	 * @param string $imagesDir
	 */
	public function setImagesDir($imagesDir) {
		$this->imagesDir = $imagesDir;
	}
	
	/**
	 * @param string $scriptsDir
	 */
	public function setScriptsDir($scriptsDir) {
		$this->scriptsDir = $scriptsDir;
	}
	
	/**
	 * @param string $stylesDir
	 */
	public function setStylesDir($stylesDir) {
		$this->stylesDir = $stylesDir;
	}
	
	/**
	 * @param string $defaultStyle
	 */
	public function setStyle($defaultStyle) {
		$this->defaultStyle = $defaultStyle;
	}
	
	public function getHTMLData($key = null)
	{
		if(!array_key_exists($key, $this->htmlData)){
			return null;
		}
		return $this->htmlData[$key];
	}
	
	public function setHTMLData($key, $value)
	{
		$this->htmlData[$key] = $value;
	}
	
	public function setOutput($action, $controller = null)
	{
		$this->action = $action;
		if(!is_null($controller))
		{
			$this->controller = $controller;
		}
	}
	
	public function getViewFile()
	{
		//return sprintf("%s/%s/%s/%s.%s", APPLICATION_PATH, self::VIEW_DIR, 
		//		$this->controller, $this->action, self::GET_VIEW_EXTENTION());
		return sprintf("%s.%s", $this->action, self::GET_VIEW_EXTENTION());
		
	}
	
	public function getViewDir()
	{
		return sprintf("%s/%s/%s", APPLICATION_PATH, self::VIEW_DIR,
						$this->controller);
	}
	
	public function renderView()
	{
		$this->addTemplateDir($this->getViewDir(), 'v');
	    $this->display(self::VIEW_TEMPLATE_PREFIX.$this->getViewFile());
	}
	
	public function renderLayout()
	{
		$this->display($this->getLayout());
	}
	
	public function render()
	{
		$this->initSpecialVariables ();
		if($this->layoutEnabled)
			$this->renderLayout();
		else
			$this->renderView();
	}
	
	private function initSpecialVariables() {
		parent::assign('html', $this->htmlData);
	}

	
	public function setLayout($layout)
	{
		$this->layoutFile = $layout.'.'.self::GET_VIEW_EXTENTION();
	}
	
	protected function getLayout()
	{
		return $this->layoutFile;
	}
	
	public function enableLayout()
	{
		$this->layoutEnabled = true;
	}
	
	public function disableLayout()
	{
		$this->layoutEnabled = false;	
	}
	
	public function __set($name, $value)
	{
		$this->assign($name, $value);
	}
	
	public function assign($tpl_var, $value = null, $nocache = false)
	{
		$this->checkVariableName ( $tpl_var );
		parent::assign($tpl_var, $value, $nocache);
	}
	
	private function checkVariableName($name) {
		if(in_array($name, $this->illegalVariables))
		{
			throw new Cizgi_View_IllegalVariableException($name.' is not allowed for template files');
		}
	}

}

class Cizgi_View_IllegalVariableException extends RuntimeException {}