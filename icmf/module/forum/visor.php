<?php
Define('ConfFile', "$settings[moduleAddress]/$sysVar[op]/config/config");
$config = ConfFile . ".php";

if(file_exists($config)){
	require_once ($config);

	/* Model */
	$subSystem = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[modelAddress] . "/" . $settings[moduleName] . $settings[ext2];
	if(file_exists($subSystem)){
		require_once ($subSystem);
		$m_forum = new m_forum();
		$system->run($subSystem, 'On');
	}else{
		$system->run($subSystem, 'Off');
	}

	/* Controller */
	$subSystem = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[moduleController] . "/" . $settings[moduleName] . $settings[ext2];
	if(file_exists($subSystem)){
		require_once ($subSystem);
		$c_forum = new c_forum();
		$system->run($subSystem, 'On');
	}else{
		$system->run($subSystem, 'Off');
	}


}else{
	die("$sysVar[op] sub system is down !");
}
?>