<?php 

	abstract class Ozkan_Mapper{
		
		protected $db;
		
		public function __construct()
		{
			$this->db = Ozkan_Mysql_Adapter::getDb();
			
		}
	}

	
?>