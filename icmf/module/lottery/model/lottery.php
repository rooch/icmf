<?php
class m_lottery{

	private $moduleName = "lottery";
	private $entityTable = "lotteryEntity";
	private $memberTable = "lotteryMember";
	private $productEntityTable = "productEntity";
	private $shopBasket = "shopBasket";
	private $userTable = "user";


	public function m_lottery(){

		$this->entityTable = $this->tablePrefix . $this->entityTable;
		$this->memberTable = $this->tablePrefix . $this->memberTable;
		$this->productEntityTable = $this->tablePrefix . $this->productEntityTable;
		$this->userTable = $this->tablePrefix . $this->userTable;
	}

	public function m_lotteryAddEntity($name, $description=null, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer=0){
		global $system, $lang;

		$timeStamp = time();
		$startTime = $system->time->iCal->geoimport($startYear, $startMonth, $startDay, $startHour, $startMinute);
		$endTime = $system->time->iCal->geoimport($endYear, $endMouth, $endDay, $endHour, $endMinute);
		$system->dbm->db->insert("`$this->entityTable`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `ur`, `name`, `description`, `sellPrice`, `capacity`, `startTime`, `endTime`, `prizeType`, `prize`, `specialOffer`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, '$name', '$description', $price, $capacity, $startTime, $endTime, '$prizeType', $prize, $specialOffer");
		$system->watchDog->exception("s", $lang[lotteryAdd], sprintf($lang[successfulDone], $lang[lotteryAdd], $name));
	}

	public function m_lotteryEditEntity($id, $name, $description=null, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer=0){
		global $system, $lang;

		$timeStamp = time();
		$startTime = $system->time->iCal->geoimport($startYear, $startMonth, $startDay, $startHour, $startMinute);
		$endTime = $system->time->iCal->geoimport($endYear, $endMouth, $endDay, $endHour, $endMinute);
		$system->dbm->db->update("`$this->entityTable`", "`timeStamp` = $timeStamp, `name` = '$name', `description` = '$description', `sellPrice` = $price, `capacity` = $capacity, `startTime` = $startHour, `endTime` = $endTime, `prizeType` = '$prizeType', `prize` = $prize, `specialOffer` = $specialOffer", "`id` = $id");
		$system->watchDog->exception("s", $lang[lotteryEdit], sprintf($lang[successfulDone], $lang[lotteryEdit], $name));
	}

	public function m_lotteryDelEntity($id){
		global $system, $lang;
		
		$name = $system->dbm->db->informer("`$this->entityTable`", $id, "name");
		$system->dbm->db->delete("`$this->entityTable`", "`id` = $id");
		$system->watchDog->exception("s", $lang[lotteryDel], sprintf($lang[successfulDone], $lang[lotteryDel], $name));
	}

	public function m_lotteryActiveEntity(){

	}

