<?php
/***
 * Kullanıcılar üzerinde işlem yapan controller sınıfı
 * @author: Ömer ÖZKAN
 */
class Application_Controller_User extends Ozkan_Controller {
	
	private $user;
	
	public function init()
	{
		$session = new Application_Session_User();
		$user = $session->load();
		
		if($user == null)
		{
			$this->view->setAction('loginform');
		}
		else
		{
			$this->user = $user;
			$this->view->setAction('index');
			$this->view->username = $this->user->getName();
			
		}
	}
	
	public function controlUser()
	{
		if($this->user == null)
			return false;
		else
			return true;
	}
	public function indexAction()
	{
		if(!$this->controlUser())
		{
			$this->view->setAction('loginform');
		}
		
	}
	
	public function loginformAction()
	{
		if($this->controlUser())
		{
			$this->view->setAction('index');
		}
	}
	
	public function loginAction()
	{
		if($this->controlUser())
		{
			$this->view->setAction('index');
			return;
		}
		$postedForm = array();
		@ $postedForm['username'] = strip_tags($_POST['username']);
		@ $postedForm['password'] = strip_tags($_POST['password']);
		
		$userMapper = new Application_Repository_User();
		$banlistManager = new Ozkan_BanlistManager();
		$user = $userMapper->get($postedForm);
		
		//banlanmışsa şifre yanlış uyarısı ver
		//banlamamışsa birşey yapma
		//banlandıysa banlistesine ekle
		//şifre doğru girdiyse banlistesini temizle
		
		if($banlistManager->isBanned())
		{
			$this->sendError();
		}
		
		else if($user == null || count($user) == 0)
		{	
			$banlistManager->ban('user');
			$this->sendError();
		}
		else
		{
			$banlistManager->unban();
			$user = $user[0];
			$session = new Application_Session_User();
			$session->save($user);
			$this->view->username = $user->getName();
			$this->view->setAction('index');
		}
		
		
	}
	
	public function registerFormAction()
	{
		if($this->controlUser())
		{
			$this->view->setAction('index');
			return;
		}
		$this->view->setAction('registerform');
	}
	
	public function registerAction()
	{
		if($this->controlUser())
		{
			$this->view->setAction('index');
			return;
		}
		//alanların formdan alınması
		$errors = array();
	@	$username = strip_tags(trim($_POST['username']));
	@	$name = strip_tags(trim($_POST['name']));
	@	$password = strip_tags($_POST['password']);
	@	$password2 = strip_tags($_POST['password2']);
		
		
		//alanların kontrolü
		
		
		if(strlen($name) == 0 || strlen($username) == 0 || 
			strlen($password) == 0 || strlen($password2) == 0)
		{
			$errors[] = "Lütfen tüm alanları giriniz!";
		}
		else if($password != $password2)
		{
			$errors[] = "Girdiğiniz parolalar eşleşmiyor!";
		}
		else 
		{
			//kullanıcı oluştur
			$user = new Application_Model_User();
			$user->setName($name);
			$user->setPassword($password);
			$user->setUsername($username);
			$user->setEnable(1);
			$repository = new Application_Repository_User();
			$new = $repository->add($user);
			if(is_null($new))
			{
				$errors[] = "Girdiğiniz kullanıcı adı başkası tarafından kullanılmaktadır.";
			}
		}
		
		if(count($errors) == 0)
		{
			$session = new Application_Session_User();
			$session->save($user);
			$this->view->setAction('register');
		}
		else
		{
			$this->view->setAction('registerform');
			$this->view->errors = $errors;
		}		
		
	}
	
	public function logoutAction()
	{
		$session = new Application_Session_User();
		$session->delete();
		$this->view->setAction('loginform');
	}
	private function sendError()
	{
		$this->view->setAction('loginform');
		$this->view->message = 'kullanıcı adınızı veya şifrenizi hatalı girdiniz!';
	}
}