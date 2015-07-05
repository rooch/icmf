<?php
################################
# Keywords                     #
################################
require_once "module/keywords/model/keywords.php";
$keywords = new m_keywords();
$system->xorg->smarty->assign("jQCloud", $keywords->m_listObject('showList'));

################################
# Pay per click                #
################################
require_once "module/payPerClick/config/config.php";
require_once "module/payPerClick/model/payPerClick.php";
$payPerClick = new m_payPerClick();
$payPerClick->m_addObject();

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
# Left                         #
################################
$system->xorg->smarty->assign("left", $system->xorg->smarty->fetch($settings[commonTpl] . 'left' . $settings[ext4]));

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
# Contact Form                 #
################################
$system->xorg->smarty->assign("contactUs", $system->xorg->smarty->fetch($settings[commonTpl] . 'sendMessage' . $settings[ext4]));

################################
# Links                        #
################################
$system->xorg->smarty->assign("links", $system->xorg->smarty->fetch($settings[commonTpl] . "links". $settings[ext4]));

################################
# Footer                       #
################################
$system->xorg->smarty->assign("footer", $system->xorg->smarty->fetch($settings[commonTpl] . 'footer' . $settings[ext4]));

################################
# Copyright                    #
################################
$system->xorg->smarty->assign("copyright", $system->xorg->smarty->fetch($settings[commonTpl] . 'copyright' . $settings[ext4]));


################################
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>