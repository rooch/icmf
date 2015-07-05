<?php

define("superVisor", "kernel/controller/superVisor");
if(file_exists(superVisor . ".php"))
require_once(superVisor . ".php");
date_default_timezone_set($settings['timezone']);
$system->security->session->manager();

$system->xorg->smarty->assign("settings", $settings);
$system->lang->langMan();
require_once $settings['cacheDir'] . '/lang' . $settings['ext2'];
$system->xorg->smarty->assign("lang", $lang);
$system->xorg->smarty->assign("sysVar", $sysVar);

require_once 'module/mta/config/config.php';
require_once 'module/mta/model/mta.php';
$mta = new m_mta();
$mta->m_mtaSend('newsletter');

?>