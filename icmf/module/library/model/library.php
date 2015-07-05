<?php
class m_library extends masterModule{

	function m_library(){

	}

	###########################
	# Category                #
	###########################
	// Add Category
	public function m_addCategory($name, $category){
		global $settings, $lang, $system;
		
		$time = time();
		$system->dbm->db->insert("`$settings[libraryCategory]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `name`, `category`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$name', '$category'");
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
		$system->xorg->pagination->paginateStart("library", "c_categoryList", "`id`, `active`, `name`, `category`", "`$settings[libraryCategory]`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 20, 7);

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
	# Object (e-book)         #
	###########################
	// Add Object
	public function m_addObject($name, $category, $filePath, $author=null, $price, $abstract=null, $imagePath=null){
		global $settings, $lang, $system;
		
		$time = time();
		$system->dbm->db->insert("`$settings[libraryObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `name`, `author`, `price`, `category`, `abstract`, `imagePath`, `filePath`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$name', '$author', $price, $category, '$abstract', '$imagePath', '$filePath'");
		$system->watchDog->exception("s", $lang[bookAdd], sprintf($lang[successfulDone], $lang[bookAdd], $name));
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
		$system->xorg->pagination->paginateStart("library", "c_$viewMode", "`id`, `active`, `name`, `category`, `author`, `imagePath`, `abstract`", "`$settings[libraryObject]`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][imagePath] = trim($row[imagePath], ',');
			$entityList[$count]['abstract'] = $row['abstract'];
			$entityList[$count][name] = $row[name];
			$entityList[$count][author] = $row[author];
			$entityList[$count][price] = $row[price];
			$entityList[$count][category] = $row[category];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	// Show Object
	public function m_showObject($id){
		global $system, $settings, $lang;
		
		$files = explode(",", $system->dbm->db->informer("`$settings[libraryObject]`", "`id` = $id", "filePath"));
		$system->xorg->smarty->assign("fileName", $files[0]);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/show" . $settings[ext4]);
	}
	// Activate Object
	public function m_activateObject($id){

	}
	// Deactive Object
	public function m_deactivateObject($id){

	}

	###########################
	# Favorite                #
	###########################
	// Add Object to favorite
	public function m_addObjectToFavorite($name, $articleContent){

	}
	// Del Object from favorite
	public function m_delObjectFromFavorite($id){

	}
	// List favorite
	public function m_listFavorite($filter = null){

	}

}
?>