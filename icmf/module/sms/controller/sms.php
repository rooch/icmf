<?php
class c_sms extends m_sms{

	public $active = 1;
	
	function c_sms(){
		
	}
	
	###########################
	# Object (SMS)            #
	###########################
	// Add Object
	public function c_addObject($to, $message, $category=null){

		$this->m_addObject($to, $message, $category);
	}
	// Edit Object
	public function c_editObject($values){
		
		$this->m_editObject();
	}
	// Del Object
	public function c_delObject($id){
		
		$this->m_delObject($id);
	}
	// List Object
	public function c_listObject($viewMode, $filter = null){
		
		$this->m_listObject($viewMode, $filter);
	}
	// Show Object
	public function c_showObject($id){
		$this->m_showObject($id);
	}
	// Activate Object
	public function c_activateObject($id){
		
		$this->m_activateObject($id);
	}
	// Deactive Object
	public function c_deactivateObject($id){
		
		$this->m_deactivateObject($id);
	}

}
?>