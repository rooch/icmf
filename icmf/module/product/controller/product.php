<?php
class c_product extends m_product{

	public $active = 1;

	public function c_product(){

	}
	###########################
	# Category                #
	###########################
	// Add Category
	public function c_addCategory($name, $category, $description=null){
		global $system, $lang, $settings;

		if($system->dbm->db->count_records("`$settings[productCategory]`", "`name` = '$name'") == 0){
			$category = empty($category) ? '0' : $category;
			$this->m_addCategory($name, $category, $description);
		}else{
			$system->watchDog->exception("w", $lang[warning], $lang[categoryExist]);
		}
	}
	// Edit Category
	public function c_editCategory($id, $name, $category=null, $description=null){

		$this->m_editCategory($id, $name, $category, $description);
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
	// Find HierarchicalCategory
	public function c_hierarchicalCategoryFinder($categories){
		$this->m_hierarchicalCategoryFinder($categories);
	}
	// Make Hierarchical Category
	public function c_hierarchicalListCategory($category, $level=0, $flag=0){
		$this->m_hierarchicalListCategory($category, $level, $flag);
	}
	###########################
	# Object (product)        #
	###########################
	// Add Object
	public function c_addObject($values){
		global $system, $lang;

		//		if($system->dbm->db->count_records("`$this->productTable`", "`name` = '$name'") == 0){
		$this->m_addObject($values);
		//		}else{
		//			$system->watchDog->exception("w", $lang[warning], $lang[productExist]);
		//		}

	}
	// Edit Object
	public function c_editObject($values){
		$this->m_editObject($values);
	}
	// Del Object
	public function c_delObject($id, $name=null){
		$this->m_delObject($id, $name);
	}
	// List Object
	public function c_listObject(){
		return $this->m_listObject();
	}
	// Activate Object
	public function c_activateObject(){

	}
	// Deactivate Object
	public function c_deactivateObject(){

	}
	// Info Object
	public function c_infoObject($id){
		return $this->m_infoObject($id);
	}

}
?>