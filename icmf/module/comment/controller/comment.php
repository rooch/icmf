<?php
class c_comment extends m_comment{

	public $active = 1;

	public function c_comment(){

	}
	###########################
	# Object (comment)        #
	###########################
	// Add Object
	public function c_addObject($values, $show=false){
		$this->m_addObject($values, $show);
	}
	// Edit Object
	public function c_editObject($values){
		$this->m_editObject($values);
	}
	// Del Object
	public function c_delObject($id){
		$this->m_delObject($id);
	}
	// List Object
	public function c_listObject($viewMode, $filter=null){
		return $this->m_listObject($viewMode, $filter);
	}
	// Activate Object
	public function c_activateObject($id){
		$this->m_activateObject($id);
	}
	// Deactivate Object
	public function c_deactivateObject($id){
		$this->m_deactivateObject($id);
	}
}
?>