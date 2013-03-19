<?php

abstract class Ozkan_Object {

	public function __get($name)
	{
		$method = 'get'.ucfirst($name);
		if(method_exists($this, $method))
		{
			return $this->$method();
		}
	
	}
	
	public function __set($name, $value)
	{
		$method = 'set'.ucfirst($name);
		if(method_exists($this, $method))
		{
			$this->$method($value);
			return $this;
		}
	}
}

?>