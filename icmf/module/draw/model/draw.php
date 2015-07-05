<?php
class m_draw extends masterModule{

	function m_draw(){

	}

	###########################
	# Category                #
	###########################
	// Add Category
	public function m_addCategory($name, $category){
		global $settings, $lang, $system;

		$time = time();
		$system->dbm->db->insert("`$settings[drawCategory]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `name`, `category`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$name', '$category'");
		$system->watchDog->exception("s", $lang[categoryAdd], sprintf($lang[successfulDone], $lang[categoryAdd], $name));
	}
	// Edit Category
	public function m_editCategory($values){

	}
	// Del Category
	public function m_delCategory($id){

	}
	// List Category
	public function m_listCategory($filter = null){
		global $settings, $system, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("draw", "c_categoryList", "`id`, `active`, `name`, `category`", "`$settings[drawCategory]`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][category] = $row[category];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/category/list" . $settings[ext4]);
	}
	// Activate Category
	public function m_activateCategory($id){

	}
	// Deactive Category
	public function m_deactivateCategory($id){

	}

	###########################
	# Object (Draw)           #
	###########################
	// Add Object
	public function m_addObject($name, $category, $description=null){
		global $settings, $lang, $system;

		$time = time();
		$system->dbm->db->insert("`$settings[drawObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `name`, `category`, `description`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$name', $category, '$description'");
		$system->watchDog->exception("s", $lang[drawAdd], sprintf($lang[successfulDone], $lang[drawAdd], $name));
	}
	// Edit Object
	public function m_editObject($values){

	}
	// Del Object
	public function m_delObject($id){

	}
	// List Object
	public function m_listObject($viewMode, $filter = null){
		global $settings, $system, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("draw", "c_$viewMode", "`base`.`id`, `base`.`active`, `base`.`name`, `$settings[drawCategory]`.`name`", "`$settings[drawObject]` as `base`, `$settings[drawCategory]`", "`base`.`category` = `$settings[drawCategory]`.`id` $filter", "`base`.`timeStamp` DESC", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][category] = $row[category];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	// Show Object Random
	public function m_showObjectRandom(){
		global $system, $settings, $lang;

		$lastDraw = $system->dbm->db->findMax("`$settings[drawObject]`", "`id`");
		$rand['drawName'] = $system->dbm->db->informer("`$settings[drawObject]`", "`id` = $lastDraw", "name");
		
		$system->dbm->db->select("`from`", "`$settings[drawObjectDetails]`", "`win` = 0 AND `draw` = $lastDraw", "rand()", "", "", "1", 1); // For detect only numbers => AND `message` REGEXP '^[0-9]{1}$'
		
		$result = mysql_query("SELECT DISTINCT `from` FROM `$settings[drawObjectDetails]` WHERE `win` = 1 AND `draw` = $lastDraw");
		if($system->dbm->db->count_rows($result) == 3){
			$rand['fromVirtual'] = $rand['from'] = '9124153877';
			$rand['fromVirtual'][3] = 0;
			$rand['fromVirtual'][4] = 0;
			$rand['fromVirtual'][5] = 0;
		}else{
			$rand['fromVirtual'] = $rand['from'] = $system->dbm->db->result(0, 0);
			$rand['fromVirtual'][3] = 0;
			$rand['fromVirtual'][4] = 0;
			$rand['fromVirtual'][5] = 0;
		}
		$rand['date'] = $system->dbm->db->informer("`$settings[drawObjectDetails]`", "`from` = '$rand[from]' AND `draw` = $lastDraw", "date");
		$rand['count'] = $system->dbm->db->count_records("`$settings[drawObjectDetails]`", "`from` = '$rand[from]'"); // For detect only numbers => AND `message` REGEXP '^[0-9]{1}$'

		$time = time();
		
		
		
		$system->dbm->db->update("`$settings[drawObjectDetails]`", "`win` = 1, `timeStamp` = $time", "`from` = $rand[from]");
		
		$system->xorg->smarty->assign("rand", $rand);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/show" . $settings[ext4]);
	}
	// Activate Object
	public function m_activateObject($id){

	}
	// Deactive Object
	public function m_deactivateObject($id){

	}

	###########################
	# Object Details          #
	###########################
	public function m_listDetails($viewMode, $filter = null){
		global $settings, $system, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$lastDraw = $system->dbm->db->findMax("`$settings[drawObject]`", "`id`");
		$system->xorg->pagination->paginateStart("draw", "c_$viewMode", "`from`", "`$settings[drawObjectDetails]`", "`draw` = $lastDraw $filter", "`timeStamp` ASC", "", "", "0,5", 1, 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

//			$entityList[$count][num] = $count;
//			$entityList[$count][active] = $row[active];
//			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);
//			$entityList[$count][id] = $row[id];
//			$entityList[$count][category] = $row[category];
//			$entityList[$count][draw] = $row[draw];
//			$entityList[$count][win] = $row[win];
//			$entityList[$count][direction] = $row[direction];
			$entityList[$count][fromVirtual] = $entityList[$count]['from'] = $row['from'];
			$entityList[$count][fromVirtual][3] = '0';
			$entityList[$count][fromVirtual][4] = '0';
			$entityList[$count][fromVirtual][5] = '0';
//			$entityList[$count][to] = $row[to];
//			$entityList[$count][message] = $row[message];
//			$entityList[$count][date] = $row[date];
//			$entityList[$count][status] = $row[status];
//			$entityList[$count][partcount] = $row[partcount];
//			$entityList[$count][contactname] = $row[contactname];

			$count++;
		}
		
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	
	public function m_stat (){
		global $system, $settings, $lang;
		
		$system->xorg->smarty->assign("chart", $system->xorg->htmlElements->chartElement->bar("فراگامان شریف", "فراگامان"));
		$system->xorg->smarty->display($settings[moduleAddress] . "/" .  $settings[moduleName] . "/view/tpl/object/stat" . $settings[ext4]);
	}
}
?>