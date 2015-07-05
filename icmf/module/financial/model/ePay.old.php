<?php
class m_ePay extends financial{

	private $RefNum;
	private $MID;
	private $State;
	private $ResNum;
	private $basket = "basket";
	private $shop = "shop";

	function m_ePay(){

	}

	public function m_bankList(){
		global $system;

		$system->dbm->db->select("`id`, `name`", "`$this->financialBank`");
		return $system->dbm->db->fetch_array();
	}

	public function m_insertTrans($batchNumber, $transactionType, $bankId, $amount){
		global $system;

		$timeStamp = time();
		$system->dbm->db->insert("`$this->financialTransaction`", "`active`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `timeStamp`, `batchNumber` , `amount`, `uid`         , `transactionType`, `bankId`",
											   				 	  "0	   , 1      , 1      , 1   , 1   , 1   , 1   , 1   , $timeStamp , '$batchNumber', $amount , $_SESSION[uid], $transactionType , $bankId");
	}

	public function m_transControl($RefNum, $MID, $State, $ResNum){
		global $system, $lang, $settings;

		$this->RefNum = $RefNum;
		$this->MID = $MID;
		$this->State = $State;
		$this->ResNum = $ResNum;

		if($this->RefNum && $this->MID && $this->State){
			if($this->State == 'OK'){
				$soapProxy = $system->relation->nusoap->getProxy();
				$result = $soapProxy->verifyTransaction($RefNum,$MID);
				if($result <= 0){
					echo $system->watchDog->exception("e", $lang[securityWarning], $this->resutlState($result));
				}else{
					if($this->m_addNewTrans($result)){
						echo $system->watchDog->exception("s", $lang[securityWarning], $this->m_succTrans($this->ResNum));
					}else{
						echo $system->watchDog->exception("e", $lang[securityWarning], $lang[payRegError]);
					}
				}
			}else{
				echo $system->watchDog->exception("e", $lang[securityWarning], $this->m_checkState());
			}
		}else{
			echo $system->watchDog->exception("e", $lang[securityWarning], $lang[securityWarning]);	
		}
	}

	// Save new transaction in DB
	public function m_addNewTrans($procRes){
		global $system, $lang, $settings;

		$procRefCount = $system->dbm->db->count_records("`$this->financialTransaction`", "`batchNumber` = '$this->RefNum'");
		$system->dbm->db->select("*", "`$this->financialTransaction`", "`batchNumber` = '$this->RefNum'");
		$backRefNum = $system->dbm->db->fetch_array();
		
		$procResCount = $system->dbm->db->count_records("`$this->financialTransaction`", "`id` = $this->ResNum");
		$system->dbm->db->select("*", "`$this->financialTransaction`", "`id` = '$this->ResNum'");
		$backResNum = $system->dbm->db->fetch_array();

		if($procRefCount == 0){
			if($procResCount == 1){
				if($backResNum){
					if($backResNum['amount'] == $procRes){
						$time = time();
						$system->dbm->db->update("`$this->financialTransaction`", "`active` = 1, `batchNumber` = '$this->RefNum', `payTime` = $time", "`id` = $this->ResNum");
//						echo $system->watchDog->exception("s", $lang[successful], $lang[transUpdateSuccessfull]);
						return true;
					}else{
//						echo $system->watchDog->exception("e", $lang[securityWarning], $lang[amountDismatch]);
						return false;
					}
				}else{
//					echo $system->watchDog->exception("e", $lang[securityWarning], $lang[securityError]);
					return false;
				}
			}else{
//				echo $system->watchDog->exception("e", $lang[securityWarning], $lang[invalidTrans]);
				return false;
			}
		}else{
//			echo $system->watchDog->exception("e", $lang[securityWarning], $lang[registeredToken]);
			return false;
		}
	}

