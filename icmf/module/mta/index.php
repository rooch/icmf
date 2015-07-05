<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (MTA)            #
	###########################
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("receiverMail", $_POST['receiverMail']);
		$system->xorg->smarty->assign("firstName", $_POST['firstName']);
		$system->xorg->smarty->assign("lastName", $_POST['lastName']);
		$system->xorg->prompt->promptShow('p', $lang['send'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4]));
		break;
	case "c_addObject":
		$c_mta->c_addObject($_POST['from'], $_POST['subject'], $_POST['message'], $_POST['receiverMail'], $_POST['receiverFirstName'], $_POST['receiverLastName']);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>