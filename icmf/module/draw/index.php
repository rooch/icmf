<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category                #
	###########################
	case "v_category":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings[ext4]);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[drawCategory]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings[ext4]);
		break;
	case "c_addCategory":
		$c_draw->c_addCategory($_POST[name], $_POST[category]);
		break;
		// Edit Category
	case "c_editCategory":

		break;
		// Del Category
	case "c_delCategory":
		$c_article->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[drawCategory]));
		$c_draw->c_listCategory($_POST[filter]);
		break;
		// Activate Category
	case "c_activateCategory":
		$c_article->c_activateCategory($_POST[id]);
		break;
		// Deactive Category
	case "c_deactivateCategory":
		$c_article->c_deactivateCategory($_POST[id]);
		break;

		###########################
		# Object (Draw)           #
		###########################
	case "v_object":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings[ext4]);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[drawCategory]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4]);
		break;
	case "c_addObject":
		$c_draw->c_addObject($_POST[name], $_POST[category], $_POST[description]);
		break;
		// Edit Object
	case "c_editObject":

		break;
		// Del Object
	case "c_delObject":
		$c_draw->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_draw->c_listObject('list', $_POST[filter]);
		break;
		// Show List Object
	case "c_showListObject":
		$c_draw->c_listObject('showList', $_POST[filter]);
		break;
		// Show Object Random
	case "c_showObjectRandom":
		$c_draw->c_showObjectRandom();
		break;
		// Activate Object
	case "c_activateObject":
		$c_draw->c_activateObject($_POST[id]);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$c_draw->c_deactivateObject($_POST[id]);
		break;

		###########################
		# Object Details          #
		###########################
	case "c_listWinner":
		$c_draw->c_listDetails('listWinner', 'win=1');
		break;
	case "c_stat":
		$c_draw->c_stat();
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>