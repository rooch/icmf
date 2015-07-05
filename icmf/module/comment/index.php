<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (comment)        #
	###########################
	case "v_object":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_comment->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] );
		break;
	case "c_addObject":
		$c_comment->c_addObject($_POST, true);
		break;
		// Edit Object
	case "v_editObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[commentObject]`", "`id` = '$id'"));
		$system->xorg->prompt->promptShow('p', $lang[commentEdit], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings['ext4']));
		break;
	case "c_editObject":
		$c_comment->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[commentObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang['doYouWantDeleteObject'], $entity['text']));
		$system->xorg->prompt->promptShow('p', $lang['delObject'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_comment->c_delObject($_POST['id']);
		break;
		// List Object
	case "c_listObject":
		$c_comment->c_listObject('list', $sysVar['filter']);
		break;
		// Show List Object
	case "c_showListObject":
		$c_comment->c_listObject('showListObject', $sysVar['filter']);
		break;
	case "c_showListObjectSimple":
		$c_comment->c_listObject('showListObjectSimple', $sysVar['filter']);
		break;
		// Activate Object
	case "c_activateObject":
		$c_comment->c_activateObject($_POST['id']);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$c_comment->c_deactivateObject($_POST['id']);
		break;
	case "c_showListObject":
		$c_comment->c_listObject('showListObject', $sysVar['filter']);
		break;
	default:
		$system->xorg->smarty->display($settings['commonTpl'] . "404" . $settings['ext4']);
		break;

}

?>