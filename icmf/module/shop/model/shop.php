<?php
class m_shop extends masterModule{

	function m_shop(){

	}
	###########################
	# Category                #
	###########################
	//Add Category
	public function m_addCategory($name, $increase=null, $decrease=null, $discount=null, $tax=null, $description=null){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$settings[shopCategory]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `name`, `increase`, `decrease`, `discount`, `tax`, `description`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, '$name', $increase, $decrease, $discount, $tax, '$description'");
		$system->watchDog->exception("s", $lang[shopProfile], sprintf($lang[successfulDone], $lang[addShop], $name));
	}
	// Edit Category
	public function m_editCategory($id, $name, $increase=0, $decrease=0, $discount=0, $tax=0){
		global $settings, $system, $lang;

		$system->dbm->db->update("`$settings[shopCategory]`", "`name` = '$name', `increase` = $increase, `decrease` = $decrease, `discount` = $discount, `tax` = $tax", "`id` = $id");
		$system->watchDog->exception("s", $lang[successful], sprintf($lang[successfulDone], $lang[updateShopProfile], $name));

	}
	// Del Category
	public function m_delCategory($id){
		global $system, $lang, $settings;

		$name = $system->dbm->db->informer("`$settings[shopCategory]`", "`id` = $id", "name");
		$system->dbm->db->delete("`$settings[shopCategory]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[categoryDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Category
	public function m_listCategory(){
		global $system, $lang, $settings;

		$system->xorg->pagination->paginateStart("shop", "c_listCategory", "`id`, `active`, `name`, `increase`, `decrease`, `discount`, `tax`", "`$settings[shopCategory]`", "", "`name` DESC", "", "", "", "", 10, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][active] = $row[active];
			$entityList[$count][num] = $count;
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][increase] = $row[increase];
			$entityList[$count][decrease] = $row[decrease];
			$entityList[$count][discount] = $row[discount];
			$entityList[$count][tax] = $row[tax];

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/$settings[moduleName]/view/tpl/category/list" . $settings[ext4]);
	}
	// Activate Category
	public function m_activateCategory(){

	}
	// Deactivate Category
	public function m_deactivateCategory(){

	}
	###########################
	# Object (Product)        #
	###########################
	// Add Object
	public function vm_addObject(){
		global $system, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("shop", "v_addObject", "`base`.`id`, `base`.`name`, `model`, `announceDate`, `dimension`, `weight`, `color`, `link`, `keywords`, `imageGallery`, `filePath`, `$settings[company]`.`name` as `company`, `buyPrice`, `count`, `$settings[productCategory]`.`name` as `category`, `base`.`description`", "`$settings[productObject]` as `base`, `$settings[company]`, `$settings[productCategory]`", "`base`.`owner` = $_SESSION[uid] AND `base`.`company` = `$settings[company]`.`id` AND `base`.`category` = `$settings[productCategory]`.`id` $filter", "`base`.`name` DESC", "", "", "", "", 10, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][active] = $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $row[id]", 'active');
			$entityList[$count][num] = $count;
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][model] = $row[model];

			$imgTmp = explode(",", $row[imageGallery]);
			$row[imageGallery] = $imgTmp[0];
			$row[imageGallery] = empty($row[imageGallery]) ? "theme/$settings[theme]/img/none.jpg" : $row[imageGallery];
			$entityList[$count][imageGallery] = $row[imageGallery];
			$entityList[$count][filePath] = $row[filePath];

			$fileTmp = explode(",", $row[filePath]);
			$row[filePath] = $fileTmp[0];
			$entityList[$count][filePath] = $row[filePath];

			$entityList[$count][company] = $row[company];
			$entityList[$count][buyPrice] = $row[buyPrice];
			$entityList[$count][count] = $row[count];
			$entityList[$count][category] = $row[category];
			$entityList[$count][basePrice] = $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $row[id]", 'basePrice');
			$entityList[$count][discount] = $row[discount] = $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $row[id]", 'discount');
			$entityList[$count][tax] = $row[tax] = $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $row[id]", 'tax');
			$entityList[$count][shopCategory] = $system->xorg->combo(array('id', 'name'), "$settings[shopCategory]", null, $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $row[id]", 'category'));

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/$settings[moduleName]/view/tpl/object/add" . $settings[ext4]);

	}
	// Add Object
	public function m_addObject($objectId, $basePrice, $shopCategory, $discount=null, $tax=null){
		global $system, $lang, $settings;

		$name = $system->dbm->db->informer("`$settings[productObject]`" , "`id` = $objectId", 'name');

		if($system->dbm->db->count_records("`$settings[shopObject]`", "`objectId` = $objectId") == 0){
			$timeStamp = time();
			$system->dbm->db->insert("`$settings[shopObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `objectId`, `basePrice`, `category`, `discount`, `tax`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $objectId, $basePrice, $shopCategory, '$discount', '$tax'");
			$system->watchDog->exception("s", $lang[shopProfile], sprintf($lang[successfulDone], $lang[addProducToShop], $name));
		}else{
			$system->dbm->db->update("`$settings[shopObject]`", "`basePrice` = $basePrice, `category` = $shopCategory, `discount` = '$discount', `tax` = '$tax'", "`objectId` = $objectId");
			$system->watchDog->exception("s", $lang[shopProfile], sprintf($lang[successfulDone], $lang[updateProducToShop], $name));
		}
	}
	// Edit Object
	//	public function m_editObject(){
	//
	//	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$objectId = $system->dbm->db->informer("`$settings[shopObject]`", "`id` = $id", "objectId");
		$name = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "name");
		$system->dbm->db->delete("`$settings[shopObject]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[objectDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Object
	public function m_listObject($filter=null){
		global $system, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("shop", "c_listObject", "`id`, `active`, `objectId`, `basePrice`, `discount`, `tax`, `category`", "`$settings[shopObject]`", "`owner` = $_SESSION[uid] $filter", "`objectId` DESC", "", "", "", "", 10, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$object = $system->dbm->db->informer("`$settings[productObject]`" , "`id` = $row[objectId]");
			$entityList[$count][active] = $row[active];
			$entityList[$count][num] = $count;
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $object[name];
			$entityList[$count][model] = $object[model];

			$imgTmp = explode(",", $object[imageGallery]);
			$object[imageGallery] = $imgTmp[0];
			$object[imageGallery] = empty($object[imageGallery]) ? "theme/$settings[theme]/img/none.jpg" : $object[imageGallery];
			$entityList[$count][imageGallery] = $object[imageGallery];
			$entityList[$count][filePath] = $object[filePath];

			$fileTmp = explode(",", $object[filePath]);
			$object[filePath] = $fileTmp[0];
			$entityList[$count][filePath] = $object[filePath];

			$entityList[$count][company] = $system->dbm->db->informer("`$settings[company]`" , "`id` = $object[company]", 'name');
			$entityList[$count][count] = $object[count];
			$entityList[$count][category] = $system->dbm->db->informer("`$settings[productCategory]`" , "`id` = $object[category]", 'name');
			$entityList[$count][basePrice] = $row[basePrice];
			$entityList[$count][discount] = $row[discount];
			$entityList[$count][tax] = $row[tax];
			$entityList[$count][sellPrice] = $this->m_sellPriceCalculator($row[objectId]);
			$entityList[$count][shopCategory] = $system->dbm->db->informer("`$settings[shopCategory]`", "`id` = $row[category]", 'name');

			$count++;
		}
		
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/$settings[moduleName]/view/tpl/object/list" . $settings[ext4]);
	}
	// Activate Object
	public function m_activateObject($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$settings[shopObject]`", "`active` = 1", "`id` = $id");
		$system->watchDog->exception("s", $lang[activate], sprintf($lang[successfulDone], $lang[showProductInShopActivated], null));
	}
	// Deactivate Object
	public function m_deactivateObject($id){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$settings[shopObject]`", "`active` = 0", "`id` = $id");
		$system->watchDog->exception("s", $lang[deActivate], sprintf($lang[successfulDone], $lang[hiddenProductInShopActivated], null));
	}
	###########################
	# Vitrin                  #
	###########################
	// List Vitrin	
	public function m_listVitrin($viewMode=null, $filter=null){
		global $system, $settings, $lang;
		
		if(strstr($filter, "ex.")){
//			echo 1;
			$valueCount = 0;
			if(!strstr($filter, ","))
			die($lang[noRecordExist]);
			$parameters = explode(",", $filter);
			foreach ($parameters as $key=>$param){
				$values = explode("=", $param);
				if(strstr($values[0], 'name')){
					//					print "Count: $count<br>";
					$or = ($valueCount > 0) ? ' OR ' : null;
					$temp = "$or`ex`.`name` = '$values[1]'";
				}elseif(strstr($values[0], 'value')){
					if(!empty($values[1])){
						$where .= "$temp AND `ex`.`value` LIKE '%$values[1]%'";
						$valueCount++;
					}
					$temp;
				}
			}
				
			$result = mysql_query("SELECT `objectId` FROM `$settings[productObjectExtraFields]` as `ex` WHERE $where");
			if(empty($result))
			die($lang[noRecordExist]);
			while ($out = mysql_fetch_array($result)){
				$objects[] = $out[objectId];
			}

			if(empty($objects))
			die($lang[noRecordExist]);
			$objectCount = array_count_values($objects);
			foreach ($objectCount as $key=>$counter){
				if($counter == $valueCount){
					$objectQuery[] = $key;
				}
			}

			if(count($objectQuery) > 0){
				$objectQuery = implode(",", $objectQuery);
				$system->xorg->pagination->paginateStart("shop", "v_vitrin", "`base`.`id`, `base`.`active`, `base`.`name`, `model`, `imageGallery`, `$settings[company]`.`name` as `company`, `buyPrice`, `count`, `$settings[productCategory]`.`name` as `category`", "`$settings[productObject]` as `base`, `$settings[company]`, `$settings[productCategory]`, `$settings[shopObject]`", "`base`.`id` = `$settings[shopObject]`.`objectId` AND `base`.`company` = `$settings[company]`.`id` AND `base`.`category` = `$settings[productCategory]`.`id` AND `$settings[shopObject]`.`active` = 1 and `base`.`id` IN ($objectQuery)", "`base`.`timeStamp` DESC", "", "", "", "", 12, 7);
			}else{
				die($lang[noRecordExist]);
			}
		}else{
			$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
			
			if($viewMode == 'list' || $viewMode == 'masonryList'){
//				echo 2;
				$system->xorg->pagination->paginateStart("shop", "v_vitrin", "`base`.`id`, `base`.`active`, `base`.`name`, `model`, `imageGallery`, `buyPrice`, `count`", "`$settings[productObject]` as `base`, `$settings[shopObject]`", "`base`.`id` = `$settings[shopObject]`.`objectId` AND `$settings[shopObject]`.`active` = 1 $filter", "`base`.`timeStamp` DESC", "", "", "", "", 12, 7);
			}else{
//				echo 3;
				$system->xorg->pagination->paginateStart("shop", "v_vitrin", "`base`.`id`, `base`.`active`, `base`.`name`, `model`, `announceDate`, `dimension`, `weight`, `color`, `link`, `keywords`, `imageGallery`, `filePath`, `$settings[company]`.`name` as `company`, `buyPrice`, `count`, `$settings[productCategory]`.`name` as `category`, `base`.`description`", "`$settings[productObject]` as `base`, `$settings[company]`, `$settings[productCategory]`, `$settings[shopObject]`", "`base`.`id` = `$settings[shopObject]`.`objectId` AND `base`.`company` = `$settings[company]`.`id` AND `base`.`category` = `$settings[productCategory]`.`id` AND `$settings[shopObject]`.`active` = 1 $filter", "`base`.`timeStamp` DESC", "", "", "", "", 12, 7);
			}
		}

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][active] = $row[active];
			$entityList[$count][num] = $count;
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][model] = $row[model];
			
