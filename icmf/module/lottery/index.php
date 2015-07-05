<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	case "v_entityAdd":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/entityAdd" . $settings[ext4]);
		break;
	case "c_entityAdd":
		$c_lottery->c_lotteryAddEntity($_POST[name], $_POST[description], $_POST[price], $_POST[capacity], $_POST[startDay], $_POST[startMonth], $_POST[startYear], $_POST[startMinute], $_POST[startHour], $_POST[endDay], $_POST[endMouth], $_POST[endYear], $_POST[endMinute], $_POST[endHour], $_POST[prizeType], $_POST[prize], $_POST[specialOffer]);
		break;
	case "c_prizeList":
		$c_lottery->c_lotteryPrizeList($_POST[prizeType]);
		break;
	case "c_slide":
		$c_lottery->c_slide();
		break;
	case "c_carousel":
		$c_lottery->c_carousel();
		break;
	case "c_entityList":
		$c_lottery->c_lotteryListEntity();
		break;
	case "v_entityEdit":
		$system->xorg->smarty->assign("entityInfo", $c_lottery->c_lotteryInfoEntity($_POST[id]));
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/entityEdit" . $settings[ext4]);
		break;
	case "c_entityEdit":
		$c_lottery->c_lotteryEditEntity($_POST[id], $_POST[name], $_POST[description], $_POST[price], $_POST[capacity], $_POST[startDay], $_POST[startMonth], $_POST[startYear], $_POST[startMinute], $_POST[startHour], $_POST[endDay], $_POST[endMouth], $_POST[endYear], $_POST[endMinute], $_POST[endHour], $_POST[prizeType], $_POST[prize], $_POST[specialOffer]);
		break;
	case "c_entityDel":
		$c_lottery->c_lotteryDelEntity($_POST[id]);
		break;
	case "v_join":
		if(!empty($_SESSION[uid]) && $_SESSION[uid] != 3){
			$system->xorg->smarty->assign("info", $c_lottery->c_lotteryInfoEntity($_POST[lotteryId]));
			$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/join" . $settings[ext4]);
		}else{
			$c_userMan->c_loginContent();
		}
		break;
	case "c_join":
		$c_lottery->c_lotteryJoin($_POST[lotteryId], $_POST[bankCode]);
		break;
	case "c_memberList":
		$c_lottery->c_memberList();
		break;
	case "v_addToBasket":
		if(!empty($_SESSION[uid]) && $_SESSION[uid] != 2){
			$system->xorg->smarty->assign("objectId", $_POST[objectId]);
			$system->xorg->prompt->promptShow('p', $lang[addToBasket], $system->xorg->smarty->fetch("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/lotteryCount" . $settings[ext4]));
		}elseif(!empty($_SESSION[uid]) && $_SESSION[uid] == 2){
			$system->xorg->prompt->promptShow('p', $lang[signUp], $system->xorg->smarty->fetch("$settings[moduleAddress]/userMan/$settings[viewAddress]/$settings[tplAddress]/signUpSection" . $settings[ext4]));
		}
		break;
	case "c_addToBasket":
		$c_lottery->c_addToBasket($_POST[objectId], $_POST[count]);
		break;
	case "c_setWinner":
		$c_lottery->c_setWinner($_POST[id]);
		break;
	case "c_unSetWinner":
		$c_lottery->c_unSetWinner($_POST[id]);
		break;
	case "c_winnerList":
		$c_lottery->c_lotteryWinnerList();
		break;
	case "v_help":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/help" . $settings[ext4]);
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>