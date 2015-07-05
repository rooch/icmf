<?php
class m_crm extends masterModule{

	public function m_crm(){

	}
	###########################
	# Object                  #
	###########################
	// Add Object
	public function m_addObject($values){
		global $system, $lang, $settings;
		
		$timeStamp = time();

		$values['subject'] = mysql_real_escape_string($values['subject']);
		$values['description'] = mysql_real_escape_string($values['description']);

		$values['email'] = mysql_real_escape_string($values['email']);
		$values['mobile'] = mysql_real_escape_string($values['mobile']);

		$values['firstName'] = mysql_real_escape_string($values['firstName']);
		$values['lastName'] = mysql_real_escape_string($values['lastName']);
		$values['gender'] = mysql_real_escape_string($values['gender']);
		$values['birthday'] = mysql_real_escape_string($system->time->iCal->geoimport($values['year'], $values['month'], $values['day']));
		$values['eduLevel'] = mysql_real_escape_string($values['eduLevel']);
		$values['eduBranch'] = mysql_real_escape_string($values['eduBranch']);
		$values['jobTitle'] = mysql_real_escape_string($values['jobTitle']);
		$values['website'] = mysql_real_escape_string($values['website']);
		$values['phoneCode'] = mysql_real_escape_string($values['phoneCode']);
		$values['phoneNumber'] = mysql_real_escape_string($values['phoneNumber']);
		$values['fax'] = mysql_real_escape_string($values['fax']);
		$values['receiveSms'] = (!empty($values['mobile']) && !empty($values['receiveSms'])) ? 1 : 0;
		$values['receiveEmail'] = (!empty($values['email']) && !empty($values['receiveEmail'])) ? 1 : 0;
		$values['address'] = mysql_real_escape_string($values['address']);
		$values['state'] = mysql_real_escape_string($values['state']);
		$values['city'] = mysql_real_escape_string($values['city']);


		if($system->dbm->db->count_records("`$settings[contactBook]`", "`email` = '$values[email]' AND `mobile` = '$values[mobile]'") == 0){
			$system->dbm->db->insert("`$settings[contactBook]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `firstName`, `lastName`, `gender`, `birthday`, `eduLevel`, `eduBranch`, `company`, `jobTitle`, `position`, `website`, `phoneCode`, `phoneNumber`, `fax`, `mobile`, `receiveSms`, `email`, `receiveEmail`, `address`, `state`, `city`", "1, $timeStamp, 1, 12, 1, 1, 1, 1, 1,'$values[firstName]', '$values[lastName]', '$values[gender]', '$values[birthday]', '$values[eduLevel]', '$values[eduBranch]', '$values[companyId]', '$values[jobTitleId]', '$values[postId]', '$values[website]', '$values[phoneCode]', '$values[phoneNumber]', '$values[fax]', '$values[mobile]', $values[receiveSms], '$values[email]', $values[receiveEmail], '$values[address]', '$values[state]', '$values[city]'");
			$uid = $system->dbm->db->insert_id();
		}else{
			$data = $system->dbm->db->informer("`$settings[contactBook]`", "`email` = '$values[email]' AND `mobile` = '$values[mobile]'");

			foreach ($data as $key=>$dat) {
				if(empty($data[$key]) && !empty($values[$key])){
					$data[$key] = $values[$key];
				}
			}

			$system->dbm->db->update("`$settings[contactBook]`", "`firstName` = '$data[firstName]', `lastName` = '$data[lastName]', `gender` = '$data[gender]', `birthday` = '$data[birthday]', `eduLevel` = '$data[eduLevel]', `eduBranch` = '$data[eduBranch]', `company` = '$data[company]', `jobTitle` = '$data[jobTitle]', `position` = '$data[position]', `website` = '$data[website]', `phoneCode` = '$data[phoneCode]', `phoneNumber` = '$data[phoneNumber]', `fax` = '$data[fax]', `mobile` = '$data[mobile]', `receiveSms` = '$data[receiveSms]', `email` = '$data[email]', `receiveEmail` = '$data[receiveEmail]', `address` = '$data[address]', `state` = '$data[state]', `city` = '$data[city]'", "`email` = '$values[email]' OR `mobile` = '$values[mobile]'");
			$uid = $data['id'];

			$message = "$values[firstName] $values[lastName] $lang[withNumber] <font color='red'>$uid</font>";
		}

		$deadline = time() + 172800;
		$weight = $values['priority'] * $timeStamp; 
		if($system->dbm->db->insert("`$settings[task]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `subject`, `status`, `clientType`, `clientId`, `deadline`, `description`, `lastEditTime`, `weight`", "1, $timeStamp, 1, 12, 1, 1, 1, 1, 1, '$values[subject]', 7, 1, $uid, $deadline, '$values[description]', $timeStamp, $weight")){

			$requestNumber = $system->dbm->db->insert_id();
			if($subject != 'full'){
				require_once 'module/sms/config/config.php';
				require_once 'module/sms/model/sms.php';
				//				$m_sms = new m_sms();

				switch ($values['subject']){
					case 'analysis':
//						m_sms::m_addObject('09122975431', "$values[subject]\n$values[firstName] $values[lastName]\n$values[mobile]\n$values[email]\n$values[website]\n$values[description]" , '', false);
						break;
					case 'website':
						m_sms::m_addObject('', "$values[subject]\n$values[firstName] $values[lastName]\n$values[mobile]\n$values[email]\n$values[website]\n$values[description]" , '', false);
						break;
				}

				$message = "$lang[yourRequest] $lang[withNumber] <font color='red'>$requestNumber</font> $lang[inserted]";
				$system->watchDog->exception("s", $lang['add'], sprintf($lang['successfulDone'], $lang['add'], $message));
			}
		}
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();

		//		print_r($values);

		if($values['type'] == 'task'){
			$taskInfo = $system->dbm->db->informer("`$settings[task]`", "`id` =  $values[id]");

			$values['deadline'] = $system->time->iCal->geoimport($values['deadlineYear'], $values['deadlineMonth'], $values['deadlineDay'], $values['deadlineHour'], $values['deadlineMinute']);

			$commentCount = $system->dbm->db->count_records("`$settings[commentObject]`", "`op` = 'crm' AND `opid` = $values[id]");
			$weight = $values['priority'] * $timeStamp + ($commentCount * $settings['commentWeight']);
//			echo 'Comment Count: ' . $commentCount . '<br>';
//			echo 'Priority: ' . $values['priority'] . '<br>';
//			echo 'Timestamp: ' . $timeStamp . '<br>';
//			echo 'Weight: ' . $weight . '<br>';
			
			$system->dbm->db->update("`$settings[task]`", "`lastEditTime` = $timeStamp, `priority` = '$values[priority]', `status` = '$values[status]', `department` = '$values[department]', `agent` = '$values[agent]', `deadline` = '$values[deadline]', `progress` = '$values[progress]', `weight` = $weight", "`id` = $values[id]");

			if($taskInfo['priority'] != $values['priority'] && !empty($values['priority']))
			$log = '<li>' . $lang['priority'] . ' ' . $lang['from'] . ' ' . $taskInfo['priority'] . ' ' . $lang['to'] . ' ' . $values['priority'] . '<li>';
			if($taskInfo['status'] != $values['status'] && !empty($values['status'])){
				$system->dbm->db->update("`$settings[task]`", "`weight` = 0", "`id` = $values[id]");
				
				$log .= '<li>' . $lang['status'] . ' ' . $lang['from'] . ' ' . $system->dbm->db->informer($settings['status'], "`id` = $taskInfo[status]", 'name') . ' ' . $lang['to'] . ' ' . $system->dbm->db->informer($settings['status'], "`id` = $values[status]", 'name') . '</li>';

				$clientInfo = $system->dbm->db->informer("`$settings[contactBook]`", "`id` = $taskInfo[cientId]");
				if(!empty($clientInfo['mobile'])){
					require_once 'module/sms/config/config.php';
					require_once 'module/sms/model/sms.php';
					m_sms::m_addObject($clientInfo['mobile'], $lang['yourRequestStatusChangedTo'] . ': ' . $system->dbm->db->informer("`$settings[status]`", "`id` = $taskInfo[status]", 'name'), '', false);
				}
				if(!empty($clientInfo['email'])){
					require_once 'module/mta/config/config.php';
					require_once 'module/mta/model/mta.php';
					m_mta::m_addObject($settings['roboMail'], $lang['statusChanged'], $lang['yourRequestStatusChangedTo'] . ': ' . $system->dbm->db->informer("`$settings[status]`", "`id` = $taskInfo[status]", 'name'), $clientInfo['email'], $clientInfo['firstName'], $clientInfo['lastName']);
				}
			}
			if($taskInfo['department'] != $values['department'] && !empty($values['department']))
			$log .= '<li>' . $lang['department'] . ' ' . $lang['from'] . ' ' . $system->dbm->db->informer("`$settings[groupManObject]`", "`id` = $taskInfo[department]", 'name') . ' ' . $lang['to'] . ' ' . $system->dbm->db->informer("`$settings[groupManObject]`", "`id` = $values[department]", 'name') . '</li>';
			if($taskInfo['agent'] != $values['agent'] && !empty($values['agent'])){
				$log .= '<li>' . $lang['agent'] . ' ' . $lang['from'] . ' ' . $system->dbm->db->informer("`user`", "`id` = $taskInfo[agent]", 'name') . ' ' . $lang['to'] . ' ' . $system->dbm->db->informer("`user`", "`id` = $values[agent]", 'name') . '</li>';

				$agentInfo = $system->dbm->db->informer("`user`", "`id` = $values[agent]");
				if(!empty($agentInfo['mobile'])){
					require_once 'module/sms/config/config.php';
					require_once 'module/sms/model/sms.php';
					m_sms::m_addObject($agentInfo['mobile'], $lang['aTaskAssignedWithNumber'] . ': ' . $taskInfo['id'], '', false);
				}
				if(!empty($agentInfo['email'])){
					require_once 'module/mta/config/config.php';
					require_once 'module/mta/model/mta.php';
					m_mta::m_addObject($settings['roboMail'], $lang['agentChanged'], $lang['yourRequestStatusChangedTo'] . ': ' . $system->dbm->db->informer("`$settings[status]`", "`id` = $taskInfo[status]", 'name'), $agentInfo['email'], $agentInfo['firstName'], $agentInfo['lastName']);
				}
			}
			if($taskInfo['deadline'] != $values['deadline'] && !empty($values['deadline'])){
				$log .= '<li>' . $lang['deadline'] . ' ' . $lang['from'] . ' ' . $system->time->iCal->dator($taskInfo['deadline'], 2) . ' ' . $lang['to'] . ' ' . $system->time->iCal->dator($values['deadline'], 2) . '</li>';
			}
			if($taskInfo['progress'] != $values['progress'] && !empty($values['progress']))
			$log .= '<li>' . $lang['progress'] . ' ' . $lang['from'] . ' ' . $taskInfo['progress'] . ' ' . $lang['to'] . ' ' . $values['progress'] . '</li>';

			if(!empty($log))
			$system->dbm->db->insert("`$settings[taskLog]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `uid`, `taskId`, `log`", "1, $timeStamp, 1, 12, 1, 1, 1, $_SESSION[uid], $values[id], '$log'");
			$system->watchDog->exception("s", $lang['update'], sprintf($lang['successfulDone'], $lang['task'], $values['id']));
		}elseif($values['type'] == 'contactBook'){
			$system->dbm->db->update("`$settings[contactBook]`", "`firstName` = '$values[firstName]', `lastName` = '$values[lastName]', `gender` = '$values[gender]', `birthday` = '$values[birthday]', `eduLevel` = '$values[eduLevel]', `eduBranch` = '$values[eduBranch]', `company` = '$values[company]', `jopTitle` = '$values[jobTitle]', `position` = '$values[position]', `website` = '$values[website]', `phoneCode` = '$values[phoneCode]', `phoneNumber` = '$values[phoneNumber]', `fax` = '$values[fax]', `mobile` = '$values[mobile]', `receiveSms` = '$values[receiveSms]', `email` = '$values[email]', `receiveEmail` = '$values[receiveEmail]', `address` = '$values[address]', `state` = '$values[state]', `city` = '$values[city]'", "`id` = $values[id]");
			$system->watchDog->exception("s", $lang['contactBookEdit'], sprintf($lang['successfulDone'], $lang['contactBookEdit'], $values['name']));
		}


	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$subject = $system->dbm->db->informer("`$settings[task]`", "`id` = $id", "subject");
		$system->dbm->db->delete("`$settings[task]`", "`id` = $id");
		$system->watchDog->exception("s", $lang['del'], sprintf($lang['successfulDone'], $lang['delete'], $subject));
	}
	// List Object
	public function m_listObject($viewMode, $filter=null, $sort=null){
		global $system,$lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$sort = !empty($sort) ? $sort : 'weight DESC';
		$system->xorg->pagination->paginateStart("crm", 'c_' . $viewMode . 'Object', "`id`, `timeStamp`, `active`, `subject`, `priority`, `status`, `department`, `agent`, `clientType`, `clientId`, `deadline`, `progress`, `description`, `lastEditTime`, `weight`", "`$settings[task]`", "1 $filter", "$sort", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 2);
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			$entityList[$count]['subject'] = $row['subject'];
			
			$entityList[$count]['commentCount'] = $system->dbm->db->count_records("`$settings[commentObject]`", "`op` = 'crm' AND `opid` = $row[id]");
			$entityList[$count]['lastComment'] = $system->dbm->db->informer("`$settings[commentObject]`", "`op` = 'crm' AND `opid` = $row[id]", 'text', 'DESC');
			
			$entityList[$count]['priority'] = $row['priority'];
			$entityList[$count]['status'] = $system->dbm->db->informer("`$settings[status]`", "`id` = $row[status]", "name");
			$entityList[$count]['department'] = $system->dbm->db->informer("`$settings[groupManObject]`", "`id` = $row[department]", "name");
			
			$agentInfo = $system->dbm->db->informer("`user`", "`id` = $row[agent]");
			$entityList[$count]['agent'] = $agentInfo['firstName'] . ' ' . $agentInfo['lastName'];
			$entityList[$count]['clientType'] = $row['clientType'];
			$entityList[$count]['clientId'] = $row['clientId'];
			$entityList[$count]['deadline'] = $system->time->iCal->dator($row['deadline'], 2);

			$totalTime = ($row['deadline'] - $row['timeStamp'] < 0) ? 0 : $row['deadline'] - $row['timeStamp'];
			$spentTime = time() - $row['timeStamp'];
			$remainingTime = ($row['deadline'] - time() < 0) ? 0 : $row['deadline'] - time();

			if($row['deadline'] - time() < 0){
				$remainingTime = 0;
				$entityList[$count]['remainFlag'] = -1;
			}else{
				$remainingTime = $row['deadline'] - time();
			}

			$now = new DateTime();
			$deadlineDateTime = new DateTime(date("Y-m-d H:i:s", $row['deadline']));
			$deadLineInterval = $deadlineDateTime->diff($now);

			$spentDateTime = new DateTime(date("Y-m-d H:i:s", $row['timeStamp']));
			$spentTimeInterval = $spentDateTime->diff($now);

			$entityList[$count]['remainingDateTime'] = $deadLineInterval->format("%d $lang[day], %h $lang[hour], %i $lang[minute], %s $lang[second]");

			$entityList[$count]['timeRemainingPercent'] = round(($remainingTime * 100) / $totalTime, 0, PHP_ROUND_HALF_DOWN);

			$entityList[$count]['spentDateTime'] = $spentTimeInterval->format("%d $lang[day], %h $lang[hour], %i $lang[minute], %s $lang[second]");

			$entityList[$count]['progress'] = $row['progress'];
			$entityList[$count]['description'] = $row['description'];
			$entityList[$count]['lastEditTime'] = $system->time->iCal->dator($row['lastEditTime'], 2);
			$entityList[$count]['weight'] = $row['weight'];

			$contactInfo = $system->dbm->db->informer("`$settings[contactBook]`", "`id` = $row[clientId]");
			$entityList[$count]['firstName'] = $contactInfo['firstName'];
			$entityList[$count]['lastName'] = $contactInfo['lastName'];
			$entityList[$count]['website'] = $contactInfo['website'];
			$entityList[$count]['mobile'] = $contactInfo['mobile'];
			$entityList[$count]['email'] = $contactInfo['email'];
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/object/$viewMode" . $settings[ext4]);

	}
	// Activate Object
	public function m_activateObject(){

	}
	// Deactivate Object
	public function m_deactivateObject(){

	}
	// Log reader
	public function m_logReader($id){
		global $system, $settings;
	
		$result = mysql_query("SELECT `id`, `active`, `timeStamp`, `uid`, `log` FROM `$settings[taskLog]` WHERE `taskId` = $id");
//		echo "SELECT `id`, `active`, `timeStamp`, `uid`, `log` FROM `$settings[taskLog]` WHERE `id` = $id";

		$count = 1;
		while ($row = mysql_fetch_array($result)){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 2);
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			$agentInfo = $system->dbm->db->informer("`user`", "`id` = $row[uid]");
			$entityList[$count]['agent'] = $agentInfo['firstName'] . ' ' . $agentInfo['lastName'];
			$entityList[$count]['log'] = $row['log'];
			$count++;
		}

		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/crm/view/tpl/object/log" . $settings['ext4']);
	}
	
	public function m_count($filter=null){
		global $settings, $system;

		echo 120 - $system->dbm->db->count_records("`$settings[task]`", "$filter");
	}

}
?>