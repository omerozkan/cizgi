<?php
class Controller_Index extends Cizgi_Controller
{
	function init() {
	}

	function indexAction() {
	//	$this->view->assign("name", "Cizgi");
		$this->view->name = "Cizgi";
	}
	
	function secondAction()
	{
		$this->view->assign("message", "Second action is working now");
		
		$example = new Model_Example();
		$example->name = 'Ömer ÖZKAN';
		$this->view->assign('object', $example);
	}
}