<?php

if(file_exists(visor . ".php"))
require_once(visor . ".php");

switch ($sysVar[mode]){
	case "v_ePay":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/ePay" . $settings[ext4]);
		break;
	case "v_payInPerson":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/payInPerson" . $settings[ext4]);
		break;
	case "v_payCard":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/payCard" . $settings[ext4]);
		break;
	case "v_payCardSite":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/payCardSite" . $settings[ext4]);
		break;
	case "v_onlinePayment":
		$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/onlinePayment" . $settings[ext4]);
		break;
	case "c_invoiceMaker":
		$financial->c_ePay->c_invoiceMaker($_POST[transactionType], $_POST[bankId], $_POST['amount']);
		break;
	case "c_invoiceViewer":
		$id = $system->utility->filter->queryString('invoiceNumber');
		$financial->c_ePay->c_invoiceViewer($id);
		break;
	case "c_transControl":
		$financial->c_ePay->c_transControl($_POST['RefNum'], $_POST['MID'], $_POST['State'], $_POST['ResNum']);
		break;
	case "c_transactionList":
		$financial->c_finance->c_transactionList();
		break;
	case "tester":
		$financial->c_ePay->c_tester();
		break;
	default:
		$system->xorg->smarty->display($settings[commonTpl] . "404" . $settings[ext4]);
		break;
}

?>