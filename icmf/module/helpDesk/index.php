<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	// Add helpDesk
	case "v_add":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/add" . $settings[ext4]);
		break;
	case "c_add":
		$c_helpDesk->c_add($_POST[title], $_POST[priority], $_POST[description]);
		break;
	// Edit helpDesk
	case "c_edit":
		
		break;
	// Del helpDesk
	case "c_del":
		$c_helpDesk->c_del($_POST[id]);
		break;
	// List helpDesk
	case "c_list":
		$c_helpDesk->c_list($_POST[filter]);
		break;
	case "c_show":
		$c_helpDesk->c_show($_POST[id]);
		break;
	// Activate helpDesk
	case "c_activate":
		$c_helpDesk->c_activate($_POST[id]);
		break;
	// Deactive helpDesk
	case "c_deactivate":
		$c_helpDesk->c_deactivate($_POST[id]);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;	
}

?>