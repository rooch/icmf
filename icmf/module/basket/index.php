<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (Basket)         #
	###########################
	case "v_object":
		$userInfo = $system->dbm->db->informer("`user`", "`id` = $_SESSION[uid]");
		
//		$userInfo['stateId'] = $userInfo['state'];
//		$userInfo['cityId'] = $userInfo['city'];
//		$userInfo['regionId'] = $userInfo['region'];
//		$userInfo['districtId'] = $userInfo['district'];
//		
//		$userInfo['state'] = $system->dbm->db->informer("`$settings[state]`", "`id` = '$userInfo[state]'", "name");
//		$userInfo['city'] = $system->dbm->db->informer("`$settings[city]`", "`id` = '$userInfo[city]'", "name");
//		$userInfo['region'] = $system->dbm->db->informer("`$settings[region]`", "`id` = '$userInfo[region]'", "name");
//		$userInfo['district'] = $system->dbm->db->informer("`$settings[district]`", "`id` = '$userInfo[district]'", "name");
//		
//		if($userInfo['state'] || $userInfo['city'] || $userInfo['region'] || $userInfo['district'] || $userInfo['address']){
//			$system->xorg->prompt->promptShow('p', $lang[delObject], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
//		}

		$system->xorg->smarty->assign('userInfo', $userInfo);
		$system->xorg->smarty->assign('state', $system->xorg->htmlElements->selectElement->select('state', $system->dbm->db->lookup("`$settings[state]`"), $userInfo['state']));
		$system->xorg->smarty->assign('city', $system->xorg->htmlElements->selectElement->select('city', $system->dbm->db->lookup("`$settings[city]`", "`sid` = $userInfo[state]"), $userInfo['issued']));
		$system->xorg->smarty->assign('region', $system->xorg->htmlElements->selectElement->select('region', $system->dbm->db->lookup("`$settings[region]`"), $userInfo['region']));
		$system->xorg->smarty->assign('district', $system->xorg->htmlElements->selectElement->select('district', $system->dbm->db->lookup("`$settings[district]`"), $userInfo['district']));
		$system->xorg->smarty->assign('eDeliveryType', $system->xorg->htmlElements->selectElement->select('eDeliveryType', $system->dbm->db->lookup("`$settings[eDeliveryType]`"), 1));
		$system->xorg->smarty->assign('yearNumber', $system->time->iCal->dator(time(), 'y'));
		$system->xorg->smarty->assign('monthNumber', $system->time->iCal->dator(time(), 'm'));
		$system->xorg->smarty->assign('dayNumber', $system->time->iCal->dator(time(), 'd'));
		$system->xorg->smarty->assign("list", $c_basket->c_listObject($_GET[filter]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		$objectId = $system->utility->filter->queryString('objectId');
		$system->xorg->smarty->assign("objectId", $objectId);
		$system->xorg->smarty->assign("objectInfo", $objectInfo = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $objectId"));
		$system->xorg->smarty->assign("objectImage", $system->dbm->db->informer("`$settings[galleryObject]`", "`category` = $objectInfo[imageGallery]", "url"));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4']);
		break;
	case "c_addObject":
		$c_basket->c_addObject($_POST[objectId], $_POST[count]);
		break;
		// Edit Object
		//	case "v_editObject":
		//
		//		break;
		//	case "c_editObject":
		//
		//		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[basketObject]`", "`id` = $id"));
		$name = $system->dbm->db->informer("`$settings[productObject]`", "`id` = '$entity[objectId]'", "name");
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteObject], $name));
		$system->xorg->prompt->promptShow('p', $lang[delObject], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_basket->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_basket->c_listObject($_GET[filter]);
		break;
		// Calculate basket price
	case "c_calculate":
		$c_basket->c_calculate();
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings['ext4']);
		break;
}

?>