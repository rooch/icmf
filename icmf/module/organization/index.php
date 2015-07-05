<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
		###########################
		# Object (Organization)   #
		###########################
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("countries", $system->xorg->combo(array('id', 'name'), $settings[countries]));
		$system->xorg->smarty->assign("state", $system->xorg->combo(array('id', 'name'), $settings[state]));
		$system->xorg->smarty->assign("city", $system->xorg->combo(array('id', 'name'), $settings[city]));
		
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4] );
		break;
	case "c_addObject":
		$c_organization->c_addObject($_POST);
		break;
		// Edit Object
	case "v_editObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[postCategory], '', $entity[category]));
		$system->xorg->prompt->promptShow('p', $lang[postEdit], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings[ext4]));
		break;
	case "c_editObject":
		$c_organization->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteObject], $entity[title]));
		$system->xorg->prompt->promptShow('p', $lang[delObject], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings[ext4]));
		break;
	case "c_delObject":
		$c_organization->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_organization->c_listObject('list', $_GET[filter]);
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	case "c_feedObject":
		$c_organization->c_feedObject("http://brand.persianblog.ir/rss.xml", 9);
		break;
	case "c_showListObject":
//		$_GET[filter] = ",`timeStamp` < $time";
		$c_organization->c_listObject('showListObject', $_GET[filter]);
		break;
	case "c_showObject":
		$id = $system->utility->filter->queryString('id');
		$a = $system->dbm->db->informer("`$settings[postObject]`", "`id` = $id");
		$system->xorg->smarty->assign("item", $system->dbm->db->informer("`$settings[postObject]`", "`id` = $id"));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/show" . $settings[ext4]);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;

}

?>