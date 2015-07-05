<?php
class m_eDelivery extends masterModule{

	function m_eDelivery(){
	
	}

	// Add District
	public function m_addDistrict($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$settings[district]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `city`, `region`, `name`, `zipcode`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[city], $values[region], '$values[district]', '$values[zipcode]'");
		$system->watchDog->exception("s", $lang['eDelivery'], sprintf($lang['successfulDone'], $lang['addRegion'], $values['district']));
	}
	// Add Distance
	public function m_addDistance($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$settings[distance]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `city1`, `region1`, `district1`, `city2`, `region2`, `district2`, `distance`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $values[city1], '$values[region1]', '$values[district1]', $values[city2], '$values[region2]', '$values[district2]', $values[distance]");
		$system->watchDog->exception("s", $lang['eDelivery'], sprintf($lang['successfulDone'], $lang['addDistance'], $system->dbm->db->informer($settings['city'], "`id` = $values[city1]", "name") . '-' . $system->dbm->db->informer($settings['district'], "`id` = $values[district1]", "name") . '<->' . $system->dbm->db->informer($settings['city'], "`id` = $values[city2]", "name") . '-' . $system->dbm->db->informer($settings['district'], "`id` = $values[district2]", "name")));
	}
	// Add Object
	public function m_addObject($objectId, $count=null, $values=null){
		global $settings, $lang, $system;
		
		$timeStamp = time();
		$row = mysql_fetch_array(mysql_query("SELECT count(*) as `count` FROM `$settings[eDeliveryObject]` WHERE `uid` = $_SESSION[uid] AND `objectId` = $objectId"));
		if($row['count'] == 0){
			$userInfo = mysql_fetch_array(mysql_query("SELECT * FROM `user` WHERE `id` = $_SESSION[uid]"));
			print_r($userInfo);
			$yearNumber = $system->time->iCal->dator($timeStamp, 'y');
			$monthNumber = $system->time->iCal->dator($timeStamp, 'm');
			$dayNumber = $system->time->iCal->dator($timeStamp, 'd') + 1;
			$system->dbm->db->insert("`$settings[eDeliveryObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `count`, `uid`, `objectId`, `receiver`, `mobile`, `state`, `city`, `region`, `district`, `address`, `zipcode`, `year`, `month`, `day`, `startHour`, `startMinute`, `endHour`, `endMinute`, `eDeliveryType`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, '$count', '$_SESSION[uid]', '$objectId', '$userInfo[firstName] $userInfo[lastName]', '$userInfo[mobile]', '$userInfo[state]', '$userInfo[issued]', '$userInfo[region]', '$userInfo[district]', '$userInfo[address]', '$userInfo[zipcode]', '$yearNumber', '$monthNumber', '$dayNumber', 10, 0, 11, 0, 4");
		}else{
//			$system->dbm->db->update("`$settings[eDeliveryObject]`", "`timeStamp`=$timeStamp, `receiver`='$values[receiver]', `mobile`='$values[mobile]', `state`='$values[state]', `city`='$values[city]', `region`='$values[region]', `district`='$values[district]', `address`='$values[address]', `zipcode`='$values[zipcode]', `year`='$values[year]', `month`='$values[month]', `day`='$values[day]', `startHour`='$values[startHour]', `startMinute`='$values[startMinute]', `endHour`='$values[endHour]', `endMinute`='$values[endMinute]', `eDeliveryType`='$values[eDeliveryType]'", "`uid` = $_SESSION[uid] AND `objectId` = '$objectId'");
//			$system->watchDog->exception("s", $lang['eDelivery'], sprintf($lang['successfulDone'], $lang['updateEDelivery'], $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId", "name")));
		}
	}
	
	// Invoice Object
	public function m_invoiceObject($filter=null){
		global $settings, $lang, $system;
		
		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->dbm->db->select("`id`, `active`, `city`, `region`, `district`, `eDeliveryType`", "`$settings[eDeliveryObject]`", "`uid` = $_SESSION[uid] $filter", "", "`state`, `city`, `region`, `district`");
		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row['active'];
			$entityList[$count][id] = $row['id'];
			
//			echo "SELECT `distance` FROM `$settings[distance]` WHERE (`city1` = '$row[city]' AND `region1` = '$row[region]' AND `district1` = '$row[district]') OR (`city2` = '$row[city]' AND `region2` = '$row[region]' AND `district2` = '$row[district]') ORDER BY `distance` ASC LIMIT 0,1";
			$fetch = mysql_fetch_array(mysql_query("SELECT `distance` FROM `$settings[distance]` WHERE (`city1` = '$row[city]' AND `region1` = '$row[region]' AND `district1` = '$row[district]') OR (`city2` = '$row[city]' AND `region2` = '$row[region]' AND `district2` = '$row[district]') ORDER BY `distance` ASC LIMIT 0,1"), MYSQL_ASSOC);
			$distance = $fetch['distance'];
			$entityList[$count][distance] = $distance; 			
			$eDeliveryType = $system->dbm->db->informer("$settings[eDeliveryType]", "`id` = $row[eDeliveryType]");
			$entityList[$count][eDeliveryType] = $eDeliveryType['name'];
			$entityList[$count][price] = $distance * $eDeliveryType['ratio'];
			
			$count++;
		}
//		print_r($entityList);
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/eDelivery/view/tpl/object/invoiceList" . $settings[ext4]);
		
	}
	// Total price
	public function m_totalPrice(){
		global $system, $settings;
		
//		$system->dbm->db->select("`id`, `active`, `city`, `region`, `district`, `eDeliveryType`", "`$settings[eDeliveryObject]`", "`uid` = $_SESSION[uid] $filter", "", "`state`, `city`, `region`, `district`");
		$result = mysql_query("SELECT `id`, `active`, `city`, `region`, `district`, `eDeliveryType` FROM `$settings[eDeliveryObject]` WHERE `uid` = $_SESSION[uid] $filter GROUP BY `state`, `city`, `region`, `district`");
		
		while ($row = mysql_fetch_array($result)){
			$fetch = mysql_fetch_array(mysql_query("SELECT `distance` FROM `$settings[distance]` WHERE (`city1` = '$row[city]' AND `region1` = '$row[region]' AND `district1` = '$row[district]') OR (`city2` = '$row[city]' AND `region2` = '$row[region]' AND `district2` = '$row[district]') ORDER BY `distance` ASC LIMIT 0,1"), MYSQL_ASSOC);
			$distance = $fetch['distance'];
			$entityList[$count][distance] = $distance; 			
			$eDeliveryType = $system->dbm->db->informer("$settings[eDeliveryType]", "`id` = $row[eDeliveryType]");
			$caculate += $distance * $eDeliveryType['ratio'];
		}
		return $caculate;
	}
	
}
?>