<?php
################################
# Login                        #
################################
require_once "module/userMan/model/userMan.php";
$userMan = new m_userMan();
$system->xorg->smarty->assign("login", $userMan->m_loginContent());

################################
# Menu                         #
################################
$system->xorg->smarty->assign("menu", $userMan->m_menu());

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
# Toolbar                      #
################################
$system->xorg->smarty->assign("toolbar", $system->xorg->smarty->fetch($settings[commonTpl] . 'toolbar' . $settings[ext4]));

################################
# Shop                         #
################################
require_once "module/product/model/product.php";
$product = new m_product();
$product->m_hierarchicalListCategory(0);
$system->xorg->smarty->assign("category", "<ul id='productTreeMenu' style='padding-right: 20px;'>\n" . $product->tree . "<ul>\n");

################################
# Feed                         #
################################
//	$system->xorg->smarty->assign("feedChannel", $system->rss->rssReader("http://cbi.ir/ExRatesRss.aspx"));

################################
# Menu                         #
################################
$system->xorg->smarty->assign("news", $system->xorg->smarty->fetch($settings[customiseTpl] . 'news' . $settings[ext4]));

################################
# Main                         #
################################
if($sysVar[op] && $sysVar[mode]){
	$system->module->loadModule();
	$content = $system->xorg->smarty->fetchedVar;
	
	$system->seo->seo($content);
	$system->seo->scan();
	
	$system->xorg->smarty->assign("keywords", $system->seo->metaKeywordMaker());
	$system->xorg->smarty->assign("title", $system->seo->titleMaker());
	$system->xorg->smarty->assign("main", $content);
}

################################
# Link List                    #
################################
$system->xorg->smarty->assign("linkList", $system->xorg->smarty->fetch($settings[customiseTpl] . 'linkList' . $settings[ext4]));

################################
# Chain                        #
################################
$system->xorg->smarty->assign("chain", $system->xorg->smarty->fetch($settings[customiseTpl] . 'chain' . $settings[ext4]));

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