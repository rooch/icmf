<?php
class m_poll extends masterModule{

	public $moduleName = "poll";
	public $pollEntity = "pollEntity";
	public $pollStat = "pollStat";

	function m_poll(){

	}

	// Add Poll
	public function m_add($values){
		global $system, $lang, $settings;

		$timeStamp = $system->time->iCal->dator();
		$system->dbm->db->insert("`$this->pollEntity`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `ur`, `name`, `question`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `answer7`, `answer8`, `answer9`, `answer10`, `answer11`, `answer12`, `answer13`, `answer14`, `answer15`, `answer16`, `answer17`, `answer18`, `answer19`, `answer20`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[name]', '$values[question]', '$values[answer1]', '$values[answer2]', '$values[answer3]', '$values[answer4]', '$values[answer5]', '$values[answer6]', '$values[answer7]', '$values[answer8]', '$values[answer9]', '$values[answer10]', '$values[answer11]', '$values[answer12]', '$values[answer13]', '$values[answer14]', '$values[answer15]', '$values[answer16]', '$values[answer17]', '$values[answer18]', '$values[answer19]', '$values[answer20]'");
		$system->watchDog->exception("s", $lang[pollAdd], sprintf($lang[successfulDone], $lang[pollAdd], $values[name]));
	}
	// Edit Poll
	// Del Poll
	// List Poll
	public function m_list($filter = null){
		global $system, $lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("poll", "c_list", "`id`, `active`, `name`, `question`", "`$this->pollEntity`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 10, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][question] = $row[question];

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/object/list" . $settings[ext4]);
	}
	// Activate Poll
	public function m_activate($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->pollEntity`", "`active` = 1", "`id` = $id");
		$system->watchDog->exception("s", $lang[activate], sprintf($lang[successfulDone], $lang[pollActivated], null));
	}
	// Deactive Poll
	public function m_deactivate($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->pollEntity`", "`active` = 0", "`id` = $id");
		$system->watchDog->exception("s", $lang[deActivate], sprintf($lang[successfulDone], $lang[pollDeactivated], null));
	}
	// Show Active Poll
	public function m_showActive(){
		global $system, $lang, $settings;

		$system->dbm->db->select("*", "`$this->pollEntity`", "`active` = 1", "`timeStamp` DESC", "", "", "0,1");
		$row = $system->dbm->db->fetch_array();

		$system->xorg->smarty->assign("entityList", $row);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/object/activePoll" . $settings[ext4]);
	}
	// Submit Poll
	public function m_submit($pollId, $answerId){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$this->pollStat`", "`active`, `timeStamp`, `or`, `ow`, `ox`, `gr`, `gx`, `tr`, `ur`, `pollId`, `uid`, `answerId`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, $pollId, $_SESSION[uid], $answerId");
		$system->watchDog->exception("s", $lang[submit], sprintf($lang[successfulDone], $lang[pollSubmit], null));
	}
	// Result Poll
	public function m_result($pollId){
		global $settings, $lang, $system;

		$system->dbm->db->select("`pollId`, `answerId`, count(`answerId`) as `count`", "`$this->pollStat`", "`pollId` = $pollId", "", "`answerId`");
		
		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][answer] = $system->dbm->db->informer("`$this->pollEntity`", "`id` = $pollId", "answer$row[answerId]");
			$entityList[$count][count] = $row[count];
				
			$count++;
		}

		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->prompt->promptShow('p', $lang[result], $system->xorg->smarty->fetch($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/object/result" . $settings[ext4]));
	}

}
?>