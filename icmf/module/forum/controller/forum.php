<?php
class c_forum extends m_forum{

	public $active = 1;

	public function c_forum(){

	}
	###########################
	# Object (forum)            #
	###########################
	// List Object
	public function c_listObject($limit=5){
		return $this->m_listObject($limit);
	}
}
?>