<?php 

	class Application_Controller_Error extends Ozkan_Controller
	{
		public function indexAction()
		{
			$this->view->message = "Aradığınız sayfaya ulaşılamadı lütfen anasayfaya dönüp tekrar deneyin.";
		}
	}



?>