<?php
class c_formBuilder extends m_formBuilder{

	public $active = 1;


	function c_formBuilder(){
		
	}
	
	// Add data to form
	public function c_addData($values){
		$this->m_addData($values);
	}
	
	// List form
	public function c_list($filter = null){
		$this->m_list($filter);
	}
	
}
?>