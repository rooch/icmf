<?php
class c_post extends m_post{

	public $active = 1;

	public function c_post(){

	}
	###########################
	# Category                #
	###########################
	// Add Category
	public function c_addCategory($name, $category, $description=null){
		global $system, $lang, $settings;

//		if($system->dbm->db->count_records("`$settings[postCategory]`", "`name` = '$name'") == 0){
			$category = empty($category) ? '0' : $category;
			$this->m_addCategory($name, $category, $description);
//		}else{
//			$system->watchDog->exception("w", $lang[warning], $lang[categoryExist]);
//		}
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
		return $this->m_hierarchicalListCategory($category, $level, $flag);
	}
	###########################
	# Object (post)        #
	###########################
	// Add Object
	public function c_addObject($values, $show=false){
		global $system, $lang;

		//		if($system->dbm->db->count_records("`$this->postTable`", "`name` = '$name'") == 0){
		$this->m_addObject($values, $show);
		//		}else{
		//			$system->watchDog->exception("w", $lang[warning], $lang[postExist]);
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
	public function c_listObject($viewMode, $filter=null, $sort=null){
		return $this->m_listObject($viewMode, $filter, $sort);
	}
	// Activate Object
	public function c_activateObject(){

	}
	// Deactivate Object
	public function c_deactivateObject(){

	}
	// Feed Object
	public function c_feedObject($source, $count){
		
		$this->m_feedObject($source, $count);
	}
	// Rss Feed
	public function c_rssFeed($filter=null){
		
		$this->m_rssFeed($filter);
	}

}
?>