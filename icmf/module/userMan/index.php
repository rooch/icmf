<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	case "v_userMan":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/userMan" . $settings['ext4']);
		break;
	case "c_userDel":
		$c_userMan->c_userDel($_GET[filter]);
		break;
	case "v_signUp":
		$viewMode = (!empty($_POST[viewMode]) ? $_POST[viewMode] : "signUp");
		$system->dbm->db->select("*", "`faqObject`", "", "rand()", "", "", "0,1");
		$system->xorg->smarty->assign("securityQuestion", $row = $system->dbm->db->fetch_array());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/$viewMode" . $settings['ext4']);
		break;
	case "c_signUp":
		$c_userMan->c_signUp($_POST);
		break;
	case "v_userAdd":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/userAdd" . $settings['ext4']);
		break;
	case "c_userAdd":
		$c_userMan->c_userAdd($_POST[userName], $_POST[password], $_POST[rePassword]);
		break;
	case "c_userList":
		$c_userMan->c_userList($_GET[filter]);
		break;
	case "c_loginContent":
		$c_userMan->c_loginContent();
		break;
	case "c_login":
		$c_userMan->c_login($_POST[userName], $_POST[password]);
		break;
	case "c_logout":
		$c_userMan->c_logout();
		break;
	case "v_menu":
		$c_userMan->c_menu();
		break;
	case "v_profile":
		$c_userMan->c_userList($_GET[filter]);
		break;
	case "c_edit":
		$c_userMan->c_edit($_POST);
		break;
	case "c_home":
		$c_userMan->c_userList($_GET[filter], 'home');
		break;
	case "c_setSettings":
		$name = $system->utility->filter->queryString('name');
		$value = $system->utility->filter->queryString('value');
		$c_userMan->c_setSettings($name, $value);
		break;
	case "v_changePass":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/changePass" . $settings['ext4']);
		break;
	case "c_changePass":
		if($_POST[userName] && $_POST[resetPass] && $_POST[newPassword]){
			$c_userMan->c_resetPass($_POST[userName], $_POST[resetPass], $_POST[newPassword]);
		}elseif($_POST[userName] && empty($_POST[code]) && empty($_POST[newPassword])){
			$c_userMan->c_remember($_POST[userName]);
		}
		break;
	case "v_personalPage":
		$system->xorg->smarty->assign("pageSource", $system->dbm->db->informer("`$settings[userExtraInfo]`", "`uid` = $_SESSION[uid]", "pageSource"));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/personalPage" . $settings['ext4']);
		break;
	case "c_personalPage":
		$c_userMan->c_personalPage($_POST);
		break;
	case "v_emailActivation":
		$system->xorg->smarty->assign("email", $system->dbm->db->informer("`user`", "`id` = $_SESSION[uid]", "email"));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/emailActivation" . $settings['ext4']);
		break;
	case "v_mobileActivation":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/mobileActivation" . $settings['ext4']);
		break;
	case "c_emActivation":
		if($_POST['userName'] && empty($_POST['verificationCode']) || $POST[mobile] && empty($_POST['verificationCode'])){
			$c_userMan->c_remember($_POST['userName']);
			
		}elseif($_POST['userName'] && !empty($_POST['verificationCode']) || $_POST['mobile'] && !empty($_POST['verificationCode'])){
			$c_userMan->c_emActivation($_POST);
			
		}elseif($_POST['setUserName']){
			$c_userMan->c_emActivation($_POST);
		}
		break;
	case "v_userNameActivation":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/userNameActivation" . $settings['ext4']);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings['ext4']);
		break;
}

?>