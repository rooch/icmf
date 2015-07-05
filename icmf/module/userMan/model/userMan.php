<?php
class m_userMan extends masterModule {
	private $moduleName = "userMan";
	public $userTable = "user";
	public $userSettings = "userSettings";
	public $groupTable = "group";
	public $groupMembersTable = "groupMembers";
	private $accessTable = "access";
	private $genderTable = "gender";
	private $countriesTable = "countries";
	private $stateTable = "state";
	private $cityTable = "city";
	private $religionTable = "religion";
	private $statusTable = "status";
	private $levelTable = "level";
	private $pattern;
	function m_userMan() {
		$this->userTable = $this->tablePrefix . $this->userTable;
		$this->accessTable = $this->tablePrefix . $this->accessTable;
		$this->pattern = "dropDown"; // slide
	}
	public function m_signUp($values) {
		global $system, $settings, $lang;
		
		$timeStamp = time ();
		// if(strstr($values['userName'], '@')){
		// $filter = "`email` = '$values[userName]'";
		// $signUpFlag = 'email';
		// }else{
		// $filter = "`userName` = '$values[userName]'";
		// $signUpFlag = 'userName';
		// }
		if ($system->dbm->db->count_records ( "`$this->userTable`", "`email` = '$values[email]'" ) == 0) {
			// if($values['password'] == $values['retypePassword']){
			if (strlen ( $values ['password'] ) >= $settings ['minCharPassword']) {
				if ($_POST ['securityQuestion'] === $system->dbm->db->informer ( "`faqObject`", "`id` = $_POST[securityId]", "answer" )) {
					$password = md5 ( $values ['password'] );
					
					$system->dbm->db->insert ( "`$this->userTable`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `tr`, `tx`, `gid`, `password`, `email`, `uType`", "1, '$timeStamp', 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, '$password', '$values[email]', 2" );
					
					$id = $system->dbm->db->insert_id ();
					
					@mkdir ( "home/$id/images", 0777, true );
					@mkdir ( "home/$id/_thumbs", 0777, true );
					@mkdir ( "home/$id/files", 0777, true );
					
					@fopen ( "home/$id/images/index.html", w );
					@fopen ( "home/$id/_thumbs/index.html", w );
					@fopen ( "home/$id/files/index.html", w );
					
					require_once 'module/basket/model/basket.php';
					m_basket::m_move ( $_SESSION ['uid'], $id );
					$this->m_login ( $id, 2, 2);
					
					$system->watchDog->exception ( 's', $lang ['add'], sprintf ( $lang ['successfulDone'], $lang ['userAdd'], $values ['email'] ) . $lang ['pleaseWait'], null, "setTimeout('location.href=\'/\';', 5000);" );
				} else {
					$system->watchDog->exception ( "e", $lang ['error'], $lang ['securityAnswerIsIncorrect'] );
				}
			} else {
				$system->watchDog->exception ( "e", $lang ['error'], sprintf ( $lang ['passwordIsTooShortMinIs'], $settings ['minCharPassword'] ) );
			}
			// }else{
			// $system->watchDog->exception("e", $lang['error'], $lang['passwordsNotMatch']);
			// }
		} else {
			$system->watchDog->exception ( "e", $lang ['error'], $lang ['userNameExist'] );
		}
	}
	public function m_userAdd($userName, $password) {
		global $system, $lang, $settings;
		
		$timeStamp = time ();
		$password = md5 ( $password );
		$system->dbm->db->insert ( "`$this->userTable`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `tr`, `tx`, `userName`, `password`, `gid`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$userName', '$password', 2" );
		
		$id = $system->dbm->db->insert_id ();
		mkdir ( "home/$id/images", 0777, true );
		mkdir ( "home/$id/_thumbs", 0777, true );
		
		$system->watchDog->exception ( 's', $lang [add], sprintf ( $lang [successfulDone], $lang [userAdd], $userName ) );
	}
	public function m_edit($values) {
		global $system, $settings, $lang;
		
		$religion = (! empty ( $values [religion] )) ? ",`religion` = $values[religion]" : null;
		$financialStatus = (! empty ( $values [financialStatus] )) ? ",`financialStatus` = $values[financialStatus]" : null;
		$level = (! empty ( $values [level] )) ? ",`level` = $values[level]" : null;
		
		$deActiveMobile = ($system->dbm->db->informer ( "`$settings[userTable]`", "`id` = $_SESSION[uid]", "mobile" ) != $values ['mobile']) ? ",`showMobile` = 0 " : ",`showMobile` = 1 ";
		
// 		if ($valuesuTypeype'] == 2) {
// 			$system->dbm->db->update ( "`$this->userTable`", "`userPic` = '$values[userPic]', `coName` = '$values[coName]', `workField` = '$values[workField]', `regTime` = '$values[regTime]', `workDetails` = $values[workDetails], `nationalCode` = '$values[nationalCode]', `state` = $values[state], `issued` = $values[city], `region` = '$values[region]', `district` = '$values[district]', `zipcode` = '$values[zipcode]', `googlePlus` = '$values[googlePlus]', `facebook` = '$values[facebook]', `twitter` = '$values[twitter]', `mobile` = '$values[mobile]' $deActiveMobile, `phone` = '$values[phone]', `address` = '$values[address]'", "`id` = $values[id]" );
// 		} elseif ($values ['uType'] == 1) {
// 			$system->dbm->db->update ( "`$this->userTable`", "`userPic` = '$values[userPic]', `firstName` = '$values[firstName]', `lastName` = '$values[lastName]', `fatherName` = '$values[fatherName]', `gender` = $values[gender], `idNumber` = '$values[idNumber]', `nationalCode` = '$values[nationalCode]', `state` = $values[state], `issued` = $values[city], `region` = '$values[region]', `district` = '$values[district]', `zipcode` = '$values[zipcode]', `nationality` = '$values[nationality]' $religion $financialStatus $level, `googlePlus` = '$values[googlePlus]', `facebook` = '$values[facebook]', `twitter` = '$values[twitter]', `mobile` = '$values[mobile]' $deActiveMobile, `phone` = '$values[phone]', `address` = '$values[address]'", "`id` = $values[id]" );
// 		}
		
		$system->watchDog->exception ( 's', $lang [userEdit], sprintf ( $lang [successfulDone], $lang [userEdit], $system->dbm->db->informer ( "`$this->userTable`", "`id` = $values[id]", "email" ) ), '', "$('#content').farajax('loader', 'userMan/v_profile');$('#modalWindow').faraModal('closeModal', 'modalWindow');" );
	}
	public function m_userDel($filter) {
		global $lang, $settings, $system;
		
		$filter = $system->filterSplitter ( $filter );
		
		$userName = $system->dbm->db->informer ( "$this->userTable", "1 $filter", "userName" );
		// $system->dbm->db->delete("`$this->userTable`", "1 $filter");
		
		$system->watchDog->exception ( "s", $lang [delete], sprintf ( $lang [successfulDone], $lang [delete], $userName ) );
	}
	public function m_userList($filter = null, $viewMode = 'show') {
		global $lang, $settings, $system;
		
		$filter = $system->filterSplitter ( $filter );
		$system->xorg->pagination->paginateStart ( "userMan", "c_userList", "`id`, `active`, `timeStamp`, `uType`, `firstName`, `coName`, `workField`, `regTime`, `workDetails`, `lastName`, `fatherName`, `userName`, `userPic`, `gender`, `idNumber`, `nationalCode`, `nationalCode`, `state`, `issued`, `region`, `district`, `zipcode`, `address`, `nationality`, `religion`, `financialStatus`, `level`, `mobile`, `showMobile`, `phone`, `email`, `showEmail`, `googlePlus`, `facebook`, `twitter`", "`$this->userTable`", "1 $filter", "`timeStamp` ASC" );
		
		$count = 1;
		while ( $row = $system->dbm->db->fetch_array () ) {
			$userList [$count] ['count'] = $count;
			$userList [$count] ['id'] = $id = $row [id];
			$userList [$count] ['active'] = $row [active] == 1 ? $lang [active] : $lang [notActive];
			$userList [$count] ['timeStamp'] = $system->time->iCal->dator ( $row [timeStamp] );
			$userList [$count] ['uType'] = $row [uType];
			$userList [$count] ['firstName'] = $row [firstName];
			$userList [$count] ['coName'] = $row [coName];
			$userList [$count] ['workField'] = $row [workField];
			$userList [$count] ['regTime'] = $row [regTime];
			$userList [$count] ['workDetails'] = $row [workDetails];
			$userList [$count] ['lastName'] = $row [lastName];
			$userList [$count] ['fatherName'] = $row [fatherName];
			$userList [$count] ['userName'] = $userName = $row [userName];
			$userList [$count] ['userPic'] = (empty ( $row [userPic] ) ? "theme/$settings[theme]/img/defaultUserPic.jpg" : "$row[userPic]");
			$userList [$count] ['genderId'] = $row [gender];
			$userList [$count] ['gender'] = $system->dbm->db->informer ( "`$this->genderTable`", "`id` = $row[gender]", 'name' );
			$userList [$count] ['idNumber'] = $row [idNumber];
			$userList [$count] ['nationalCode'] = $row [nationalCode];
			$userList [$count] ['nationalityId'] = $row [nationality];
			$userList [$count] ['nationality'] = $system->dbm->db->informer ( "`$this->countriesTable`", "`id` = $row[nationality]", 'name' );
			$userList [$count] ['issuedId'] = $row [issued];
			$userList [$count] ['issued'] = $system->dbm->db->informer ( "`$this->cityTable`", "`id` = $row[issued]", 'name' );
			$userList [$count] ['stateId'] = $row [state];
			$userList [$count] ['state'] = $system->dbm->db->informer ( "`$this->stateTable`", "`id` =  $row[state]", 'name' );
			$userList [$count] ['regionId'] = $row [region];
			$userList [$count] ['region'] = $system->dbm->db->informer ( "`$settings[region]`", "`id` =  $row[region]", 'name' );
			$userList [$count] ['districtId'] = $row [district];
			$userList [$count] ['district'] = $system->dbm->db->informer ( "`$settings[district]`", "`id` =  $row[district]", 'name' );
			$userList [$count] ['address'] = $row [address];
			$userList [$count] ['zipcode'] = $row [zipcode];
			$userList [$count] ['religionId'] = $row [religion];
			$userList [$count] ['religion'] = $system->dbm->db->informer ( "`$this->religionTable`", "`id` = $row[religion]", 'name' );
			$userList [$count] ['financialStatusId'] = $row [financialStatus];
			$userList [$count] ['financialStatus'] = $system->dbm->db->informer ( "`$this->statusTable`", "`id` = $row[financialStatus]", 'name' );
			$userList [$count] ['levelId'] = $row [level];
			$userList [$count] ['level'] = $system->dbm->db->informer ( "`$this->levelTable`", "`id` = $row[level]", 'name' );
			$userList [$count] ['googlePlus'] = $row ['googlePlus'];
			$userList [$count] ['facebook'] = $row ['facebook'];
			$userList [$count] ['twitter'] = $row ['twitter'];
			$userList [$count] ['mobile'] = $row [mobile];
			$userList [$count] ['showMobile'] = $row [showMobile];
			$userList [$count] ['phone'] = $row [phone];
			$userList [$count] ['email'] = $row [email];
			$userList [$count] ['showEmail'] = $row [showEmail];
			$count ++;
		}
		
		$system->xorg->smarty->assign ( "navigation", $system->xorg->pagination->renderFullNav () );
		$system->xorg->smarty->assign ( "userList", $userList );
		if ($count > 2) {
			$system->xorg->smarty->display ( $settings [moduleAddress] . "/" . $this->moduleName . "/view/tpl/userList" . $settings [ext4] );
		} else {
			if ($viewMode == 'show') {
				$system->xorg->smarty->display ( $settings [moduleAddress] . "/" . $this->moduleName . "/view/tpl/profile" . $settings [ext4] );
			} elseif ($viewMode == 'home') {
				if ($system->dbm->db->count_records ( "`user`", "`userName` = '$userName'" ) == 1) {
					require_once 'module/post/model/post.php';
					$system->xorg->smarty->assign ( "postList", m_post::m_listObject ( 'showList', 'author=' . $id ) );
					require_once 'module/comment/model/comment.php';
					$system->xorg->smarty->assign ( "commentList", m_comment::m_listObject ( 'showListObjectSimple', 'uid=' . $id . ',op=post' ) );
					$system->xorg->smarty->assign ( "personalPage", $system->dbm->db->informer("`$settings[userExtraInfo]`", "`uid` = $id", "pageSource"));					
					
					$system->xorg->smarty->display ( $settings [moduleAddress] . "/" . $this->moduleName . "/view/tpl/home" . $settings ['ext4'] );
				} else {
					$system->xorg->smarty->display ( $settings [commonTpl] . "404" . $settings ['ext4'] );
				}
			}
		}
	}
	public function m_login($uid, $uType, $gid, $firstName = null, $lastName = null, $email = null) {
		global $lang, $system;
			
// 		echo 'Uid: '. $uid . '<br>';
// 		echo 'uType: '. $uType . '<br>';
// 		echo 'gid: '. $gid . '<br>';
// 		echo 'firstName: '. $firstName . '<br>';
// 		echo 'lastName: '. $lastName . '<br>';
// 		echo 'email: '. $email . '<br>';
		$system->security->session->manager ( $uid, $uType, $gid, $firstName, $lastName, $email );
		$system->xorg->smarty->assign ( "uid", $uid );
		$system->xorg->smarty->assign ( "uTyle", $uType );
		$system->xorg->smarty->assign ( "gid", $gid );
		$system->xorg->smarty->assign ( "firstName", $firstName );
		$system->xorg->smarty->assign ( "lastName", $lastName );
		$system->xorg->smarty->assign ( "email", $email );
		
		$this->m_loginContent ();
	}
	function m_loginContent() {
		global $lang, $system, $settings;
		
		if ($_SESSION ['uid'] && $_SESSION['uType'] > 1) {
			$res = mysql_query ( "SELECT `gender`, `firstName`, `lastName`, `userName`, `userPic`, `email` FROM `$this->userTable` WHERE `id` = $_SESSION[uid]" );
			$profile = mysql_fetch_array ( $res );
			
			if ($profile ['gender'] == 1) {
				$genderType = $lang ['mr'];
			} elseif ($profile ['gender'] == 2) {
				$genderType = $lang ['ms'];
			} else {
				$genderType = $lang ['user'];
			}
			$showName = ! empty ( $profile ['firstName'] ) || ! empty ( $profile ['lastName'] ) ? $profile ['firstName'] . " " . $profile ['lastName'] : $profile ['email'];
			$imgTmp = explode ( ",", $profile ['userPic'] );
			$profile [userPic] = $imgTmp [0];
			$system->xorg->smarty->assign ( "userPic", empty ( $profile ['userPic'] ) ? "theme/$settings[theme]/img/defaultUserPic.jpg" : $profile ['userPic'] );
			$system->xorg->smarty->assign ( "loginFlag", true );
			
			$system->xorg->smarty->assign ( "welcomeMessage", sprintf ( $lang ['welcomeMessage'], $genderType, "<b>$showName</b>" ) );
			if (file_exists ( $settings ['commonTpl'] . $this->moduleName . '/welcomeMessage' . $settings ['ext4'] )) {
				return $system->xorg->smarty->display ( $settings ['commonTpl'] . $this->moduleName . "/welcomeMessage" . $settings ['ext4'] );
			} else {
				return $system->xorg->smarty->display ( $settings ['moduleAddress'] . "/" . $this->moduleName . "/view/tpl/welcomeMessage" . $settings ['ext4'] );
			}
		} else {
			$system->xorg->smarty->assign ( "welcomeMessage", sprintf ( $lang ['welcomeMessage'], "", $lang ['guest'] ) );
			if (file_exists ( $settings ['commonTpl'] . $this->moduleName . '/login' . $settings ['ext4'] )) {
				return $system->xorg->smarty->display ( $settings ['commonTpl'] . $this->moduleName . '/login' . $settings ['ext4'] );
			} else {
				return $system->xorg->smarty->display ( $settings ['moduleAddress'] . "/" . $this->moduleName . "/view/tpl/login" . $settings ['ext4'] );
			}
		}
	}
	public function m_menu($pattern = "dropDown") {
		global $system, $lang, $settings;
		
		return $system->xorg->smarty->display ( $settings [commonTpl] . 'menu' . $settings [ext4] );
	}
	public function m_logout() {
		global $system, $lang, $settings;
		
		$uid = $_SESSION [uid];
		$system->security->session->kill ( $_SESSION [uid] );
		$system->watchDog->exception ( "s", $lang [logout], sprintf ( $lang [successfulDone], $lang [logout], $system->dbm->db->informer ( "`$this->userTable`", "`id` = $uid", 'email' ) ) );
	}
	public function m_setSettings($name, $value) {
		global $system, $lang, $settings;
		
		$timeStamp = time ();
		if ($system->dbm->db->count_records ( "`$this->userSettings`", "`uid` = $_SESSION[uid] AND `name` = '$name'" ) > 0) {
			$system->dbm->db->update ( "`$this->userSettings`", "`value` = '$value'", "`uid` =  $_SESSION[uid] AND `name` = '$name'" );
			$_SESSION [lang] = $value;
		} else {
			$system->dbm->db->insert ( "`$this->userSettings`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `uid`, `name`, `value`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, $_SESSION[uid], '$name', '$value'" );
			$_SESSION [lang] = $value;
		}
		if ($_SESSION [uid] == 2) {
			$_SESSION [lang] = $value;
		}
		require_once 'module/cPanel/model/cPanel.php';
		$cPanel = new m_cPanel ();
		$cPanel->m_emptyCache ( false );
		$system->watchDog->exception ( "s", $lang [setSettings], sprintf ( $lang [successfulDone], $lang [setSettings], $lang [$name] ) . "<br>" . $lang [reloadPageForSetChanges], null, "setTimeout('location.href=\'/\';', 1000);" );
	}
	public function m_remember($userName) {
		global $settings, $lang, $system;
		
		if (isset ( $userName )) {
			$code = rand ( 1111, 99999999 );
			
			if (strstr ( $userName, '@' )) {
				echo 'a';
				$to ['email'] = $system->dbm->db->informer ( "`$settings[userTalbe]`", "`email` = '$userName'", "email" );
				$system->dbm->db->update ( "`$settings[userTalbe]`", "`passReset` = '$code'", "`email` = '$userName'" );
			} elseif (is_numeric ( $userName )) {
				echo 'b';
				$to ['mobile'] = $system->dbm->db->informer ( "`$settings[userTalbe]`", "`mobile` = '$userName'", "mobile" );
				$system->dbm->db->update ( "`$settings[userTalbe]`", "`passReset` = '$code'", "`id` = '$_SESSION[uid]'" );
			}
		}
		
		if ($to) {
			if (! empty ( $to ['mobile'] )) {
				require_once 'module/sms/config/config.php';
				require_once 'module/sms/model/sms.php';
				m_sms::m_addObject ( $to ['mobile'], $code, '', false );
				echo "SMS-> To: $to[mobile] Code: $code";
			}
			if (! empty ( $to ['email'] )) {
				$system->mail->CharSet = 'utf-8';
				
				$system->mail->From = $settings ['roboMail'];
				$system->mail->FromName = $settings ['domainName'];
				$system->mail->Subject = $lang ['resetCodeSuccessfullSent'];
				
				$system->xorg->smarty->assign ( "subject", $lang ['resetCodeSuccessfullSent'] );
				$system->xorg->smarty->assign ( "message", 'Code: ' . $code );
				$system->mail->Body = $system->xorg->smarty->fetch ( $settings ['moduleAddress'] . "/mta/view/tpl/message" . $settings ['ext4'] );
				
				$system->mail->addAddress ( $to ['email'] );
				$system->mail->addReplyTo ( $settings ['roboMail'] );
				$system->mail->isHTML ( true );
				
				$system->mail->send ();
				echo "Email-> To: $to[email] Code: $code";
			}
			
			$system->watchDog->exception ( "s", $lang [successful], $lang [resetCodeSuccessfullSent] );
		} else {
			$system->watchDog->exception ( "e", $lang [warning], $lang [userNotExist] );
		}
	}
	public function m_emActivation($values) {
		global $system, $lang, $settings;
		
		if (! empty ( $values ['userName'] )) {
			if (strstr ( $values ['userName'], '@' )) {
				$passReset = $system->dbm->db->informer ( "`$settings[userTalbe]`", "`id` = '$_SESSION[uid]'", "passReset" );
				
				if (! empty ( $values ['verificationCode'] )) {
					if ($values ['verificationCode'] == $passReset) {
						$system->dbm->db->update ( "`$settings[userTalbe]`", "`showEmail` = 1, `passReset` = ''", "`id` = '$_SESSION[uid]'" );
					}
				}
			} elseif (is_numeric ( $values ['userName'] )) {
				$passReset = $system->dbm->db->informer ( "`$settings[userTalbe]`", "`id` = '$_SESSION[uid]'", "passReset" );
				if (! empty ( $values ['verificationCode'] )) {
					if ($values ['verificationCode'] == $passReset) {
						// echo 'mobile: ' . $system->dbm->db->informer("`$settings[userTable]`", "`id` = $_SESSION[uid]", "mobile") == '';
						if ($system->dbm->db->informer ( "`$settings[userTable]`", "`id` = $_SESSION[uid]", "mobile" ) == '')
							$system->dbm->db->update ( "`$settings[userTalbe]`", "`mobile` = '$values[userName]', `showMobile` = 1, `passReset` = ''", "`id` = '$_SESSION[uid]'" );
						else
							$system->dbm->db->update ( "`$settings[userTalbe]`", "`showMobile` = 1, `passReset` = ''", "`id` = '$_SESSION[uid]'" );
					}
				}
			}
		} elseif (! empty ( $values ['setUserName'] )) {
			if ($system->dbm->db->count_records ( "`user`", "`userName` = '$values[setUserName]'" ) == 0) {
				if(preg_match("/^[A-Za-z][A-Za-z0-9_-]{3,45}$/", $values[setUserName])){
					$system->dbm->db->update ( "`$settings[userTalbe]`", "`userName` = '$values[setUserName]'", "`id` = '$_SESSION[uid]'" );
				}else{
					$system->watchDog->exception ( "e", $lang ['error'], $lang ['userNameContainValidCharacter'] );
				}
			} else {
				$system->watchDog->exception ( "e", $lang ['error'], $lang ['userNameExist'] );
			}
		} else {
			$system->watchDog->exception ( "e", $lang ['error'], $lang ['pleaseEnterValidData'] );
		}
		$system->watchDog->exception ( "s", $lang ['successful'], $lang ['successActivation'], '', "$('#content').farajax('loader', '/userMan/v_profile');" );
	}
	public function m_resetPass($userName, $code, $newPassword) {
		global $settings, $lang, $system;
		
		$passReset = $system->dbm->db->informer ( "`$settings[userTalbe]`", "`userName` = '$userName' OR `email` = '$userName'", "passReset" );
		if ($passReset) {
			if ($passReset == $code) {
				$newPassword = md5 ( $newPassword );
				$system->dbm->db->update ( "`$settings[userTalbe]`", "`password` = '$newPassword', `passReset` = ''", "`userName` = '$userName' OR `email` = '$userName'" );
				$system->watchDog->exception ( "s", $lang [successful], $lang [passwordSuccessfullyChanged] );
			} else {
				$system->watchDog->exception ( "e", $lang [warning], $lang [codeIsIncorrect] );
			}
		} else {
			$system->watchDog->exception ( "e", $lang [warning], $lang [userNotExist] );
		}
	}
	
