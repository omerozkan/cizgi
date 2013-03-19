<?php
class Application_Controller_Contact extends Ozkan_Controller
{
	private $repo;
	
	public function init()
	{
		$this->repo = new Application_Repository_Contact();
		//kullanıcı girişini kontrol eder
		$session = new Application_Session_User();
		$user = $session->load();
		if($user == null)
		{
			$this->redirect('user', 'loginform');
		}
	}
	/**
	 * Kişilerin listesini gösterir
	 * @see Ozkan_Controller::indexAction()
	 */
	public function indexAction()
	{
		$contacts = $this->repo->getAll();
		$this->view->contacts = $contacts;
	}
	
	public function searchAction()
	{
		$s = strip_tags($_POST['s']);
		$contacts = $this->repo->find($s);
		$this->view->contacts = $contacts;
	}
	
	public function newAction()
	{
		//yeni kayıt eklemek için
	}
	
	public function viewAction($parameter)
	{
		$id = intval($parameter[0]);
		$contact = $this->repo->get($id);
		if($contact != null)
		{
			$this->view->contact = $contact;
		}
		else
		{
			$this->redirect('contact', 'index');
		}
	}
	/**
	 * 
	 * Kişiyi kaydeder
	 */
	public function saveAction()
	{
		//kişiyi kaydeder
		$this->view->disableLayout();
		$this->view->setAction('json');
		$json  = array();
		
		
		//get post data
		if(isset($_POST['id']))
		{
			$id = intval($_POST['id']);
		@	$name = strip_tags($_POST['name']);
		@	$email = strip_tags($_POST['email']);
		@	$phoneNumber = strip_tags($_POST['phonenumber']);
		@	$postalAddress = strip_tags($_POST['address']);
		@	$corporation = strip_tags($_POST['company']);
		@	$jobTitle = strip_tags($_POST['title']);
		@	$note = strip_tags($_POST['note']);
			if(strlen($name) == 0)
			{
				$json['result'] = 'fail';
			}
			else 
			{
				$contact = new Application_Model_Contact();
				$contact->setId($id);
				$contact->setName($name);
				$contact->setEmail($email);
				$contact->setPhoneNumber($phoneNumber);
				$contact->setPostalAddress($postalAddress);
				$contact->setCorporation($corporation);
				$contact->setJobTitle($jobTitle);
				$contact->setNote($note);
				$result = $this->repo->insertOrUpdate($contact);
				
				if($result == true)
				{
					$json['result'] = 'success';
					$json['content'] = $contact->getId();
				}
				else
				{
					$json['result'] = 'fail';
	 			}
				}
		}
		
		$this->view->json = $json;
	}
	
	public function deleteAction($parameter)
	{
		$id = intval($parameter[0]);
		$contact = $this->repo->get($id);
		if($contact != null)
		{
			$this->repo->delete($id);
		}
		$this->redirect('contact', 'index');
	}
}