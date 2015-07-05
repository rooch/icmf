<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	// Add Destrict
	case "v_addDistrict":
		$system->xorg->smarty->assign('state', $system->xorg->htmlElements->selectElement->select('state1', $system->dbm->db->lookup("`$settings[state]`")));
		$system->xorg->smarty->assign('region', $system->xorg->htmlElements->selectElement->select('region', $system->dbm->db->lookup("`$settings[region]`")));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/addDistrict" . $settings['ext4']);
		break;
	case "c_addDistrict":
		$c_eDelivery->c_addDistrict($_POST);
		break;
		// Add Distance
	case "v_addDistance":
		$system->xorg->smarty->assign('state1', $system->xorg->htmlElements->selectElement->select('state1', $system->dbm->db->lookup("`$settings[state]`")));
		$system->xorg->smarty->assign('region1', $system->xorg->htmlElements->selectElement->select('region1', $system->dbm->db->lookup("`$settings[region]`")));
		$system->xorg->smarty->assign('state2', $system->xorg->htmlElements->selectElement->select('state2', $system->dbm->db->lookup("`$settings[state]`")));
		$system->xorg->smarty->assign('region2', $system->xorg->htmlElements->selectElement->select('region2', $system->dbm->db->lookup("`$settings[region]`")));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/addDistance" . $settings['ext4']);
		break;
	case "c_addDistance":
		$c_eDelivery->c_addDistance($_POST);
		break;
	case "c_addObject":
		$c_eDelivery->c_addObject($_POST['objectId'], $_POST[count], $_POST);
		break;
	case "c_invoiceObject":
		$c_eDelivery->c_invoiceObject($_POST['filter']);
		break;
	default:
		$system->xorg->smarty->display($settings['commonTpl'] . "404" . $settings['ext4']);
		break;
}

?>