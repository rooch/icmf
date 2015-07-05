<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	case "v_load":
		if(empty($_GET[filter])){
			require_once "module/post/config/config.php";
			require_once "module/post/model/post.php";
			$system->xorg->smarty->assign("post", m_post::m_listObject('list'));
			$system->xorg->smarty->display($settings[customiseTpl] . 'center' . $settings[ext4]);
		}else{
			if(file_exists($settings[customiseTpl] . $_GET[filter] . $settings[ext4])){
				require_once "module/post/config/config.php";
				require_once "module/post/model/post.php";
				$system->xorg->smarty->assign("post", m_post::m_listObject('list'));
				$system->xorg->smarty->assign("titlePost", m_post::m_listObject('titleList'));
				$system->xorg->smarty->display($settings[customiseTpl] . $_GET[filter] . $settings[ext4]);
			}else{
				$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
			}
		}
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>