<?php
class c_organization extends m_organization{

	public $active = 1;

	public function c_organization(){

	}
	###########################
	# Object (organization)        #
	###########################
	// Add Object
	public function c_addObject($values){
		global $system, $lang;

		//		if($system->dbm->db->count_records("`$this->organizationTable`", "`name` = '$name'") == 0){
		$this->m_addObject($values, $show);
		//		}else{
		//			$system->watchDog->exception("w", $lang[warning], $lang[organizationExist]);
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
	public function c_listObject($viewMode, $filter=null){
		return $this->m_listObject($viewMode, $filter);
	}
	// Activate Object
	public function c_activateObject(){

	}
	// Deactivate Object
	public function c_deactivateObject(){

	}
	// Feed Object
	public function c_feedObject($source, $count){
		
		$this->m_feedObject($source, $count);
	}

}
?>