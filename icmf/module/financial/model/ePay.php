<?php
class m_ePay extends financial {
	public $RefNum;
	public $MID;
	public $State;
	public $ResNum;
	public $basket = "basketObject";
	public $shop = "shopObject";
	public $user = "user";
	function m_ePay() {
	}
	public function m_bankList() {
		global $system;
		
		$system->dbm->db->select ( "`id`, `name`", "`$settings[financialBank]`" );
		return $system->dbm->db->fetch_array ();
	}
	public function m_invoiceMaker($transactionType, $bankId, $amount = null) {
		global $system, $settings, $lang;
		
		$system->xorg->smarty->assign ( "MID", $settings ['MID'] );
		$system->xorg->smarty->assign ( "RedirectURL", $settings ['RedirectURL'] );
		$system->xorg->smarty->assign ( "LogoURL", $settings ['LogoURL'] );
		
		$invoiceNumber = $system->dbm->db->findMax ( "`$settings[financialInvoice]`", "invoiceNumber" ) + 1;
		$timeStamp = time ();
		
		if (empty ( $amount )) {
			require_once 'module/shop/model/shop.php';
			require_once 'module/eDelivery/model/eDelivery.php';
			
			$result = mysql_query ( "SELECT `objectId`, `uid`, `count` FROM `$settings[basketObject]` WHERE `uid` = $_SESSION[uid]" );
			while ( $row = mysql_fetch_array ( $result ) ) {
				
				$sellPrice = m_shop::m_sellPriceCalculator ( $row [objectId] );
				// Insert invoice in financial system
				$system->dbm->db->insert ( "`$settings[financialInvoice]`", "`active`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `timeStamp`, `invoiceNumber`, `objectId`, `uid`, `count`, `price`", "1, 1, 1, 1, 1, 1, 1, 1, $timeStamp, $invoiceNumber, $row[objectId], $row[uid], $row[count], $sellPrice" );
				
				// Insert to eDelivery system
				m_eDelivery::m_addObject ( $row ['objectId'] );
			}
			
			require_once 'module/basket/model/basket.php';
			$amount = m_basket::m_calculate ( 'return' );
		}
		$system->xorg->smarty->assign ( "amount", $amount );
		$countTransaction = $system->dbm->db->max_auto_inc ( $settings [financialTransaction] );
		$system->xorg->smarty->assign ( "ResNum", ++ $countTransaction );
		// Insert in financial transaction control
		$this->m_insertTrans ( "BATCH:FOR:$countTransaction", $transactionType, $bankId, $amount, $invoiceNumber );
		
		// Delete from basket
		$system->dbm->db->delete ( "`$settings[basketObject]`", "`uid` = $_SESSION[uid]" );
		
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/direct2Bank" . $settings ['ext4'] );
	}
	public function m_invoiceViewer($invoiceNumber, $show = true) {
		global $system, $lang, $settings;
		
		$system->dbm->db->select ( "`id`, `active`, `timeStamp`, `objectId`, `uid`, `count`, `price`", "`$settings[financialInvoice]`", "`invoiceNumber` = $invoiceNumber" );
		$count = 1;
		while ( $row = $system->dbm->db->fetch_array () ) {
			$entityList [$count] ['active'] = $row ['active'];
			$entityList [$count] ['id'] = $row ['id'];
			$entityList [$count] ['invoiceNumber'] = $invoiceNumber;
			$entityList [$count] ['timeStamp'] = $system->time->iCal->dator ( $row [timeStamp] ) . "<br>[" . date ( "H:m:s", $row ['timeStamp'] ) . "]";
			$entityList [$count] ['objectId'] = $row ['objectId'];
			
			$product = $system->dbm->db->informer ( "`$settings[productObject]`", "`id` = $row[objectId]" );
			$entityList [$count] ['objectEntityName'] = $product ['name'];
			$entityList [$count] ['model'] = $product ['model'];
			$entityList [$count] ['count'] = $row ['count'];
			$entityList [$count] ['price'] = $row ['price'];
			
			$uid = $row ['uid'];
			
			$count ++;
		}
		
		$user = $system->dbm->db->informer ( "`user`", "`id` = $uid" );
		$system->xorg->smarty->assign ( "userName", $user ['userName'] );
		$system->xorg->smarty->assign ( "lastName", $user ['lastName'] );
		$system->xorg->smarty->assign ( "mobile", $user ['mobile'] );
		$system->xorg->smarty->assign ( "address", $user ['address'] );
		$system->xorg->smarty->assign ( "entityList", $entityList );
		
		if ($show == true)
			$system->xorg->prompt->promptShow ( 'p', $lang ['invoice'] . " " . $lang ['number'] . " " . $invoiceNumber, $system->xorg->smarty->fetch ( $settings [moduleAddress] . "/" . $settings ['moduleName'] . "/view/tpl/invoice" . $settings ['ext4'] ) );
		else
			return $system->xorg->smarty->fetch ( $settings ['moduleAddress'] . "/" . $settings ['moduleName'] . "/view/tpl/invoice" . $settings ['ext4'] );
	}
	public function m_insertTrans($batchNumber, $transactionType, $bankId, $amount, $invoiceNumber) {
		global $system, $settings;
		
		$timeStamp = time ();
		$system->dbm->db->insert ( "`$settings[financialTransaction]`", "`active`, `owner`        , `group`, `or`, `ow`, `ox`, `gr`, `gx`, `timeStamp`, `batchNumber` , `invoiceNumber`, `amount`, `uid`         , `transactionType`, `bankId`", "0	   , 1              , 1      , 1   , 1   , 1   , 1   , 1   , $timeStamp , '$batchNumber', $invoiceNumber , $amount , $_SESSION[uid], $transactionType , $bankId" );
	}
	public function m_tester() {
		global $system, $lang, $settings;
		
		$user = $system->dbm->db->informer ( "`$settings[user]`", "`id` = $_SESSION[uid]" );
		$toMail = $user ['email'];
		$firstName = $user ['firstName'];
		$lastName = $user ['lastName'];
		$to = $user ['mobile'];
		
		// $transaction = $system->dbm->db->informer("`$settings[financialTransaction]`", "`id` = $ResNum");
		// $amount = $transaction['amount'];
		// $invoiceNumber = $transaction['invoiceNumber'];
		
		// require_once 'module/mta/config/config.php';
		// require_once 'module/mta/model/mta.php';
		
		// m_mta::m_mail($settings['adminMail'], $settings['domainName'], $toMail, "$firstName $lastName", $lang[yourShoppingSuccessfull], $system->xorg->smarty->fetch("module/mta/view/tpl/message.htm"));
		// m_mta::m_mail($settings['adminMail'], $settings['domainName'], $settings['adminMail'], $settings['adminMail'], "یک خرید با موفقیت انجام گردید", $system->xorg->smarty->fetch("module/mta/view/tpl/message.htm"));
		
		// require_once 'module/sms/config/config.php';
		// require_once 'module/sms/model/sms.php';
		
		// $to = "09122090271";
		$amount = 50000;
		$RefNum = 741;
		// $firstName = "Ali";
		// $lastName = "Hosseini";
		$settings [shopAlertMobile] = "09122090271";
		
		// m_sms::m_addObject($to, "با تشکر از خرید شما به مبلغ $amount ریال و به شماره پیگری $RefNum لطفا برای بررسی اطلاعات خرید به امیلتان مراجعه فرمایید. با تشکر لاندا الکترونیک", '', false);
		// m_sms::m_addObject($settings['shopAlertMobile'], "یک خرید توسط $firstName $lastName به مبلغ $amount ریال و کد پیگیری $RefNum با موفقیت انجام گرفت.", '', false);
		
		$system->watchDog->exception ( "s", $lang ['successful'], $lang ['yourShoppingSuccessfull'] );
	}
	public function m_transControl($RefNum, $MID, $State, $ResNum) {
		global $system, $lang, $settings;
		
// 		echo 'RefNum: ' . $this->RefNum = $RefNum;
// 		echo '<br>';
// 		echo 'MID: ' . $this->MID = $MID;
// 		echo '<br>';
// 		echo 'State: ' . $this->State = $State;
// 		echo '<br>';
// 		echo 'ResNum: ' . $this->ResNum = $ResNum;
// 		echo '<br>';
		
		if ($this->RefNum && $this->MID && $this->State) {
			if ($this->State == 'OK') {
				$soapProxy = $system->relation->nusoap->getProxy ();
// 				$soapProxy->debug_flag = true;
				$this->RefNum = $RefNum;
				$result = $soapProxy->verifyTransaction ( $RefNum, $MID );
				
				if ($result <= 0) {
					$system->watchDog->exception ( "e", $lang [securityWarning], $this->resutlState ( $result ) );
				} else {
					if ($this->m_addNewTrans ( $result )) {
						if (! empty ( $_SESSION ['uid'] ) && $_SESSION ['uid'] != 2) {
							$user = $system->dbm->db->informer ( "`user`", "`id` = $_SESSION[uid]" );
							$toMail = $user ['email'];
							$firstName = $user ['firstName'];
							$lastName = $user ['lastName'];
							$userName = $user ['userName'];
							$to = $user ['mobile'];
							
							$transaction = $system->dbm->db->informer ( "`$settings[financialTransaction]`", "`id` = $ResNum" );
							$amount = $transaction ['amount'];
							$invoiceNumber = $transaction ['invoiceNumber'];
							
							$system->xorg->smarty->assign ( "message", $this->m_invoiceViewer ( $invoiceNumber, false ) );
							
							require_once 'module/mta/config/config.php';
							require_once 'module/mta/model/mta.php';
							
							m_mta::m_mail ( $settings ['adminMail'], $settings ['domainName'], $toMail, "$firstName $lastName", "خرید شما با موفقیت انجام گردید", $system->xorg->smarty->fetch ( "module/mta/view/tpl/message.htm" ) );
							m_mta::m_mail ( $settings ['adminMail'], $settings ['domainName'], $settings ['adminMail'], $settings ['adminMail'], "یک خرید با موفقیت انجام گردید", $system->xorg->smarty->fetch ( "module/mta/view/tpl/message.htm" ) );
							m_mta::m_mail ( $settings ['adminMail'], $settings ['domainName'], $settings ['invoiceMail'], $settings ['invoiceMail'], "یک خرید با موفقیت انجام گردید", $system->xorg->smarty->fetch ( "module/mta/view/tpl/message.htm" ) );
							
							require_once 'module/sms/config/config.php';
							require_once 'module/sms/model/sms.php';
							
							m_sms::m_addObject ( $to, "$firstName $lastName با تشکر از خرید شما به مبلغ $amount ریال و به شماره پیگری $RefNum لطفا برای بررسی اطلاعات خرید به ایمیلتان مراجعه فرمایید.\nبازار بزرگ ایده‌آل", '', false );
							m_sms::m_addObject ( $settings ['shopAlertMobile'], "یک خرید توسط $userName به مبلغ $amount ریال و کد پیگیری $RefNum با موفقیت انجام گرفت.", '', false );
						}
// 						$system->watchDog->exception ( "s", $lang ['successful'], $lang ['yourShoppingSuccessfull'] );
						$system->xorg->smarty->display("$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/success" . $settings ['ext4']);
					} else {
						$system->watchDog->exception ( "e", $lang ['securityWarning'], $lang ['payRegError'] );
					}
				}
			} else {
				$system->watchDog->exception ( "e", $lang ['securityWarning'], $this->m_checkState () );
			}
		} else {
			$system->watchDog->exception ( "e", $lang ['securityWarning'], "$this->RefNum Or $this->MID Or $this->State is empty" );
		}
	}
	
