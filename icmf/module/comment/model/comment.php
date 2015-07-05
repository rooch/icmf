<?php
class m_comment extends masterModule{

	public function m_comment(){

	}
	###########################
	# Object (comment)        #
	###########################
	// Add Object
	public function m_addObject($values){
		global $system, $lang, $settings, $sysVar;

		$timeStamp = time();
		if(empty($_SESSION['uType']) > 1){
			$userInfo = $system->dbm->db->informer("user", "id=$_SESSION[uid]");
		}else{
			$userInfo['firstName'] = $values['firstName'];
			$userInfo['lastName'] = $values['lastName'];
			$userInfo['email'] = $values['email'];
		}

		$active = ($_SESSION['uid'] == 1 || ($_SESSION['gid'] != 2 && $_SESSION['gid'] != 3)) ? 1 : 0;
		$values['text'] = nl2br($values['text']);
		$system->dbm->db->insert("`$settings[commentObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `op`, `opid`, `uid`, `firstName`, `lastName`, `email`, `text`", "$active, $timeStamp, 1, 12, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[op]', $values[opid], $_SESSION[uid], '$userInfo[firstName]', '$userInfo[lastName]', '$userInfo[email]', '$values[text]'");
		if($system->dbm->db->count_records("`$settings[contactBook]`", "`email` = '$values[email]'") == 0){
			$system->dbm->db->insert("`$settings[contactBook]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `firstName`, `lastName`, `email`, `receiveEmail`", "1, $timeStamp, 1, 12, 1, 1, 1, '$values[firstName]', '$values[lastName]', '$values[email]', 1");
		}
		$system->watchDog->exception("s", $lang['commentAdd'], sprintf($lang['successfulDone'], $lang['commentAdd'], $values['text']) . $lang['afterConfirmViewInSite']);
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$values[category] = empty($values[category]) ? 0 : $values[category];

		$system->dbm->db->update("`$settings[commentObject]`", "`title` = '$values[title]', `brief` = '$brief', `description` = '$values[description]', `category` = $values[category], `startTime` = $values[startTime], `endTime` = $values[endTime], `resources` = '$values[resources]', `filePath` = '$values[filePath]', `contentType` = '$values[contentType]', `contentPath` = '$values[contentPath]'", "`id` = $values[id]");

		$system->watchDog->exception("s", $lang[commentEdit], sprintf($lang[successfulDone], $lang[commentEdit], $values[title]));
	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$text = $system->dbm->db->informer("`$settings[commentObject]`", "`id` = $id", "text");
		$system->dbm->db->delete("`$settings[commentObject]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[commentDel], sprintf($lang[successfulDone], $lang[delete], $text));
	}
	// List Object
	public function m_listObject($viewMode, $filter=null){
		global $system,$lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		if($viewMode == 'list'){
			$system->xorg->pagination->paginateStart("comment", "c_$viewMode", "`active`, `id`, `timeStamp`, `op`, `opid`, `uid`, `firstName`, `lastName`, `email`, `text`", "`$settings[commentObject]`", "1 $filter", "`timeStamp` DESC");
		}elseif($viewMode == 'showListObject'){
			$system->xorg->pagination->paginateStart("comment", "c_$viewMode", "`active`, `id`, `timeStamp`, `op`, `opid`, `uid`, `firstName`, `lastName`, `email`, `text`", "`$settings[commentObject]`", "`active` = 1 $filter ", "`timeStamp` DESC");
		}elseif($viewMode == 'showListObjectSimple'){
			$system->xorg->pagination->paginateStart("comment", "c_$viewMode", "`active`, `id`, `timeStamp`, `op`, `opid`, `uid`, `firstName`, `lastName`, `email`, `text`", "`$settings[commentObject]`", "`active` = 1 $filter ", "`timeStamp` DESC", "", "", "", "", 5);
		}

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 2);
			if($row['uid'] != 2){
				$entityList[$count]['commentorImage'] = $system->dbm->db->informer("`$settings[userTable]`", "`id` = $row[uid]", "userPic");
			}
				
			switch ($row['op']){
				case 'post':
					$table = $settings['postObject'];
					break;
				case 'crm':
					$table = $settings['task'];
					break;
			}
				
			$entityList[$count]['op'] = $row['op'];
			$entityList[$count]['opid'] = $row['opid'];
			$entityList[$count]['firstName'] = $row['firstName'];
			$entityList[$count]['lastName'] = $row['lastName'];
			$entityList[$count]['email'] = $row['email'];
			$entityList[$count]['title'] = $system->dbm->db->informer("`$table`", "`id` = $row[opid]", "title");
			$entityList[$count]['text'] = $row['text'];
				
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/comment/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	// Activate Object
	public function m_activateObject($id){
		global $system, $settings, $lang;

		$system->dbm->db->update("`$settings[commentObject]`", "`active` = 1", "`id` = $id");
		$system->watchDog->exception("s", $lang[activated], sprintf($lang[successfulDone], $lang[activated], $id));
	}
	// Deactivate Object
	public function m_deactivateObject($id){
		global $system, $settings, $lang;

		$system->dbm->db->update("`$settings[commentObject]`", "`active` = 0", "`id` = $id");
		$system->watchDog->exception("s", $lang[deActivated], sprintf($lang[successfulDone], $lang[deActivated], $id));
	}

}
?>