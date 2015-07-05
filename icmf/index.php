<?php

//ob_start("ob_gzhandler");
define("superVisor", "kernel/controller/superVisor");
if(file_exists(superVisor . ".php"))
require_once(superVisor . ".php");
date_default_timezone_set($settings['timezone']);
//if($_SERVER['HTTP_REFERER'] == '' || in_array($_SERVER['HTTP_REFERER'], $system->security->trustUrl->trustUrlList())){
$system->security->session->manager();

$settings[domain] = $domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
$system->xorg->smarty->assign("settings", $settings);
$system->lang->langMan();
require_once $settings['cacheDir'] . '/lang' . $settings['ext2'];
$system->xorg->smarty->assign("lang", $lang);
$system->xorg->smarty->assign("sysVar", $sysVar);

$system->module->loadModule();
$content = $system->xorg->smarty->fetchedVar;

//require_once "module/relatedContent/model/relatedContent.php";
//$relatedContent = new m_relatedContent();
//$relatedContent->m_relatedURL($system->seo->titleMaker());
//echo "Title: " . $system->seo->titleMaker() . "<br>";
//$content = $content . $relatedContent->m_relatedURL($system->seo->titleMaker());
//echo $relatedContent->m_relatedURL($system->seo->titleMaker());

//echo $system->dbm->db->anyCol('user', '@gmail.com');

//if($_SESSION['uid']==1){
//	require_once 'kernel/lib/sitemap/sitemap.php';
//	$sitemap = new sitemap();
//	echo $sitemap->generate('http://digiseo.ir');
//}

if($_SERVER["HTTP_X_REQUESTED_WITH"] == 'XMLHttpRequest'){
	echo $content;
	
	if($_POST['crawl']){
		$system->seo->seo($_POST['crawl'], $content);
		$system->seo->scan('add');
	}
}else{
	$_SERVER['QUERY_STRING'] = str_replace("op=", '', $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&mode=", '/', $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&filter=", '/', $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&p=", '/', $_SERVER['QUERY_STRING']);
	$_SERVER['QUERY_STRING'] = str_replace("&f=", '/', $_SERVER['QUERY_STRING']);
	
	$system->seo->seo($_SERVER['QUERY_STRING'], $content);
	$pageInfo = $system->seo->scan();
	if(file_exists("theme/$settings[theme]")){
		require_once "theme/$settings[theme]/env/env" . $settings['ext2'];
		echo $system->xorg->smarty->fetch($settings[commonTpl] . 'main' . $settings['ext4']);
	}else{
		echo "Your theme not exist";
	}
}

//}else{
//	echo "ATU: Anti Trust Url!";
//}
//echo "Using ", memory_get_peak_usage(1)/1024, " KB of ram<br>";
?>