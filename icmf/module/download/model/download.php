<?php
class m_download extends masterModule{

	public $moduleName = "download";

	function m_download(){
		
	}
	
	public function m_readDownloadDir(){
		global $system, $lang, $settings;
		
		$entityList = $system->utility->fileSystem->scanDirectories($settings[downloadDir], $settings[trustFiles]);
		$system->xorg->smarty->assign("entityList", $entityList);
		$system->xorg->smarty->assign("downloadDir", $settings[downloadDir]);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/simpleList" . $settings[ext4]);
	}

}
?>