<?php

class Ozkan_Mysql_Adapter {
	
	private static $db;
	
	/**
	 * @return the $db
	 */
	public static function getDb() {
		if(is_null(Ozkan_Mysql_Adapter::$db))
		{
			Ozkan_Mysql_Adapter::setDb();
		}
		Ozkan_Mysql_Adapter::$db->query("SET NAMES ´utf8´");
		Ozkan_Mysql_Adapter::$db->query("SET CHARACTER SET utf8");
		Ozkan_Mysql_Adapter::$db->query("SET COLLATION_CONNECTION = 'utf8_turkish_ci'");
		return Ozkan_Mysql_Adapter::$db;
	}
	
	private static function setDb()
	{
		Ozkan_Mysql_Adapter::$db = new mysqli ( Application_Configuration::$hostname, 
		Application_Configuration::$dbUser, Application_Configuration::$dbPassword, Application_Configuration::$db );
	}
	
	public static function closeDb()
	{
		if(!is_null(Ozkan_Mysql_Adapter::$db))
	    	Ozkan_Mysql_Adapter::getDb()->close();
	}
	
}
?>