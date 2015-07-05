<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (contact)        #
	###########################
	case "v_object":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_credit->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		
		break;
	case "c_addObject":
		$c_credit->c_addObject($_POST);
		break;
		// Edit Object
	case "v_editObject":
		
		break;
	case "c_editObject":
		$c_credit->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		
		break;
	case "c_delObject":
		$c_credit->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_credit->c_listObject('list', $_GET['filter'], $system->utility->filter->queryString('sort'));
		break;
		// Activate Object
	case "c_activateObject":
		$c_credit->c_activateObject($_POST['id']);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$c_credit->c_deactivateObject($_POST['id']);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings['ext4']);
		break;

}

?>