<?php
/**
 * @author Ömer ÖZKAN
 */
class Test_Library_Autoloader extends PHPUnit_Framework_TestCase{
	
	private $loader, $lib, $app, $root;
    function setUp()
    {
        $this->loader = new Cizgi_Autoloader();
        $this->lib = ROOT_PATH."/library";
        $this->app = APPLICATION_PATH;
        $this->root = ROOT_PATH;
    }
    function testGetClassFile() {
        $this->assertEquals($this->lib."/cizgi/Bootstrap.php", $this->loader->getClassFile("Cizgi_Bootstrap"));
        $this->assertEquals($this->lib."/cizgi/Controller.php", $this->loader->getClassFile("Cizgi_Controller"));
    }

    function testGetClassFileForDifferentLibraryPath()
    {
        $loader = new Mock_AutoLoader;
        $this->assertEquals("test/other/path/library/cizgi/Cizgi.php", $loader->getClassFile("Cizgi_Cizgi"));
    }
    
    function testGetClassFileWithOneSubFolder()
    {
        $this->assertEquals($this->lib."/cizgi/mysql/Adapter.php", 
                $this->loader->getClassFile("Cizgi_Mysql_Adapter"));
    }
    
    function testGetClassFileWithMultipleSubFolders()
    {
        $this->assertEquals($this->lib."/cizgi/folder/subfolder/Class.php", 
                $this->loader->getClassFile("Cizgi_Folder_Subfolder_Class"));
    }
    
    function testGetClassFileForTestCases()
    {
        $this->assertEquals($this->root."/test/Case.php", 
                $this->loader->getClassFile("Test_Case"));
    }
    
    function testGetClassFileForTestCasesWithSubFolder()
    {
        $this->assertEquals($this->root."/test/folder/Case.php",
                $this->loader->getClassFile("Test_Folder_Case"));
    }
    
    function testGetClassFileForApplication()
    {
        $this->assertEquals($this->app."/controller/IndexController.php",
                $this->loader->getClassFile("Controller_Index"));
        $this->assertEquals($this->app."/repository/UserRepository.php",
                $this->loader->getClassFile("Repository_User"));
        $this->assertEquals($this->app."/model/sub/UserModel.php",
                $this->loader->getClassFile("Model_Sub_User"));
        $this->assertEquals($this->app."/Bootstrap.php", 
        		$this->loader->getClassFile("Bootstrap"));
        $this->assertEquals($this->app."/Configuration.php", 
        		$this->loader->getClassFile("Configuration"));
        
    }
    
}


class Mock_Autoloader extends Cizgi_AutoLoader
{
    function getRootPath() {
        return "test/other/path";
    }
}

?>
