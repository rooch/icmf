<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category                #
	###########################
	case "v_category":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['directoryCategory'], 0, 'directoryCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']));
		$system->xorg->smarty->assign("list", $c_directory->c_listCategory());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings['ext4']);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['directoryCategory'], 0, 'directoryCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']);
		break;
	case "c_addCategory":
		$c_directory->c_addCategory($_POST[name], $_POST[category], $_POST[description]);
		break;
		// Edit Category
	case "v_editCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[directoryCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[directoryCategory], '', $entity[category]));
		$system->xorg->prompt->promptShow('p', $lang[editCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/edit" . $settings['ext4']));
		break;
	case "c_editCategory":
		$c_directory->c_editCategory($_POST[id], $_POST[name], $_POST[category], $_POST[description]);
		break;
		// Del Category
	case "v_delCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[directoryCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteCategory], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/del" . $settings['ext4']));
		break;
	case "c_delCategory":
		$c_directory->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$c_directory->c_listCategory();
		break;
		// Activate Category
	case "c_activateCategory":

		break;
		// Deactive Category
	case "c_deactivateCategory":

		break;
		###########################
		# Object (directory)           #
		###########################
	case "v_object":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['directoryCategory'], 0, 'directoryCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_directory->c_listObject());
		$system->xorg->prompt->promptShow('p', $lang[directoryEdit], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']));
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['directoryCategory'], 0, 'directoryCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] );
		break;
	case "c_addObject":
		$c_directory->c_addObject($_POST, true);
		break;
		// Edit Object
	case "v_editObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[directoryObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['directoryCategory'], 0, 'directoryCategory', 'mcdropdown_menu'));
		$system->xorg->prompt->promptShow('p', $lang[directoryEdit], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings['ext4']));
		break;
	case "c_editObject":
		$c_directory->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[directoryObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang['doYouWantDeleteObject'], $entity['title']));
		$system->xorg->prompt->promptShow('p', $lang['delObject'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_directory->c_delObject($_POST['id']);
		break;
		// List Object
	case "c_listObject":
		$c_directory->c_listObject('list', $_GET['filter']);
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	case "c_showListObject":
		if($settings['colNumber'] == 1)
		$c_directory->c_listObject('showListObjectSingleCol', $_GET['filter']);
		elseif($settings['colNumber'] == 2)
		$c_directory->c_listObject('showListObject', $_GET['filter']);
		break;
	case "c_rssFeed":
		$c_directory->c_rssFeed($_GET['filter']);
		break;
	default:
		$system->xorg->smarty->display($settings['commonTpl'] . "404" . $settings['ext4']);
		break;

}

?>