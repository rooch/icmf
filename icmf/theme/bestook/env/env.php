<?php
################################
# Keywords                     #
################################
//require_once "module/keywords/model/keywords.php";
//$keywords = new m_keywords();
//$system->xorg->smarty->assign("jQCloud", $keywords->m_listObject('showList'));

################################
# Basket                       #
################################
//require_once "module/basket/config/config.php";
//require_once "module/basket/model/basket.php";
//$basket = new m_basket();
//$system->xorg->smarty->assign("basketContent", $basket->m_listObject());

################################
# Google Analytic              #
################################
//$system->xorg->smarty->assign("googleAnalytic", $system->xorg->smarty->fetch($settings[commonTpl] . "googleAnalytic". $settings['ext4']));

################################
# Login                        #
################################
require_once "module/userMan/model/userMan.php";
$userMan = new m_userMan();
$system->xorg->smarty->assign("login", $userMan->m_loginContent());

################################
# Fs Network Panel             #
################################
$system->xorg->smarty->assign("fsNetwork", $system->xorg->smarty->fetch($settings[commonTpl] . "fsNetwork". $settings['ext4']));

################################
# Menu                         #
################################
$system->xorg->smarty->assign("menu", $userMan->m_menu());

################################
# Panel                        #
################################
$system->xorg->smarty->assign("panel", $system->xorg->smarty->fetch($settings[commonTpl] . 'panel' . $settings['ext4']));

################################
# Header                       #
################################
$system->xorg->smarty->assign("header", $system->xorg->smarty->fetch($settings[commonTpl] . 'header' . $settings['ext4']));

################################
# Calendar                     #
################################
$system->xorg->smarty->assign("dateJalali", $system->time->iCal->dator(time(), 1, 'jalali'));
$system->xorg->smarty->assign("dateGregorian", date("j F Y"));

################################
# Basket                       #
################################
$system->xorg->smarty->assign("basket", $system->xorg->smarty->fetch($settings[commonTpl] . 'basket' . $settings['ext4']));

################################
# Post                         #
################################
require_once "module/post/config/config.php";
require_once "module/post/model/post.php";
$post = new m_post();
$system->xorg->smarty->assign("postList", $post->m_listObject('showListObjectSingleCol', $_GET[filter]));

################################
# Main                         #
################################
$thumbnail = $system->seo->thumbnail();
if(strstr($thumbnail, 'http')){
	$system->xorg->smarty->assign("thumbnail", $thumbnail);
}else{
	$system->xorg->smarty->assign("thumbnail", 'http://' . $settings[domainName] . '/' . $thumbnail);
}
$system->xorg->smarty->assign("keywords", $system->seo->metaKeywordMaker('show'));
$system->xorg->smarty->assign("description", $system->seo->metaDescriptionMaker());
$system->xorg->smarty->assign("title", $settings[siteName] . ' - ' . $system->seo->titleMaker('best'));
$system->xorg->smarty->assign("main", $content);

################################
# Link List                    #
################################
$system->xorg->smarty->assign("linkList", $system->xorg->smarty->fetch($settings[customiseTpl] . 'linkList' . $settings['ext4']));

################################
# Contact Form                 #
################################
$system->xorg->smarty->assign("contactUs", $system->xorg->smarty->fetch($settings[commonTpl] . 'sendMessage' . $settings['ext4']));

################################
# Links                        #
################################
$system->xorg->smarty->assign("links", $system->xorg->smarty->fetch($settings[commonTpl] . "links". $settings['ext4']));

################################
# Copyright                    #
################################
$system->xorg->smarty->assign("copyright", $system->xorg->smarty->fetch($settings[commonTpl] . 'copyright' . $settings['ext4']));

################################
# Footer                       #
################################
$system->xorg->smarty->assign("footer", $system->xorg->smarty->fetch($settings[commonTpl] . 'footer' . $settings['ext4']));

################################
# Last Update                  #
################################
/*$lastUpdate = mysql_result(mysql_query("SELECT max(`timeStamp`) FROM `watchDog` WHERE `uid` = 1"), 0);
$system->xorg->smarty->assign("lastUpdate", $system->time->iCal->dator($lastUpdate, 1));*/

################################
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>