	// Save new transaction in DB
	public function m_addNewTrans($procRes) {
		global $system, $lang, $settings;
		
		$procResCount = $system->dbm->db->count_records ( "`$settings[financialTransaction]`", "`id` = $this->ResNum" );
		$sql = "SELECT * FROM `$settings[financialTransaction]` WHERE `id` = $this->ResNum";
		$qres = mysql_query ( $sql );
		$backResNum = mysql_fetch_array ( $qres );
		if ($procResCount == 1) {
			if ($backResNum) {
				if ($backResNum ['amount'] == $procRes) {
					$time = time ();
					$system->dbm->db->update ( "`$settings[financialTransaction]`", "`active` = 1, `batchNumber` = '$this->RefNum', `payTime` = $time", "`id` = $this->ResNum" );
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function resutlState($result) {
		switch ($res) {
			case '1' :
				return "فرايند بازگشت با موفقيت انجام شد";
				break;
			case '-1' :
				return "خطاي داخلي شبکه مالي.";
				break;
			case '-2' :
				return "سپرده‌ها برابر نيستند. ( در حال حاضر اين شرايط به وجود نمی آيد)";
				break;
			case '-3' :
				return "ورودي‌ها حاوي کارکترهاي غيرمجاز مي‌باشند.";
				break;
			case '-4' :
				return "Merchant Authentication Failed ( کلمه عبور يا کد فروشنده اشتباه است)";
				break;
			case '-5' :
				return "Database Exception";
				break;
			case '-6' :
				return "سند قبلا برگشت کامل يافته است.";
				break;
			case '-7' :
				return "رسيد ديجيتالي تهي است.";
				break;
			case '-8' :
				return "طول ورودي‌ها بيشتر از حد مجاز است.";
				break;
			case '-9' :
				return "وجود کارکترهاي غيرمجاز در مبلغ برگشتي.";
				break;
			case '-10' :
				return "رسيد ديجيتالي به صورت Base64 نيست (حاوي کارکترهاي غيرمجاز است).";
				break;
			case '-11' :
				return "طول ورودي‌ها کمتر از حد مجاز است.";
				break;
			case '-12' :
				return "مبلغ برگشتي منفي است.";
				break;
			case '-13' :
				return "مبلغ برگشتي براي برگشت جزئي بيش از مبلغ برگشت نخورده‌ي رسيد ديجيتالي است.";
				break;
			case '-14' :
				return "چنين تراکنشي تعريف نشده است.";
				break;
			case '-15' :
				return "مبلغ برگشتی به صورت اعشاری داده شده است.";
				break;
			case '-16' :
				return "خطای داخلی سيستم";
				break;
			case '-17' :
				return "برگشت زدن جزيي تراکنشی که با کارت بانکی غير از بانک سامان انجام پذيرفته است.";
				break;
			case '-18' :
				return "IP Address  فروشنده نا معتبر است.";
				break;
			DEFAULT :
				return "Invalid error state";
				break;
		}
	}
	public function m_succTrans($ResNum) {
		global $system, $lang, $settings;
		
		$procCount = $system->dbm->db->count_records ( "`$settings[financialTransaction]`", "`id` = $this->ResNum" );
		$system->dbm->db->select ( "*", "`$settings[financialTransaction]`", "`id` = $this->ResNum" );
		$pRec = $system->dbm->db->fetch_array ();
		
		if ($system->dbm->db->count_records ( "`$settings[financialTransaction]`", "`id` = $this->ResNum" ) != 1) {
			return sprintf ( $lang ['amountSuccessfullReceive'], $pRec ['amount'], $pRec ['batchNumber'] );
		}
	}
	public function m_checkState() {
		switch ($this->State) {
			case 'Canceled By User' :
				return "تراکنش توسط خريدار کنسل شده است.";
				break;
			case 'Invalid Amount' :
				return "مبلغ سند برگشتی، از مبلغ تراکنش اصلی بيشتر است.";
				break;
			case 'Invalid Transaction' :
				return "درخواست برگشت يک تراکنش رسيده است، در حالی که تراکنش اصلی پيدا نمی شود.";
				break;
			case 'Invalid Card Number' :
				return "شماره کارت اشتباه است.";
				break;
			case 'No Such Issuer' :
				return "چنين صادر کننده کارتی وجود ندارد.";
				break;
			case 'Expired Card Pick Up' :
				return "از تاريخ انقضای کارت گذشته است و کارت ديگر معتبر نيست.";
				break;
			case 'Allowable PIN Tries Exceeded Pick Up' :
				return "رمز کارت (PIN) 3 مرتبه اشتباه وارد شده است در نتيجه کارت غير فعال خواهد شد.";
				break;
			case 'Incorrect PIN' :
				return "خريدار رمز کارت (PIN) را اشتباه وارد کرده است.";
				break;
			case 'Exceeds Withdrawal Amount Limit' :
				return "مبلغ بيش از سقف برداشت می باشد.";
				break;
			case 'Transaction Cannot Be Completed' :
				return "تراکنش Authorize شده است ( شماره PIN و PAN درست هستند) ولی امکان سند خوردن وجود ندارد.";
				break;
			case 'Response Received Too Late' :
				return "تراکنش در شبکه بانکی Timeout خورده است.";
				break;
			case 'Suspected Fraud Pick Up' :
				return "خريدار يا فيلد CVV2 و يا فيلد ExpDate را اشتباه زده است. ( يا اصلا وارد نکرده است)";
				break;
			case 'No Sufficient Funds' :
				return "موجودی به اندازی کافی در حساب وجود ندارد.";
				break;
			case 'Issuer Down Slm' :
				return "سيستم کارت بانک صادر کننده در وضعيت عملياتی نيست.";
				break;
			case 'TME Error' :
				return "خطا ايجاد شده قابل شناسايى نيست. لطفا با مديريت سايت تماس بگيريد";
				break;
		}
	}
}

?>