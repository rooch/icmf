<?php
Define("drawConfFile", "$settings[moduleAddress]/$sysVar[op]/config/config");
$config = drawConfFile . ".php";

if(file_exists($config)){
	require_once ($config);

	/* Model */
	$subSystem = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[modelAddress] . "/" . $settings[moduleName] . $settings[ext2];
	if(file_exists($subSystem)){
		require_once ($subSystem);
		$m_draw = new m_draw();
		$system->run($subSystem, 'On');
	}else{
		$system->run($subSystem, 'Off');
	}

	/* Controller */
	$subSystem = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[moduleController] . "/" . $settings[moduleName] . $settings[ext2];
	if(file_exists($subSystem)){
		require_once ($subSystem);
		$c_draw = new c_draw();
		$system->run($subSystem, 'On');
	}else{
		$system->run($subSystem, 'Off');
	}


}else{
	die("Draw sub system is down !");
}
?>