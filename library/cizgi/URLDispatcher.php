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
			case 3:
				$this->action = $requests[2];
		}
		$this->parameters = array_slice($requests, 3);
	}
	
	private function setActionAsDefault() {
		$this->action = self::DEFAULT_ACTION;
	}
	
	public function getController()
	{
		return $this->controller;
	}
	
	public function getAction()
	{
		return $this->action;
	}
	
	public function setDefaultController($controller)
	{
		$this->controller = $controller;	
	}
	
	public function getParameters()
	{
		return $this->parameters;
	}
}