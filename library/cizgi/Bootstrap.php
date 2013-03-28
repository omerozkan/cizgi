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
	private $view;
	
	const CONTROLLER_PREFIX = "Controller";
	const ACTION_PREFIX = "Action";

	function  __construct(Cizgi_URLDispatcher $urlDispatcher)
	{
		$this->urlDispatcher = $urlDispatcher;
		$this->view = new Cizgi_View();
	}
	public function run($url = null)
	{
		$this->urlDispatcher->dispatch($url);
		try {
			$this->invoke();
		}
		catch (Cizgi_Bootstrap_Exception $e)
		{
			$this->invokeError();			
		}
	
	}
	
	private function invokeError()
	{
		$this->invoke($this->getErrorController(), "index");
	}
	
	private function invoke($controller = null, $action = null, $parameters = null)
	{
		$this->initController($controller);
		$this->initAction($action);
		$this->invokeActionMethod($parameters);
	}
	
	private function invokeActionMethod($parameters = null) {
		$methodName = $this->action;
		if(is_null($parameters))
		{
			$parameters = $this->urlDispatcher->getParameters();
		}
		$this->controller->$methodName($parameters);
	}

	
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
	
	private function checkMethod($methodName) {
		if(!method_exists($this->controller, $methodName))
			throw new Cizgi_Bootstrap_Action_Not_Found($methodName." has not found" );}

	private function initController($controller = null)
	{
		$className = $this->getControllerClassName($controller);
		$this->checkClass ( $className );
		$this->controller = new $className($this, $this->getView());
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	private function checkClass($className) {
		if(!class_exists($className))
			throw new Cizgi_Bootstrap_Controller_Not_Found($className." has not declared");
	}

	 
	private function getControllerClassName($controller = null) {
		if(is_null($controller))
		{
			$controller = $this->urlDispatcher->getController();
		}
		return sprintf("%s_%s", self::CONTROLLER_PREFIX, ucfirst($controller));
	}

	protected function getView() {
		return $this->view;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function getErrorController()
	{
		return Configuration::$errorController;
	}
	
	public function redirect($controller, $action, $parameters = null)
	{
		$this->redirectFlag = true;
		$this->parameters = $parameters;
		$this->invoke($controller, $action);
	}
	
}

class Cizgi_Bootstrap_Exception extends RuntimeException
{}
class Cizgi_Bootstrap_Controller_Not_Found extends Cizgi_Bootstrap_Exception 
{}
class Cizgi_Bootstrap_Action_Not_Found extends Cizgi_Bootstrap_Exception
{}
