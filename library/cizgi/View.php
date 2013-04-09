<?php
class Cizgi_View {
	
	const PUBLIC_FOLDER = "public";
	protected $imagesDir = "images";
	protected $scriptsDir = "js";
	protected $stylesDir = "css";
	protected $defaultStyle = "style.css";
	
	/**
	 * Girilen parametrelere göre bir url oluşturur
	 * @param string $controller
	 * @param string $action
	 * @param string or array $parameters
	 * @param string $ext
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
		return $this->getApplicationUrl()."/".self::PUBLIC_FOLDER."/".$this->imagesDir;
	}
	
	public function getScriptsDir()
	{
		return $this->getApplicationUrl()."/".self::PUBLIC_FOLDER."/".$this->scriptsDir;
	}
	
	public function getStylesDir()
	{
		return $this->getApplicationUrl()."/".self::PUBLIC_FOLDER."/".$this->stylesDir;
	}
	
	public function getStyle()
	{
		return $this->getApplicationUrl()."/".self::PUBLIC_FOLDER."/"
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
}