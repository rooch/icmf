<?php
class c_credit extends m_credit{

	public $active = 1;

	public function c_credit(){

	}
	###########################
	# Object                  #
	###########################
	// Add Object
	public function c_addObject($values){
		global $system, $lang;

		//		if($system->dbm->db->count_records("`$this->creditTable`", "`name` = '$name'") == 0){
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
	public function c_activateObject($id){
		$this->m_activateObject($id);
	}
	// Deactivate Object
	public function c_deactivateObject($id){
		$this->m_deactivateObject($id);
	}
	// Log reader
	public function c_logReader($id){
		
		return $this->m_logReader($id);
	}

}
?>