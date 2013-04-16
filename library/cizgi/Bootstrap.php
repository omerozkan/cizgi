<?php
/**
 * URLDispatcher nesnesi kullanarak controller ve view nesnelerini oluşturur
 * action metodlarını çağırır
 * @author Ömer Özkan <omer@ozkan.info>
 */
abstract class Cizgi_Bootstrap
{
	private $urlDispatcher;
	private $controller;
	private $action;
	private $view;
	private $developerMode = false;
	
	const CONTROLLER_PREFIX = "Controller";
	const ACTION_PREFIX = "Action";
	
	/**
	 * 
	 * @param Cizgi_URLDispatcher gelen isteği ayrıştırması için gerekli nesne
	 */
	function  __construct(Cizgi_URLDispatcher $urlDispatcher)
	{
		$this->urlDispatcher = $urlDispatcher;
		$this->view = new Cizgi_View();
	}
	
	/**
	 * Uygulamayı başlatarak gelen isteğe cevap verir.
	 * @param string $url - istek
	 * @throws Cizgi_Bootstrap_Exception
	 */
	public function run($url = null)
	{
		$this->urlDispatcher->dispatch($url);
		try {
			$this->invoke();
		}
		catch (Cizgi_Bootstrap_Exception $e)
		{
			$this->invokeError();	
			if($this->developerMode)
				throw $e;		
		}
	}
	
	
	/**
	 * Gelen isteğe göre gerekli controller ve action işlemlerini yapar
	 * @param Cizgi_Controller $controller
	 * @param string $action
	 * @param array $parameters
	 */
	private function invoke($controller = null, $action = null, $parameters = null)
	{
		$this->initController($controller);
		$this->initAction($action);
		$this->invokeActionMethod($parameters);
		$this->view->setOutput($action, $controller);
	}
	
	/**
	 * Hata Controller nesnesini ve action metodunu çağırır
	 */
	private function invokeError()
	{
		$this->invoke($this->getErrorController(), "index");
	}

	/**
	 * actionMethodunu parametrelerle çağırır
	 * @param array $parameters
	 */
	private function invokeActionMethod($parameters = null) {
		$methodName = $this->action;
		if(is_null($parameters))
		{
			$parameters = $this->urlDispatcher->getParameters();
		}
		$this->controller->$methodName($parameters);
	}

	/**
	 * Controller nesnesini üretir
	 * @param string $controller Controller sınıfı adı
	 */
	private function initController($controller = null)
	{
		$className = $this->getControllerClassName($controller);
		$this->checkClass ( $className );
		$this->controller = new $className($this, $this->getView());
	}

	/**
	 * Action metodun tam adını belirler
	 * @param string $name actionMetod adı
	 */
	private function initAction($name = null)
	{
		if(is_null($name))
		{
			$methodName = $this->urlDispatcher->getAction().self::ACTION_PREFIX;
		}
		else
		{
			$methodName = $name.self::ACTION_PREFIX;
		}
		
		$this->checkMethod($methodName);
		$this->action =  $methodName;
	}
	
	/**
	 * Methodun tanımlı olup olmadığını kontrol eder
	 * @param string $methodName
	 * @throws Cizgi_Bootstrap_Action_Not_Found Action metodu bulunamadı
	 */
	private function checkMethod($methodName) {
		if(!method_exists($this->controller, $methodName))
			throw new Cizgi_Bootstrap_Action_Not_Found($methodName." has not found" );}
	
	
	/**
	 * controller nesnesini dönderir
	 * @return Cizgi_Controller 
	 */
	public function getController()
	{
		return $this->controller;
	}
	
	/**
	 * Controller sınıfının tanımlanıp tanımlanmadığını kontrol eder
	 * @param string $className
	 * @throws Cizgi_Bootstrap_Controller_Not_Found Controller bulunamadı
	 */
	private function checkClass($className) {
		if(!class_exists($className))
			throw new Cizgi_Bootstrap_Controller_Not_Found($className." has not declared");
	}

	/**
	 * Controller'ın sınıf adını tam olarak dönderir.
	 * @param string $controller controller adı
	 * @return string controller sınıfının tam adı
	 */
	private function getControllerClassName($controller = null) {
		if(is_null($controller))
		{
			$controller = $this->urlDispatcher->getController();
		}
		return sprintf("%s_%s", self::CONTROLLER_PREFIX, ucfirst($controller));
	}
	
	/**
	 * View nesnesini dönderir
	 * @return Cizgi_View
	 */
	public function getView() {
		return $this->view;
	}
	
	/**
	 * Action metodun tam adını dönderir
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * Configuration sınıfında tanımlı hata controller'ın adını dönderir
	 * @return string controller adı
	 */
	public function getErrorController()
	{
		return Configuration::$errorController;
	}
	
	/**
	 * Controller sınıflarının yönlendirme yapabilmesini sağlar
	 * @param string $controller
	 * @param string $action
	 * @param array $parameters
	 */
	public function redirect($controller, $action, $parameters = null)
	{
		$this->redirectFlag = true;
		$this->parameters = $parameters;
		$this->invoke($controller, $action, $parameters);
	}
	
	/**
	 * Geliştirici modunu aktif eder veya devredışı bırakır.
	 * @param boolean $on true veya boş ise aktif, false ise devredışı
	 */
	public function setDeveloperMode($on = true)
	{
		$this->developerMode = $on;
	}
	
}

class Cizgi_Bootstrap_Exception extends RuntimeException
{}
class Cizgi_Bootstrap_Controller_Not_Found extends Cizgi_Bootstrap_Exception 
{}
class Cizgi_Bootstrap_Action_Not_Found extends Cizgi_Bootstrap_Exception
{}
