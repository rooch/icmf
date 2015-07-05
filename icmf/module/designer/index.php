<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	case "v_add":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/fileAdd" . $settings[ext4]);
		break;
	case "c_add":
		$file = fopen($settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress] . "/customise/" . $_POST[title] . $settings[ext4], "w+");
		fwrite($file, stripcslashes($_POST[description]));
		fclose($file);
		$system->watchDog->exception("s", $lang[add], sprintf($lang[successfulDone], $lang[add], $_POST[title]));
		break;
	case "c_list":
		$system->xorg->smarty->assign("fileAdd", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/fileAdd" . $settings[ext4]));
		$c_designer->c_list($_POST[filter]);
		break;
	case "v_edit":
		$dir = $system->utility->filter->queryString('dir');
		$file = $system->utility->filter->queryString('file');
		$system->xorg->smarty->assign("dir", $dir);
		$system->xorg->smarty->assign("file", $file);
		$system->xorg->smarty->assign("fileContent", file_get_contents($settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress] . "/" . $dir . "/" . $file . $settings[ext4]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/fileEdit" . $settings[ext4]);
		break;
	case "c_edit":
		!copy($settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress] . "/" . $_POST[dir] . "/" . $_POST[file] . $settings[ext4], $settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress] . "/" . $_POST[dir] . "/" . $_POST[file] . 'backup' . $settings[ext4]);
		$file = fopen($settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress] . "/" . $_POST[dir] . "/" . $_POST[file] . $settings[ext4], "w+");
		fwrite($file, stripslashes($_POST[description]));
		fclose($file);
		$system->watchDog->exception("s", $lang[edit], sprintf($lang[successfulDone], $lang[edit], $_POST[file]));
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>