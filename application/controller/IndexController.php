<?php
class Controller_Index extends Cizgi_Controller
{
	function init() {
	}

	function indexAction() {
		$this->view->assign("name", "Cizgi");
		$this->view->setOutput('index', 'index');
		$this->view->display($this->view->getViewFile());
	}
}