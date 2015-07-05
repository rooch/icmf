<?php
class c_shop extends m_shop{

	public $active = 1;

	function c_shop(){

	}
	###########################
	# Category                #
	###########################
	// Add Category
	public function c_addCategory($name, $increase=null, $decrease=null, $discount=null, $tax=null, $description=null){
		global $system, $lang, $settings;

		if($system->dbm->db->count_records("`$settings[shopCategory]`", "`name` = '$name'") == 0){
			$this->m_addCategory($name, $increase, $decrease, $discount, $tax, $description);
		}else{
			$system->watchDog->exception("w", $lang[warning], $lang[shopExist]);
		}
			
	}
	// Edit Category
	public function c_editCategory($id, $name, $increase=0, $decrease=0, $discount=0, $tax=0){
		$this->m_editCategory($id, $name, $increase, $decrease, $discount, $tax);
	}
	// Del Category
	public function c_delCategory($id){
		$this->m_delCategory($id);
	}
	// List Category
	public function c_listCategory(){
		return $this->m_listCategory();
	}
	// Activate Category
	public function c_activateCategory(){

	}
	// Deactivate Category
	public function c_deactivateCategory(){

	}
	###########################
	# Object (Product)        #
	###########################
	// Add Object
	public function vc_addObject(){
		return $this->vm_addObject($filter);
	}
	// Add Object
	public function c_addObject($objectId, $basePrice, $shopCategory, $discount=null, $tax=null){
		$this->m_addObject($objectId, $basePrice, $shopCategory, $discount, $tax);
	}
	//	// Edit Object
	//	public function c_editObject(){
	//
	//	}
	// Del Object
	public function c_delObject($id){

		$this->m_delObject($id);
	}
	// List Object
	public function c_listObject($filter=null){
		return $this->m_listObject($filter);
	}
	// Activate Object
	public function c_activateObject($id){

		$this->m_activateObject($id);
	}
	// Deactivate Object
	public function c_deactivateObject($id){

		$this->m_deactivateObject($id);
	}
	###########################
	# Vitrin                  #
	###########################
	// Vitrin list
	public function c_listVitrin($viewMode=null, $filter=null){
		return $this->m_listVitrin($viewMode, $filter);
	}
	// Make Carousel
	public function c_carousel($filter=null){
		return $this->m_carousel($filter);
	}
}
?>