			$entityList[$count][singleImage] = $system->dbm->db->informer("`$settings[galleryObject]`", "`category` = $row[imageGallery]", "url");
			$fileTmp = explode(",", $row[filePath]);
			$row[filePath] = $fileTmp[0];
			$entityList[$count][filePath] = $row[filePath];

			$entityList[$count][company] = $row[company];
			$entityList[$count][buyPrice] = $row[buyPrice];
			$entityList[$count][count] = $row[count];
			$entityList[$count][category] = $row[category];

			$shopObject = $system->dbm->db->informer("`$settings[shopObject]`", "`objectId` = $row[id]");
			$entityList[$count][basePrice] = $shopObject[basePrice];
			$entityList[$count][discount] = $shopObject[discount];
			$entityList[$count][tax] = $shopObject[tax];
			$row[shopCategory] = $shopObject[category];

			$entityList[$count][shopCategory] = $system->dbm->db->informer("`$settings[shopCategory]`" , "`id` = $row[shopCategory]", 'name');
			$entityList[$count][sellPrice] = $this->m_sellPriceCalculator($row[id]);

			if($viewMode == 'description'){
				$entityList[$count][dimension] = $row[dimension];
				$entityList[$count][weight] = $row[weight];
				$entityList[$count][color] = $row[color];
				$entityList[$count][link] = $row[link];
				$entityList[$count][keyWords] = $row[keywords];						
				$entityList[$count][imageGallery] = $system->xorg->htmlElements->imageGalleryElement->gallery($row['imageGallery']);
				$entityList[$count][description] = $row[description];
			
			}

