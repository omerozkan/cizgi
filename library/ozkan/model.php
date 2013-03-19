<?php 
	abstract class Ozkan_Model extends Ozkan_Object{
		
		protected $table;
		/**
	 * @return the $table
	 */
		
		
	public function getTable() {
		return $this->table;
	}

		/**
	 * @param field_type $table
	 */
	public function setTable($table) {
		$this->table = $table;
	}

}