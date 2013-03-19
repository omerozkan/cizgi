<?php 

	abstract class Ozkan_Controller
	{
		protected $view;
		public function __construct($view)
		{
			 $this->view = $view;
		}
		
		public function init()
		{
			
		}
		
		public function indexAction()
		{
			
		}
		
		protected function redirect($controller, $action, $parameter = null)
		{
			header('Location: '.$this->view->getLink($controller, $action, $parameter));
			exit;
		}
		
	}