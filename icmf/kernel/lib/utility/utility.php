<?php

class utility extends system{

	public $arrayMan;
	public $browserDetector;
	public $fileSystem;
	public $filter;
	public $getContent;
	public $srtReader;

	function utility(){
		global $settings;

		/* Browser detector sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "browserDetector" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->browserDetector = new browserDetector();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Array sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "arrayMan" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->arrayMan = new arrayMan();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* File system sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "fileSystem" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->fileSystem = new fileSystem();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Filter system sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "filter" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->filter = new filter();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* srtReader system sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "srtReader" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->srtReader = new srtReader();
		}else{
			$this->run($subSystem, 'Off');
		}
		
		/* getContent system sub library */
		$subSystem = $settings[libraryAddress] . "/utility/" . "getContent" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->getContent = new getContent();
		}else{
			$this->run($subSystem, 'Off');
		}

	}

}

?>