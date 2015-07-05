<?php
################################
# Keywords                     #
################################
require_once "module/keywords/model/keywords.php";
$keywords = new m_keywords();
$system->xorg->smarty->assign("jQCloud", $keywords->m_listObject('showList'));

################################
# Basket                       #
################################
require_once "module/basket/config/config.php";
require_once "module/basket/model/basket.php";
$basket = new m_basket();
$system->xorg->smarty->assign("basketContent", $basket->m_listObject());

################################
# Search                       #
################################
$system->xorg->smarty->assign("category", $system->xorg->combo(array('id', 'name'), 'productCategory'));
$system->xorg->smarty->assign("company", $system->xorg->combo(array('id', 'name'), 'company'));
$system->xorg->smarty->assign("search", $system->xorg->smarty->fetch("$settings[moduleAddress]/shop/$settings[viewAddress]/$settings[tplAddress]/vitrin/search" . $settings[ext4]));

################################
# CSS Loader                   #
################################
$system->xorg->smarty->assign("css", $system->xorg->smarty->fetch($settings[commonTpl] . 'cssLoader' . $settings[ext4]));

################################
# JS Loader                    #
################################
$system->xorg->smarty->assign("js", $system->xorg->smarty->fetch($settings[commonTpl] . 'jsLoader' . $settings[ext4]));

################################
# Google Analytic              #
################################
//$system->xorg->smarty->assign("googleAnalytic", $system->xorg->smarty->fetch($settings[commonTpl] . "googleAnalytic". $settings[ext4]));

################################
# Login                        #
################################
require_once "module/userMan/model/userMan.php";
$userMan = new m_userMan();
$system->xorg->smarty->assign("login", $userMan->m_loginContent());

################################
# Fs Network Panel             #
################################
$system->xorg->smarty->assign("fsNetwork", $system->xorg->smarty->fetch($settings[commonTpl] . "fsNetwork". $settings[ext4]));

################################
# Menu                         #
################################
$system->xorg->smarty->assign("menu", $userMan->m_menu());

################################
# Panel                        #
################################
$system->xorg->smarty->assign("panel", $system->xorg->smarty->fetch($settings[commonTpl] . 'panel' . $settings[ext4]));

################################
# Slider                       #
################################
require_once "module/slider/model/slider.php";
$slider = new m_slider();
$system->xorg->smarty->assign("slider", $slider->m_lastSlide());

################################
# Header                       #
################################
$system->xorg->smarty->assign("header", $system->xorg->smarty->fetch($settings[commonTpl] . 'header' . $settings[ext4]));

################################
# Calendar                     #
################################
$system->xorg->smarty->assign("date", $system->time->iCal->dator(time(), 1));

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
# Basket                       #
################################
$system->xorg->smarty->assign("basket", $system->xorg->smarty->fetch($settings[commonTpl] . 'basket' . $settings[ext4]));

################################
# Main                         #
################################
$system->xorg->smarty->assign("keywords", $system->seo->metaKeywordMaker('show'));
$system->xorg->smarty->assign("description", $system->seo->metaDescriptionMaker());
$system->xorg->smarty->assign("title", $system->seo->titleMaker('best'));
$system->xorg->smarty->assign("main", $content);

################################
# Link List                    #
################################
$system->xorg->smarty->assign("linkList", $system->xorg->smarty->fetch($settings[customiseTpl] . 'linkList' . $settings[ext4]));

################################
# Contact Form                 #
################################
$system->xorg->smarty->assign("contactUs", $system->xorg->smarty->fetch($settings[commonTpl] . 'sendMessage' . $settings[ext4]));

################################
# Footer                       #
################################
$system->xorg->smarty->assign("footer", $system->xorg->smarty->fetch($settings[commonTpl] . 'footer' . $settings[ext4]));

################################
# Links                        #
################################
$system->xorg->smarty->assign("links", $system->xorg->smarty->fetch($settings[commonTpl] . "links". $settings[ext4]));


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