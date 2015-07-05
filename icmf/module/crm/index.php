<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Object (contact)        #
	###########################
	case "v_object":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_crm->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		if($_SESSION['uid'] != 2 && $_SESSION['gid'] != 2 && $_SESSION['gid'] != 3){
			$system->xorg->smarty->assign("clientInfo", $clientInfo = $system->dbm->db->informer("`user`", "`id` = $_SESSION[uid]"));
			$system->xorg->smarty->assign("mobile", $clientInfo['mobile']);
			$system->xorg->smarty->assign("email", $clientInfo['email']);
		}

		$system->xorg->smarty->assign("deadlineYear", $system->time->iCal->dator($clientInfo['birthday'], 'y'));
		$system->xorg->smarty->assign("deadlineMonth", $system->time->iCal->dator($clientInfo['birthday'], 'm'));
		$system->xorg->smarty->assign("deadlineDay", $system->time->iCal->dator($clientInfo['birthday'], 'd'));
		$system->xorg->smarty->assign("deadlineHour", date("H", $clientInfo['birthday']));
		$system->xorg->smarty->assign("deadlineMinute", date("i", $clientInfo['birthday']));
		
		$system->xorg->smarty->assign("gender", $system->xorg->htmlElements->selectElement->select('gender', $system->dbm->db->lookup('gender'), $clientInfo['gender']));
		$system->xorg->smarty->assign("state", $system->xorg->htmlElements->selectElement->select('state', $system->dbm->db->lookup('state'), $clientInfo['state']));
		$system->xorg->smarty->assign("eduBranch", $system->xorg->htmlElements->selectElement->select('eduBranch', $system->dbm->db->lookup('eduBranch'), $clientInfo['eduBranch']));
		$system->xorg->smarty->assign("eduLevel", $system->xorg->htmlElements->selectElement->select('level', $system->dbm->db->lookup('level'), $clientInfo['level']));
		$system->xorg->smarty->assign("company", $system->xorg->htmlElements->selectElement->select('company', $system->dbm->db->lookup('company'), $clientInfo['company']));
		$system->xorg->smarty->assign("jobTitle", $system->xorg->htmlElements->selectElement->select('jobTitle', $system->dbm->db->lookup('jobTitle'), $clientInfo['jobTitle']));
		$system->xorg->smarty->assign("position", $system->xorg->htmlElements->selectElement->select('position', $system->dbm->db->lookup('position'), $clientInfo['position']));

		$system->xorg->smarty->assign("priority", $system->xorg->htmlElements->selectElement->select('priority', range(0, 10)));
		$system->xorg->smarty->assign("status", $system->xorg->htmlElements->selectElement->select('status', $system->dbm->db->lookup('status', '`id` > 6')));
		$system->xorg->smarty->assign("department", $system->xorg->htmlElements->selectElement->select('department', $system->dbm->db->lookup('groupManObject')));
		$system->xorg->smarty->assign("agent", $system->xorg->combo(array('id', 'firstName', 'lastName'), "user", "((`firstName` <> '' AND `lastName` <> '') OR (`email` <> '')) AND `gid` <> 2 AND `gid` <> 3"));
		$system->xorg->smarty->assign("progress", $system->xorg->htmlElements->selectElement->select('progress', range(0, 100)));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] );
		break;
	case "c_addObject":
		$c_crm->c_addObject($_POST);
		break;
		// Edit Object
	case "v_editObject":
		$system->xorg->smarty->assign("clientInfo", $clientInfo = $system->dbm->db->informer("`$settings[contactBook]`", "`id` = '$_POST[clientId]'"));
		$system->xorg->smarty->assign("gender", $system->xorg->htmlElements->selectElement->select('gender', $system->dbm->db->lookup('gender'), $clientInfo['gender']));
		$system->xorg->smarty->assign("state", $system->xorg->htmlElements->selectElement->select('state', $system->dbm->db->lookup('state'), $clientInfo['state']));
		$system->xorg->smarty->assign("eduBranch", $system->xorg->htmlElements->selectElement->select('eduBranch', $system->dbm->db->lookup('eduBranch'), $clientInfo['eduBranch']));
		$system->xorg->smarty->assign("eduLevel", $system->xorg->htmlElements->selectElement->select('level', $system->dbm->db->lookup('level'), $clientInfo['level']));
		$system->xorg->smarty->assign("company", $system->xorg->htmlElements->selectElement->select('company', $system->dbm->db->lookup('company'), $clientInfo['company']));
		$system->xorg->smarty->assign("jobTitle", $system->xorg->htmlElements->selectElement->select('jobTitle', $system->dbm->db->lookup('jobTitle'), $clientInfo['jobTitle']));
		$system->xorg->smarty->assign("position", $system->xorg->htmlElements->selectElement->select('position', $system->dbm->db->lookup('position'), $clientInfo['position']));

		$system->xorg->smarty->assign("taskInfo", $taskInfo = $system->dbm->db->informer("`$settings[task]`", "`id` = '$_POST[taskId]'"));
		$system->xorg->smarty->assign("priority", $system->xorg->htmlElements->selectElement->select('priority', range(0, 10), $taskInfo['priority']));
		$system->xorg->smarty->assign("status", $system->xorg->htmlElements->selectElement->select('status', $system->dbm->db->lookup('status', '`id` > 6'), $taskInfo['status']));
		$system->xorg->smarty->assign("department", $system->xorg->htmlElements->selectElement->select('department', $system->dbm->db->lookup('groupManObject'), $taskInfo['department']));
		$system->xorg->smarty->assign("agent", $system->xorg->combo(array('id', 'id', 'firstName', 'lastName', 'email'), "user", "((`firstName` <> '' AND `lastName`) OR (`email` <> '')) AND `gid` <> 2 AND `gid` <> 3", $taskInfo['agent']));
		$system->xorg->smarty->assign("deadlineYear", $system->time->iCal->dator($taskInfo['deadline'], 'y'));
		$system->xorg->smarty->assign("deadlineMonth", $system->time->iCal->dator($taskInfo['deadline'], 'm'));
		$system->xorg->smarty->assign("deadlineDay", $system->time->iCal->dator($taskInfo['deadline'], 'd'));
		$system->xorg->smarty->assign("deadlineHour", date("H", $taskInfo['deadline']));
		$system->xorg->smarty->assign("deadlineMinute", date("i", $taskInfo['deadline']));
		$system->xorg->smarty->assign("progress", $system->xorg->htmlElements->selectElement->select('progress', range(0, 100), $taskInfo['progress']));

		require_once 'module/comment/config/config.php';
		require_once 'module/comment/model/comment.php';
		$system->xorg->smarty->assign("comments", m_comment::m_listObject('showListObjectSimple', "op=crm,opid=$taskInfo[id]"));

		$system->xorg->smarty->assign("history", $c_crm->c_logReader($taskInfo['id']));

		$system->xorg->prompt->promptShow('p', $lang['edit'], $system->xorg->smarty->fetch("$settings[moduleAddress]/crm/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings['ext4']));
		break;
	case "c_editObject":
		$c_crm->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[task]`", "`id` = '$_POST[id]'"));
		$system->xorg->smarty->assign("text", sprintf($lang['doYouWantDeleteObject'], $entity['subject']));
		$system->xorg->prompt->promptShow('p', $lang[delObject], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_crm->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_crm->c_listObject('list', $_GET['filter'], $system->utility->filter->queryString('sort'));
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	case "c_count":
		$c_crm->c_count($_POST['filter']);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings['ext4']);
		break;

}

?>