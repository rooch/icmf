<?php
class m_forum extends masterModule{

	public $active = 1;

	public function m_forum(){

	}
	###########################
	# Object (forum)            #
	###########################
	// List Object
	public function m_listObject($limit=5){
		global $system, $settings;
		
		$result = mysql_query("SELECT * FROM `$settings[forumObject]` WHERE `visible` = '1' AND `closed` NOT LIKE 'moved|%' ORDER BY `lastpost` DESC LIMIT 0,$limit");
		$count = 1;
		while ($row = mysql_fetch_array($result)){
			$entityList[$count][num] = $count;
			$entityList[$count][tid] = $row[tid];
			$entityList[$count][fid] = $row[fid];
			$entityList[$count][uid] = $row[uid];
			$entityList[$count][subject] = $row[subject];
			$entityList[$count][lastposter] = $row[lastposter];
			$entityList[$count][lastpost] = $system->time->iCal->dator($row[lastpost], 2);
			
			$count++;
		}
		
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/forum/view/tpl/object/list" . $settings[ext4]);
	}
}
?>