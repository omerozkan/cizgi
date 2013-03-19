<?php

class Ozkan_Session extends Ozkan_Object{
	
	private $key;
	private $originalKey;
	private $value;
	/**
	 * @return the $name
	 */
	protected function getKey() {
		return $this->key;
	}

	/**
	 * @return the $value
	 */
	protected function getValue() {
		return $this->value;
	}

	/**
	 * @param field_type $name
	 */
	protected function setKey($name) {
		$this->key = $name;
		$this->originalKey = Application_Configuration::$sessionKey.$this->key;
	}

	/**
	 * @param field_type $value
	 */
	protected function setValue($value) {
		$this->value = $value;
	}

	public function __construct($values = null)
	{
		
		if(is_array($values))
		{
			foreach($values as $key=>$value)
			{
				$this->$key = $value;
			}
		}
	}

	protected function set()
	{
		global $_SESSION;		
		$_SESSION[$this->originalKey] = $this->value;
	}
	
	protected function get()
	{
		global $_SESSION;
		return @$_SESSION[$this->originalKey];
	}
	
	
	
}

?>