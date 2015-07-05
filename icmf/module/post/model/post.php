<?php
class m_post extends masterModule{

	public $tree;

	public function m_post(){

	}
	###########################
	# Category                #
	###########################
	// Add Category
	public function m_addCategory($name, $category, $description=null){
		global $system, $lang, $settings;

		$timeStamp = time();
		$system->dbm->db->insert("`$settings[postCategory]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `name`, `category`, `description`", "1, $timeStamp, $_SESSION[uid], 7, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$name', $category, '$description'");
		$system->watchDog->exception("s", $lang['categoryAdd'], sprintf($lang['successfulDone'], $lang['categoryAdd'], $name));
	}
	// Edit Category
	public function m_editCategory($id, $name, $category=null, $description=null){
		global $system, $lang, $settings;

		$system->dbm->db->update("`$settings[postCategory]`", "`name` = '$name', `category` = '$category', `description` = '$description'", "`id` = $id");
		$system->watchDog->exception("s", $lang[editCategory], sprintf($lang[successfulDone], $lang[editCategory], $name));
	}
	// Del Category
	public function m_delCategory($id){
		global $system, $lang, $settings;

		$name = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = $id", "name");
		$system->dbm->db->delete("`$settings[postCategory]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[categoryDel], sprintf($lang[successfulDone], $lang[delete], $name));
	}
	// List Category
	public function m_listCategory(){
		global $system,$lang, $settings;

		$system->xorg->pagination->paginateStart("post", "c_listCategory", "`active`, `id`, `name`, `category`, `description`", "`$settings[postCategory]`", "", "`timeStamp` DESC", "", "", "", "", 50, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count][num] = $count;
			$entityList[$count][active] = $row[active];
			$entityList[$count][id] = $row[id];
			$entityList[$count][name] = $row[name];
			$entityList[$count][category] = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = $row[category]", 'name');
			//			$entityList[$count][description] = $row[description];
			$count++;
		}
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		//		print_r($entityList);
		unset($entityList);
		$entityList = array();
		//		print "List";
		//		print_r($entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/category/list" . $settings[ext4]);

	}
	// Activate Category
	public function m_activateCategory(){

	}
	// Deactivate Category
	public function m_deactivateCategory(){

	}
	// Find HierarchicalCategory
	public function m_hierarchicalCategoryFinder($categories){
		global $system, $settings;

		foreach ($categories as $key => $category){
			$hierarchicalList[$category] = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = $category", "name");
		}

		$system->xorg->smarty->assign("hierarchicalList", $hierarchicalList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/" . $settings[moduleName] . "/view/tpl/hierarchicalCategory" . $settings[ext4]);
	}

	public function m_hierarchicalListCategory($category, $level=0, $flag=0){
		global $system, $lang, $settings;

		$result = mysql_query("SELECT `id`, `category`, `name` FROM `$settings[postCategory]` WHERE `category` = $category");
// 		echo "SELECT `id`, `category`, `name` FROM `$settings[postCategory]` WHERE `category` = $category";
		if(!empty($result)){
			if($flag == 1)
			$this->tree .= str_repeat("\t", $level+1) . "<ul>\n";
			while ($row = mysql_fetch_array($result)){
				$res = mysql_query("SELECT `id` FROM `$settings[postCategory]` WHERE `category` = $row[id]");
				if(mysql_num_rows($res) > 0){
					$this->tree .= str_repeat("\t", $level+2) . "<li rel='$row[id]'>$row[name]\n";
					$this->m_hierarchicalListCategory($row['id'], $level+1, 1);
					$this->tree .= str_repeat("\t", $level+2) . "</li>\n";
				}else{
					$this->tree .= str_repeat("\t", $level+2) . "<li rel='$row[id]'>$row[name]</li>\n";
				}
			}
			if($flag == 1)
			$this->tree .= str_repeat("\t", $level+1) . "</ul>\n";
		}
		return $this->tree;
	}
	###########################
	# Object (post)        #
	###########################
	// Add Object
	public function m_addObject($values, $show=false){
		global $system, $lang, $settings;

		$timeStamp = time();
		$values[category] = empty($values[category]) ? 0 : $values[category];
		if(empty($values[startYear])){
			$values[startTime] = time();
		}else{
			$startTime = $system->time->iCal->geoimport($values[startYear], $values[startMonth], $values[startDay], $values[startHour], $values[startMinute]);
			if($startTime < time()){
				$values[startTime] = time();
			}else{
				$values[startTime] = $startTime;
			}
		}
		$values[endTime] = empty($values[endYear]) ? 0 : $system->time->iCal->geoimport($values[endYear], $values[endMonth], $values[endDay], $values[endHour], $values[endMinute], 59);

		if(empty($values[contentPath])){
			preg_match('/src="(.+?)"/', $values['description'], $result);
			if($result){
				$values[contentPath] = $result[1];
				str_replace($result[0], '', $values['description']);
			}
		}
		
		$system->seo->seo(null, $values['description']);
		$brief = trim($system->seo->p());
		
		if($_SESSION['uid'] == 1 || $_SESSION['gid'] == 1){
			$system->dbm->db->insert("`$settings[postObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `title`, `brief`, `description`, `category`, `startTime`, `endTime`, `resources`, `filePath`, `contentType`, `contentPath`, `author`, `emailPublish`, `smsPublish`", "1, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[title]', '$brief', '$values[description]', $values[category], '$values[startTime]', '$values[endTime]', '$values[resources]', '$values[fileSinglePath2]', '$values[contentType]', '$values[fileSinglePath1]', $_SESSION[uid], $values[emailPublish], $values[smsPublish]");
			$id = $system->dbm->db->insert_id();
	
			if($settings['enableSendSMS'] && $values['smsPublish']){
				$system->dbm->db->select("`mobile`", "`$settings[contactBook]`", "`mobile` <> ''", "rand()", '', '', '0,49');
				while ($row = $system->dbm->db->fetch_array()){
					if(!empty($row[mobile]))
					$to .= $row[mobile] . ",";
				}
	
				require_once 'module/sms/config/config.php';
				require_once 'module/sms/model/sms.php';
				m_sms::m_addObject($to, "$values[title] ...\n $lang[continueAt] \n $settings[domainName]" , '', false);
			}
	
			if($settings['enableSendEmail'] && $values['emailPublish']){
				require_once 'module/mta/config/config.php';
				require_once 'module/mta/model/mta.php';
				m_mta::m_addMtaQueue ($values['domain'], $values['title'], $brief . ' ...', "post/c_showListObject/" . $id . "_" . str_ireplace(' ', '-', trim($values['title'])), $values['fileSinglePath1'], 'newsletter@' . $values['domain'], 'newsletter');
			}
	
			if($show == true)
			$system->watchDog->exception("s", $lang['postAdd'], sprintf($lang[successfulDone], $lang[postAdd], $values[title]), '', "setTimeout('$(\'#content\').farajax(\'loader\', \'/post/c_listObject\')', 3000);");
		}else{
			$system->dbm->db->insert("`$settings[postObject]`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `gw`, `gx`, `tr`, `tx`, `ur`, `ux`, `title`, `brief`, `description`, `category`, `startTime`, `endTime`, `resources`, `filePath`, `contentType`, `contentPath`, `author`, `emailPublish`, `smsPublish`", "0, $timeStamp, $_SESSION[uid], 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '$values[title]', '$brief', '$values[description]', $values[category], '$values[startTime]', '$values[endTime]', '$values[resources]', '$values[fileSinglePath2]', '$values[contentType]', '$values[fileSinglePath1]', $_SESSION[uid], $values[emailPublish], $values[smsPublish]");
			if($show == true)
			$system->watchDog->exception("s", $lang['postAdd'], sprintf($lang['successfulDone'], $lang['postAdd'], $values['title']) . 'و بعد از تایید توسط مدیر درون سایت قرار می‌گیرد.');
		}
	}
	// Edit Object
	public function m_editObject($values){
		global $system, $lang, $settings;

		$timeStamp = time();
		$values[category] = empty($values[category]) ? 0 : $values[category];
		if(!empty($values[startYear])){
			$startTime = $system->time->iCal->geoimport($values[startYear], $values[startMonth], $values[startDay], $values[startHour], $values[startMinute]);
			$values[startTime] = $startTime;
		}
		$values[endTime] = empty($values[endYear]) ? 0 : $system->time->iCal->geoimport($values[endYear], $values[endMonth], $values[endDay], $values[endHour], $values[endMinute], 59);

		if(empty($values[contentPath])){
			preg_match('/src="(.+?)"/', $values[description], $result);
			if($result){
				$values[contentPath] = $result[1];
				str_replace($result[0], '', $values[description]);
			}
		}
		
		$system->seo->seo($values['description']);
		$brief = trim($system->seo->p());
		
		$system->dbm->db->update("`$settings[postObject]`", "`title` = '$values[title]', `brief` = '$brief', `description` = '$values[description]', `category` = $values[category], `startTime` = $values[startTime], `endTime` = $values[endTime], `resources` = '$values[resources]', `filePath` = '$values[fileSinglePath2]', `contentType` = '$values[contentType]', `contentPath` = '$values[fileSinglePath1]'", "`id` = $values[id]");

		$system->watchDog->exception("s", $lang[postEdit], sprintf($lang[successfulDone], $lang[postEdit], $values[title]));
	}
	// Del Object
	public function m_delObject($id){
		global $system, $lang, $settings;

		$title = $system->dbm->db->informer("`$settings[postObject]`", "`id` = $id", "title");
		$system->dbm->db->delete("`$settings[postObject]`", "`id` = $id");
		$system->watchDog->exception("s", $lang[postDel], sprintf($lang[successfulDone], $lang[delete], $title));
	}
	// List Object
	public function m_listObject($viewMode, $filter=null, $sort=null){
		global $system,$lang, $settings;

		$time = time();

		if(strstr($filter, '_')){
			$filter = explode("_", $filter);
			$id = $filter[0];
			$filter = "id=$id";
			$filterFlag = 1;
			$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
			$system->dbm->db->update("`$settings[postObject]`", "`viewCount` = `viewCount`+1", "`id` = $id");
			
			$system->xorg->pagination->paginateStart("post", "c_$viewMode" . 'Object', "`active`, `id`, `title`, `category`, `description`, `startTime`, `endTime`, `resources`, `filePath`, `contentType`, `contentPath`, `author`, `viewCount`", "`$settings[postObject]`", "`active` = 1 AND `startTime` < $time $filter");
		}else{
			$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
			$sort = !empty($sort) ? $sort : 'timeStamp DESC';
			$system->xorg->pagination->paginateStart("post", "c_$viewMode" . 'Object', "`active`, `id`, `title`, `category`, `startTime`, `brief`, `contentType`, `contentPath`, `viewCount`", "`$settings[postObject]`", "(`category` < 20 OR `category` > 26) AND `active` = 1 AND `startTime` < $time $filter", "$sort", "", "", "", "", 5, 7);
		}

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['active'] = $row['active'];
			$entityList[$count]['id'] = $row['id'];
			$entityList[$count]['category'] = 
			$entityList[$count]['contentType'] = $row['contentType'];
			$entityList[$count]['title'] = $row['title'];
			$entityList[$count]['brief'] = $row['brief'];
			$entityList[$count]['contentPath'] = $row['contentPath'];
			$entityList[$count]['viewCount'] = $viewCount = $row['viewCount'];
			$entityList[$count]['startTime'] = $system->time->iCal->dator($row['startTime'], 2);
			$entityList[$count]['dayCount'] = $dayCount = floor(($time - $row['startTime']) / 86400);
			$entityList[$count]['weight'] = round($viewCount/$dayCount, 2);
			$entityList[$count]['category'] = $system->dbm->db->informer("`$settings[postCategory]`", "`id` = $row[category]", 'name');
				
			if($filterFlag == 1){
				$author = $system->dbm->db->informer("`$settings[userTable]`", "`id` = $row[author]");
				$entityList[$count]['author'] = $author['userName'];
				$entityList[$count]['authorFirstName'] = $author['firstName'];
				$entityList[$count]['authorLastName'] = $author['lastName'];
				$entityList[$count]['googlePlus'] = $author['googlePlus'];
				$entityList[$count]['facebook'] = $author['facebook'];
				$entityList[$count]['twitter'] = $author['twitter'];
				$entityList[$count]['authorPic'] = $author['userPic'];
				$entityList[$count]['description'] = $row['description'];
				
				$entityList[$count]['startTimeDateTime'] = $system->time->iCal->dator($row['startTime'], 'dateTime');
//				$entityList[$count][endTime] = $system->time->iCal->dator($row[endTime], 2);
//				$entityList[$count][endTimeDateTime] = $system->time->iCal->dator($row[endTime], 'dateTime');
				$entityList[$count][resources] = nl2br($row[resources]);
				if(!empty($row[filePath])){
					$attachs = explode(",", $row[filePath]);
					foreach ($attachs as $attach) {
						$filePath .= "<a href='$attach'>$attach</a><br>";
					}
					$entityList[$count][filePath] = $filePath;
				}
				
				require_once 'module/comment/config/config.php';
				require_once 'module/comment/model/comment.php';
				$m_comment = new m_comment();
				$entityList[$count][comments] = $m_comment->m_listObject('showListObject', "op=post,opid=$row[id]"); 
			}
			$count++;
		}

		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->display($settings[moduleAddress] . "/post/view/tpl/object/$viewMode" . $settings[ext4]);
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
				if($system->dbm->db->count_records("`$settings[postObject]`", "`title` = '$item[title]'") == 0)
				$this->m_addObject($item);
			}
		}
	}
	
	public function m_rssFeed($filter=null){
		global $system, $settings;
		
		$time = time();

		$system->dbm->db->select("`id`, `timeStamp`, `title` , `brief`, `contentType`, `contentPath`", "`$settings[postObject]`", "(`category` < 20 OR `category` > 26) AND `active` = 1 AND `startTime` < $time $filter", "`timeStamp` DESC", "", "", "0,10");
		
		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			$entityList[$count]['num'] = $count;
			$entityList[$count]['id'] = $row['id'];
			$entityList[$count]['timeStamp'] = $system->time->iCal->dator($row['timeStamp'], 'dateTime');
			$entityList[$count]['title'] = $row['title'];
			$entityList[$count]['brief'] = $row['brief'];
			$entityList[$count]['contentType'] = $row['contentType'];
			$entityList[$count]['contentPath'] = $row['contentPath'];
			$title = str_ireplace(' ', '-', trim($row['title']));
			$entityList[$count][link] = "/post/c_showListObject/$row[id]_$title";
			$count++;
		}
		
//		print_r($entityList);
		header('Content-Type: application/xml; charset=utf-8');
		die($system->rss->create($entityList));
	}

}
?>