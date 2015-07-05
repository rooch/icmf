<?php
class m_organization extends masterModule{

	public $tree;

	public function m_organization(){

	}
	###########################
	# Object (organization)   #
	###########################
	// Add Object
	public function m_addObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		
		$mBirthday = $system->time->iCal->birthtime($_POST[mStartYear], $_POST[mStartMonth], $_POST[mStartDay]);
		$system->dbm->db->insert("`firstName`, `lastName`, `fatherName`, `idNo`, `nationalNumber`, `birthday`, `issue`, `nationality`, `provience`, `city`, `address`, `phoneCode`, `phoneNumber`, `mobile`, `fax`, `email`", '$_POST[mFirstName]', '$_POST[mLastName]', '$_POST[mFatherName]', $_POST[mIdNo], $_POST[mNationalNumber], $mBirthday, $_POST[nIssue], $_POST[mNationality], $_POST[mProvience], $_POST[mCity], '$_POST[mAddress]', '$_POST[mPhoneCode]', $_POST[mPhoneNumber], '$_POST[mMobile]', $_POST[mFax], '$_POST[mEmail]');
		$mId = $system->dbm->db->insert_id();
		
		$eBirthday = $system->time->iCal->birthtime($_POST[eStartYear], $_POST[eStartMonth], $_POST[eStartDay]);
		$system->dbm->db->insert("`firstName`, `lastName`, `fatherName`, `idNo`, `nationalNumber`, `birthday`, `issue`, `nationality`, `provience`, `city`, `address`, `phoneCode`, `phoneNumber`, `mobile`, `fax`, `email`", '$_POST[eFirstName]', '$_POST[eLastName]', '$_POST[eFatherName]', $_POST[eIdNo], $_POST[eNationalNumber], $eBirthday, $_POST[nIssue], $_POST[eNationality], $_POST[eProvience], $_POST[eCity], '$_POST[eAddress]', '$_POST[ePhoneCode]', $_POST[ePhoneNumber], '$_POST[eMobile]', $_POST[eFax], '$_POST[eEmail]');
		$eId = $system->dbm->db->insert_id();
		
		$system->dbm->db->insert("`name`, `parent`, `ministry`, `field`, `nationalCode`, `address`, `state`, `city`, `zipcode`, `manager`, `expert`", "'$_POST[oName]', '$_POST[oParent]', '$_POST[oMinistry]', '$_POST[oField]', $_POST[oNationalCode], '$_POST[oAddress]', $_POST[oState], $_POST[oCity], $_POST[oZipCode], $mId, $eId");
		$oId = $system->dbm->db->insert_id();
		
		for($i=1; $i==10; $i++){
			if($_POST['pName' . $i] && $_POST['pUrl' . $i]){
				$pOrganization = $oId;
				$pName = $_POST['pName' . $i];
				$pUrl = $_POST['pUrl' . $i];
				$pPriority = $_POST['pPriority' . $i];
				$pField = $_POST['pField' . $i];
				$pServiceType = $_POST['pServiceType' . $i];
				$pSoftware = $_POST['pSoftware' . $i];
				$pDb = $_POST['pDb' . $i];
				$pHost = $_POST['pHost' . $i];
				
				$system->dbm->db->insert("`organization`, `name`, `url`, `priority`, `field`, `serviceType`, `software`, `database`, `host`", "$oId, '$pName', '$pUrl', $pPriority, '$pField', $pServiceType, $pSoftware, $pDb, '$pHost'");
			}
		}
		
		$insertId = $system->dbm->db->insert_id();
		
		$system->watchDog->exception("s", $lang[organizationAdd], sprintf($lang[successfulDone], $lang[organizationAdd], $values[title]) . "<br>کد رهگیری: $insertId");
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->update("`$settings[organizationObject]`", "`timeStamp` = $timeStamp, `title` = '$values[title]', `` = '$values[model]', `company` = $values[company], `count` = $values[count], `category` = $values[category], `announceDate` = '$values[announceDate]', `dimension` = '$values[dimension]', `weight` = '$values[weight]', `color` = '$values[color]', `link` = '$values[link]', `keyWords` = '$values[keyWords]', `buyPrice` = '$values[buyPrice]', `description` = '$values[description]', `imagePath` = '$values[ImagePath]', `filePath` = '$values[FilePath]'", "`id` = $values[id]");

		$system->watchDog->exception("s", $lang[organizationEdit], sprintf($lang[successfulDone], $lang[organizationEdit], $values[name]));
	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$title = $system->dbm->db->informer("`$settings[organizationObject]`", "`id` = $id", "title");
		$system->dbm->db->delete("`$settings[organizationObject]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[organizationDel], sprintf($lang[successfulDone], $lang[delete], $title));
	}
	// List Object
	public function m_listObject($viewMode, $filter=null){
		global $system,$lang, $settings;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("organization", "c_$viewMode", "`active`, `id`, `title`, `category`, `description`, `startTime`, `endTime`, `resources`, `filePath`, `imagePath`, `author`", "`$settings[organizationObject]`", "1 $filter", "`timeStamp` DESC", "", "", "", "", 20, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][title] = $row[title];
			$entityList[$count][category] = $system->dbm->db->informer("`$settings[organizationCategory]`", "`id` = $row[category]", 'name');
			$entityList[$count][description] = $row[description];
			$entityList[$count][startTime] = $system->time->iCal->dator($row[startTime]);
			$entityList[$count][endTime] = $system->time->iCal->dator($row[endTime]);
			$entityList[$count][resources] = $row[resources];
			$entityList[$count][filePath] = $row[filePath];
			$row[imagePath] = explode(",", $row[imagePath]);
			$entityList[$count][imagePath] = $row[imagePath][0];
			$entityList[$count][author] = $system->dbm->db->informer("`$settings[userTable]`", "`id` = $row[author]", 'userName');
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
	// Feed Object
	public function m_feedObject($source, $count){
		global $system, $settings;
		
		if($_SESSION[uid] == 1){
			$feeds = $system->rss->load($source, $count);
			foreach ($feeds[items] as $item){
				if($system->dbm->db->count_records("`$settings[organizationObject]`", "`title` = '$item[title]'") == 0)
				$this->m_addObject($item);	
			}
		}
	}

}
?>