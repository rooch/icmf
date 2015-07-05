<?php
class c_mta extends m_mta{

	public $active = 1;


	function c_mta(){
		
	}
	
	public function c_addObject($from, $subject, $message, $receiverMail, $receiverFirstName=null, $receiverLastName=null){
		
		$this->m_addObject($from, $subject, $message, $receiverMail, $receiverFirstName, $receiverLastName);
	}

}
?>