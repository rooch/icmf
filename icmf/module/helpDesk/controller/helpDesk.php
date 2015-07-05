<?php
class c_helpDesk extends m_helpDesk{

	public $active = 1;
	
	function c_helpDesk(){
		
	}
	
	// Add helpDesk
	public function c_add($title, $priority, $description){

		$this->m_add($title, $priority, $description);
	}
	// Edit helpDesk
	public function c_edit($values){
		
		$this->m_edit();
	}
	// Del helpDesk
	public function c_del($id){
		
		$this->m_del($id);
	}
	// List helpDesk
	public function c_list($filter = null){
		
		$this->m_list($filter);
	}
	
	// Activate helpDesk
	public function c_activate($id){
		
		$this->m_activate($id);
	}
	// Deactive helpDesk
	public function c_deactivate($id){
		
		$this->m_deactivate($id);
	}

}
?>