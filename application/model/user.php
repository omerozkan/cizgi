<?php
/**
 * 
 * Deneyde oylama yapacak olan kullanıcıları modelleyen sınıf
 * @author Ömer ÖZKAN
 *
 */
class Application_Model_User extends Ozkan_Model {
	
	protected $table = 'users';
	
	private $id; //AUTO_INCREMENT int
	private $name; //varchar 30
	private $username; //varchar 50
	private $password; //varchar 255
	private $enable; //boolean - tinyint -1
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return the $email
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param field_type $email
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * @return the $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param field_type $password
	 */
	public function setPassword($password) {
		$this->password = $password;
	}
	/**
	 * @return the $enable
	 */
	public function getEnable() {
		return $this->enable;
	}

	/**
	 * @param field_type $enable
	 */
	public function setEnable($enable) {
		$this->enable = $enable;
	}

	
}

