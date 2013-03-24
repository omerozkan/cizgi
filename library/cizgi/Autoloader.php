<?php
/**
 * Autoloader sınıfı sınıfların otomatik olarak include edilmesini sağlar.
 *
 * @author Ömer ÖZKAN <omer@ozkan.info>
 */
class Cizgi_Autoloader {
    private static $parsedArray;
    private static $specialPrefix;
    public function __construct()
    {
        $this->specialPrefix = array(
            'Test' => $this->getRootPath().'/test',
            'Cizgi' => $this->getRootPath().'/library/cizgi',
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
        else
        {
            return $this->getApplicationClass();
        }
    }
    
    protected function setParsedArray($className)
    {
        $this->parsedArray = explode("_", $className);
    }

    protected function getApplicationPath()
    {
        return APPLICATION_PATH;
    }
    
    protected function getRootPath()
    {
        return ROOT_PATH;
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
    
    protected function getApplicationClass()
    {
    	if(count($this->parsedArray) == 1)
    		return sprintf("%s/%s.php", $this->getApplicationPath(), $this->parsedArray[0]);
        return sprintf("%s/%s%s.php", $this->getApplicationPath(), $this->getFolderPath(0)
                , $this->parsedArray[0]);
    }
}

?>