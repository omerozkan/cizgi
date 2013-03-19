<?php
//application/sessions/user.php
/**
 * 
 * Kullanıcı oturumlarını yöneten sınıf
 * @author Ömer ÖZKAN
 *
 */
class Application_Session_User extends Ozkan_Session{
	
	private $session;
	private $user;
	
	public function __construct()
	{
		$this->setKey('USER_LOGIN');
	}
	public function save(Application_Model_User $user)
	{
		
		if($user->getId() == null)
		{
			return false;
		}
		
		$this->setValue($user->getId());
		$this->set();
	}
	
	public function load()
	{
		$id = $this->get();
		
		$mapper =  new Application_Repository_User();
		
		return $mapper->getById($id);
	}
	
	public function delete()
	{
		$this->setValue(null);
		$this->set();
	}
}