	public function m_lotteryListEntity(){
		global $system, $settings;

		$system->xorg->pagination->paginateStart("lottery", "c_entityList", "`base`.`active` as `lActive`, `base`.`id` as `lId`, `base`.`name` as `lName`,`base`.`description` as `lDescription` ,`sellPrice`, `capacity`, `$this->productEntityTable`.`name` as `pName`, `startTime`, `endTime`, `specialOffer`", "`$this->entityTable` as `base`, `$this->productEntityTable`", "`prize` = `$this->productEntityTable`.`id`", "`lId` DESC");

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][count] = $count;
			$entityList[$count][lActive] = $row[lActive];
			$entityList[$count][lId] = $row[lId];
			$entityList[$count][lName] = $row[lName];
			$entityList[$count][lDescription] = $row[lDescription];
			$entityList[$count][price] = $row[sellPrice];
			$entityList[$count][specialOffer] = $row[specialOffer];
			$entityList[$count][capacity] = $row[capacity];
			$entityList[$count][pName] = $row[pName];
			$entityList[$count][startTime] = $system->time->iCal->dator($row[startTime]);
			$entityList[$count][endTime] = $system->time->iCal->dator($row[endTime]);
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/entityList" . $settings[ext4]);
	}

	public function m_lotteryInfoEntity($id){
		global $system;

		$system->dbm->db->select("`base`.`active`, `base`.`id`, `base`.`name` as `lName`,`base`.`description` ,`sellPrice`, `capacity`, `$this->productEntityTable`.`name` as `pName`, `$this->productEntityTable`.`id` as `productId`, `$this->productEntityTable`.`imagePath`, `startTime`, `endTime`", "`$this->entityTable` as `base`, `$this->productEntityTable`", "`prize` = `$this->productEntityTable`.`id` AND `base`.`id` = '$id'");
		$row = $system->dbm->db->fetch_array();
		$imgTmp = explode(",", $row[imagePath]);
		$row[imagePath] = $imgTmp[0];
		return $row;
	}

	public function m_lotteryPrizeList($type){
		global $system, $settings;

		$system->dbm->db->select("`id`, `name`, `description`, `imagePath`", "`$type`", "`active` = 1");

		while($row = $system->dbm->db->fetch_array()){
			$info[$row[id]][id] = $row[id];
			$info[$row[id]][name] = $row[name];
			$imgTmp = explode(",", $row[imagePath]);
			$row[imagePath] = $imgTmp[0];
			$info[$row[id]][imagePath] = $row[imagePath];
		}

		$system->xorg->smarty->assign("prizeList", $info);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/prizeList" . $settings[ext4]);
	}

	public function m_lotteryJoin($lotteryId, $bankCode){
		global $system, $settings, $lang;

		$timeStamp = $system->time->iCal->dator();
		$system->dbm->db->insert("`$this->memberTable`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `tr`, `ur`, `lotteryId`, `uid`, `bankCode`", "0, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, $lotteryId, $_SESSION[uid], '$bankCode'");
		$system->watchDog->exception("s", $lang[lotteryMembership], sprintf($lang[successfulDone], $lang[membershipOfLottery], $system->dbm->db->insert_id()) . $lang[saveTransactionCode]);
	}

	public function m_addToBasket($objectId, $count){
		global $system, $lang;

		if($system->dbm->db->count_records("`$this->shopBasket`", "`objectId` = $objectId AND `uid` = $_SESSION[uid]") == 0){
			$timeStamp = $system->time->iCal->dator();
			$system->dbm->db->insert("`$this->shopBasket`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `objectType`, `objectId`, `uid`, `count`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 'lotteryEntity',$objectId, $_SESSION[uid], $count");
			$system->watchDog->exception("s", $lang[lottery], sprintf($lang[successfulDone], $lang[addLotteryToBasket], $objectName));
		}else{
			if(!empty($count)){
				$system->dbm->db->update("`$this->shopBasket`", "`count` = $count", "`uid` = $_SESSION[uid] AND `objectType` = 'lotteryEntity' AND `objectId` = $objectId");
				$system->watchDog->exception("s", $lang[lottery], sprintf($lang[successfulDone], $lang[updateLotteryToBasket], $objectName));
			}else{
				$system->dbm->db->delete("`$this->shopBasket`", "`uid` = $_SESSION[uid] AND `objectType` = 'lotteryEntity' AND `objectId` = $objectId");
				$system->watchDog->exception("s", $lang[lottery], sprintf($lang[successfulDone], $lang[delLotteryFromBasket], $objectName));
			}
		}

	}

	public function m_memberList($filter=null){
		global $system, $settings;

		$system->xorg->pagination->paginateStart("lottery", "c_memberList", "`base`.`id`, `base`.`active`, `$this->entityTable`.`name` as `lName`, `$this->userTable`.`userName` as `uName`, `base`.`bankCode`, `base`.`winner`", "`$this->memberTable` as `base`, `$this->entityTable`, `$this->userTable`", "`base`.`lotteryId` = `$this->entityTable`.`id` AND `base`.`uid` = `$this->userTable`.`id`", "`base`.`lotteryId` DESC");

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$memberList[$count][count] = $count;
			$memberList[$count][id] = $row[id];
			$memberList[$count][active] = $row[active];
			$memberList[$count][lName] = $row[lName];
			$memberList[$count][uName] = $row[uName];
			$memberList[$count][bankCode] = $row[bankCode];
			$memberList[$count][winner] = $row[winner];
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("memberList", $memberList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/memberList" . $settings[ext4]);
	}

	public function m_setWinner($id){
		global $system, $lang, $c_userMan;

		$timeStamp = $system->time->iCal->dator();
		$system->dbm->db->update("`$this->memberTable`", "`timeStamp` = $timeStamp, `winner` = 1", "`id` = $id");
		$system->dbm->db->select("`uid`", "`$this->memberTable`", "`id` = $id");
		mail($c_userMan->c_userInfo($system->dbm->db->result(1, 0)), "You are winner", "You are winner");
		//		$system->watchDog->exception("s", $lang[setWinner], sprintf($lang[successfulDone], $lang[setWinner], ''));
	}

	public function m_unSetWinner($id){
		global $system, $lang;

		$timeStamp = $system->time->iCal->dator();
		$system->dbm->db->update("`$this->memberTable`", "`timeStamp` = $timeStamp, `winner` = 0", "`id` = $id");
		//		$system->watchDog->exception("s", $lang[unSetWinner], sprintf($lang[successfulDone], $lang[unSetWinner], ''));
	}

	public function m_lotteryWinnerList(){
		global $system, $settings;

		$system->xorg->pagination->paginateStart("lottery", "c_winnerList", "`base`.`id`, `base`.`timeStamp`, `mobile`, `showMobile`, `email`, `showEmail`", "`$this->memberTable` as `base`, `$this->userTable`", "`base`.`uid` = `$this->userTable`.`id` AND `winner` = 1", "`timeStamp` DESC");

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$winnerList[$count][count] = $count;
			$winnerList[$count][id] = $row[id];
			$winnerList[$count][mobile] = ($row[showMobile] == 1 ? $row[mobile] : '&nbsp;');
			$winnerList[$count][email] = ($row[showEmail] == 1 ? $row[email] : '&nbsp;');
			$winnerList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("winnerList", $winnerList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/winnerList" . $settings[ext4]);
	}

	public function m_slide(){
		global $system, $settings, $lang;

		$system->dbm->db->select("`base`.`id`, `base`.`name`, `sellPrice`, `capacity`, `prize`, `startTime`, `endTime`, `base`.`description`, `imagePath`", "`$this->entityTable` as `base`, `$this->productEntityTable`", "`base`.`prize` = `$this->productEntityTable`.`id` AND `specialOffer` = 1", "`base`.`timeStamp` DESC", "", "", "0,1");
		while($row = $system->dbm->db->fetch_array()){

			$info[id] = $row[id];
			$info[name] = $row[name];
			$info[imagePath] = $row[imagePath];
			$imgTmp = explode(",", $info[imagePath]);
			$info[imagePath] = $imgTmp[0];
			$info[price] = $row[sellPrice];
			$info[capacity] = $row[capacity];
			$info[prize] = $row[prize];
			$info[startTime] = $system->time->iCal->dator($row[startTime]);
			$info[endTime] = $system->time->iCal->dator($row[endTime]);
			$info[description] = $row[description];

			$row[memberCount] = @mysql_num_rows(mysql_query("SELECT `id` FROM `$this->memberTable` WHERE `lotteryId` = $row[id]"));
			$row[memberCount] = $row[memberCount] ? $row[memberCount] : 0;
			$info[memberCount] = $row[memberCount];
			$info[stat] = ($row[memberCount] > $row[capacity]) ? $lang[capacityOverflow] : " $lang[capacity]: " . ($row[capacity]-$row[memberCount]) . " $lang[person]";
		}

		$system->xorg->smarty->assign("slideInfo", $info);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/slide" . $settings[ext4]);
	}

	public function m_carousel(){
		global $system, $settings, $lang;

		$system->dbm->db->select("`base`.`id`, `base`.`name`, `sellPrice`, `capacity`, `prize`, `startTime`, `endTime`, `base`.`description`, `imagePath`", "`$this->entityTable` as `base`, `$this->productEntityTable`", "`base`.`prize` = `$this->productEntityTable`.`id` AND `specialOffer` = 0", "`base`.`timeStamp` DESC", "", "", "0,10");

		while($row = $system->dbm->db->fetch_array()){
			$info[$row[id]][id] = $row[id];
			$info[$row[id]][name] = $row[name];
			$imgTmp = explode(",", $row[imagePath]);
			$row[imagePath] = $imgTmp[0];
			$info[$row[id]][imagePath] = $row[imagePath];
			$info[$row[id]][price] = $row[sellPrice];
			$info[$row[id]][capacity] = $row[capacity];
			$info[$row[id]][prize] = $row[prize];
			$info[$row[id]][startTime] = $system->time->iCal->dator($row[startTime]);
			$info[$row[id]][endTime] = $system->time->iCal->dator($row[endTime]);
			$info[$row[id]][description] = $row[description];

			$info[$row[id]][memberCount] = $row[memberCount] = mysql_num_rows(mysql_query("SELECT `id` FROM `$this->memberTable` WHERE `lotteryId` = $row[id]"));
			$info[$row[id]][stat] = ($row[memberCount] > $row[capacity]) ? $lang[capacityOverflow] : " $lang[modCapacity]: " . ($row[capacity]-$row[memberCount]) . " $lang[person]";
		}

		$system->xorg->smarty->assign("carouselList", $info);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/carousel" . $settings[ext4]);
	}
}
?>