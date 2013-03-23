<?php
/**
 * Autoloader sınıfı sınıfların otomatik olarak include edilmesini sağlar.
 *
 * @author Ömer ÖZKAN <omer@ozkan.info>
 */
class Autoloader {
    
    public function getClassFile($className)
    {
        $subFolders = explode('_', $className);
        if(count($subFolders) == 1)
            $classPath = $className;
        else
            $classPath = $this->getFolderPath($subFolders);
        
        return sprintf("%s/%s/%s.php", $this->getLibraryPath(), "cizgi", $classPath);
    }
    
    protected function getLibraryPath()
    {
        return LIBRARY_PATH;
    }
    
    protected function getFolderPath($array)
    {
        $path = "";
        $size = count($array);
        for($i = 0; $i<$size - 1; $i++)
        {
            $path .= strtolower($array[$i])."/";
        }
        return $path.$array[$size - 1];
    }
}

?>
