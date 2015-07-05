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
# Forum                        #
################################
//require_once "module/forum/config/config.php";
//require_once "module/forum/model/forum.php";
//$m_forum = new m_forum();
//$system->xorg->smarty->assign("lastForum", $m_forum->m_listObject(10));

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
# Header                       #
################################
$system->xorg->smarty->assign("header", $system->xorg->smarty->fetch($settings[commonTpl] . 'header' . $settings['ext4']));

################################
# Post                         #
################################
require_once "module/post/config/config.php";
require_once "module/post/model/post.php";
$m_post = new m_post();
$system->xorg->smarty->assign("post", $m_post->m_listObject('showListObjectSingleCol', $settings['category']));
$system->xorg->smarty->assign("titleList", $m_post->m_listObject('titleList'));
$system->xorg->smarty->assign("analysisList", $m_post->m_listObject('titleList', 'category=18'));
$system->xorg->smarty->assign("mediaPost", $m_post->m_mediaListObject('mediaList'));

################################
# Left Box                     #
################################
$system->xorg->smarty->assign("leftBox", $system->xorg->smarty->fetch($settings[customiseTpl] . 'leftBox' . $settings['ext4']));

################################
# Live Support                 #
################################
//$system->xorg->smarty->assign("liveSupport", $system->xorg->smarty->fetch($settings[commonTpl] . 'liveSupport' . $settings['ext4']));

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
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>