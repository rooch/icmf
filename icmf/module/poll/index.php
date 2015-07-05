<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (Poll)           #
	###########################
	// Object
	case "v_object":
		
		break;
	// Add Object
	case "v_addObject":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4]);
		break;
	case "c_addObject":
		$c_poll->c_add($_POST);
		break;
		// Edit Object
	case "c_editObject":

		break;
		// Del Object
	case "c_delObject":

		break;
		// List Object
	case "c_listObject":
		$c_poll->c_list($_POST[filter]);
		break;
		// Activate Poll
	case "c_activateObject":
		$id = $system->utility->filter->queryString('id');
		$c_poll->c_activate($id);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$id = $system->utility->filter->queryString('id');
		$c_poll->c_deactivate($id);
		break;
		// Show Active Object
	case "c_showActiveObject":
		$c_poll->c_showActive();
		break;
		// Submit Poll
	case "c_submitObject":
		$c_poll->c_submit($_POST[pollId], $_POST[answerId]);
		break;
		// Result Object
	case "c_resultObject":
		$id = $system->utility->filter->queryString('id');
		$c_poll->c_result($id);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>