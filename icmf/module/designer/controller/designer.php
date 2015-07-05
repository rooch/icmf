<?php
class c_designer extends m_designer{

	public $active = 1;


	public function c_designer(){

	}

	public function c_list($filter=null){
		$this->m_list($filter);
	}
}
?>