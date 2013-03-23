<?php
require "Autoloader.php";
/**
 * @author Ömer ÖZKAN
 */
define('LIBRARY_PATH', "../library");
define('APPLICATION_PATH', "..");
class Test_Autoloader extends PHPUnit_Framework_TestCase{

    function setUp()
    {
        $this->loader = new Autoloader();
        $this->path = "../library";
        $this->app = "..";
    }
    function testGetClassFile() {
        $this->assertEquals($this->path."/cizgi/Bootstrap.php", $this->loader->getClassFile("Cizgi_Bootstrap"));
        $this->assertEquals($this->path."/cizgi/Controller.php", $this->loader->getClassFile("Cizgi_Controller"));
    }

    function testGetClassFileForDifferentLibraryPath()
    {
        $loader = new Mock_AutoLoader;
        $this->assertEquals("test/other/path/cizgi/Cizgi.php", $loader->getClassFile("Cizgi_Cizgi"));
    }
    
    function testGetClassFileWithOneSubFolder()
    {
        $this->assertEquals($this->path."/cizgi/mysql/Adapter.php", 
                $this->loader->getClassFile("Cizgi_Mysql_Adapter"));
    }
    
    function testGetClassFileWithMultipleSubFolders()
    {
        $this->assertEquals($this->path."/cizgi/folder/subfolder/Class.php", 
                $this->loader->getClassFile("Cizgi_Folder_Subfolder_Class"));
    }
    
    function testGetClassFileForTestCases()
    {
        $this->assertEquals($this->app."/test/Case.php", 
                $this->loader->getClassFile("Test_Case"));
    }
    
    function testGetClassFileForTestCasesWithSubFolder()
    {
        $this->assertEquals($this->app."/test/folder/Case.php",
                $this->loader->getClassFile("Test_Folder_Case"));
    }
}


class Mock_Autoloader extends AutoLoader
{
    function getLibraryPath() {
        return "test/other/path";
    }
}

?>
