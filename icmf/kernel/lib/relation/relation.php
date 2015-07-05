<?php

class relation extends system{

	public $active;
	public $nusoap;

	public function relation(){
		global $settings;

		/* Nusoap sub library */
		$subSystem = $settings[libraryAddress] . "/relation/nusoap/" . "nusoap" . $settings[ext2];
		if(file_exists($subSystem)){
			$this->run($subSystem, 'On');
			$this->nusoap = new nusoap_client('https://acquirer.samanepay.com/payments/referencepayment.asmx?WSDL', 'wsdl');
		}else
		$this->run($subSystem, 'Off');

	}
}

?>