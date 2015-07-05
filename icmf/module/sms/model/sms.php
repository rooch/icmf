<?php
class m_sms extends masterModule{

	function m_sms(){

	}

	###########################
	# Object (SMS)            #
	###########################
	// Add Object
	public function m_addObject($to, $message, $show=true){
		global $settings, $lang, $system;
		
		set_time_limit ( 600 );
//		$show = true;

		$time = time();
//		$to = $to . $settings['adminMobile'];
		$to = (strstr($to, ',')) ? explode(',', $to) : array($to);

		if($settings[proto] == "REST"){
			$encoding = (mb_detect_encoding($message) == 'ASCII') ? "1" : "8";
			$send = $this->SendREST($settings[userName], $settings[password], $settings['from'], $to, $message, $encoding);
			if ($send){
				foreach ($to as $t){
					$system->dbm->db->insert("`$settings[smsObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `from`, `to`, `message`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$settings[from]', '$t', '$message'");
				}
				if($show)
				$system->watchDog->exception("s", $lang[messageSend], sprintf($lang[successfulDone], $lang[messageSend], strstr($message, ' ', true)));
			}else{
				if($show)
				$system->watchDog->exception("e", $lang[error], '2');
			}
		}elseif($settings[proto] == "SOAP"){

			ini_set("soap.wsdl_cache_enabled", "0");
			$client = new SoapClient($settings[url], array('encoding'=>'UTF-8'));
			$parameters['username'] = $settings[userName];
			$parameters['password'] = $settings[password];
			$parameters['from'] = $settings['from'];
			$parameters['to'] = $to;
			$parameters['text'] = $message;
			$parameters['isflash'] = false;
			$parameters['udh'] = "";
			$parameters['recId'] = array(0);
			$parameters['status'] = 0x0;

			switch ($client->SendSms($parameters)->SendSmsResult){
				case 0:
					$system->watchDog->exception("e", $lang[error] . '0', '‫نام كاربري يا رمز عبور صحيح نمي باشد‬');
					break;
				case 1:
					foreach ($to as $t){
						$system->dbm->db->insert("`$settings[smsObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `from`, `to`, `message`", "1, $time, 1, 1, 1, 1, 1, 1, 1, '$settings[from]', '$t', '$message'");
					}
					if($show)
					$system->watchDog->exception("s", $lang[messageSend], sprintf($lang[successfulDone], $lang[messageSend], $message));
					break;
				case 2:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '2', '‫اعتبار كافي نيست‬');
					break;
				case 3:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '3', '‫محدوديت در ارسال روزانه‬');
					break;
				case 4:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '4', '‫محدوديت در حجم ارسال‬');
					break;
				case 5:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '5', '‫شماره فرستنده معتبر نيست‬');
					break;
				case 6:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '6', '‫سامانه در حال بروز رساني مي باشد‬‬');
					break;
				case 7:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '7', '‫متن پيامك شامل كلمات فيلتر شده مي باشد‬‬');
					break;
				case 8:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '8', '‫‫عدم رسيدن به حداقل ارسال‬‬');
					break;
				case 9:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '9', '‫ارسال از خطوط عمومي از طريق وب سرويس امكان پذير نمي باشد‬‬');
					break;
				case 10:
					if($show)
					$system->watchDog->exception("e", $lang[error] . '10', '‫‫كاربر مسدود شده است‬‬');
					break;
				default:
					if($show)
					$system->watchDog->exception("e", $lang[error], $lang['unknown'] . $lang[error]);
					break;
			}
		}else{
			$system->watchDog->exception("e", $lang[error], 'Protochol not set');
		}

	}
	// Edit Object
	public function m_editObject($values){

	}
	// Del Object
	public function m_delObject($id){

	}
	// List Object
	public function m_listObject($viewMode, $filter = null){
		global $settings, $system, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("sms", "c_$viewMode", "`id`, `active`, `name`, `author`, `imagePath`, `abstract`", "`$settings[smsObject]`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){

			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][imagePath] = trim($row[imagePath], ',');
			$entityList[$count]['abstract'] = $row['abstract'];
			$entityList[$count][name] = $row[name];
			$entityList[$count][author] = $row[author];
			$entityList[$count][price] = $row[price];
			$entityList[$count][timeStamp] = $system->time->iCal->dator($row[timeStamp]);

			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	// Show Object
	public function m_showObject($id){
		global $system, $settings, $lang;

		$files = explode(",", $system->dbm->db->informer("`$settings[smsObject]`", "`id` = $id", "filePath"));
		$system->xorg->smarty->assign("fileName", $files[0]);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/show" . $settings[ext4]);
	}
	// Activate Object
	public function m_activateObject($id){

	}
	// Deactive Object
	public function m_deactivateObject($id){

	}

	###########################
	# Favorite                #
	###########################
	// Add Object to favorite
	public function m_addObjectToFavorite($name, $articleContent){

	}
	// Del Object from favorite
	public function m_delObjectFromFavorite($id){

	}
	// List favorite
	public function m_listFavorite($filter = null){

	}

	public function SendREST($username,$password, $Source, $Destination, $MsgBody, $Encoding){
		global $settings;
		$URL = "http://www.asanak.ir/webservice/v1rest/sendsms";
		$msg = urlencode(trim($MsgBody));
		$url = $URL.'?username='.$username.'&password='.$password.'&source='.$Source.'&destination='.$Destination.'&message='. $msg;
		$headers[] = 'Accept: text/html';
		$headers[] = 'Connection: Keep-Alive';
		$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
		$process = curl_init($url);
		curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($process, CURLOPT_HEADER, 0);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
		if(($return = curl_exec($process))){
			return $return;
		}
	}

}
?>