	public function resutlState($result){
		switch($result){
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
		if($result == 1){
			echo "
				<br><br><br><br>
				<center>
				<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#7c931a'><tr><td bgcolor='#f6fff0' style='font-family:tahoma; font-size:12px; color:#738b3b; ' align=center >
				پاسخ بانک : <b>$prompt</b>
				<br><a href='admin.php'>بازگشت به صفحه اصلي</a>
				</td></tr></table>
				</center>	
				";
			return true;
		}else{
			echo "
				<br><br><br><br>
				<center>
				<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#936b1a'><tr><td bgcolor='#ffe8db' style='font-family:tahoma; font-size:12px; color:#8b643b; ' align=center >
				پاسخ بانک : <b>$prompt</b>
				<br><a href='admin.php'>بازگشت به صفحه اصلي</a>
				</td></tr></table>
				</center>
				";	
			return false;
		}
		return false;
	}








	public function m_succTrans($ResNum){
		global $system, $lang, $settings;

		$procCount = $system->dbm->db->count_records("`$this->financialTransaction`", "`id` = $this->ResNum");
		$system->dbm->db->select("*", "`$this->financialTransaction`", "`id` = $this->ResNum");
		$pRec = $system->dbm->db->fetch_array();

		if($system->dbm->db->count_records("`$this->financialTransaction`", "`id` = $this->ResNum") != 1){
			return sechof($lang[amountSuccessfullReceive], $pRec[amount], $pRec[batchNumber]);
		}
	}

	public function m_failTrans($batch_number){
		if(!$_POST['sb24password']){
			$this->watchDog->watch('4', $lang[securityError]);
			BRING_SB24PASSWORD($batch_number);
			die();
		}
		if(!$sql=mysql_query(" select * from epay where 1 and batch_number='".$_POST['batch_number']."'")){
			ERROR("Error in mysql_query6");
			return false;
		}
		if(mysql_num_rows($sql)!=1){
			ERROR("Invalid security:8");
			return false;
		}
		if(!$row=mysql_fetch_array($sql)){
			ERROR("Error in mysql_query7");
			return false;
		}
		if($row['pay_value']<=0){
			ERROR("Invalid value");
			return false;
		}
		#	include('/usr/share/pear/nusoap.php');
		require_once('nusoap/nusoap.php');
		$nusoap = new soapclient('https://acquirer.sb24.com/ref-payment/ws/ReferencePayment?WSDL','wsdl');
		$soapProxy = $nusoap->getProxy();
		$res=$soapProxy->ReverseTransaction(
		$_POST['batch_number'], /*Refrence Number*/
		$GLOBALS['MID'], /*MTID*/
		$_POST['sb24password'], /*Password*/
		$row['pay_value'] /*"Reverse Number"*/
		); //reference number,sellerid,password,reverse amount


		return $res;
	}

	public function m_checkState(){
		switch($this->State){
			case 'Canceled By User':
				return "تراکنش توسط خريدار کنسل شده است.";
				break;
			case 'Invalid Amount':
				return "مبلغ سند برگشتی، از مبلغ تراکنش اصلی بيشتر است.";
				break;
			case 'Invalid Transaction':
				return "درخواست برگشت يک تراکنش رسيده است، در حالی که تراکنش اصلی پيدا نمی شود.";
				break;
			case 'Invalid Card Number':
				return "شماره کارت اشتباه است.";
				break;
			case 'No Such Issuer':
				return "چنين صادر کننده کارتی وجود ندارد.";
				break;
			case 'Expired Card Pick Up' :
				return "از تاريخ انقضای کارت گذشته است و کارت ديگر معتبر نيست.";
				break;
			case 'Allowable PIN Tries Exceeded Pick Up':
				return "رمز کارت (PIN) 3 مرتبه اشتباه وارد شده است در نتيجه کارت غير فعال خواهد شد.";
				break;
			case 'Incorrect PIN':
				return "خريدار رمز کارت (PIN) را اشتباه وارد کرده است.";
				break;
			case 'Exceeds Withdrawal Amount Limit':
				return "مبلغ بيش از سقف برداشت می باشد.";
				break;
			case 'Transaction Cannot Be Completed':
				return "تراکنش Authorize شده است ( شماره PIN و PAN درست هستند) ولی امکان سند خوردن وجود ندارد.";
				break;
			case 'Response Received Too Late':
				return "تراکنش در شبکه بانکی Timeout خورده است.";
				break;
			case 'Suspected Fraud Pick Up':
				return "خريدار يا فيلد CVV2 و يا فيلد ExpDate را اشتباه زده است. ( يا اصلا وارد نکرده است)";
				break;
			case 'No Sufficient Funds':
				return "موجودی به اندازی کافی در حساب وجود ندارد.";
				break;
			case 'Issuer Down Slm':
				return "سيستم کارت بانک صادر کننده در وضعيت عملياتی نيست.";
				break;
			case 'TME Error':
				return "خطا ايجاد شده قابل شناسايى نيست. لطفا با مديريت سايت تماس بگيريد";
				break;
		}
	}
	
	
	
	

	function m_DELETE_NUN_BATCH_RECORDS(){
		/*	db();
		 if(!$sql=mysql_query(" delete from epay where 1 and ( batch_number like 'BATCH:FOR:%' ) "))
		 {ERROR("Error in remove invalid records");return false;}
		 */	return true;
	}

	function m_CHECK_REJECT_RESULT($res){
		switch($res){
			case '1' :
				$prompt="فرايند بازگشت با موفقيت انجام شد";
				break;
			case '-1' :
				$prompt="خطاي داخلي شبکه مالي.";
				break;
			case '-2' :
				$prompt="سپرده‌ها برابر نيستند. ( در حال حاضر اين شرايط به وجود نمی آيد)";
				break;
			case '-3' :
				$prompt="ورودي‌ها حاوي کارکترهاي غيرمجاز مي‌باشند.";
				break;
			case '-4' :
				$prompt="Merchant Authentication Failed ( کلمه عبور يا کد فروشنده اشتباه است)";
				break;
			case '-5' :
				$prompt="Database Exception";
				break;
			case '-6' :
				$prompt="سند قبلا برگشت کامل يافته است.";
				break;
			case '-7' :
				$prompt="رسيد ديجيتالي تهي است.";
				break;
			case '-8' :
				$prompt="طول ورودي‌ها بيشتر از حد مجاز است.";
				break;
			case '-9' :
				$prompt="وجود کارکترهاي غيرمجاز در مبلغ برگشتي.";
				break;
			case '-10' :
				$prompt="رسيد ديجيتالي به صورت Base64 نيست (حاوي کارکترهاي غيرمجاز است).";
				break;
			case '-11' :
				$prompt="طول ورودي‌ها کمتر از حد مجاز است.";
				break;
			case '-12' :
				$prompt="مبلغ برگشتي منفي است.";
				break;
			case '-13' :
				$prompt="مبلغ برگشتي براي برگشت جزئي بيش از مبلغ برگشت نخورده‌ي رسيد ديجيتالي است.";
				break;
			case '-14' :
				$prompt="چنين تراکنشي تعريف نشده است.";
				break;
			case '-15' :
				$prompt="مبلغ برگشتی به صورت اعشاری داده شده است.";
				break;
			case '-16' :
				$prompt="خطای داخلی سيستم";
				break;
			case '-17' :
				$prompt="برگشت زدن جزيي تراکنشی که با کارت بانکی غير از بانک سامان انجام پذيرفته است.";
				break;
			case '-18' :
				$prompt="IP Address  فروشنده نا معتبر است.";
				break;
			DEFAULT :
				$prompt="Invalid error state";
				break;
		}
		if($res==1){
			echo "
				<br><br><br><br>
				<center>
				<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#7c931a'><tr><td bgcolor='#f6fff0' style='font-family:tahoma; font-size:12px; color:#738b3b; ' align=center >
				پاسخ بانک : <b>$prompt</b>
				<br><a href='admin.php'>بازگشت به صفحه اصلي</a>
				</td></tr></table>
				</center>	
				";
			return true;
		}else{
			echo "
				<br><br><br><br>
				<center>
				<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#936b1a'><tr><td bgcolor='#ffe8db' style='font-family:tahoma; font-size:12px; color:#8b643b; ' align=center >
				پاسخ بانک : <b>$prompt</b>
				<br><a href='admin.php'>بازگشت به صفحه اصلي</a>
				</td></tr></table>
				</center>
				";	
			return false;
		}
		return false;
	}

	function m_EPAY_DELL($batch_number){
		//db();
		if(!$sql=mysql_query(" delete from epay where 1 and batch_number='$batch_number' limit 1 ")){
			ERROR("Invalid MySQL Query");
			return false;
		}
		return true;
	}
	////////////////////// ADMIN SECTION

	function m_LIST_ARCHIVE(){
		//db();
		$tdd=10;
		$stt=$tdd*GTPT('PaG');
		switch(GTPT('ACT')){
			case 'DELL' :
				EPAY_DELL(GTPT('batch_number'));
				break;
			case 'EDIT' :
				EPAY_EDIT(GTPT('batch_number'));
				return true;
				break;
		}
		//DELETE_NUN_BATCH_RECORDS();
		if(!$sql=mysql_query(" select * from epay where 1 and not ( batch_number like 'BATCH:FOR:%' )   order by pay_date desc   limit $stt,$tdd ")){
			ERROR("Error in progress");
			return false;
		}
		echo '
			<br>
			<form name="aFORM" method="post" action="admin.php">
			<input type="hidden" name="ACT" value="EDIT" >
			<input type="hidden" name="batch_number" value="" >
			
			<center>
			<table dir="rtl" style="font-size:12px; font-family:tahoma;" width="80%" cellpadding="2" cellspacing="1" border="0" bgcolor="#57b151">
				<tr bgcolor="#aec6ac">
					<th>شماره سريال</th>
					<th>سبب تراکنش</th>
					<th>پرداخت کننده</th>
					<th>مبلغ تراکنش (ريال)</th>
					<th>تاريخ پرداخت</th>
					<th>---</th>
			</tr>';
		for($i=0; $i<mysql_num_rows($sql); $i++){
			$row=mysql_fetch_array($sql);
			echo "
			<tr bgcolor='#edffe3'>
				<td>".$row['batch_number']."</td>
				<td>".$row['memo']."</td>
				<td>".$row['pay_from']."</td>
				<td>".$row['pay_value']." </td>
				<td>".substr(U2Vaght($row['pay_date']),0,10)."</td>
				<td width=50 align=center >
					<a title='ويرايش' href='javascript:aFORM.batch_number.value=\"".$row['batch_number']."\"; aFORM.submit();'><img border=0 src='img/edit.gif'></a>
				</td>
			</tr>
		";
		}
		echo '
			<tr>
			<td colspan="5" align="center">';
		$mysqlnumrows=mysql_num_rows($sql);
		$PG=($mysqlnumrows-$mysqlnumrows%$tdd)/$tdd;
		if($mysqlnumrows%$tdd)
		$PG++;
		for($x=0; $x<$PG; $x++)
		if($x==GTPT('PaG'))
		echo "<b>".($x+1)."</b>";
		else
		echo "<a href='admin.php?ACT=LIST_ARCHIVE&PaG=$x' >".($x+1)."</a> ";
		echo '
					</td>
				</tr>
				</table>
				</center>
				</form>';
	}

	function m_EPAY_EDIT($batch_number=''){
		//db();

		if(!$batch_number){
			ERROR("<br>No record found");
			return false;
		}
		if(!$sql=mysql_query(" select * from epay where 1 and batch_number='$batch_number' limit 1 ")){
			ERROR("Invalid MySQL");
			return false;
		}
		if(mysql_num_rows($sql)>1){
			ERROR("Error in progress");
			return false;
		}
		if(mysql_num_rows($sql)==1)
		if(!$row=mysql_fetch_array($sql)){
			ERROR("Error in progress");
			return false;
		}
		if(mysql_num_rows($sql)==0)
		$addSTR="<br>تراکنش قبلاً ثبت نشده. لطفاً مشخصات را کامل، و تأييد کنيد";
		if(!$VERIFY_RESULT=VERIFY_PROCCES($batch_number,$GLOBALS['MID'],"OK")){
			echo "
					<br><br><br><br>
					<center>
					<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#936b1a'><tr><td bgcolor='#ffe8db' style='font-family:tahoma; font-size:12px; color:#8b643b; ' align=center >
					پاسخ بانک : <b>تراکنشي با اين رسيد ديجيتالي ثبت نشده</b>
					<br>
					<form method='post' action='admin.php'>
					<input type='hidden' name='ACT' value='DELL' >
					<input type='hidden' name='batch_number' value='$batch_number' >
					<input type='submit' value='حذف از ليست پرداختها' >
					</form>
					<br>
					</td></tr></table>
					</center>
					<br><br>	
				";	
			return false;
		}
		if($VERIFY_RESULT!=$row['pay_value']){
			echo "
					<br><br><br><br>
					<center>
					<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#936b1a'><tr><td bgcolor='#ffe8db' style='font-family:tahoma; font-size:12px; color:#8b643b; ' align=center >
					پاسخ بانک : <b>مبلغ پرداختي با مبلغ ثبت شده در بانک مطابقت ندارد</b>
					<br>
					<form method='post' action='admin.php'>
					<input type='hidden' name='ACT' value='DELL' >
					<input type='hidden' name='batch_number' value='$batch_number' >
					<input type='submit' value='حذف از ليست پرداختها' >
					</form>
					<br>
					</td></tr></table>
					</center>
					<br><br>
				";	
			return false;
		}
		echo ' <form method="post" action="admin.php">
				<input type="hidden" name="ACT" value="SAVE_EDIT">
				<input type="hidden" name="batch_number" value="<?=$batch_number ?>">
				<input type="hidden" name="pay_value" value="<?=$VERIFY_RESULT ?>">
				<center><br>
				<table dir="rtl" width="80%" style="font-family:tahoma; font-size:12px;" cellpadding="2" cellspacing="1" bgcolor="#c2dcdf">
				<tr height="1" bgcolor="#acb2b5"><td colspan="2" align="center"></td></tr>		
				<tr height="35"><td colspan="2" align="center">ويرايش پرداختها</td></tr>		
				<tr height="1" bgcolor="#acb2b5"><td colspan="2" align="center"></td></tr>		
				<tr bgcolor="#f4ffff">
				<td>شماره سريال:</td>
				<td><input style="font-size:12px; font-family:tahoma;" disabled type="text" name="batch_number" value="<?=$batch_number ?>"></td>
				</tr>		
				<tr bgcolor="#f4ffff">
				<td>مبلغ پرداخت (به ريال):</td>
				<td><input style="font-size:12px; font-family:tahoma;" disabled type="text" name="pay_value" value="<?=$VERIFY_RESULT ?>"></td>
				</tr>
				<tr bgcolor="#f4ffff">
				<td>نام پرداخت کننده:</td>
				<td><input style="font-size:12px; font-family:tahoma;" type="text" name="pay_from" value="' . $row[pay_from] . '"></td>
				</tr>
				<tr bgcolor="#f4ffff">
				<td>سبب تراکنش:</td>
				<td><input style="font-size:12px; font-family:tahoma;" type="text" name="memo" value="' . $row[memo] . '"></td>
				</tr>
				<tr height="1" bgcolor="#acb2b5"><td colspan="2" align="center"></td></tr>		
				<tr height="35">
				<td colspan="2" align="center">
				<input style="font-size:12px; font-family:tahoma; background-color:white;" type="submit" value="ثبت تغييرات">
				<input style="font-size:12px; font-family:tahoma; background-color:white;" type="button" onclick="if(confirm("آيا مايل به بازگشت کامل تراکنش هستيد؟"))
				location.href="admin.php?ACT=REJECT&batch_number=' . $batch_number . '" value="برگشت تراکنش">
				</td>
				</tr>
				<tr height="1" bgcolor="#acb2b5"><td colspan="2" align="center"></td></tr>				
				</table>
				</center>
				</form>';
		echo "
			<center>
			<table width=400 height=40 cellpadding=2 cellspacing=1 bgcolor='#7c931a'><tr><td bgcolor='#f6fff0' style='font-family:tahoma; font-size:12px; color:#738b3b; ' align=center >
			پاسخ بانک : <b>تأييد شد</b>
			$addSTR
			</td></tr></table>
			</center>	
		 ";
	}

	function m_SAVE_EDIT(){
		if(!$batch_number=$_POST['batch_number'])
		return false;
		//db();
		if(!$sql=mysql_query(" select * from epay where 1 and batch_number='$batch_number' limit 1 ")){
			ERROR("Error in progress");
			return false;
		}
		if(mysql_num_rows($sql)!=1){
			if(!$sql=mysql_query(" insert into epay (res_num,batch_number,memo,pay_from,pay_value,pay_date) values ('".BRING_NEW_RES_NUM()."','".$_POST['batch_number']."','".$_POST['memo']."','".$_POST['pay_from']."','".$_POST['pay_value']."','".date("U")."') ")){
				ERROR("Error in progress");
				return false;
			}
		}else{
			if(!$sql2=mysql_query(" update epay set	pay_from='".$_POST['pay_from']."', memo='".$_POST['memo']."' where 1 and batch_number='$batch_number' limit 1 ")){
				ERROR("Error in security:310");
				return false;
			}
		}
		return true;
	}

	function m_MINI_BATCH_FORM(){
		echo '
				<form method="post" action="admin.php">
				<input type="hidden" name="ACT" value="EDIT" >
					<center>
					<table style="font-size:12px; font-family:tahoma;" dir="rtl" bgcolor="#adced2" cellpadding="2" cellspacing="1"><tr><td bgcolor="#e9eff0" align="center">
					شماره سريال : <input type="text" style="font-size:12px; font-family:tahoma;" name="batch_number" >
					<input type="submit" value="جستجو" style="font-size:12px; font-family:tahoma;" >
					</td></tr></table>
					</center>
				</form>
			  ';
	}

	function m_SAVEPASS(){
		//db();
		if(!$sql=mysql_query(" select * from admin where 1 and username='admin' limit 1 ")){
			echo "Invalid query";
			return false;
		}
		$admin=mysql_fetch_array($sql);
		if($admin['password']!=$_POST['pass1']){
			echo "Invalid password";
			return false;
		}
		if($_POST['pass2']!=$_POST['pass3']){
			echo "Invalid password";
			return false;
		}
		if(!$sql=mysql_query(" update admin set password='".$_POST['pass2']."' where username='admin' limit 1 ")){
			echo "Invalid query2";
			return false;
		}
		$_SESSION['aUSER']='admin';
		$_SESSION['aPASS']=$_POST['pass2'];
		return true;
	}
}
?>