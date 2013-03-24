<?php
abstract class Cizgi_Controller
{
	private $view;
	private $bootstrap;
	
	
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
	
	public function __toString()
	{
		return get_class($this);
	}
}