<?php
/**
 * Uygulamada kullanılan View sınıfı
 * @author Ömer Özkan <omer@ozkan.info>
 * @package Cizgi
 * @version 0.1
 */
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
	protected $htmlData = array ();
	protected $controller;
	protected $action;
	protected $layoutFile;
	protected $layoutEnabled;
	private $illegalVariables = array (
			'html',
			'cizgi' 
	);
	
	/**
	 * Configuration ile ayarlanan template dosyalarının varsayılan uzantısı
	 * @return string dosya uzantısı
	 */
	static function GET_VIEW_EXTENTION() {
		return Configuration::$viewDefaultExtention;
	}
	/**
	 * uygulamanın çalıştığı public dizini
	 * @return string public dizininin tam yolu
	 */
	static function GET_PUBLIC_DIR() {
		return Configuration::$publicDirectory;
	}
	/**
	 * Temalarda view'leri otomatik entegre etmek için yazılan smarty plugin fonksiyonu
	 * @param array $params parametreler
	 * @param Smarty $smarty smarty nesnesi
	 */
	static function VIEW($params, $smarty) {
		$smarty->renderView ();
	}
	
	public function __construct() {
		parent::__construct ();
		$this->initDirs ();
		$this->initLayout ();
		$this->initPlugins ();
	}
	/**
	 * Smarty için gerekli plugin tanımlamalarını yapar
	 */
	private function initPlugins() {
		$this->registerPlugin ( 'function', 'cizgiview', 'Cizgi_View::VIEW' );
	}
	
	/**
	 * Uygulamada kullanılacak olan layout bilgilerini tanımlar
	 */
	private function initLayout() {
		$this->layoutEnabled = Configuration::$viewLayout == 1;
		$this->setLayout ( Configuration::$viewDefaultLayout );
	}
	
	/**
	 * smarty ile ilgili dizin tanımları yapar
	 */
	private function initDirs() {
		$this->setCacheDir ( ROOT_PATH . '/' . self::SMARTY_CACHE );
		$this->setCompileDir ( ROOT_PATH . '/' . self::SMARTY_CACHE );
		$this->setTemplateDir ( APPLICATION_PATH . '/' . self::LAYOUT_DIR );
	}
	
	/**
	 * Girilen parametrelere göre bir url oluşturur
	 * 
	 * @param string $controller        	
	 * @param string $action        	
	 * @param
	 *        	string or array $parameters
	 * @param string $ext
	 *        	uzantı
	 * @return string
	 */
	public function getLink($controller = null, $action = null, $parameters = null, $ext = null) {
		if (is_null ( $controller )) {
			return $this->getApplicationUrl () . "/";
		} else {
			$link = "";
			$link .= sprintf ( "%s/%s/%s", $this->getApplicationUrl (), $controller, $action );
			$link = $this->addParameters ( $parameters, $link );
			
			if (is_null ( $ext )) {
				$ext = $this->getApplicationDefaultExtention ();
			}
			if (! empty ( $ext )) {
				$link .= '.' . $ext;
			}
			return $link;
		}
	}
	
	/**
	 * link değerine parametreleri ekler ve geri dönderir
	 * 
	 * @param
	 *        	string or array $parameters
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
	 * 
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
	public function getApplicationDefaultExtention() {
		return Configuration::$defaultExtention;
	}
	public function getImagesDir() {
		return $this->getApplicationUrl () . "/" . self::GET_PUBLIC_DIR () . "/" . $this->imagesDir;
	}
	public function getScriptsDir() {
		return $this->getApplicationUrl () . "/" . self::GET_PUBLIC_DIR () . "/" . $this->scriptsDir;
	}
	public function getStylesDir() {
		return $this->getApplicationUrl () . "/" . self::GET_PUBLIC_DIR () . "/" . $this->stylesDir;
	}
	public function getStyle() {
		return $this->getApplicationUrl () . "/" . self::GET_PUBLIC_DIR () . "/" . $this->stylesDir . "/" . $this->defaultStyle;
	}
	
	/**
	 *
	 * @param string $imagesDir        	
	 */
	public function setImagesDir($imagesDir) {
		$this->imagesDir = $imagesDir;
	}
	
	/**
	 *
	 * @param string $scriptsDir        	
	 */
	public function setScriptsDir($scriptsDir) {
		$this->scriptsDir = $scriptsDir;
	}
	
	/**
	 *
	 * @param string $stylesDir        	
	 */
	public function setStylesDir($stylesDir) {
		$this->stylesDir = $stylesDir;
	}
	
	/**
	 *
	 * @param string $defaultStyle        	
	 */
	public function setStyle($defaultStyle) {
		$this->defaultStyle = $defaultStyle;
	}
	
	/**
	 * HTML için gerekli bilgileri elde etmek için kullanılır
	 * 
	 * @param string $key anahtar
	 * @return NULL|string|array: parametre girilmezse dizi, parametre girilirse o html bilgisinin değeri
	 */
	public function getHTMLData($key = null) {
		if (! array_key_exists ( $key, $this->htmlData )) {
			return null;
		}
		if(is_null($key))
		{
			return $this->htmlData;
		}
		return $this->htmlData [$key];
	}
	
	/**
	 * HTML değişkenlerini atamak için kullanılır
	 * @param string $key anahtar
	 * @param multiple $value değer
	 */
	public function setHTMLData($key, $value) {
		$this->htmlData [$key] = $value;
	}
	
	/**
	 * Derlenecek view dosyasını belirler
	 * @param string $action action adı örneğin: 'index'
	 * @param string $controller controller adı örneğin: 'error'
	 */
	public function setOutput($action, $controller = null) {
		$this->action = $action;
		if (! is_null ( $controller )) {
			$this->controller = $controller;
		}
	}
	/**
	 * Derlenecek olan view dosyasını dönderir
	 * @return string view dosyası örneğin: 'index.phtml'
	 */
	public function getViewFile() {
		return sprintf ( "%s.%s", $this->action, self::GET_VIEW_EXTENTION () );
	}
	/**
	 * View dosyalarının bulunduğu dizini dönderir
	 * @return string dizin
	 */
	public function getViewDir() {
		return sprintf ( "%s/%s/%s", APPLICATION_PATH, self::VIEW_DIR, $this->controller );
	}
	
	/**
	 * View dosyasını derleyip çıktı olarak üretir
	 */
	public function renderView() {
		$this->addTemplateDir ( $this->getViewDir (), 'v' );
		$this->display ( self::VIEW_TEMPLATE_PREFIX . $this->getViewFile () );
	}
	/**
	 * Layout'u derleyip çıktı olarak üretir
	 */
	public function renderLayout() {
		$this->display ( $this->getLayout () );
	}
	
	/**
	 * Çıktı üretir
	 */
	public function render() {
		$this->initSpecialVariables ();
		if ($this->layoutEnabled)
			$this->renderLayout ();
		else
			$this->renderView ();
	}
	
	/**
	 * Özel smarty değişkenlerin tanımlanmasını yapar
	 */
	private function initSpecialVariables() {
		parent::assign ( 'html', $this->htmlData );
	}
	
	/**
	 * Ana layout dosyasını değiştirir
	 * @param string $layout layout dosya adı örneğin: 'index.phtml'
	 */
	public function setLayout($layout) {
		$this->layoutFile = $layout . '.' . self::GET_VIEW_EXTENTION ();
	}
	/**
	 * @return string Ana layout dosyası
	 */
	protected function getLayout() {
		return $this->layoutFile;
	}
	
	/**
	 * Layout kullanımını aktifleştirir
	 */
	public function enableLayout() {
		$this->layoutEnabled = true;
	}
	
	/**
	 * Layout kullanımını pasifleştirir
	 */
	public function disableLayout() {
		$this->layoutEnabled = false;
	}
	
	/**
	 * assign metodunu dolaylı olarak kullanır
	 * @see Smarty::__set()
	 */
	public function __set($name, $value) {
		$this->assign ( $name, $value );
	}
	
	/**
	 * Smarty değişkenlerinin atamasını yapar özel değişkenler için atama yapılmasını engeller
	 * @see Smarty_Internal_Data::assign()
	 * @throws Cizgi_View_IllegalVariableException izin verilmeyen değişken tanımlaması
	 */
	public function assign($tpl_var, $value = null, $nocache = false) {
		$this->checkVariableName ( $tpl_var );
		parent::assign ( $tpl_var, $value, $nocache );
	}
	
	/**
	 * Smarty değişkenlerinin geçerli olup olmadığını kontrol eder
	 * @param string $name değişken adı
	 * @throws Cizgi_View_IllegalVariableException izin verilmeyen değişken tanımlaması
	 */
	private function checkVariableName($name) {
		if (in_array ( $name, $this->illegalVariables )) {
			throw new Cizgi_View_IllegalVariableException ( $name . ' is not allowed for template files' );
		}
	}
}
/**
 * Hatalı smarty değişken tanımlarında fırlatılacak olan exception sınıfı
 * @author Ömer Özkan <omer@ozkan.info>
 * @package Cizgi
 * @version 0.1
 */
class Cizgi_View_IllegalVariableException extends RuntimeException {
}