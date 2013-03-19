<?php

	class Ozkan_View
	{
		private $controller;
		private $application;
		private $layout;
		private $action;
		private $enableLayout;
		private $variables;
		private static $htmlElements = array(
			'doctype' => '<!doctype html>',
			'description' => '',
			'scriptsHead'=> array(),
			'scriptsBody' => array(),
			'cssLink' => array(),
			'cssText' => array(),
			'title' => '',
			'titleSeparator' => ' | ',
			'charset' => 'utf-8',
		);
		
		public function __construct($controller, $action = 'index', $application = 'application')
		{
			$this->application = $application;
			$this->enableLayout = true;
			$this->layout = Application_Configuration::$defaultLayout;
			$this->variables = array();
			
			if(is_array($controller))
			{
				foreach ($controller as $key => $value)
				{
					$method = 'set'.ucfirst($key);
					
					if(method_exists($this, $method))
					{
						$this->$method($value);
					}
				}
			}
			else
			{
				$this->controller = $controller;
				$this->action = $action;
				
			}
		}
		
		//properties
		
		public function __get($name)
		{
			$method = 'get'.ucfirst($name);
			
			if (method_exists($this, $method))
			{
				return $this->$method();
			}
			else
			{
				return $this->variables[$name];
			}
		}
		
		public function __set($name, $value)
		{
			$method = 'set'.ucfirst($name);
			
			if(method_exists($this, $method))
			{
				$this->$method($value);
			}
			else
			{
				$this->assign($name, $value);
			}

		}
		
		public function contains($variable)
		{
			return isset($this->variables[$variable]); 
		}
		
		public function getController()
		{
			return $this->controller;
		}
		
		public function setController($value)
		{
			$this->controller = $value;
			return $this;
		}
		
		public function getApplication()
		{
			return $this->application;
		}
		
		public function setApplication($value)
		{
			$this->application = $value;
			return $this;
		}
		
		public function getLayout()
		{
			return $this->layout;
		}
		
		public function setLayout($value)
		{
			$this->layout = $value;
			return $this;
		}
		
		public function getAction()
		{
			return $this->action;
		}
		
		public function setAction($value)
		{
			$this->action = $value;
			return $this;
		}
		
		public function getEnableLayout()
		{
			return $this->enableLayout;
		}
		public function setEnableLayout($value)
		{
			$this->enableLayout = $value;
			return $this;
		}
		
		public function enableLayout()
		{
			$this->setEnableLayout(true);
		}
		
		public function disableLayout()
		{
			$this->setEnableLayout(false);
		}
		
		//variables
		
		public function assign($name, $value)
		{
			$this->variables[$name] = $value;
		}
		
		
		
		
		//methods
		
		public function loadView($options = null)
		{
			if($this->enableLayout == true)
			{
				$this->render($this->layout);
			}
			else
			{
				$this->loadContent($options);
			}
		}
		
		public function loadContent($options = null)
		{
			if(is_array($options))
			{
				if(isset($options['controller']))
				{
					$this->controller = $options['controller'];
				}
				
				if(isset($options['action']))
				{
					$this->action = $options['action'];
				}
			}
			
			$file = '../'.$this->application.'/views/'.$this->controller.'/'.$this->action.'.phtml';
			if(!file_exists($file))
			{
				throw new Exception("the view ' $file '  not found");
			}
			else
			{
				
				include $file;	
			}
		}
		
		public function render($layout)
		{
			$file = '../'.$this->application.'/layouts/'.$layout.'.phtml';
			
			if(!file_exists($file))
			{
				throw new Exception("the layout ' $file ' not found");
			}
			else
			{
				
			  include $file;
			}
		}
		
		//for template methods
		
		//doctype
		public function doctype()
		{
			echo $this->getDoctype();
		}
		
		public function getDoctype()
		{
			return Ozkan_View::$htmlElements['doctype']."\n";
		}
		public function setDoctype($doctype)
		{
			Ozkan_View::$htmlElements['doctype'] = $doctype;
		}
		
		//description
		
		public function setDescription($description)
		{
			Ozkan_View::$htmlElements['description'] = $description;
		}
		
		public function getDescription()
		{
			return Ozkan_View::$htmlElements['description'];
		}
		
		public function description()
		{
			echo $this->getDescription();
		}
		//title
		public function title()
		{
			echo $this->getTitle();	
		}
		
		public function getTitle()
		{
			return Ozkan_View::$htmlElements['title'];
		}
		public function setTitle($value)
		{
			Ozkan_View::$htmlElements['title'] = $value;
			return $this;
		}
		
		public function setTitleSeparator($value)
		{
			Ozkan_View::$htmlElements['titleSeparator'] = $value;
			return $this;
		}
		public function setTitlePrepend($value)
		{
			$currentTitle = Ozkan_View::$htmlElements['title'];
			$separator = Ozkan_View::$htmlElements['titleSeparator'];
			
			Ozkan_View::$htmlElements['title'] = $value.$separator.$currentTitle;
			return $this;
		}
		public function setTitlePost($value)
		{
			Ozkan_View::$htmlElements['title'] .= Ozkan_View::$htmlElements['titleSeparator'].$value;
			return $this;
		}
		
		//charset
		public function getCharset()
		{
			return Ozkan_View::$htmlElements['charset'];
		}
		
		public function charset()
		{
			echo $this->getCharset();
		}
		
		
		public function setCharset($value)
		{
			Ozkan_View::$htmlElements['charset'] = $value;
		}
		
		//css
		private function css()
		{
			//duzenlenmesi gerek
			$css= '';
			
			//link olanlar
			foreach(Ozkan_View::$htmlElements['cssLink'] as $value)
			{
				$css .= $value."\n";
			}
			
			//text olanlar
			if(count(Ozkan_View::$htmlElements['cssText']) > 0)
			{
				$css .= '<style type="text/css">'."\n";
				
				foreach(Ozkan_View::$htmlElements['cssText'] as $value)
				{
					$css .= $value."\n";	
				}
				
				$css .= '</style>'."\n";
			}
			
			return $css;
		}
		
		public function addCssLink($file, $media = 'screen')
		{
			$html = '<link type="text/css" href="'.$file.'" media="'.$media.'" />';
			Ozkan_View::$htmlElements['cssLink'][] = $html;
			return $this;
		} 
		
		public function addCssText($value)
		{
			Ozkan_View::$htmlElements['cssText'][] = $value;
			return $this;
		}
		
		//scripts
		private function scriptHead()
		{
			$script = '';
			
			foreach(Ozkan_View::$htmlElements['scriptHead'] as $value)
			{
				$script .= $value."\n";
			}
			
			return $script;
		}
		
		private function scriptBody()
		{
			$script = '';
			
			foreach(Ozkan_View::$htmlElements['scriptBody'] as $value)
			{
				$script .= $value."\n";
			}
			
			return $script;
		}
		
		public function addScriptText($value, $location='head')
		{
			$script = '<script type="text/javascript">'."\n"
					 .$value."\n"
					 ."</script>\n";
			
			if($location == 'head')
			{
				Ozkan_View::$htmlElements['scriptHead'][] = $script;
			}
			else if($location == 'body')
			{
				Ozkan_View::$htmlElements['scriptBody'][] = $script;
			}
			
			return $this;
		}
		
		public function addScriptSrc($value, $location='head')
		{
			$script = '<script type="text/javascript" src=">'.$value.'" ></script>'."\n";
			
			if($location == 'head')
			{
				Ozkan_View::$htmlElements['scriptHead'][] = $script;
			}
			else if($location == 'body')
			{
				Ozkan_View::$htmlElements['scriptBody'][] = $script;
			}
			
			return $this;
		}
		
		public function head()
		{
			return $this->css().$this->scriptHead();
		}
		
		public function footer()
		{
			return $this->scriptBod();
		}
		
		public function getLink($controller, $action, $parameters = null)
		{
			$url = sprintf('%s/%s/%s', Application_Configuration::$url, $controller, $action);
			$extention = Application_Configuration::$defaultExtention;
			
			if(is_array($parameters))
				foreach($parameters as $parameter)
					$url .= '/'.$parameter;
			if(!is_null($parameters))
				$url .= '/'.$parameters;
			
			if($extention != null || $extention != "")
			{
				$url .= '.'.$extention;
			}
			
			return $url;
		}
		
		public function link($controller, $action, $parameters = null)
		{
			echo $this->getLink($controller, $action, $parameters);
		}
		
		public function getDefaultCss()
		{
			return Application_Configuration::$url.'/'.Application_Configuration::$publicDirectory.'/css/style.css';
		}
		
		public function  defaultCss()
		{
			echo $this->getDefaultCss();
		}
		
		public function getDefaultImages()
		{
			return Application_Configuration::$url.'/'.Application_Configuration::$publicDirectory.'/images';
		}
		
		public function defaultImages()
		{
			echo $this->getDefaultImages();
		}
		
		public function getDefaultJs()
		{
			return Application_Configuration::$url.'/'.Application_Configuration::$publicDirectory.'/js';
		}
		
		public function defaultJs()
		{
			echo $this->getDefaultJs();
		}
	}