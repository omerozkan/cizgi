<?php
abstract class Cizgi_Controller
{
	private $view;
	private $bootstrap;

	public function __construct(Cizgi_Bootstrap $bootstrap, Cizgi_View $view)
	{
		$this->setBootstrap($bootstrap);
		$this->setView($view);
	}
	
	abstract function init();
	
	abstract function indexAction();
	
	public function setView(Cizgi_View $view)
	{
		$this->view = $view;
	}
	
	public function getView()
	{
		return $this->view;
	}
	
	public function setBootstrap(Cizgi_Bootstrap $bootstrap)
	{
		$this->bootstrap = $bootstrap;
	}
	
	public function getBootstrap()
	{
		return $this->bootstrap;
	}
	
	public function equals($that)
	{
		return get_class($this) == get_class($that);
	}
	
	public function redirect($controller, $action, $parameters = null)
	{
		$this->bootstrap->redirect($controller, $action, $parameters);
	}
}