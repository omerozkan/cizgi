<?php
/**
 * 
 * User modelinin veritabanı işlemlerini yapan sınıf
 * @author Ömer ÖZKAN
 *
 */
class Application_Repository_User extends Ozkan_Mapper{
	private static $table = 'users';
	public function add(Application_Model_User $user)
	{
			$preparedStatement = $this->db->prepare('INSERT INTO '.$user->getTable().' (`name`, `username`, `password`, `enable`) VALUES(?,?,?,?)');
			
	//		$encryptedPassword = sha1($user->getPassword());
			
			$preparedStatement->bind_param('sssd', $user->getName(), $user->getUsername(), $user->getPassword(), $user->getEnable());

			
			$preparedStatement->execute();
			
			$user->setId($this->db->insert_id);
			
			$preparedStatement->close();
			if($user->getId() == 0){
				return null;
			}
			return $user;
		
	}
	
	public function getById($id)
	{
		$query  = array(
			'id' => $id
		);
		$user = $this->get($query);
		if(count($user) != 0)
			return $user[0];
		else
			return null;	
	}
	
	public function getByUsername($username)
	{	
		$query =  array(
			'username' => $username
		);
		
		$user = $this->get($query);
		return $user[0];
	}
	
	public function get($options = null)
	{
		$users = array();
		$user = new Application_Model_User();
		$query = 'SELECT * FROM '.$user->getTable();
		
		if(is_array($options))
		{
			
			$firstItem = true;
			foreach($options as $key=>$value)
			{
				if($firstItem)
				{
					$query .=  ' WHERE '.'`'.$key.'` = \''.$value.'\'';
					$firstItem = false;
				}
				else
				{
					$query .= ' AND '.'`'.$key.'` = \''.$value.'\'';
				}	
			}
		}
		
		$results = $this->db->query($query);
		while($result = $results->fetch_array())
		{
			$user = new Application_Model_User();
			$user->setName($result['name']);
			$user->setPassword($result['password']);
			$user->setId($result['id']);
			$user->setEnable($result['enable']);
			$user->setUsername($result['username']);
			
			$users[] = $user;
		}
		
		return $users;
	}
	
	public function update(Application_Model_User $user, Array $where)
	{
		
	}
	
	
}

?>