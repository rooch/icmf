<?php
class m_designer{

	private $moduleName = "designer";
	private $accessTable = "access";

	public function m_designer(){

		$this->accessTable = $this->tablePrefix . $this->accessTable;

	}

	public function m_list($filter=null){
		global $system, $lang, $settings;

		$fileList = $system->utility->fileSystem->scanDirectories($settings[themeAddress] . "/" . $settings[theme] . "/" . $settings[tplAddress], array('html', 'htm'));
		
		$system->xorg->smarty->assign("fileList", $fileList);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/fileList" . $settings[ext4]);

	}
}
?>