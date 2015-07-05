<?php 

class selectElement extends htmlElements{
	
	function selectElement(){
		
	}
	
	/**
	 * Select element
	 * @param unknown_type $name
	 * @param unknown_type $options
	 * @param unknown_type $selected
	 * @param unknown_type $size
	 * @return Ambigous <string, void, unknown>
	 */
	public function select($name, $options, $selected = null, $size=1){
		global $system, $settings;
		
		$system->xorg->smarty->assign("name", $name);
		$system->xorg->smarty->assign("options", $options);
		$system->xorg->smarty->assign("selected", $selected);
		$system->xorg->smarty->assign("size", $size);
		return $system->xorg->smarty->fetch($settings['libraryAddress'] . "/xorg/htmlElements/tpl/select" . $settings['ext4']);
	}
	
	
}

?>