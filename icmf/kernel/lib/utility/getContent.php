<?php 

class getContent {
	
	private $channel;
	private $timeOut;
	
	function __construct(){
		$this->channel = curl_init();
		$this->timeOut = 20;
	}
	
	public function fetchUrl($url){
		
		curl_setopt($this->channel, CURLOPT_URL, $url);
		curl_setopt($this->channel, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->channel, CURLOPT_CONNECTTIMEOUT, $this->timeOut);
		
		// Get URL content
		$string = curl_exec($this->channel);
		// close handle to release resources
		curl_close($this->channel);
		return $string;
	}
	
}

?>