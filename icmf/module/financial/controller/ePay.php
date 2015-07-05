<?php
class c_ePay extends m_ePay{

	public $active = 1;


	public function c_ePay(){
		
	}

	public function c_bankList(){

		$this->m_bankList();
	}
	
	public function c_invoiceMaker($transactionType, $bankId, $amount=null){
		
		$this->m_invoiceMaker($transactionType, $bankId, $amount);
	}
	
	public function c_invoiceViewer($invoiceNumber){
		
		$this->m_invoiceViewer($invoiceNumber);
	}

	public function c_insertTrans($batchNumber, $transactionType, $bankId, $amount){

		$this->m_insertTrans($batchNumber, $transactionType, $bankId, $amount);
	}

	public function c_transControl($RefNum, $MID, $State, $ResNum){

		$this->m_transControl($RefNum, $MID, $State, $ResNum);
	}

	public function c_addNewTrans($procRes){

		$this->m_addNewTrans($procRes);
	}

	public function c_succTrans($ResNum){

		$this->m_succTrans($ResNum);
	}
	
	public function c_failTrans($batch_number){
		
		$this->m_failTrans($batch_number);
	}
	
	public function c_checkState(){
		
		$this->m_checkState();
	}
	
	public function c_tester(){
		$this->m_tester();
	}

}
?>