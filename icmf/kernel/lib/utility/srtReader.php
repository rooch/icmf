<?php

class srtReader {

	private $srtStateSubNumber = 0;
	private $srtStateTime = 1;
	private $srtStateText = 2;
	private $srtStateBlank = 3;
	private $lines;
	private $subs;
	private $state;
	private $subNum;
	private $subText;
	private $subTime;

	function srtReader(){
		
	}
	
	public function read($file){
		
		$this->subs    = array();
		$this->state   = $this->srtStateSubNumber;
		$this->subNum  = 0;
		$this->subText = '';
		$this->subTime = '';
		$this->lines = file($file);
		
		foreach($this->lines as $line) {
			switch($this->state) {
				case $this->srtStateSubNumber:
					$this->subNum = trim($line);
					$this->state  = $this->srtStateTime;
					break;

				case $this->srtStateTime:
					$this->subTime = trim($line);
					$this->state   = $this->srtStateText;
					break;

				case $this->srtStateText:
					if (trim($line) == '') {
						$sub = new stdClass;
						$sub->number = $$this->subNum;
						list($sub->startTime, $sub->stopTime) = explode(' --> ', $this->subTime);
						$sub->text   = $this->subText;
						$this->subText     = '';
						$this->state       = $this->srtStateSubNumber;

						$this->subs[]      = $sub;
					} else {
						$this->subText .= $line;
					}
					break;
			}
		}
		return $this->subs;
	}

}

?>