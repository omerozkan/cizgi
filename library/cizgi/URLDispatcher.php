<?php
/**
 * Gelen isteği controller, action ve parametrelere böler
 * @author Ömer ÖZKAN <omer@ozkan.info>
 */
class Cizgi_URLDispatcher
{
	private $controller;
	private $action;
	private $parameters;
	const DEFAULT_ACTION = "index";
	
	/**
	 * bir Request'i controller, action ve parametrelere böler
	 * @param string $url request
	 */
	public function dispatch($url = null)
	{
		$requests = explode("/", $url);
		switch (count($requests))
		{
			case 2:
				$this->controller = $requests[1];
			case 1:
				$this->setActionAsDefault();
				break;
			default:
				$this->controller = $requests[1];
				$this->action = $requests[2];
		}
		$this->parameters = array_slice($requests, 3);
	}
	
	private function setActionAsDefault() {
		$this->action = self::DEFAULT_ACTION;
	}
	
	/**
	 * @return string controller
	 */
	public function getController()
	{
		return $this->controller;
	}
	/**
	 * 
	 * @return string action
	 */
	public function getAction()
	{
		return $this->action;
	}
	
	/**
	 * request içerisinde belirtilmemişse varsayılan controller değerini atar
	 * @param string $controller controller
	 */
	public function setDefaultController($controller)
	{
		if(!is_string($controller))
			throw new InvalidArgumentException("controller must be string", "", null);
		$this->controller = $controller;	
	}
	/**
	 * action metodları için parametreleri dönderir
	 * @return multitype:string parametre dizisi
	 */
	public function getParameters()
	{
		return $this->parameters;
	}
}