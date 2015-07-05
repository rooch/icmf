<?php

class m_mta extends masterModule{

	private $queue;
	private $smtp;
	private $receiver;

	function __construct(){

	}

	public function m_addObject($from, $subject, $message, $receiverMail, $receiverFirstName=null, $receiverLastName=null){
		global $system, $settings, $lang;

		$system->mail->CharSet = 'utf-8';
		$system->mail->From = (!empty($from)) ? $from : $settings['roboMail'];
		$system->mail->FromName = (!empty($from)) ? $from : $settings['domainName'];
		// $system->mail->SetFrom("digiseo.ir@gmail.com");
		$system->mail->Subject = $subject;
			
		$system->xorg->smarty->assign("subject", $subject);
		$system->xorg->smarty->assign("firstName", $receiverFirstName);
		$system->xorg->smarty->assign("lastName", $receiverLastName);
		$system->xorg->smarty->assign("message", $message);
		$system->mail->Body = $system->xorg->smarty->fetch($settings['moduleAddress'] . "/mta/view/tpl/message" . $settings['ext4']);
		$system->mail->AltBody = $message;
			
		$system->mail->addAddress($receiverMail, $receiverFirstName . ' ' . $receiverLastName);
// 		$system->mail->addAddress('s.a.hosseini', 'Ali Hosseini');
		$system->mail->addBCC("s.a.hosseini@gmail.com");
		$system->mail->addReplyTo($settings['roboMail']);
		$system->mail->isHTML(true);
			
		if($system->mail->send()){
			$system->watchDog->exception("s", $lang['messageSend'], sprintf($lang[successfulDone], $lang[messageSend], strstr($subject, ' ', true)));
		}else{
			$system->watchDog->exception("e", $lang[error], $system->mail->ErrorInfo);
		}
	}

	public function m_addMtaQueue ($domain=null, $subject, $message, $link, $image=null, $from=null, $fromName, $attachment=null){
		global $settings, $system;

		$from = (!empty($from)) ? $from : $settings['roboMail'];
		$fromName = (!empty($fromName)) ? $fromName : $settings['roboMail'];
		$timeStamp = time();

		$system->dbm->db->insert("`$settings[mtaQueue]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ox`, `gr`, `gx`, `tr`, `tx`, `ur`, `ux`, `domain`, `from`, `fromName`, `subject`, `image`, `message`, `link`, `attachment`, `maxCount`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$domain', '$from', '$fromName', '$subject', '$image', '$message', '$link', '$attachment', 500");
	}

	private function m_mtaQueueFind (){
		global $settings, $system;

		$system->dbm->db->select("`id`, `domain`, `from`, `fromName`, `subject`, `image`, `message`, `link`", "`$settings[mtaQueue]`", "`count` < `maxCount`", "`count` ASC", "", "", "0,1");
		$this->queue = $system->dbm->db->fetch_array();
		
// 		print_r($this->queue);
	}

	private function m_mtaReceiverFind (){
		global $settings, $system;

		$queueId = $this->queue['id'];
		$this->receiver = mysql_fetch_array(mysql_query("SELECT `id`, `firstName`, `lastName`, `email` FROM `$settings[contactBook]` WHERE `email` != '' AND `id` NOT IN(SELECT `contactId` FROM `$settings[mtaLog]` WHERE `queueId` = $queueId) ORDER BY rand() LIMIT 0,1"), MYSQL_ASSOC);
		
// 		print_r($this->receiver);
	}

	private function m_mtaSmtpFind (){
		global $settings, $system;

		$time = time();
		$timeOffset = $time-$settings['timeSlice'];
		$timeDead = $time-900;

		$system->dbm->db->update("`mtaSmtp`", "`status` = 'live'", "`active` = 1 AND `status` = 'dead' AND `lastActivity` < $timeDead");
		$system->dbm->db->select("`id`, `host`, `port`, `auth`, `userName`, `password`, `secure`", "`$settings[mtaSmtp]`", "`active` = 1 AND `status` = 'live' AND `lastActivity` < $timeOffset", "`lastActivity` DESC", "", "", "0,1");
		$this->smtp = $system->dbm->db->fetch_array();
		
// 		print_r($this->smtp);
	}

