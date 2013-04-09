<?php
class Cizgi_View {
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
}