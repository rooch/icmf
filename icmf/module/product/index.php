<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category                #
	###########################
	case "v_category":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['productCategory'], 0, 'productCategory', 'mcdropdown_menu'));		
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings[ext4]));
		$system->xorg->smarty->assign("list", $c_product->c_listCategory());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings[ext4]);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['productCategory'], 0, 'productCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings[ext4]);
		break;
	case "c_addCategory":
		$c_product->c_addCategory($_POST[name], $_POST[category], $_POST[description]);
		break;
		// Edit Category
	case "v_editCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[productCategory], '', $entity[category]));
		$system->xorg->prompt->promptShow('p', $lang[editCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/edit" . $settings[ext4]));
		break;
	case "c_editCategory":
		$c_product->c_editCategory($_POST[id], $_POST[name], $_POST[category], $_POST[description]);
		break;
		// Del Category
	case "v_delCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[productCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteCategory], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/del" . $settings[ext4]));
		break;
	case "c_delCategory":
		$c_product->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$c_product->c_listCategory();
		break;
		// Make Hierarchical List Category
//	case "c_hierarchicalListCategory":
//		print "<ul id='productTreeMenu' style='padding-right: 20px;'>\n";
//		$c_product->c_hierarchicalListCategory(0);
//		print "<ul>\n";
//		break;
		// Activate Category
	case "c_activateCategory":

		break;
		// Deactive Category
	case "c_deactivateCategory":

		break;
		###########################
		# Object (product)        #
		###########################
	case "v_object":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['productCategory'], 0, 'productCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->assign('company', $system->xorg->htmlElements->selectElement->select('company', $system->dbm->db->lookup("`$settings[directoryObject]`")));
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4] ));
		$system->xorg->smarty->assign("list", $c_product->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings[ext4]);
		break;
		// Add Object
	case "v_addObject":
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['productCategory'], 0, 'productCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->assign("company", $system->xorg->combo(array('id', 'name'), $settings[company]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/add" . $settings[ext4] );
		break;
	case "c_addObject":
		$c_product->c_addObject($_POST);
		break;
		// Edit Object
	case "v_editObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $c_product->c_infoObject($id));
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[productCategory], '', $entity[category]));
		$system->xorg->smarty->assign("company", $system->xorg->combo(array('id', 'name'), $settings[company], '', $entity[company]));
		
		$galleryId = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $id", "imageGallery");
		$system->xorg->smarty->assign("imageGallery", $system->xorg->htmlElements->imageGalleryElement->gallery($galleryId, 'v'));
		
		$imageArray = $system->dbm->db->arrayLister("`url`", "`galleryObject`", "`category` = $galleryId");
		$system->xorg->smarty->assign("imageString", implode(",", $imageArray));
		$system->xorg->smarty->assign("electricType", array(1 => 'AC', 2 => 'DC'));
//		$system->xorg->prompt->promptShow('p', $lang[productEdit], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings[ext4]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/edit" . $settings[ext4]);
		break;
	case "c_editObject":
		$c_product->c_editObject($_POST);
		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[productObject]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteObject], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings[ext4]));
		break;
	case "c_delObject":
		$c_product->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_product->c_listObject();
		break;
		// Activate Object
	case "c_activateObject":

		break;
		// Deactive Object
	case "c_deactivateObject":

		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;

}

?>