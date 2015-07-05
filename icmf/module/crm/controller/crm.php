<?php
class c_crm extends m_crm{

	public $active = 1;

	public function c_crm(){

	}
	###########################
	# Object                  #
	###########################
	// Add Object
	public function c_addObject($values){
		global $system, $lang;

		//		if($system->dbm->db->count_records("`$this->crmTable`", "`name` = '$name'") == 0){
		$this->m_addObject($values);
		//		}else{
		//			$system->watchDog->exception("w", $lang[warning], $lang[exist]);
		//		}

	}
	// Edit Object
	public function c_editObject($values){
		$this->m_editObject($values);
	}
	// Del Object
	public function c_delObject($id, $name=null){
		$this->m_delObject($id, $name);
	}
	// List Object
	public function c_listObject($viewMode, $filter=null, $sort=null){
		return $this->m_listObject($viewMode, $filter, $sort);
	}
	// Activate Object
	public function c_activateObject(){

	}
	// Deactivate Object
	public function c_deactivateObject(){

	}
	// Log reader
	public function c_logReader($id){
		
		return $this->m_logReader($id);
	}
	
	public function c_count($filter=null){
		
		return $this->m_count($filter);
	}

}
?>