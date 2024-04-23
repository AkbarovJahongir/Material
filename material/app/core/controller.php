<?php
class Controller {
	
	public $model;
    public $model_common;
	public $view;
	
	function __construct()
	{
		$this->view = new View();
	//	session_start();
	}
	

	function return_json($json)
	{
		header("Content-type: application/json; charset=utf-8");
    	echo json_encode($json);
	}

	public function print_array($array){
	    echo "<pre>";
        print_r($array);
        echo "</pre>";
    }

	function ru2lat($str){
	    $tr = array(
	    "А"=>"A", "Б"=>"B", "В"=>"V", "Г"=>"G", "Д"=>"D",
	    "Е"=>"E", "Ё"=>"Yo", "Ж"=>"Zh", "З"=>"Z", "И"=>"I", 
	    "Й"=>"J", "К"=>"K", "Л"=>"L", "М"=>"M", "Н"=>"N", 
	    "О"=>"O", "П"=>"P", "Р"=>"R", "С"=>"S", "Т"=>"T", 
	    "У"=>"U", "Ф"=>"F", "Х"=>"Kh", "Ц"=>"Ts", "Ч"=>"Ch", 
	    "Ш"=>"Sh", "Щ"=>"Sch", "Ъ"=>"", "Ы"=>"Y", "Ь"=>"", 
	    "Э"=>"E", "Ю"=>"Yu", "Я"=>"Ya", "а"=>"a", "б"=>"b", 
	    "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", 
	    "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k", 
	    "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", 
	    "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", 
	    "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", 
	    "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", 
	    "я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",  
	    ":"=>"", ";"=>"","—"=>"", "–"=>"-", 
	    "Ғ"=>"G", "ғ"=>"g", "Ӣ"=>"I", "ӣ"=>"i", "Қ"=>"Q", "қ"=>"q", "Ӯ"=>"U", "ӯ"=>"u", "Ҳ"=>"H", "ҳ"=>"h", "Ҷ"=>"J", "ҷ"=>"j",
	    );
	return strtr($str,$tr);
	}

}
?>