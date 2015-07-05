<?php 

class pageSpeed {
	
	function __construct(){
		
	}
	
	public function scan($url){
		global $system, $settings;
		
		$url = preg_replace('#^http?://#', '', $url);
		$url = preg_replace('#^https?://#', '', $url);
		$ch = curl_init("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?url=http://$url/&key=AIzaSyDZy1AjH6icHvvtrbgZlVLaO4EMYAH9KVo");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		
		$obj = json_decode($res, true);
		
		echo '<pre>';
		print_r($obj);
		echo '</pre>';

		$system->xorg->smarty->assign("info", json_decode($res, true));
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/pageSpeedResult" . $settings ['ext4'] );
	}
	
}

?>