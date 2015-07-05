<?php
Define("financialConfFile", "$settings[moduleAddress]/$sysVar[op]/config/config");
$config = financialConfFile . ".php";

if(file_exists($config)){
	require_once ($config);

	/* Financial subSystem */
	$subSystem = $settings[moduleAddress] . "/" . $settings[moduleName] . "/" . $settings[moduleController] . "/" . $settings[moduleName] . $settings[ext2];
	if(file_exists($subSystem)){
		require_once ($subSystem);
		$financial = new financial();
		$system->run($subSystem, 'On');
	}else{
		$system->run($subSystem, 'Off');
	}

}else{
	die("$settings[moduleName] is down !");
}
?>