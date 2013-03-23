<?php
/**
 * Autoloader sınıfı sınıfların otomatik olarak include edilmesini sağlar.
 *
 * @author Ömer ÖZKAN <omer@ozkan.info>
 */
class Autoloader {
    private static $parsedArray;
    private static $specialPrefix;
    
    public function __construct()
    {
        $this->specialPrefix = array(
            'Test' => $this->getApplicationPath().'/test',
            'Cizgi' => $this->getLibraryPath().'/cizgi',
        );
    }
    
    public function getClassFile($className)
    {
        $this->setParsedArray($className);
        $prefix = $this->parsedArray[0];
        if(array_key_exists($prefix, $this->specialPrefix))
        {
            return $this->getPhpFile($this->specialPrefix[$prefix], 1);
        }
        return $this->getPhpFile("cizgi", 0);
    }
    
    protected function setParsedArray($className)
    {
        $this->parsedArray = explode("_", $className);
    }
    protected function getLibraryPath()
    {
        return LIBRARY_PATH;
    }

    protected function getApplicationPath()
    {
        return APPLICATION_PATH;
    }
    
    protected function getFolderPath($startPoint)
    {
        $array = $this->parsedArray;
        $path = "";
        $size = count($array);
        for($i = $startPoint; $i<$size - 1; $i++)
        {
            $path .= strtolower($array[$i])."/";
        }
        return $path.$array[$size - 1];
    }
    
    protected function getPhpFile($folder, $startPoint)
    {
        $classPath = $this->getFolderPath($startPoint);
        return sprintf ("%s/%s.php", $folder, $classPath);
    }
}

?>
