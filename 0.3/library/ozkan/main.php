<?php 

	function __autoload($name)
	{
		$names = explode('_', $name);
		$size = count($names);
		
		if($names[0] == 'Ozkan')
		{
			for($i = 0; $i<$size; $i++)
			{
				$names[$i] = strtolower($names[$i]);
			}
			
			$file = implode('/', $names);
			$file = LIBRARY_PATH.'/'.$file.'.php';
		}
		else
		{
			
			$i = 1;
			for(; $i<$size - 1;$i++)
			{
				$names[$i] = strtolower($names[$i]);
				$names[$i] = pluralize($names[$i]);
			}
			$names[0] = strtolower($names[0]);
			$names[$size-1] = strtolower($names[$i]);
			$file = implode('/', $names);
			
			$file = '../'.$file.'.php';
/*			if($names[0] == 'Application')
			{
				$file = APPLICATION_PATH.'/'.$file.'.php';
			}
			else
			{
				$file = '../'.$file.'.php';
			}*/
			
			
		}
		
			if(file_exists($file))
			{
				include_once $file;
			}
			else
			{
				//echo "dosya bulunamadı dosya=$file";
			}
	}
	
	function pluralize($word)
    {
        $plural = array(
        '/(quiz)$/i' => '1zes',
        '/^(ox)$/i' => '1en',
        '/([m|l])ouse$/i' => '1ice',
        '/(matr|vert|ind)ix|ex$/i' => '1ices',
        '/(x|ch|ss|sh)$/i' => '1es',
        '/([^aeiouy]|qu)ies$/i' => '1y',
        '/([^aeiouy]|qu)y$/i' => 'ries',
        '/(hive)$/i' => '1s',
        '/(?:([^f])fe|([lr])f)$/i' => '12ves',
        '/sis$/i' => 'ses',
        '/([ti])um$/i' => '1a',
        '/(buffal|tomat)o$/i' => '1oes',
        '/(bu)s$/i' => '1ses',
        '/(alias|status)/i'=> '1es',
        '/(octop|vir)us$/i'=> '1i',
        '/(ax|test)is$/i'=> '1es',
        '/s$/i'=> 's',
        '/$/'=> 's');

        $uncountable = array('equipment', 'information', 'rice', 'money', 'species', 'series', 'fish', 'sheep');

        $irregular = array(
        'person' => 'people',
        'man' => 'men',
        'child' => 'children',
        'sex' => 'sexes',
        'move' => 'moves');

        $lowercased_word = strtolower($word);

        foreach ($uncountable as $_uncountable){
            if(substr($lowercased_word,(-1*strlen($_uncountable))) == $_uncountable){
                return $word;
            }
        }

        foreach ($irregular as $_plural=> $_singular){
            if (preg_match('/('.$_plural.')$/i', $word, $arr)) {
                return preg_replace('/('.$_plural.')$/i', substr($arr[0],0,1).substr($_singular,1), $word);
            }
        }

        foreach ($plural as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }
        return false;

    }