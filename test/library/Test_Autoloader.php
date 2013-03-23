<?php
require "Autoloader.php";
/**
 * @author Ömer ÖZKAN
 */
define('LIBRARY_PATH', "../library");
define('APPLICATION_PATH', "../");
class Test_Autoloader extends PHPUnit_Framework_TestCase{
    
    
    function setUp()
    {
        $this->loader = new Autoloader();
        $this->path = "../library";
        $this->app = "..";
    }
    function testGetClassFile() {
        $this->assertEquals($this->path."/cizgi/Bootstrap.php", $this->loader->getClassFile("Bootstrap"));
        $this->assertEquals($this->path."/cizgi/Controller.php", $this->loader->getClassFile("Controller"));
    }

    function testGetClassFileForDifferentLibraryPath()
    {
        $loader = $this->getMock("Autoloader", array('getLibraryPath'));
        $loader->expects($this->once())
               ->method('getLibraryPath')
               ->will($this->returnValue("test/other/path"));
        $this->assertEquals("test/other/path/cizgi/Cizgi.php", $loader->getClassFile("Cizgi"));
    }
    
    function testGetClassFileWithOneSubFolder()
    {
        $this->assertEquals($this->path."/cizgi/mysql/Adapter.php", 
                $this->loader->getClassFile("Mysql_Adapter"));
    }
    
    function testGetClassFileWithMultipleSubFolders()
    {
        $this->assertEquals($this->path."/cizgi/folder/subfolder/Class.php", 
                $this->loader->getClassFile("Folder_Subfolder_Class"));
    }
    
    function testGetClassFileForTestCases()
    {
        $this->assertEquals($this->app."/test/Test_Case.php", 
                $this->loader->getClassFile("Test_Case"));
    }
}

?>
