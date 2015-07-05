<?php
class c_poll extends m_poll{

	public $active = 1;


	function c_poll(){
		
	}
	
	// Add Poll
	public function c_add($values){
		
		$this->m_add($values);
	}
	// Edit Poll
	// Del Poll
	// List Poll
	public function c_list($filter = null){
		$this->m_list($filter);
	}
	// Activate Poll
	public function c_activate($id){
		$this->m_activate($id);
	}
	// Deactive Poll
	public function c_deactivate($id){
		$this->m_deactivate($id);
	}
	// Show Active Poll
	public function c_showActive(){
		$this->m_showActive();
	}
	// Submit Poll
	public function c_submit($pollId, $answerId){
		global $system, $lang, $settings;
		
		if($system->dbm->db->count_records("`$this->pollStat`", "`pollId` = $pollId AND `uid` = $_SESSION[uid]") > 0){
			$system->watchDog->exception("w", $lang[warning], $lang[youPolledBefore]);
		}else{
			$this->m_submit($pollId, $answerId);
		}
	}
	// Result Poll
	public function c_result($pollId){
		$this->m_result($pollId);
	}
}
?>