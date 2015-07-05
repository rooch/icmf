<?php
class c_eDelivery extends m_eDelivery{

	public $active = 1;
	
	function c_eDelivery(){
		
	}
	
	// Add District
	public function c_addDistrict($values){

		$this->m_addDistrict($values);
	}	
	// Add eDelivery
	public function c_addDistance($values){
		global $system, $settings, $lang;
		
		if(!empty($values['city1']) && !empty($values['city2']) && !empty($values['district1']) && !empty($values['district2']))
		$filter = "`city1` = $values[city1] AND `district1` = $values[district1] AND `city2` = $values[city2] AND `district2` = $values[district2] OR `city2` = $values[city1] AND `district2` = $values[district1] AND `city1` = $values[city2] AND `district1` = $values[district2]";
		elseif(!empty($values['city1']) && !empty($values['city2']) && empty($values['district1']) && empty($values['district2']))
		$filter = "`city1` = $values[city1] AND `city2` = $values[city2] OR `city1` = $values[city2] AND `city2` = $values[city1]";
		
		if($system->dbm->db->count_records("`$settings[distance]`", $filter) == 0)
		$this->m_addDistance($values);
		else
		$system->watchDog->exception("w", $lang['warning'], $lang['distanceExist']);
	}
	//Add object
	public function c_addObject($objectId, $count=null, $values=null){
		$this->m_addObject($objectId, $count, $values);
	}
	// Invoice Object
	public function c_invoiceObject($filter=null){
		return $this->m_invoiceObject($filter);
	}
}
?>