	public function m_personalPage ($values){
		global $system, $settings, $lang;
		
		$timeStamp = time();
		if($system->dbm->db->count_records("`$settings[userExtraInfo]`", "`uid` = $_SESSION[uid]") == 0){
			$system->dbm->db->insert("`$settings[userExtraInfo]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gx`, `tr`, `tx`, `ur`, `ux`, `uid`, `pageSource`", "1, $timeStamp, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, $_SESSION[uid], '$values[pageSource]'");
		}else{
			$system->dbm->db->update("`$settings[userExtraInfo]`", "`timeStamp` = $timeStamp, `pageSource` = '$values[pageSource]'");
		}
		$system->watchDog->exception ( "s", $lang ['successful'], $lang ['persoanlPageSuccessfullChanged'] );
	}
	
	public function m_accDeny() {
		global $system, $settings, $lang;
		
		$system->dbm->db->select ( "*", "`faqObject`", "", "rand()", "", "", "0,1" );
		$system->xorg->smarty->assign ( "securityQuestion", $row = $system->dbm->db->fetch_array () );
		$system->watchDog->exception ( "w", $lang [securityWarning], $system->xorg->smarty->fetch ( $settings ['moduleAddress'] . "/userMan/view/tpl/" . "accDeny" . $settings ['ext4'] ) );
	}
}
?>