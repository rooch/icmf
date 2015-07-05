<?php

class m_formBuilder extends masterModule{

	public $moduleName = "formBuilder";
	public $orderEntity = "formsEntity";
	public $orderFields = "formsFields";

	function m_formBuilder(){

	}

	// Add data to Form
	public function m_addData($values){
		global $system, $settings, $lang;
		
//		if($_SESSION[uid] !=2){
			$or = $values[permission][0];
			$ow = $values[permission][1];
			$ox = $values[permission][2];
			$gr = $values[permission][3];
			$gw = $values[permission][4];
			$gx = $values[permission][5];
			$tr = $values[permission][6];
			$tw = $values[permission][7];
			$tx = $values[permission][8];
			$ur = $values[permission][9];
			$uw = $values[permission][10];
			$ux = $values[permission][11];
			
			$timeStamp = time();
			
			$formId = $system->dbm->db->findMax("`$this->orderFields`", "`formId`") + 1;
			
			foreach ($values as $key => $value){
				if($key != 'op' || $key != 'mode' || $key != 'formId' || $key != 'permission'){
					$system->dbm->db->insert("`$this->orderFields`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tw`, `tx`, `ur`, `uw`, `ux`, `formId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, $or, $ow, $ox, $gr, $gw, $gx, $tr, $tw, $tx, $ur, $uw, $ux, $formId, '$key', '$value'");
				}
			}
			$system->watchDog->exception("s", $lang[order], sprintf($lang[successfulDone], $formId));
		/*}else{
			$system->watchDog->exception("e", $lang[error], $lang[fillContactInformation]);
		}*/
	}
	
	// List Form
	public function m_list($filter = null){
		global $system, $lang, $settings;

	}
	
	

}
?>