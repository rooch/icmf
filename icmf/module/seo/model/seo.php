<?php
/**
 * @author Ali Hosseini
 *
 */
class m_seo extends masterModule {
	private $hash = array ();
	private $site;
	private $html;
	private $actual;
	function m_seo() {
	}
	
	// ##########################
	// Object (words) #
	// ##########################
	// List Object
	public function m_listObject($viewMode, $filter = null) {
		global $settings, $system, $lang;
		
		$filter = ! empty ( $filter ) ? $system->filterSplitter ( $filter ) : null;
		$system->xorg->pagination->paginateStart ( "seo", "c_$viewMode", "`base`.`id`, `base`.`active`, `base`.`name`, `$settings[seoCategory]`.`name`", "`$settings[seoObject]` as `base`, `$settings[seoCategory]`", "`base`.`category` = `$settings[seoCategory]`.`id` $filter", "`base`.`timeStamp` DESC", "", "", "", "", 20, 7 );
		
		$count = 1;
		while ( $row = $system->dbm->db->fetch_array () ) {
			
			$entityList [$count] [num] = $count;
			$entityList [$count] [active] = $row [active];
			$entityList [$count] [id] = $row [id];
			$entityList [$count] [name] = $row [name];
			$entityList [$count] [category] = $row [category];
			$entityList [$count] [timeStamp] = $system->time->iCal->dator ( $row [timeStamp] );
			
			$count ++;
		}
		$system->xorg->smarty->assign ( "navigation", $system->xorg->pagination->renderFullNav () );
		$system->xorg->smarty->assign ( "entityList", $entityList );
		$system->xorg->smarty->display ( $settings [moduleAddress] . "/" . $settings [moduleName] . "/view/tpl/object/$viewMode" . $settings [ext4] );
	}
	
	/**
	 *
	 * @param String $keyword        	
	 */
	public function m_keywordSuggestion($keyword) {
		global $settings, $system;
		
		$keywords = array ();
		$data = file_get_contents ( 'http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=en-US&q=' . urlencode ( $keyword ) );
		if (($data = json_decode ( $data, true )) !== null) {
			$keywords = $data [1];
		}
		
		$system->xorg->smarty->assign ( 'keywords', $keywords );
		$system->xorg->smarty->display ( $settings ['moduleAddress'] . "/" . $settings [moduleName] . "/view/tpl/object/keywordSuggestionResult" . $settings ['ext4'] );
	}
	/**
	 *
	 * @param string $domain        	
	 * @return boolean
	 */
	public function m_googleBacklink($domain) {
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=link:" . $domain . "&filter=0";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_NOBODY, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
		$json = curl_exec ( $ch );
		curl_close ( $ch );
		$data = json_decode ( $json, true );
		if ($data ['responseStatus'] == 200)
			echo $data ['responseData'] ['cursor'] ['resultCount'];
		else
			return false;
	}
	/**
	 * @param string $domain
	 * @return boolean
	 */
	function m_googleIndexPageCounter($domain) {
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=site:" . $domain . "&filter=0";
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_NOBODY, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 30 );
		$json = curl_exec ( $ch );
		curl_close ( $ch );
		$data = json_decode ( $json, true );
		if ($data ['responseStatus'] == 200)
			echo $data ['responseData'] ['cursor'] ['resultCount'];
		else
			return false;
	}
}
?>