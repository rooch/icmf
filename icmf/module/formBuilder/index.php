<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	// Add data
	case "c_addData":
		$c_formBuilder->c_addData($_POST);
		break;
	// List forms
	case "c_list":
		$c_formBuilder->c_list($_POST[filter]);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>