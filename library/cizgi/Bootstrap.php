<?php
/**
 * URLDispatcher nesnesi kullanarak controller ve view nesnelerini oluşturur
 * action metodlarını çağırır
 * @author Ömer Özkan <omer@ozkan.info>
 */
class Cizgi_Bootstrap
{
	private $urlDispatcher;
	private $controller;
	private $action;
	
	const CONTROLLER_PREFIX = "Controller";
	const ACTION_PREFIX = "Action";
	
	function  __construct(Cizgi_URLDispatcher $urlDispatcher)
	{
		$this->urlDispatcher = $urlDispatcher;
	}
	public function run($url = null)
	{
		$this->urlDispatcher->dispatch($url);
		$this->initController();
		$this->initAction();
	}
	
	private function initAction()
	{
		$methodName = $this->urlDispatcher->getAction().self::ACTION_PREFIX;
		$this->checkMethod ( $methodName );
		$this->action =  $methodName;
	}
	/**
	 * @param methodName
	 */private function checkMethod($methodName) {
		if(method_exists($this->controller, $methodName))
			throw new Cizgi_Bootstrap_Action_Not_Found($methodName." has not found" );}

	private function initController()
	{
		$className = $this->getControllerClassName();
		$this->checkClass ( $className );
		$this->controller = new $className;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	private function checkClass($className) {
		if(!class_exists($className))
			throw new Cizgi_Bootstrap_Controller_Not_Found($className." has not declared");
	}

	 
	private function getControllerClassName() {
		$controller = $this->urlDispatcher->getController();
		return sprintf("%s_%s", self::CONTROLLER_PREFIX, ucfirst($controller));
	}

	
	public function getAction()
	{
		return $this->action;
	}
}

class Cizgi_Bootstrap_Controller_Not_Found extends RuntimeException {
}
class Cizgi_Bootstrap_Action_Not_Found extends RuntimeException
{
}
