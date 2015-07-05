<?php
class m_stat extends masterModule{

	public $moduleName = "stat";
	
	public $statTable = "watchDog";
	
	private $currentTime;
	private $recentDay;
	private $recentMonth;

	function m_stat(){
		
	}
	
	public function m_simpleStat(){
		global $system, $lang, $settings;
		
		$this->currentTime = time();
		$this->recentDay = $this->currentTime-86400;
		$this->recentMonth = $this->currentTime-2592000;
				
		$recentDayCount = mysql_result(mysql_query("SELECT count(DISTINCT `ip`) as `num` FROM `$this->statTable` WHERE `timeStamp` > $this->recentDay AND `timeStamp` < $this->currentTime"), 0);
		$recentMonthCount = mysql_result(mysql_query("SELECT count(DISTINCT `ip`) as `num` FROM `$this->statTable` WHERE `timeStamp` > $this->recentMonth AND `timeStamp` < $this->currentTime"), 0);
		
		$system->xorg->smarty->assign("recentDayCount", $recentDayCount);
		$system->xorg->smarty->assign("recentMonthCount", $recentMonthCount);
		$system->xorg->smarty->display($settings[moduleAddress] . "/" . $this->moduleName . "/view/tpl/simpleStat" . $settings[ext4]);
	}

}
?>