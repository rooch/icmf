<?php
class m_keywords extends masterModule{

	function m_keywords(){

	}

	###########################
	# Object (words)          #
	###########################
	// List Object
	public function m_listObject($viewMode, $filter = null){
		global $settings, $system, $lang;

		$filter = !empty($filter) ? $system->filterSplitter($filter) : null;
		$system->xorg->pagination->paginateStart("seo", "c_$viewMode", "`id`, `active`, `word1`, `word2`, `word3`, `word4`, `word5`, `word6`, `word7`, `word8`, `word9`, `word10`", "`seo`", "`domain` = '$settings[domain]' $filter", "", "", "", "", "", 200000, 7);

		$count = 1;
		while ($row = $system->dbm->db->fetch_array()){
			for($i=1; $i<11; $i++){
				if($row['word' . $i] != ''){
					$entityList[] = $row['word' . $i];
				}
			}
			$count++;
		}
		if(is_array($entityList) && count($entityList) > 0){
			$entityList= @array_count_values($entityList);
			@arsort($entityList);
		}
//		print_r($entityList);
		$system->xorg->smarty->assign("navigation", $system->xorg->pagination->renderFullNav());
		$system->xorg->smarty->assign("entityList", $entityList);
		return $system->xorg->smarty->fetch($settings[moduleAddress] . "/keywords/view/tpl/object/$viewMode" . $settings[ext4]);
	}
	
}
?>