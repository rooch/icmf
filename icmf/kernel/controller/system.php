<?php
class system{

	public $dbm;
	public $lang;
	public $security;
	public $tablePrefix;
	public $time;
	public $mail;
	public $module;
	public $credit;
	public $relation;
	public $rss;
	public $seo;
	public $utility;
	public $watchDog;
	public $xorg;
	
	public function system(){
		global $settings;

		$this->tablePrefix = $settings[tablePrefix];

		/* Database sub system */
		$subSystem = $settings[libraryAddress] . "/dbm/" . "dbm" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->dbm = new dbm($settings[type], $settings[host], $settings[user], $settings[pass], $settings[name]);
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Feed sub system */
		$subSystem = $settings[libraryAddress] . "/feed/" . "rss" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->rss = new rss();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Lang sub system */
		$subSystem = $settings[libraryAddress] . "/lang/" . "lang" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->lang = new lang();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Mail sub system */
		$subSystem = $settings[libraryAddress] . "/mail/" . "PHPMailerAutoload" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->mail = new PHPMailer();
		}else{
			$this->run($subSystem, 'Off');
		}
		
		/* Module sub system */
		$subSystem = $settings[libraryAddress] . "/module/" . "module" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->module = new module();
		}else{
			$this->run($subSystem, 'Off');
		}
		
		/* Credit sub system */
		$subSystem = $settings[libraryAddress] . "/credit/" . "credit" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->credit = new credit();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Relation sub system */
		$subSystem = $settings[libraryAddress] . "/relation/" . "relation" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->relation = new relation();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* SEO sub system */
		$subSystem = $settings[libraryAddress] . "/seo/" . "seo" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->seo = new seo();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Security sub system */
		$subSystem = $settings[libraryAddress] . "/security/" . "security" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->security = new security();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Time sub system */
		$subSystem = $settings[libraryAddress] . "/time/" . "time" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->time = new time();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Utility sub system */
		$subSystem = $settings[libraryAddress] . "/utility/" . "utility" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->utility = new utility();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* WatchDog sub system */
		$subSystem = $settings[libraryAddress] . "/watchDog/" . "watchDog" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->watchDog = new watchDog();
		}else{
			$this->run($subSystem, 'Off');
		}

		/* Xorg sub system */
		$subSystem = $settings[libraryAddress] . "/xorg/" . "xorg" . $settings['ext2'];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->xorg = new xorg();
		}else{
			$this->run($subSystem, 'Off');
		}

	}

	public function run($subSystem, $status){

		if($status == 1 || $status == 'On' || $status == 'on'){
			require_once($subSystem);
		}elseif($status == 0 || $status == 'Off' || $status == 'off'){
			die("\"$subSystem\" is Off");
		}
	}

	public function filterSplitter($string){

		if(strstr($string, ',') || strstr($string, '=')){
			$records = explode(",", $string);
			foreach ($records as $key => $record){
				if(!empty($record)){
					$string = explode("=", $record);
					if(isset($string[1]) && $string[0] != 'sort'){
						$slices[$key][name] = $string[0];
						$slices[$key][value] = $string[1];
					}
				}
			}

			if(is_array($slices)){
				foreach ($slices as $key => $slice){
					if($slice[value] != ""){
						if(is_numeric($slice[value])){
							if(strstr($slice[name], ".")){
								$dotSlice = explode(".", $slice[name]);
								$out .= " AND `$dotSlice[0]`.`$dotSlice[1]` = $slice[value]";
							}else{
								$out .= " AND `$slice[name]` = $slice[value]";
							}
						}elseif(strstr($slice[name], 'match_')){
							if(strstr($slice[name], ".")){
								$dotSlice = explode(".", $slice[name]);
								$out .= " AND `$dotSlice[0]`.`" . trim($dotSlice[1], 'match_') . "` = '$slice[value]'";
							}else{
								$out .= " AND `" . trim($slice[name], 'match_') . "` = '$slice[value]'";
							}
						}else{
							if(strstr($slice[name], ".")){
								$dotSlice = explode(".", $slice[name]);
								$out .= " AND `$dotSlice[0]`.`$dotSlice[1]` LIKE '%$slice[value]%'";
							}else{
								$out .= " AND `$slice[name]` LIKE '%$slice[value]%'";
							}
						}
					}
				}
			}
			return $out;
		}
		return null;
	}
}
?>