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
        	'Smarty' => $this->getRootPath().'/library/smarty',
        );
    }
    
    /**
     * Bir sınıfın dosyasını bulur
     * @param string $className - Sınıf adı
     * @return string
     */
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
    /**
     * Sınıf adını parçalar
     * @param string $className - Sınıf adı
     */
    protected function setParsedArray($className)
    {
        $this->parsedArray = explode("_", $className);
    }

    /**
     * Uygulama dizini
     * @return string uygulama yolu
     */
    protected function getApplicationPath()
    {
        return APPLICATION_PATH;
    }
    /**
     * Kök dizin
     * @return string kök dizin
     */
    protected function getRootPath()
    {
        return ROOT_PATH;
    }
    
    /**
     * Diziyi dosya yolu haline çevirir
     * @param integer $startPoint dizinin başlayacağı değer
     * @return string dizin yolu
     */
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
    
    /**
     * Özel sınıfların php dosyasını dönderir
     * @param string $directory özel dizin
     * @param integer $startPoint parsedArray için başlangıç noktası
     * @return string php dosya yolu
     */
    protected function getPhpFile($directory, $startPoint)
    {
        $classPath = $this->getFolderPath($startPoint);
        return sprintf ("%s/%s.php", $directory, $classPath);
    }
    
    /**
     * Uygulama sınıflarının tam yolunu bulur
     * @return string php dosya yolu
     */
    protected function getApplicationClass()
    {
    	if(count($this->parsedArray) == 1)
    		return sprintf("%s/%s.php", $this->getApplicationPath(), $this->parsedArray[0]);
        return sprintf("%s/%s%s.php", $this->getApplicationPath(), $this->getFolderPath(0)
                , $this->parsedArray[0]);
    }
}

?>