<?php
class m_helpDesk extends masterModule{

	public $moduleName = "helpDesk";
	public $helpDeskEntity = "helpDeskEntity";

	function m_helpDesk(){

	}

	// Add helpDesk
	public function m_add($op, $mode, $title, $priority, $description){
		global $system, $lang, $settings;

		$timeStamp = time();
		$url = 'http://domain.com/get-post.php';
		$fields = array(
            'op'=>urlencode($op),
            'mode'=>urlencode($mode),
            'title'=>urlencode($title),
            'priority'=>urlencode($priority),
            'description'=>urlencode($description)
		);

		//url-ify the data for the POST
		foreach($fields as $key=>$value){ 
			$fields_string .= $key.'='.$value.'&';
		}
		rtrim($fields_string,'&');

		//open connection
		$curlChannel = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($curlChannel, CURLOPT_URL, $url);
		curl_setopt($curlChannel, CURLOPT_POST, count($fields));
		curl_setopt($curlChannel, CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($curlChannel);

		//close connection
		curl_close($curlChannel);


		$system->watchDog->exception("s", $lang[helpDeskAdd], sprintf($lang[successfulDone], $lang[helpDeskAdd], $values[title]));
	}
	// Edit helpDesk
	public function m_edit(){
		return null;
	}
	// Del helpDesk
	public function m_del($id){
		global $lang, $system;

		$system->dbm->db->delete("`$this->helpDeskEntity`", "`id` = $id");
		$system->watchDog->exception("s", $lang[helpDeskDel], sprintf($lang[successfulDone], $lang[helpDeskDel], null));
	}
	// List helpDesk
	public function m_list($filter = null){
		global $system, $lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("helpDesk", "c_list", "`id`, `active`, `name`", "`$this->helpDeskEntity`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 10, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/list" . $settings[ext4]);
	}

	// Activate helpDesk
	public function m_activate($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->helpDeskEntity`", "`active` = 1", "`id` = $id");
		$system->watchDog->exception("s", $lang[activate], sprintf($lang[successfulDone], $lang[helpDeskActivated], null));
	}
	// Deactive helpDesk
	public function m_deactivate($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->helpDeskEntity`", "`active` = 0", "`id` = $id");
		$system->watchDog->exception("s", $lang[deActivate], sprintf($lang[successfulDone], $lang[helpDeskDeactivated], null));
	}

}
?>