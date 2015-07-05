<?php
class m_basket extends masterModule{

	function m_basket(){

	}

	###########################
	# Object (Basket)         #
	###########################
	// Add Object
	public function m_addObject($objectId, $count){
		global $system, $lang, $settings;

		$storeCount = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "count");
		if($system->dbm->db->count_records("`$settings[basketObject]`", "`objectId` = $objectId AND `uid` = $_SESSION[uid]") == 0){
			echo 1;
			if(!empty($count)){
				echo 2;
				if($count < $storeCount){
					echo 3;
					$timeStamp = time();
					$system->dbm->db->insert("`$settings[basketObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `objectId`, `uid`, `count`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, $objectId, $_SESSION[uid], $count");
					
// 					require_once 'module/eDelivery/config/config.php';
// 					require_once 'module/eDelivery/model/eDelivery.php';
// 					m_eDelivery::m_addObject($objectId, $count);
					
					$system->watchDog->exception("s", $lang[shopProfile], sprintf($lang[successfulDone], $lang[addProducToShop], $objectName));
				}else{
					echo 4;
					$system->watchDog->exception("e", $lang[error], sprintf($lang[youCantSubmitBiggerThan], $storeCount));
				}
			}else{
				echo 5;
				$system->watchDog->exception("e", $lang[error], $lang[youCantSubmitWithZeroCount]);
			}
		}else{
			echo 6;
			if(!empty($count)){
				echo 7;
				if($count < $storeCount){
					echo 8;
					$system->dbm->db->update("`$settings[basketObject]`", "`count` = $count", "`uid` = $_SESSION[uid] AND `objectId` = $objectId");
					$system->watchDog->exception("s", $lang[shopProfile], sprintf($lang[successfulDone], $lang[updateProducToShop], $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "name")));
				}else{
					echo 9;
					$system->watchDog->exception("e", $lang[error], sprintf($lang[youCantSubmitBiggerThan], $storeCount));
				}
			}else{
				echo 10;
				$system->dbm->db->delete("`$settings[basketObject]`", "`uid` = $_SESSION[uid] AND `objectId` = $objectId");
				$system->watchDog->exception("s", $lang[success], sprintf($lang[successfulDone], $lang[delete], $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "name")));
			}
		}
	}
	// Edit Object
	public function m_editObject($values){

	}
	// Del Object
	public function m_delObject($id){
		global $settings, $lang, $system;

		$objectId = $system->dbm->db->informer("`$settings[basketObject]`", "`id` = $id", "objectId");
		$name = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "name");
		$system->dbm->db->delete("`$settings[basketObject]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[objectDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Object
	public function m_listObject($filter = null){
		global $system, $lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("basket", "v_listObject", "`base`.`id`, `base`.`objectId`, `base`.`count`, `name`, `model`, `imageGallery`", "`$settings[basketObject]` as `base`, `$settings[productObject]`", "`base`.`objectId` = `$settings[productObject]`.`id` AND `base`.`uid` = $_SESSION[uid] AND `base`.`active` = 1", "`base`.`timeStamp` DESC", "", "", "", "", 1000, 7);
		$count = 1;
		require_once 'module/shop/model/shop.php';
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][model] = $row[model];
			$entityList[$count][objectId] = $row[objectId];
//			$imgTmp = explode(",", $row[imagePath]);
//			$row[imagePath] = $imgTmp[0];
//			$entityList[$count][imagePath] = $row[imagePath];
			$entityList[$count][singleImage] = $system->dbm->db->informer("`$settings[galleryObejct]`", "`category` = $row[imageGallery]", "url");
			$entityList[$count][count] = $row[count];

			$entityList[$count][basePrice] = $row[basePrice] = $system->dbm->db->informer("`$settings[shopObject]`", "`objectId` = $row[objectId]", 'basePrice');
				
			$entityList[$count][sellPrice] = $row[sellPrice] = m_shop::m_sellPriceCalculator($row[objectId]);
				
			$entityList[$count][totalMulPrice] = $row[totalMulPrice] = $row[count] * $row[sellPrice];
			$finalPrice += $row[totalMulPrice];
			
			require_once 'module/eDelivery/model/eDelivery.php';
			$entityList[$count][totalAllPrice] = $finalPrice + m_eDelivery::m_totalPrice();

			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("currentTime", $system->time->iCal->dator(time()));
		require_once 'module/eDelivery/model/eDelivery.php';
		$system->xorg->smarty->assign("eDeliveryList", m_eDelivery::m_invoiceObject());
		$system->xorg->smarty->assign("entityList", $entityList);
//		print_r($entityList);
		
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/list" . $settings[ext4]);
	}
	// Activate Object
	//	public function m_activateObject($id){
	//
	//	}
	// Deactive Object
	//	public function m_deactivateObject($id){
	//
	//	}
	// Calculate basket price
	public function m_calculate($mode = 'print'){
		global $system, $lang, $settings;

		$system->dbm->db->select("`id`, `count`, `objectId`", "`$settings[basketObject]`", "`active` = 1 AND `uid` = $_SESSION[uid]");

		require_once 'module/shop/model/shop.php';
		while ($row = $system->dbm->db->fetch_array()){
			
			$row[sellPrice] = m_shop::m_sellPriceCalculator($row[objectId]);
				
			$row[totalMulPrice] = $row[count] * $row[sellPrice];
			$caculate += $row[totalMulPrice];

		}
		require_once 'module/eDelivery/model/eDelivery.php';
		$caculate = $caculate + m_eDelivery::m_totalPrice();

		if($mode == 'return'){
			return $caculate;
		}else{
			echo $caculate;
		}

	}
	
	public function m_move ($source, $destionation){
		global $settings, $system;
		
		$system->dbm->db->update("`$settings[basketObject]`", "`uid` = $destionation", "`uid` = $source");
	}

}
?>