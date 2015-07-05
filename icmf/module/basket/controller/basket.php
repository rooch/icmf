<?php
class c_basket extends m_basket{

	public $active = 1;
	
	function c_basket(){
		
	}	
	###########################
	# Object (Basket)         #
	###########################
	// Add Object
	public function c_addObject($objectId, $count){
		$this->m_addObject($objectId, $count);
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
	public function c_listObject($filter = null){
		$this->m_listObject($filter);
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
	
	public function c_calculate($mode = 'print'){
		$this->m_calculate($mode);
	}

}
?>