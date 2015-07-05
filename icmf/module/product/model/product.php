<?php
class m_product extends masterModule{
	
	public $tree;

	public function m_product(){

	}
	###########################
	# Category                #
	###########################
	// Add Category
	public function m_addCategory($name, $category, $description=null){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$settings[productCategory]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `name`, `category`, `description`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$name', $category, '$description'");
		$system->watchDog->exception("s", $lang[categoryAdd], sprintf($lang[successfulDone], $lang[categoryAdd], $name));
	}
	// Edit Category
	public function m_editCategory($id, $name, $category=null, $description=null){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$settings[productCategory]`", "`name` = '$name', `category` = '$category', `description` = '$description'", "`id` = $id");
		$system->watchDog->exception("s", $lang[editCategory], sprintf($lang[successfulDone], $lang[editCategory], $name));
	}
	// Del Category
	public function m_delCategory($id){
		global $system, $lang, $settings;

		$name = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = $id", "name");
		$system->dbm->db->delete("`$settings[productCategory]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[categoryDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Category
	public function m_listCategory(){
		global $system, $lang, $settings;

		$system->xorg->pagination->paginateStart("product", "c_listCategory", "`active`, `id`, `name`, `category`, `description`", "`$settings[productCategory]`", "", "`timeStamp` DESC", "", "", "", "", 15, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][category] = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = $row[category]", 'name');
			$entityList[$count][description] = $row[description];
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/category/list" . $settings[ext4]);

	}
	// Activate Category
	public function m_activateCategory(){

	}
	// Deactivate Category
	public function m_deactivateCategory(){

	}
	// Find HierarchicalCategory
	public function m_hierarchicalCategoryFinder($categories){
		global $system, $settings;

		foreach ($categories as $key => $category){
			$hierarchicalList[$category] = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = $category", "name");
		}

		$system->xorg->smarty->assign("hierarchicalList", $hierarchicalList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/hierarchicalCategory" . $settings[ext4]);
	}
	// Make Hierarchical Category
	public function m_hierarchicalListCategory($category, $level=0, $flag=0){
		global $system, $lang, $settings;
		
		$result = mysql_query("SELECT `id`, `category`, `name` FROM `productCategory` WHERE `category` = $category");
		if(!empty($result)){
			if($flag == 1)
			$this->tree .= str_repeat("\t", $level+1) . "<ul>\n";
			while ($row = mysql_fetch_array($result)){
				$res = mysql_query("SELECT `id` FROM `productCategory` WHERE `category` = $row[id]");
				if(mysql_num_rows($res) > 0){
					$this->tree .= str_repeat("\t", $level+2) . "<li><span>$row[name]</span>\n";
					$this->m_hierarchicalListCategory($row['id'], $level+1, 1);
					$this->tree .= str_repeat("\t", $level+2) . "</li>\n";
				}else{
					$this->tree .= str_repeat("\t", $level+2) . "<li><a href='/shop/v_vitrin/productCategory.id=$row[id]' title='$row[name]'>$row[name]</a></li>\n";
				}
			}
			if($flag == 1)
			$this->tree .= str_repeat("\t", $level+1) . "</ul>\n";
		}
	}
	###########################
	# Object (product)        #
	###########################
	// Add Object
	public function m_addObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$values[description] = nl2br($values[description]);
		$images = rtrim($values['imagePath'], ',');
		$images = explode(',', $images);
		$system->dbm->db->insert("`galleryCategory`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `name`, `category`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[name]', 0");
		$imageGallery = $system->dbm->db->insert_id();
		foreach ($images as $image){
			$system->dbm->db->insert("`galleryObject`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `name`, `category`, `url`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[name]', $imageGallery, '$image'");
		}
		$system->dbm->db->insert("`$settings[productObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `name`, `model`, `company`, `count`, `category`, `announceDate`, `dimension`, `weight`, `color`, `link`, `keyWords`, `buyPrice`, `description`, `imageGallery`, `filePath`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[name]', '$values[model]', $values[company], $values[count], $values[category], '$values[announceDate]', '$values[dimension]', '$values[weight]', '$values[color]', '$values[link]', '$values[keyWords]', '$values[buyPrice]', '$values[description]', $imageGallery, '$values[filePath]'");
		$objectId = $system->dbm->db->insert_id();

		// Additional fields
		if(!empty($values[rpm])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'rpm', '$values[rpm]'");
		}
		if(!empty($values[tav])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'tav', '$values[tav]'");
		}
		if(!empty($values[voltage])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'voltage', '$values[voltage]'");
		}
		if(!empty($values[amper])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'amper', '$values[amper]'");
		}
		if(!empty($values[electricType])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'electricType', '$values[electricType]'");
		}
		if(!empty($values[power])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'power', '$values[power]'");
		}
		if(!empty($values[code])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'code', '$values[code]'");
		}
		if(!empty($values[usage])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'usage', '$values[usage]'");
		}
		if(!empty($values[warranty])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'warranty', '$values[warranty]'");
		}
		if(!empty($values[cpu])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'cpu', '$values[cpu]'");
		}
		if(!empty($values[cache])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'cache', '$values[cache]'");
		}
		if(!empty($values[ram])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'ram', '$values[ram]'");
		}
		if(!empty($values[hdd])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'hdd', '$values[hdd]'");
		}
		if(!empty($values[screen])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'screen', '$values[screen]'");
		}
		if(!empty($values[vga])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'vga', '$values[vga]'");
		}
		if(!empty($values[os])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'os', '$values[os]'");
		}
		if(!empty($values[modem])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'modem', '$values[modem]'");
		}
		if(!empty($values[wireless])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'wireless', '$values[wireless]'");
		}
		if(!empty($values[trackingTechnology])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'trackingTechnology', '$values[trackingTechnology]'");
		}
		if(!empty($values[chargeable])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'chargeable', '$values[chargeable]'");
		}
		if(!empty($values[chargeLife])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'chargeLife', '$values[chargeLife]'");
		}
		if(!empty($values[transceiverLength])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'transceiverLength', '$values[transceiverLength]'");
		}
		if(!empty($values[button])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'button', '$values[button]'");
		}
		if(!empty($values[scroll])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'scroll', '$values[scroll]'");
		}
		if(!empty($values[avgBatteryLife])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'avgBatteryLife', '$values[avgBatteryLife]'");
		}
		if(!empty($values[range])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'range', '$values[range]'");
		}
		if(!empty($values[ferquencyResponse])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'ferquencyResponse', '$values[ferquencyResponse]'");
		}
		if(!empty($values[impedance])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'impedance', '$values[impedance]'");
		}
		if(!empty($values[sensitivity])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'sensitivity', '$values[sensitivity]'");
		}
		if(!empty($values[cableLengthRange])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'cableLengthRange', '$values[cableLengthRange]'");
		}
		if(!empty($values['interface'])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'interface', '$values[interface]'");
		}
		if(!empty($values[noiseCancelling])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'noiseCancelling', '$values[noiseCancelling]'");
		}
		if(!empty($values[other])){
			$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, 'other', '$values[other]'");
		}

		$system->watchDog->exception("s", $lang[productAdd], sprintf($lang[successfulDone], $lang[productAdd], $values[name]));
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$values[description] = nl2br($values[description]);
		$system->dbm->db->update("`$settings[productObject]`", "`timeStamp` = $timeStamp, `name` = '$values[name]', `model` = '$values[model]', `company` = $values[company], `count` = $values[count], `category` = $values[category], `announceDate` = '$values[announceDate]', `dimension` = '$values[dimension]', `weight` = '$values[weight]', `color` = '$values[color]', `link` = '$values[link]', `keyWords` = '$values[keyWords]', `buyPrice` = '$values[buyPrice]', `description` = '$values[description]', `imageGallery` = '$values[imageGallery]', `filePath` = '$values[filePath]'", "`id` = $values[id]");
		//		$objectId = $system->dbm->db->insert_id();

		if(!empty($values[rpm])){
			//			print "ID: $values[id]<br>";
			//			print "Count: " . $system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'rpm'");
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'rpm'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[rpm]'", "`objectId` = $values[id] AND `name` = 'rpm'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'rpm', '$values[rpm]'");
			}
		}
		if(!empty($values[tav])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'tav'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[tav]'", "`objectId` = $values[id] AND `name` = 'tav'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'tav', '$values[tav]'");
			}
		}
		if(!empty($values[voltage])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'voltage'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[voltage]'", "`objectId` = $values[id] AND `name` = 'voltage'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'voltage', '$values[voltage]'");
			}
		}
		if(!empty($values[amper])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'amper'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[amper]'", "`objectId` = $values[id] AND `name` = 'amper'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'amper', '$values[amper]'");
			}
		}
		if(!empty($values[electricType])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'electricType'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[electricType]'", "`objectId` = $values[id] AND `name` = 'electricType'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'electricType', '$values[electricType]'");
			}
		}
		if(!empty($values[power])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'power'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[power]'", "`objectId` = $values[id] AND `name` = 'power'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'power', '$values[power]'");
			}
		}
		if(!empty($values[code])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'code'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[code]'", "`objectId` = $values[id] AND `name` = 'code'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'code', '$values[code]'");
			}
		}
		if(!empty($values[usage])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'usage'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[usage]'", "`objectId` = $values[id] AND `name` = 'usage'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'usage', '$values[usage]'");
			}
		}
		if(!empty($values[warranty])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'warranty'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[warranty]'", "`objectId` = $values[id] AND `name` = 'warranty'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'warranty', '$values[warranty]'");
			}
		}
		if(!empty($values[cpu])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'cpu'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[cpu]'", "`objectId` = $values[id] AND `name` = 'cpu'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'cpu', '$values[cpu]'");
			}
		}
		if(!empty($values[cache])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'cache'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[cache]'", "`objectId` = $values[id] AND `name` = 'cache'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'cache', '$values[cache]'");
			}
		}
		if(!empty($values[ram])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'ram'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[ram]'", "`objectId` = $values[id] AND `name` = 'ram'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'ram', '$values[ram]'");
			}
		}
		if(!empty($values[hdd])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'hdd'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[hdd]'", "`objectId` = $values[id] AND `name` = 'hdd'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'hdd', '$values[hdd]'");
			}
		}
		if(!empty($values[screen])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'screen'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[screen]'", "`objectId` = $values[id] AND `name` = 'screen'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'screen', '$values[screen]'");
			}
		}
		if(!empty($values[vga])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'vga'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[vga]'", "`objectId` = $values[id] AND `name` = 'vga'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'vga', '$values[vga]'");
			}
		}
		if(!empty($values[os])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'os'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[os]'", "`objectId` = $values[id] AND `name` = 'os'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'os', '$values[os]'");
			}
		}
		if(!empty($values[modem])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'modem'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[modem]'", "`objectId` = $values[id] AND `name` = 'modem'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'modem', '$values[modem]'");
			}
		}
		if(!empty($values[wireless])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'wireless'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[wireless]'", "`objectId` = $values[id] AND `name` = 'wireless'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'wireless', '$values[wireless]'");
			}
		}
		if(!empty($values[trackingTechnology])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'trackingTechnology'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[trackingTechnology]'", "`objectId` = $values[id] AND `name` = 'trackingTechnology'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'trackingTechnology', '$values[trackingTechnology]'");
			}
		}
		if(!empty($values[chargeable])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'chargeable'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[chargeable]'", "`objectId` = $values[id] AND `name` = 'chargeable'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'chargeable', '$values[chargeable]'");
			}
		}
		if(!empty($values[chargeLife])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'chargeLife'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[chargeLife]'", "`objectId` = $values[id] AND `name` = 'chargeLife'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'chargeLife', '$values[chargeLife]'");
			}
		}
		if(!empty($values[transceiverLength])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'transceiverLength'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[transceiverLength]'", "`objectId` = $values[id] AND `name` = 'transceiverLength'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'transceiverLength', '$values[transceiverLength]'");
			}
		}
		if(!empty($values[button])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'button'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[button]'", "`objectId` = $values[id] AND `name` = 'button'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'button', '$values[button]'");
			}
		}
		if(!empty($values[scroll])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'scroll'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[scroll]'", "`objectId` = $values[id] AND `name` = 'scroll'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'scroll', '$values[scroll]'");
			}
		}
		if(!empty($values[avgBatteryLife])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'avgBatteryLife'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[avgBatteryLife]'", "`objectId` = $values[id] AND `name` = 'avgBatteryLife'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'avgBatteryLife', '$values[avgBatteryLife]'");
			}
		}
		if(!empty($values[range])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'range'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[range]'", "`objectId` = $values[id] AND `name` = 'range'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'range', '$values[range]'");
			}
		}
		if(!empty($values[ferquencyResponse])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'ferquencyResponse'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[ferquencyResponse]'", "`objectId` = $values[id] AND `name` = 'ferquencyResponse'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'ferquencyResponse', '$values[ferquencyResponse]'");
			}
		}
		if(!empty($values[impedance])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'impedance'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[impedance]'", "`objectId` = $values[id] AND `name` = 'impedance'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'impedance', '$values[impedance]'");
			}
		}
		if(!empty($values[sensitivity])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'sensitivity'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[sensitivity]'", "`objectId` = $values[id] AND `name` = 'sensitivity'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'sensitivity', '$values[sensitivity]'");
			}
		}
		if(!empty($values[cableLengthRange])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'cableLengthRange'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[cableLengthRange]'", "`objectId` = $values[id] AND `name` = 'cableLengthRange'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'cableLengthRange', '$values[cableLengthRange]'");
			}
		}
		if(!empty($values['interface'])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'interface'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[interface]'", "`objectId` = $values[id] AND `name` = 'interface'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'interface', '$values[interface]'");
			}
		}
		if(!empty($values[noiseCancelling])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'noiseCancelling'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[noiseCancelling]'", "`objectId` = $values[id] AND `name` = 'noiseCancelling'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'noiseCancelling', '$values[noiseCancelling]'");
			}
		}
		if(!empty($values[other])){
			if($system->dbm->db->count_records("`$settings[productObjectExtraFields]`", "`objectId` = $values[id] AND `name` = 'other'") > 0){
				$system->dbm->db->update("`$settings[productObjectExtraFields]`", "`value` = '$values[other]'", "`objectId` = $values[id] AND `name` = 'other'");
			}else{
				$system->dbm->db->insert("`$settings[productObjectExtraFields]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[id], 'other', '$values[other]'");
			}
		}

		$system->watchDog->exception("s", $lang[productEdit], sprintf($lang[successfulDone], $lang[productEdit], $values[name]));
	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$name = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $id", "name");
		$system->dbm->db->delete("`$settings[productObject]`", "`id` = $id");
		$system->dbm->db->delete("`$settings[productObjectExtraFields]`", "`objectId` = $id");
		$system->watchDog->exception("s", $lang[productDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Object
	public function m_listObject(){
		global $system,$lang, $settings;

		$system->xorg->pagination->paginateStart("product", "c_listObject", "`active`, `id`, `name`, `category`, `model`, `buyPrice`, `count`", "`$settings[productObject]`", "`owner` = $_SESSION[uid]", "`name` DESC", "", "", "", "", 15, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][category] = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = $row[category]", 'name');
			$entityList[$count][model] = $row[model];
			$entityList[$count][buyPrice] = $row[buyPrice];
			$entityList[$count][count] = $row[count];
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/list" . $settings[ext4]);

	}
	// Activate Object
	public function m_activateObject(){

	}
	// Deactivate Object
	public function m_deactivateObject(){

	}
	// Increase Object
	public function m_increaseObject($id, $plus){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->productEntity`", "`count` = `count`+$plus", "`id` = $id");
	}
	// Decrease Object
	public function m_decrease($id, $minus){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$this->productEntity`", "`count` = `count`-$minus", "`id` = $id");
	}
	// Info Object
	public function m_infoObject($id){
		global $system, $settings;

		$row = mysql_fetch_array(mysql_query("SELECT `id`, `name`, `model`, `imageGallery`, `filePath`, `company`, `announceDate`, `dimension`, `weight`, `color`, `link`, `keywords`, `buyPrice`, `count`, `category`, `description` FROM `$settings[productObject]` WHERE `id` = $id"));
		$res = mysql_query("SELECT `name`, `value` FROM `$settings[productObjectExtraFields]` WHERE `objectId` = $row[id]");
		if($res){
			while($fields = mysql_fetch_array($res)){
				$row[$fields[name]] = $fields[value];
				if($row[electricType] == 'AC'){
					$row[electricType] = 1;
				}elseif ($row[electricType] == 'DC'){
					$row[electricType] == 2;
				}
			}
		}

		$fileTmp = explode(",", $row[filePath]);
		$row[filePath] = $fileTmp[0];
		$row[filePath] = empty($row[filePath]) ? "" : $row[filePath];

		return $row;
	}

}
?>