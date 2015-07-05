<?php

class financial extends system{

	public $moduleName = "financial";
	public $financialBank = "financialBank";
	public $financialTransactionType = "financialTransactionType";
	public $financialTransaction = "financialTransaction";
	public $financialInvoice = "financialInvoice";
	public $c_ePay;
	public $c_finance;

	function financial(){
		global $settings, $system, $lang;

		$this->financialBank = $this->tablePrefix . $this->financialBank;
		$this->financialTransactionType = $this->tablePrefix . $this->financialTransactionType;
		$this->financialTransaction = $this->tablePrefix . $this->financialTransaction;

		/* ePay subModule Model */
		$subModule = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[modelAddress] . "/ePay" . $settings[ext2];
		if(file_exists($subModule)){
			require_once ($subModule);
			$m_ePay = new m_ePay();
			$system->run($subModule, 'On');
		}else{
			$system->run($subModule, 'Off');
		}

		/* ePay subModule Controller */
		$subModule = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[moduleController] . "/ePay" . $settings[ext2];
		if(file_exists($subModule)){
			require_once ($subModule);
			$this->c_ePay = new c_ePay();
			$system->run($subModule, 'On');
		}else{
			$system->run($subModule, 'Off');
		}

		/* finance subModule Model */
		$subModule = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[modelAddress] . "/finance" . $settings[ext2];
		if(file_exists($subModule)){
			require_once ($subModule);
			$m_finance = new m_finance();
			$system->run($subModule, 'On');
		}else{
			$system->run($subModule, 'Off');
		}

		/* finance subModule Controller */
		$subModule = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[moduleController] . "/finance" . $settings[ext2];
		if(file_exists($subModule)){
			require_once ($subModule);
			$this->c_finance = new c_finance();
			$system->run($subModule, 'On');
		}else{
			$system->run($subModule, 'Off');
		}

	}

}

?>