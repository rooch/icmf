<?php
class c_seo extends m_seo{

	public $active = 1;
	
	function c_seo(){
		
	}
		
	###########################
	# Object (words)          #
	###########################
	// List Object
	public function c_listObject($viewMode, $filter = null){
		
		$this->m_listObject($viewMode, $filter);
	}
	
	public function c_sitemapGenerate($url){
		
		$this->m_sitemapGenerate($url);
	}
	
	public function c_keywordSuggestion ($keyword){
		
		$this->m_keywordSuggestion($keyword);
	}
	
	public function c_googleBacklink($domain){
		
		$this->m_googleBacklink($domain);
	}
	
	public function c_googleIndexPageCounter($domain){
		
		$this->m_googleIndexPageCounter($domain);
	}
}
?>