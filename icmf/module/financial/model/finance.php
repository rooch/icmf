<?php

class m_finance extends financial{
	
	private $userTable = "user";

	function m_finance(){

	}

	public function m_transactionList(){
		global $system, $lang, $settings;

		$system->xorg->pagination->paginateStart("financial", "c_transactionList", "`base`.`id`, `base`.`active`, `base`.`timeStamp`, `batchNumber`, `amount`, `payTime`, `$this->userTable`.`id` as `uid`, `$this->userTable`.`userName`, `$this->financialTransactionType`.`name` as `transType`, `$this->financialBank`.`name` as `bankName`, `invoiceNumber`", "`$this->financialTransaction` as `base`, `$this->userTable`, `$this->financialBank`, `$this->financialTransactionType`", "`base`.`uid` = `$this->userTable`.`id` AND `base`.`transactionType` = `$this->financialTransactionType`.`id` AND `base`.`bankId` = `$this->financialBank`.`id`", "`base`.`timeStamp` DESC");
		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][invoiceNumber] = $row[invoiceNumber];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]) . "<br>[" .date("H:m:s", $row[timeStamp]) . "]";	
			$entityList[$count][batchNumber] = $row[batchNumber];
			$entityList[$count][amount] = $row[amount];
			$entityList[$count][payTime] = !empty($row[payTime]) ? $system->time->iCal->dator($row[payTime]) . "<br>[" .date("H:m:s", $row[payTime]) . "]" : $lang[notPayYet];
			$entityList[$count][uid] = $row[uid];
			$entityList[$count][userName] = $row[userName];
			$entityList[$count][transType] = $row[transType];
			$entityList[$count][bankName] = $row[bankName];
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/transactionList" . $settings[ext4]);

	}

}

?>