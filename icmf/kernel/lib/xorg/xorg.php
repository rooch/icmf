<?php

class xorg extends system{

	public $active;
//	public $ajax;
	public $captcha;
	public $chart;
	public $editor;
	public $finder;
	public $gd;
	public $htmlElements;
	public $pagination;
	public $prompt;
	public $smarty;

	public function xorg(){
		global $settings;

//		/* Ajax sub library */
//		$subSystem = $settings[libraryAddress] . "/xorg/ajax/" . "ajax" . $settings[ext2];
//		if(file_exists($subSystem)){
//			//$this->run($subSystem, 'On');
//			//$this->ajax = new ajax();
//		}else
//		$this->run($subSystem, 'Off');

		/* Captcha sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/captcha/" . "captcha" . $settings[ext2];
		if(file_exists($subSystem)){
			//$this->run($subSystem, 'On');
			//$this->captcha = new captcha();
		}else
		$this->run($subSystem, 'Off');

		/* Chart sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/chart/" . "chart" . $settings[ext2];
		//if(file_exists($subSystem)){
		//$this->run($subSystem, 'On');
		//$this->chart = new chart();
		//}else
		//$this->run($subSystem, 'Off');

		/* GD sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/gd/" . "fagd" . $settings[ext2];
		if(file_exists($subSystem)){
			//$this->run($subSystem, 'On');
			//$this->gd = new gd();
		}else
		$this->run($subSystem, 'Off');

		/* HtmlElements sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/htmlElements/" . "htmlElements" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->htmlElements = new htmlElements();
		}else
		$this->run($subSystem, 'Off');
		
		/* Pagination sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/pagination/" . "pagination" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->pagination = new pagination();
		}else
		$this->run($subSystem, 'Off');

		/* Prompt sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/prompt/" . "prompt" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->prompt = new prompt();
		}else
		$this->run($subSystem, 'Off');

		/* Smarty sub library */
		$subSystem = $settings[libraryAddress] . "/xorg/smarty/" . "Smarty.class" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->smarty = new Smarty();
			if($settings[cache] == true){
				$this->smarty->caching = true;
				$this->smarty->cache_lifetime = $settings[cacheLifeTime];
	//			$this->smarty->clearAllCache();
				$this->smarty->compile_check = false;
	//			$this->smarty->force_compile = false;
				$this->smarty->merge_compiled_includes = true;
				$this->smarty->cache_dir = $settings[cacheDir];	
			}
		}else
		$this->run($subSystem, 'Off');

	}

	public function combo($fields, $table, $filter=null, $selected=null){

//		print "<br>Selected: " . $selected . "<br>";
		$field = implode(", ", $fields);
		$filter = (!empty($filter) ? "WHERE $filter" : null);
		$result = mysql_query("SELECT $field FROM `$table` $filter");
		if($result){
			$out[selected] = $selected;
			while($row = mysql_fetch_array($result)){
				$out[$row[$fields[0]]] = $row[$fields[1]] . " " . $row[$fields[2]] . " " . $row[$fields[3]] . " " . $row[$fields[4]];
			}
//			print_r($out);
			return $out;
		}else{
			$message = 'ENO: System:1 - Invalid Query: ' . mysql_error() . "\n";
			return $message;
		}
	}

}

?>