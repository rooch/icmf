<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	###########################
	# Category                #
	###########################
	case "v_category":
		$system->xorg->smarty->assign("add", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings[ext4]));
		$system->xorg->smarty->assign("list", $c_shop->c_listCategory());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category" . $settings[ext4]);
		break;
		// Add Category
	case "v_addCategory":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/add" . $settings[ext4]);
		break;
	case "c_addCategory":
		$c_shop->c_addCategory($_POST[name], $_POST[increase], $_POST[decrease], $_POST[discount], $_POST[tax], $_POST[description]);
		break;
		// Edit Category
		//	case "v_editCategory":
		//
		//		break;
	case "c_editCategory":
		$c_shop->c_editCategory($_POST[id], $_POST[name], $_POST[increase], $_POST[decrease], $_POST[discount], $_POST[tax]);
		break;
		// Del Category
	case "v_delCategory":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[shopCategory]`", "`id` = '$id'"));
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteCategory], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/category/del" . $settings[ext4]));
		break;
	case "c_delCategory":
		$c_shop->c_delCategory($_POST[id]);
		break;
		// List Category
	case "c_listCategory":
		$c_shop->c_listCategory();
		break;
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
		$system->xorg->smarty->assign("add", $c_shop->vc_addObject());
		$system->xorg->smarty->assign("list", $c_shop->c_listObject());
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object" . $settings[ext4]);
		break;
		// Add Object
	case "v_addObject":
		$c_shop->vc_addObject();
		break;
	case "c_addObject":
		$c_shop->c_addObject($_POST[objectId], $_POST[basePrice], $_POST[shopCategory], $_POST[discount], $_POST[tax]);
		break;
		// Edit Object
		//	case "c_editObject":
		//
		//		break;
		//	case "c_editObject":
		//
		//		break;
		// Del Object
	case "v_delObject":
		$id = $system->utility->filter->queryString('id');
		$system->xorg->smarty->assign("entity", $entity = $system->dbm->db->informer("`$settings[shopObject]`", "`id` = '$id'"));
		$entity[name] = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $entity[objectId]", "name");
		$system->xorg->smarty->assign("text", sprintf($lang[doYouWantDeleteObject], $entity[name]));
		$system->xorg->prompt->promptShow('p', $lang[delCategory], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/del" . $settings[ext4]));
		break;
	case "c_delObject":
		$c_shop->c_delObject($_POST[id]);
		break;
		// List Object
	case "c_listObject":
		$c_shop->c_listObject();
		break;
		// DataSheet Viewer
	case "v_showObject":
		$id = $system->utility->filter->queryString('id');
//		print "ID: $id<br>";
		$filePath = $system->dbm->db->informer("`$settings[productObject]`", "`id` = $id", "filePath");
//		print "File Path: $filePath<br>";
		$file = explode(",", $filePath);
		$system->xorg->smarty->assign("file", $file[0]);
		$system->xorg->prompt->promptShow('p', $lang[info], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/dataSheet" . $settings[ext4]));
		break;
		// Activate Object
	case "c_activateObject":
		$id = $system->utility->filter->queryString('id');
		$c_shop->c_activateObject($id);
		break;
		// Deactive Object
	case "c_deactivateObject":
		$id = $system->utility->filter->queryString('id');
		$c_shop->c_deactivateObject($id);
		break;
		###########################
		# Vitrin (Shop)           #
		###########################
	case "v_vitrin":
		$id = $system->utility->filter->queryString('id');
		require_once "module/product/model/product.php";
		$product = new m_product();
		$product->m_hierarchicalListCategory(0);
		$system->xorg->smarty->assign("category", $system->xorg->htmlElements->treeElement->tree($settings['productCategory'], 0, 'productCategory', 'mcdropdown_menu'));
		$system->xorg->smarty->assign("tree", "<ul id='productTreeMenu' style='padding-right: 20px;'>\n" . $product->tree . "<ul>\n");
		$system->xorg->smarty->assign("basket");
		$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), $settings[productCategory]));
		$system->xorg->smarty->assign("company", $system->xorg->combo(array('id', 'name'), $settings[company]));
		$system->xorg->smarty->assign("search", $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/vitrin/search" . $settings[ext4]));
		$system->xorg->smarty->assign("list", $c_shop->c_listVitrin('masonryList', $_GET[filter]));
		$system->xorg->smarty->assign("carousel", $c_shop->c_carousel($id));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/vitrin" . $settings[ext4]);
		break;
	case "v_listVitrin":
		if($_POST[filter]){
			$filter = $_POST[filter];
		}else{
			$filter = $_GET[filter];
		}
		
		$c_shop->c_listVitrin('list', $filter);
		break;
	case "v_searchListVitrin":
		if($_POST[filter]){
			$filter = $_POST[filter];
		}else{
			$filter = $_GET[filter];
		}
		
		$c_shop->c_listVitrin('searchList', $filter);
		break;
	case "v_descriptionVitrin":
		$c_shop->c_listVitrin('description', $_GET[filter]);
		break;
//	case "v_search":
//		$system->xorg->smarty->assign("productCategory", $system->xorg->combo(array('id', 'name'), $settings[productCategory]));
//		$system->xorg->smarty->assign("company", $system->xorg->combo(array('id', 'name'), $settings[productCompany]));
//		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/searchShop" . $settings[ext4]);
//		break;
	case "c_carousel":
		$c_shop->c_carousel($_GET[filter]);
		break;
	case "v_compare":
		
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>