<?php
################################
# Keywords                     #
################################
//require_once "module/keywords/model/keywords.php";
//$keywords = new m_keywords();
//$system->xorg->smarty->assign("jQCloud", $keywords->m_listObject('showList'));

################################
# Google Analytic              #
################################
//$system->xorg->smarty->assign("googleAnalytic", $system->xorg->smarty->fetch($settings[commonTpl] . "googleAnalytic". $settings['ext4']));

################################
# Zopim                        #
################################
//$system->xorg->smarty->assign("zopim", $system->xorg->smarty->fetch($settings[commonTpl] . "zopim". $settings['ext4']));

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
$system->xorg->smarty->assign("menu", $system->xorg->smarty->fetch($settings[commonTpl] . "menu". $settings['ext4']));

################################
# Panel                        #
################################
$system->xorg->smarty->assign("panel", $system->xorg->smarty->fetch($settings[commonTpl] . 'panel' . $settings[ext4]));

################################
# Slider                       #
################################
$system->xorg->smarty->assign("slider", $system->xorg->smarty->fetch($settings[commonTpl] . 'slider' . $settings[ext4]));

################################
# Header                       #
################################
$system->xorg->smarty->assign("header", $system->xorg->smarty->fetch($settings[commonTpl] . 'header' . $settings['ext4']));

################################
# Left Box                     #
################################
$system->xorg->smarty->assign("leftBox", $system->xorg->smarty->fetch($settings[customiseTpl] . 'leftBox' . $settings['ext4']));

################################
# Basket                       #
################################
//$system->xorg->smarty->assign("basket", $system->xorg->smarty->fetch($settings[commonTpl] . 'basket' . $settings['ext4']));

################################
# Main                         #
################################
//$thumbnail = $system->seo->thumbnail();
if(strstr($thumbnail, 'http')){
	$system->xorg->smarty->assign("image", $pageInfo['image']);
}else{
	$system->xorg->smarty->assign("image", 'http://' . $settings[domainName] . '/' . $pageInfo['image']);
}
$system->xorg->smarty->assign("keywords", $pageInfo['keywords']);
$system->xorg->smarty->assign("description", $pageInfo['description']);
$system->xorg->smarty->assign("title", $pageInfo['title']);
$system->xorg->smarty->assign("googleAuthor", $pageInfo['author']);
$system->xorg->smarty->assign("main", $content);

################################
# Contact Form                 #
################################
//$system->xorg->smarty->assign("contactUs", $system->xorg->smarty->fetch($settings[commonTpl] . 'sendMessage' . $settings['ext4']));

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
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>