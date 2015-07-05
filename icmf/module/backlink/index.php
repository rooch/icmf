<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category (customer)     #
	###########################
	case "v_category":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']));
		$system->xorg->smarty->assign("list", $c_backlink->c_listCategory());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings['ext4']);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']);
		break;
	case "c_addCategory":
		$c_backlink->c_addCategory($_POST[name], $_POST[category], $_POST[description]);
		break;
		// Edit Category
	case "v_editCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[backlinkCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[backlinkCategory], '', $entity[category]));
		$system->xorg->prompt->promptShow('p', $lang['editCategory'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/edit" . $settings['ext4']));
		break;
	case "c_editCategory":
		$c_backlink->c_editCategory($_POST['id'], $_POST['name'], $_POST['category'], $_POST['description']);
		break;
		// Del Category
	case "v_delCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[backlinkCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteCategory], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/del" . $settings['ext4']));
		break;
	case "c_delCategory":
		$c_backlink->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$c_backlink->c_listCategory();
		break;
		// Activate Category
	case "c_activateCategory":

		break;
		// Deactive Category
	case "c_deactivateCategory":

		break;
	###########################
	# Object (backlink)       #
	###########################
	case "v_object":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_backlink->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] );
		break;
	case "c_addObject":
		$c_backlink->c_addObject($_POST);
		break;
		// Edit Object
	case "v_editObject":
		$system->xorg->smarty->assign("comments", m_comment::m_listObject('showListObjectSimple', "op=backlink,opid=$taskInfo[id]"));

		$system->xorg->smarty->assign("history", $c_backlink->c_logReader($taskInfo['id']));

		$system->xorg->prompt->promptShow('p', $lang['edit'], $system->xorg->smarty->fetch("$settings[moduleAddress]/backlink/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings['ext4']));
		break;
	case "c_editObject":
		$c_backlink->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[task]`", "`id` = '$_POST[id]'"));
		$system->xorg->smarty->assign("text", sprintf($lang['doYouWantDeleteObject'], $entity['subject']));
		$system->xorg->prompt->promptShow('p', $lang[delObject], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_backlink->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_backlink->c_listObject('list', $_GET['filter'], $system->utility->filter->queryString('sort'));
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings['ext4']);
		break;

}

?>