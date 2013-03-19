<?php

class Ozkan_BanlistManager {
	
	private $banlistMapper;
	
	public function __construct()
	{
		$this->banlistMapper = new Application_Repository_Banlist();
	}
	
	public function isBanned()
	{
		$ip = $this->getIp();
		$banlist = $this->banlistMapper->get($ip);
		
		if($banlist == null)
		{
			return false;
		}
		if($banlist->getCount() < 5)
		{
			return false;
		}
		
		return true;
	}
	
	public function ban($controller)
	{
		$ip = $this->getIp();
		$banlist = $this->banlistMapper->get($ip);
		if($banlist == null)
		{
			$banlist = new Application_Model_Banlist();
			$banlist->setIp($ip);
			$banlist->setController($controller);
			$banlist->setCount(1);
			$banlist->setDate(date("Y-m-d G:i:s"));
			$banlist->setEnable(1);
			$this->banlistMapper->add($banlist);
		}
		else
		{
			$banlist->setCount($banlist->getCount() + 1);
			$banlist->setDate(date("Y-m-d G:i:s"));
			$this->banlistMapper->save($banlist);
		}
	}
	
	public function unban()
	{
		$ip = $this->getIp();
		$banlist = $this->banlistMapper->get($ip);
		if($banlist == null)
		{
			return;
		}
		else
		{
			$this->banlistMapper->delete($ip);
		}
	}
	
	public function getIp()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	
}

?>