	public function m_mtaSend ($file){
		global $settings, $system;

		$this->m_mtaSmtpFind();
		$this->m_mtaQueueFind();

		if($this->smtp && $this->queue){
			$this->m_mtaReceiverFind();
				
// 			$system->mail->SMTPDebug = 2; //0 no debug, 1 some debug, 2 full debug
			$system->mail->isSMTP();
// 			$system->mail->Timeout = 10;
			
// 			echo 'host:' . $this->smtp['host'] . '<br>';
// 			echo 'port:' . $this->smtp['port'] . '<br>';
// 			echo 'userName:' . $this->smtp['userName'] . '<br>';
// 			echo 'password:' . $this->smtp['password'] . '<br>';
// 			echo 'secure:' . $this->smtp['secure'] . '<br>';
			
			$system->mail->Host = $this->smtp['host'];// 'mail.digiseo.ir';
			$system->mail->Port = $this->smtp['port'];// '587';
			$system->mail->SMTPAuth = true;
			$system->mail->Username = $this->smtp['userName'];// 'info@digiseo.ir';
			$system->mail->Password = $this->smtp['password'];// 'jyu88y';
			$system->mail->SMTPSecure = $this->smtp['secure'];// 'tls';
			$system->mail->CharSet = 'utf-8';
				
			$system->mail->From = (!empty($this->queue['from'])) ? $this->queue['from'] : $settings['roboMail'];// 'info@digiseo.ir';
			$system->mail->FromName = (!empty($this->queue['fromName'])) ? $this->queue['fromName'] : $settings['domainName'];// 'Digiseo';
			$system->mail->SetFrom($this->queue['from']);
			$system->mail->Subject = $this->queue['subject'];// 'Subject'; 
				
			$system->xorg->smarty->assign("domain", $this->queue['domain']);
			$system->xorg->smarty->assign("subject", $this->queue['subject']);
			$system->xorg->smarty->assign("firstName", $this->receiver['firstName']);
			$system->xorg->smarty->assign("lastName", $this->receiver['lastName']);
			$system->xorg->smarty->assign("image", $this->queue['image']);
			$system->xorg->smarty->assign("message", $this->queue['message']);
			$system->xorg->smarty->assign("link", $this->queue['link']);
			$system->mail->Body = $system->xorg->smarty->fetch($settings[moduleAddress] . "/mta/view/tpl/$file" . $settings['ext4']);// $settings[moduleAddress] . "/mta/view/tpl/$file" . $settings['ext4'];
// 			echo 'Output: ' . $system->xorg->smarty->fetch($settings[moduleAddress] . "/mta/view/tpl/$file" . $settings['ext4']);
			$system->mail->AltBody = $this->queue['message'];// $settings[moduleAddress] . "/mta/view/tpl/$file" . $settings['ext4'];
				
// 			echo 'Email: ' . $this->receiver['email'] . '<br>';
// 			echo 'Name: ' . $this->receiver['firstName'] . ' ' . $this->receiver['lastName'] . '<br>';
			$system->mail->addAddress($this->receiver['email'], $this->receiver['firstName'] . ' ' . $this->receiver['lastName']);
// 			$system->mail->addAddress("s.a.hosseini@gmail.com", 'ali hosseini');
//			$system->mail->addBCC("s.a.hosseini@gmail.com");
			$system->mail->addReplyTo($this->queue['from']);
			$system->mail->isHTML(true);
				
			if($system->mail->send()){
				$this->m_mtaLog();
// 				echo 'SSSS';
			}else{
// 				echo 'Error: ' . $system->mail->ErrorInfo;
				$time = time();
				$smtpId = $this->smtp['id'];
				$system->dbm->db->update("`$settings[mtaSmtp]`", "`status` = 'dead', `lastActivity` = $time", "`id` = $smtpId");
			}
		}else{
			//			echo 'Live SMTP not found.';
		}
	}

	public function m_mtaLog (){
		global $settings, $system;

		$time = time();
		$queueId = $this->queue['id'];
		$receiverId = $this->receiver['id'];
		$smtpId = $this->smtp['id'];
		$system->dbm->db->insert("`$settings[mtaLog]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ox`, `queueId`, `contactId`", "1, $time, 1, 1, 1, 1, $queueId, $receiverId");
		$system->dbm->db->update("`$settings[mtaQueue]`", "`count` = `count`+1", "`id` = $queueId");
		$system->dbm->db->update("`$settings[mtaSmtp]`", "`lastActivity` = $time", "`id` = $smtpId");
	}

}

?>