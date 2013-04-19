<?php
class Controller_Index extends Cizgi_Controller
{
	function init() {
	}

	function indexAction() {
		$this->view->assign("name", "Cizgi");
	}
	
	function secondAction()
	{
		$this->view->assign("message", "Second action is working now");
	}
}