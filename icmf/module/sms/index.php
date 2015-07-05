<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
		###########################
		# Object (SMS)            #
		###########################
	case "v_object":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings[ext4]);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("to", $_POST['to']);
		$system->xorg->prompt->promptShow('p', $land['send'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4]));
		break;
	case "c_addObject":
		$c_sms->c_addObject($_POST[to], $_POST[message], $_POST[category]);
		break;
		// Edit Object
	case "c_editObject":

		break;
		// Del Object
	case "c_delObject":
		$c_article->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_sms->c_listObject('list', $_POST[filter]);
		break;
		// Show List Object
	case "c_showListObject":
		$c_sms->c_listObject('showList', $_POST[filter]);
		break;
		// Show Object
	case "c_showObject":
		$c_sms->c_showObject($_POST[id]);
		break;
		// Activate Object
	case "c_activateObject":
		$c_article->c_activateObject($_POST[id]);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$c_article->c_deactivateObject($_POST[id]);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>