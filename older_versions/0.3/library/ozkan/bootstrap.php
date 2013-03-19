<?php 

	abstract class Ozkan_Bootstrap{
	
		protected $requests;
		protected $view;
		protected $controller;
		
		public function __construct()
		{
			session_start();
			$this->requests = array();
			$this->Requests();
			$this->view = new Ozkan_View('index');
		}
		
		private function Requests()
		{
		//varsayilan verileri girelim
			$this->requests['controller'] = Application_Configuration::$defaultController;
			$this->requests['action'] = 'index';
			$this->requests['parameters'] = array();
			//gelen isteği controller - action parameters haline getirelim
			
			if(isset($_GET['oorequest']))
			{
				$ozkanRequest = strip_tags(($_GET['oorequest']));
				
				$ozkanRequest = explode('.',$ozkanRequest);
				
				$ozkanRequest = $ozkanRequest[0];
				
				$ozkanRequest = explode('/', $ozkanRequest);
				
				$ozkanRequest = array_filter($ozkanRequest, 'strlen');
				
				$count = 0;
				
				$requests = array();
				
				foreach($ozkanRequest as $value)
				{
					if($count == 0)	
					{
						$requests['controller'] = $value;
					}
					else if($count == 1)
					{
						$requests['action'] = $value;
					}
					else
					{
						$requests['parameters'][$count-2] = $value;
					}
					$count++;
				}
				
				if(isset($requests['controller']))
				{
					$this->requests['controller'] = $requests['controller'];
				}
				
				if(isset($requests['action']))
				{
					$this->requests['action'] = $requests['action'];
				}
				
				if(isset($requests['parameters']))
				{
					$this->requests['parameters'] =  $requests['parameters'];
				}
			}
		}
		
		private function loadError()
		{
			$this->requests['controller'] = Application_Configuration::$errorController;
			$this->requests['action'] = 'index';
			$controllerClassName = 'Application_Controller_'.$this->requests['controller'];
			$actionMethodName = $this->requests['action'].'Action';
			
			
			
			if(class_exists($controllerClassName))
			{
				$this->view->setController($this->requests['controller']);
				$this->view->setAction('index');
				$this->view = new Ozkan_View($this->requests['controller'], $this->requests['action']);
				$this->controller = new $controllerClassName($this->view);
				$this->controller->init();
				
				if(method_exists($this->controller, $actionMethodName))
				{
					$this->controller->$actionMethodName($this->requests['parameters']);
					$this->loadView();
				}
				else
				{
					throw new Exception("indexAction was not found in Error Controller");
				}
			}
			else
			{
				throw new Exception("Error Controller was not found!");
			}
		}
		
		public function execute()
		{
			
			$this->init();
			
			$controllerClassName = 'Application_Controller_'.$this->requests['controller'];
			$actionMethodName = $this->requests['action'].'Action';
			
			if(!class_exists($controllerClassName))
			{
				$this->loadError();
				return;
			}
			else 
			{
				
				$this->view->setController($this->requests['controller']);
				$this->view->setAction($this->requests['action']);
				$this->controller = new $controllerClassName($this->view);
				$this->controller->init();
				if(!method_exists($this->controller, $actionMethodName))
				{
					$this->loadError();
					return;
				}
				else
				{
					$this->controller->$actionMethodName($this->requests['parameters']);
					
					$this->loadView();
				}
			}
		
		}
		
		public function loadView()
		{
			
			$this->view->loadView();
		}
		
		public function init()
		{
			$this->initDoctype();
			$this->initTitle();
			$this->initDescription();
		}
		
		public function initDoctype()
		{
			
		}
		
		public function initTitle()
		{
			
		}
		
		public function initDescription()
		{
			
		}
		
		private function closeDb()
		{
		@	Ozkan_Mysql_Adapter::closeDb();
		}
		
		public function __destruct()
		{
			$this->closeDb();
		}
	}
