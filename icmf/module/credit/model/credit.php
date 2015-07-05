<?php
class m_credit extends masterModule{

	public function m_credit(){

	}
	###########################
	# Object                  #
	###########################
	// Add Object
	public function m_addObject($values){
		
	}
	// Edit Object
	public function m_editObject($values){
		
	}
	// Del Object
	public function m_delObject($id){
		
	}
	// List Object
	public function m_listObject($viewMode, $filter=null, $sort=null){
		global $system,$lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$sort = !empty($sort) ? $sort : 'timeStamp DESC';
		$system->xorg->pagination->paginateStart("credit", 'c_' . $viewMode . 'Object', "`id`, `timeStamp`, `active`, `uid`, `op`, `mode`, `filter`, `score`", "`$settings[creditObject]`", "1 $filter", "$sort", "", "", "", "", 20, 7);
		
		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 2);
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			$entityList[$count]['uid'] = $row['uid'];
			$entityList[$count]['op'] = $row['op'];
			$entityList[$count]['mode'] = $row['mode'];
			$entityList[$count]['filter'] = $row['filter'];
			$entityList[$count]['score'] = $row['score'];
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);

	}
	// Activate Object
	public function m_activateObject($id){
		global $system, $settings, $lang;

		$system->dbm->db->update("`$settings[creditObject]`", "`active` = 1", "`id` = $id");
		$system->watchDog->exception("s", $lang[activated], sprintf($lang[successfulDone], $lang[activated], $id));
	}
	// Deactivate Object
	public function m_deactivateObject(){
		global $system, $settings, $lang;
		
		$system->dbm->db->update("`$settings[creditObject]`", "`active` = 0", "`id` = $id");
		$system->watchDog->exception("s", $lang[deActivated], sprintf($lang[successfulDone], $lang[deActivated], $id));
	}

}
?>