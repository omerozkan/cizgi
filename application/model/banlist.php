<?php


class Application_Model_Banlist extends Ozkan_Model {
	protected $table = "banlist";
	private $id;
	private $ip;
	private $date;
	private $count;
	private $controller;
	private $enable;
	
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
	 * @return the $ip
	 */
	public function getIp() {
		return $this->ip;
	}

	/**
	 * @param field_type $ip
	 */
	public function setIp($ip) {
		$this->ip = $ip;
	}

	/**
	 * @return the $date
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @param field_type $date
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * @return the $count
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * @param field_type $count
	 */
	public function setCount($count) {
		$this->count = $count;
	}

	/**
	 * @return the $controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 * @param field_type $controller
	 */
	public function setController($controller) {
		$this->controller = $controller;
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
	
	public function  getTable()
	{
		return $this->table;
	}
	
}

?>