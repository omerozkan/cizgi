<?php

class Application_Repository_Banlist extends Ozkan_Mapper {
	
	public function get($ip)
	{
		$banlist = new Application_Model_Banlist();
		
		$ps = $this->db->prepare('SELECT * FROM '.$banlist->getTable().' WHERE `ip` = ? AND `enable` = 1');
		$ps->bind_param('s', $ip);
		$ps->execute();
		$ps->bind_result($id, $ipx, $date, $count, $controller, $enable);
		
		if($ps->fetch())
		{
			$banlist->setId($id);
			$banlist->setIp($ip);
			$banlist->setDate($date);
			$banlist->setCount($count);
			$banlist->setController($controller);
			$banlist->setEnable(1);
		}
		else
		{
			$banlist = null;
		}		
		$ps->close();
		
		return $banlist;
	}
	
	public function add(Application_Model_Banlist $banlist)
	{
		$ps = $this->db->prepare('INSERT INTO '.$banlist->getTable().' (`ip`, `date`, `count`, `controller`, `enable` ) VALUES (?,?,?,?,?)');
		$ps->bind_param('ssisi', $banlist->getIp(), $banlist->getDate(), $banlist->getCount(), $banlist->getController(), $banlist->getEnable());
		$ps->execute();
		$ps->close();
	}
	
	public function save(Application_Model_Banlist $banlist)
	{
		$ps = $this->db->prepare('UPDATE '.$banlist->getTable().' SET `count`=?, `date` = ?, `enable` = ? WHERE `id` = ?');
		$ps->bind_param('isii', $banlist->getCount(), $banlist->getDate(), $banlist->getEnable(), $banlist->getId());
		$ps->execute();
		$ps->close();
	}

	public function delete($ip)
	{
		$banlist = new Application_Model_Banlist();
		$ps = $this->db->prepare('DELETE FROM '.$banlist->getTable().' WHERE `ip` = ?');
		$ps->bind_param('s', $ip);
		$ps->execute();
		$ps->close();
		$banlist = null;
	}
}

?>