<?php

	class Application_Controller_Index extends Ozkan_Controller
	{
		
		public function indexAction()
		{
			$this->view->message = "Bu bir deneme mesajıdır. Controller tarafından üretilmiştir.";
			if(isset($_SERVER['PATH_INFO']))
			{
				echo $_SERVER['PATH_INFO'];
			}
		}
		
		public function editAction()
		{
		
			$this->view->message = "Bu bir deneme mesajıdır. edit action tarafından üretilmiştir.";
		}
	}