<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category                #
	###########################
	case "v_category":
		$system->xorg->smarty->assign("category", $c_post->c_hierarchicalListCategory(0));
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']));
		$system->xorg->smarty->assign("list", $c_post->c_listCategory());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings['ext4']);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->assign("category", $c_post->c_hierarchicalListCategory(0));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings['ext4']);
		break;
	case "c_addCategory":
		$c_post->c_addCategory($_POST[name], $_POST[category], $_POST[description]);
		break;
		// Edit Category
	case "v_editCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[postCategory], '', $entity[category]));
		$system->xorg->prompt->promptShow('p', $lang['editCategory'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/edit" . $settings['ext4']));
		break;
	case "c_editCategory":
		$c_post->c_editCategory($_POST['id'], $_POST['name'], $_POST['category'], $_POST['description']);
		break;
		// Del Category
	case "v_delCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteCategory], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/del" . $settings['ext4']));
		break;
	case "c_delCategory":
		$c_post->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$c_post->c_listCategory();
		break;
		// Make Hierarchical List Category
	case "c_hierarchicalListCategory":
		echo "<ul id='categorymenu' class='mcdropdown_menu'>\n";
		echo $c_post->c_hierarchicalListCategory(0) . "\n";
		echo "</ul>\n";
		break;
		// Activate Category
	case "c_activateCategory":

		break;
		// Deactive Category
	case "c_deactivateCategory":

		break;
		###########################
		# Object (post)           #
		###########################
	case "v_object":
		$system->xorg->smarty->assign("category", $c_post->c_hierarchicalListCategory(0));
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] ));
		//		$system->xorg->smarty->assign("list", $c_post->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings['ext4']);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("category", $c_post->c_hierarchicalListCategory(0));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings['ext4'] );
		break;
	case "c_addObject":
		$c_post->c_addObject($_POST, true);
		break;
		// Edit Object
	case "v_editObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("startTime", $system->time->iCal->dator($entity['startTime'], 2));
		$system->xorg->smarty->assign("endTime", $system->time->iCal->dator($entity['endTime'], 2));
		$system->xorg->smarty->assign("startYear", $system->time->iCal->dator($entity['startTime'], 'y'));
		$system->xorg->smarty->assign("startMonth", $system->time->iCal->dator($entity['startTime'], 'm'));
		$system->xorg->smarty->assign("startDay", $system->time->iCal->dator($entity['startTime'], 'd'));
		$system->xorg->smarty->assign("startHour", date("H", $entity['startTime']));
		$system->xorg->smarty->assign("startMinute", date("i", $entity['startTime']));
		$system->xorg->smarty->assign("endYear", $system->time->iCal->dator($entity['endTime'], 'y'));
		$system->xorg->smarty->assign("endMonth", $system->time->iCal->dator($entity['endTime'], 'm'));
		$system->xorg->smarty->assign("endDay", $system->time->iCal->dator($entity['endTime'], 'd'));
		$system->xorg->smarty->assign("endHour", date("H", $entity['endTime']));
		$system->xorg->smarty->assign("endMinute", date("i", $entity['endTime']));
		$system->xorg->smarty->assign("category", $c_post->c_hierarchicalListCategory(0));
		$system->xorg->prompt->promptShow('p', $lang['postEdit'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings['ext4']));
		break;
	case "c_editObject":
		$c_post->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[postObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang['doYouWantDeleteObject'], $entity['title']));
		$system->xorg->prompt->promptShow('p', $lang['delObject'], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings['ext4']));
		break;
	case "c_delObject":
		$c_post->c_delObject($_POST['id']);
		break;
		// List Object
	case "c_listObject":
		$system->xorg->smarty->assign("contentType", $system->xorg->htmlElements->selectElement->select('contentType', array('image' => 'image', 'voice' => 'voice', 'video' => 'video', 'text' => 'text'), $system->utility->filter->queryString('contentType')));
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->selectElement->select('category', $system->dbm->db->lookup($settings['postCategory']), $system->utility->filter->queryString('category')));
		
		$c_post->c_listObject('list', $sysVar['filter'], $system->utility->filter->queryString('sort'));
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	case "c_showListObject":
		if($_GET['filter'] == 'contentType=voice' || $_GET['filter'] == 'contentType=video'){
			$c_post->c_listObject('shortList', $_GET['filter']);
		}elseif($_GET['filter'] == 'sort=viewCount DESC'){
			$c_post->c_listObject('shortList', $_GET['filter'], $system->utility->filter->queryString('sort'));
		}else{
			$c_post->c_listObject('showList', $_GET['filter']);
		}
		break;
	case "c_showTitleListObject":
		$c_post->c_listObject('titleList', $_GET['filter']);
		break;
	case "c_feedObject":
		$c_post->c_feedObject("http://digiseo.persianblog.ir/rss.xml", 9);
		break;
	case "c_rssFeed":
		$c_post->c_rssFeed($_GET['filter']);
		break;
	default:
		$system->xorg->smarty->display($settings['commonTpl'] . "404" . $settings['ext4']);
		break;

}

?>