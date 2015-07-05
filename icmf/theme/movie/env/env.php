<?php

################################
# Slider                       #
################################
require_once "module/slider/model/slider.php";
$slider = new m_slider();
$system->xorg->smarty->assign("slider", $slider->m_lastSlide());

################################
# Calendar                     #
################################
$system->xorg->smarty->assign("dateJalali", $system->time->iCal->dator(time(), 1, 'jalali'));
$system->xorg->smarty->assign("dateGregorian", date("j F Y"));

################################
# Menu                         #
################################
$system->xorg->smarty->assign("menu", $system->xorg->smarty->fetch($settings[commonTpl] . 'menu' . $settings[ext4]));

################################
# Toolbar                      #
################################
$system->xorg->smarty->assign("toolbar", $system->xorg->smarty->fetch($settings[commonTpl] . 'toolbar' . $settings[ext4]));

################################
# Shop                         #
################################
require_once "module/shop/model/shop.php";
$shop = new m_shop();
//$shop->m_productHierarchicalListCategory(0);
$system->xorg->smarty->assign("category", "<ul id='productTreeMenu' style='padding-right: 20px;'>\n" . $GLOBALS[category] . "<ul>\n");

################################
# Feed                         #
################################
//	$system->xorg->smarty->assign("feedChannel", $system->rss->rssReader("http://cbi.ir/ExRatesRss.aspx"));

################################
# Main                         #
################################
if($sysVar[op] && $sysVar[mode]){
	$system->module->loadModule();
	$system->xorg->smarty->assign("main", $system->xorg->smarty->fetchedVar);
}
################################
# Last Update                  #
################################
$lastUpdate = mysql_result(mysql_query("SELECT max(`timeStamp`) FROM `watchDog` WHERE `uid` = 1"), 0);
$system->xorg->smarty->assign("lastUpdate", $system->time->iCal->dator($lastUpdate, 1));

################################
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>