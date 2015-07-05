<?php
class m_backlink extends masterModule{

	public function m_backlink(){

	}
	###########################
	# Object                  #
	###########################
	// Add Object
	public function m_addObject($values){
		global $system, $lang, $settings;
		
		$timeStamp = time();

		
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();

	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$subject = $system->dbm->db->informer("`$settings[task]`", "`id` = $id", "subject");
		$system->dbm->db->delete("`$settings[task]`", "`id` = $id");
		$system->watchDog->exception("s", $lang['del'], sprintf($lang['successfulDone'], $lang['delete'], $subject));
	}
	// List Object
	public function m_listObject($viewMode, $filter=null, $sort=null){
		global $system,$lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$sort = !empty($sort) ? $sort : 'weight DESC';
		$system->xorg->pagination->paginateStart("backlink", 'c_' . $viewMode . 'Object', "`id`, `timeStamp`, `active`, `subject`, `priority`, `status`, `department`, `agent`, `clientType`, `clientId`, `deadline`, `progress`, `description`, `lastEditTime`, `weight`", "`$settings[task]`", "1 $filter", "$sort", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 2);
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			
			
			
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);

	}
	// Activate Object
	public function m_activateObject(){

	}
	// Deactivate Object
	public function m_deactivateObject(){

	}

}
?>