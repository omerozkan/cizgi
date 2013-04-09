<?php
/**
 * Uygulamada kullanılacak olan bütün Controller nesnelerinin atası
 * @author Ömer Özkan <omer@ozkan.info>
 *
 */
abstract class Cizgi_Controller
{
	private $view;
	private $bootstrap;
	
	/**
	 * @param Cizgi_Bootstrap $bootstrap
	 * @param Cizgi_View $view
	 */
	public function __construct(Cizgi_Bootstrap $bootstrap, Cizgi_View $view)
	{
		$this->setBootstrap($bootstrap);
		$this->setView($view);
	}
	
	/**
	 * init metodu her action metodundan önce çağırılır. Genel amaçlı kullanılabilir.
	 */
	abstract function init();
	
	/**
	 * Her controller sınıfının index adlı action'u olmak zorundadır
	 */
	abstract function indexAction();
	
	/**
	 * View nesnesi
	 * @param Cizgi_View $view
	 */
	public function setView(Cizgi_View $view)
	{
		$this->view = $view;
	}
	/**
	 * View nesnesi
	 * @return Cizgi_View
	 */
	public function getView()
	{
		return $this->view;
	}
	
	/**
	 * Bootstrap nesnesi
	 * @param Cizgi_Bootstrap $bootstrap
	 */
	public function setBootstrap(Cizgi_Bootstrap $bootstrap)
	{
		$this->bootstrap = $bootstrap;
	}
	
	/**
	 * Bootstrap nesnesi
	 * @return Cizgi_Bootstrap
	 */
	public function getBootstrap()
	{
		return $this->bootstrap;
	}
	
	/**
	 * 2 controller nesnesinin aynı olup olmadığını belirler
	 * Test sınıfları için yazılmıştır.
	 * @param Cizgi_Controller $that
	 * @return boolean
	 */
	public function equals($that)
	{
		return get_class($this) == get_class($that);
	}
	
	/**
	 * Başka bir controller ve actiona yönlendirmesini sağlar
	 * @param unknown_type $controller
	 * @param unknown_type $action
	 * @param unknown_type $parameters
	 */
	public function redirect($controller, $action, $parameters = null)
	{
		$this->bootstrap->redirect($controller, $action, $parameters);
	}
}