			require_once 'module/product/model/product.php';
			$product = new m_product();

			$result = mysql_query("SELECT `name`, `value` FROM `$settings[productObjectExtraFields]` WHERE `objectId` = $row[id]");
			while($ext = mysql_fetch_array($result)){
				$entityList[$count][$ext[name]] = $ext[value];
			}

			$count++;
		}
//		print_r($entityList);

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/vitrin/$viewMode" . $settings[ext4]);

	}
	// Make Carousel
	public function m_carousel($filter=null){
		global $system, $settings, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->dbm->db->select("`id`, `objectId`, `category`",  "$settings[shopObject]", "1 $filter", "rand()", "", "", "0,10", 1);

		$count = 1;
		while($row = $system->dbm->db->fetch_array()){
			$entityList[$count][id] = $row[id];
			$entityList[$count][objectId] = $row[objectId];
			$row[imageGallery] = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $row[objectId]", "imageGallery");
			$imgTmp = explode(",", $row[imageGallery]);
			$entityList[$count][imageGallery] = $system->xorg->htmlElements->imageElement->thumbnailLocator($imgTmp[0]);

			$count++;
		}

		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/vitrin/carousel" . $settings[ext4]);
	}
	###########################
	# Other                   #
	###########################
	// Calculate sell price
	public function m_sellPriceCalculator($objectId){
		global $settings, $system;

		//		print "Object Id: $objectId<br>";
		$base = $system->dbm->db->informer("`$settings[shopObject]`" , "`objectId` = $objectId");
		$basePrice = $base['basePrice'];
		$discount = $base['discount'];
		$tax = $base['tax'];
		$shopCategory = $base['category'];

		
		$category = $system->dbm->db->informer("`$settings[shopCategory]`" , "`id` = $shopCategory");
		$categoryIncrease = $category['increase'];
		$categoryDecrease = $category['decrease'];
		$categoryDiscount = $category['discount'];
		$categoryTax = $category['tax'];

		$discountValue = ($basePrice * $discount)/100;
		$taxValue = ($basePrice * $tax)/100;

		$categoryDiscountValue = ($basePrice * $categoryDiscount)/100;
		$categoryTaxValue = ($basePrice * $categoryTax)/100;

		$sellPrice = $basePrice - $discountValue + $taxValue - $categoryDiscountValue + $categoryTaxValue - $categroyDecrease + $categoryIncrease;

		return $sellPrice;
	}
}
?>