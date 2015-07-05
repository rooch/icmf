<?php
################################
# Sections [Landing pages]     #
################################
switch ($sysVar['op']){
	case 'post':
		// Blog landing page
		$sections['basket'] = false;
		$sections['panel'] = true;
		$sections['header'] = true;
		$sections['menu'] = true;
		$sections['headerSplash'] = false;
		$sections['right'] = false;
		$sections['center'] = true;
		$sections['centerWidth'] = 70;
		$sections['slider'] = false; 
		$sections['left'] = true;
		$sections['leftWidth'] = 30;
		$sections['footer'] = true;
		break;
	default:
		// Home landing page
		$sections['basket'] = false;
		$sections['panel'] = true;
		$sections['header'] = true;
		$sections['menu'] = true;
		if($_POST['filter'] || $_GET['filter'])
		$sections['headerSplash'] = false;
		else
		$sections['headerSplash'] = false;
		$sections['right'] = false;
		$sections['center'] = true;
		$sections['centerWidth'] = 100;
		$sections['slider'] = false; 
		$sections['left'] = false;
		$sections['footer'] = true;
		break;
}
$system->xorg->smarty->assign("sections", $sections);
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
//$system->xorg->smarty->assign("lastForum", $m_forum->m_listObject(5));

################################
# Comments                     #
################################
require_once "module/comment/config/config.php";
require_once "module/comment/model/comment.php";
$m_comment = new m_comment();
$system->xorg->smarty->assign("lastComment", $m_comment->m_listObject('showListObjectSimple', 'op=post'));
################################
# Fs Network Panel             #
################################
//$system->xorg->smarty->assign("fsNetwork", $system->xorg->smarty->fetch($settings[commonTpl] . "fsNetwork". $settings['ext4']));

################################
# Menu                         #
################################
//$system->xorg->smarty->assign("menu", $system->xorg->smarty->fetch($settings[commonTpl] . "menu". $settings['ext4']));

################################
# Panel                        #
################################
//$system->xorg->smarty->assign("panel", $system->xorg->smarty->fetch($settings[commonTpl] . 'panel' . $settings[ext4]));

################################
# Header                       #
################################
//$system->xorg->smarty->assign("header", $system->xorg->smarty->fetch($settings[commonTpl] . 'header' . $settings['ext4']));

################################
# Google Plus                  #
################################
//$system->xorg->smarty->assign("googlePlus", $system->xorg->smarty->fetch($settings[commonTpl] . "googlePlus". $settings['ext4']));

################################
# Post                         #
################################
require_once "module/post/config/config.php";
require_once "module/post/model/post.php";
$m_post = new m_post();
//$system->xorg->smarty->assign("post", $m_post->m_listObject('showListObjectSingleCol', $settings['category']));
$system->xorg->smarty->assign("titleList", $m_post->m_listObject('titleList'));
$system->xorg->smarty->assign("postCategory", $system->xorg->htmlElements->treeElement->tree($settings[postCategory], 0, 'postCategory', 'postCategory right specialFont', '(`id` < 20 OR `id` > 26) AND `active` = 1'));
//$system->xorg->smarty->assign("analysisList", $m_post->m_listObject('titleList', 'category=18'));
$system->xorg->smarty->assign("voicePost", $m_post->m_listObject('shortList', 'contentType=voice'));
$system->xorg->smarty->assign("videoPost", $m_post->m_listObject('shortList', 'contentType=video'));

################################
# Left Box                     #
################################
//$system->xorg->smarty->assign("leftBox", $system->xorg->smarty->fetch($settings[customiseTpl] . 'leftBox' . $settings['ext4']));

################################
# Live Support                 #
################################
//$system->xorg->smarty->assign("liveSupport", $system->xorg->smarty->fetch($settings[commonTpl] . 'liveSupport' . $settings['ext4']));

################################
# Main                         #
################################
if(strstr($pageInfo['image'], 'http')){
	$system->xorg->smarty->assign("image", $pageInfo['image']);
}else{
	$system->xorg->smarty->assign("image", 'http://' . $settings[domainName] . '/' . $pageInfo['image']);
}
//$system->xorg->smarty->assign("keywords", $pageInfo['keywords']);
$system->xorg->smarty->assign("description", $pageInfo['description']);
$system->xorg->smarty->assign("title", $pageInfo['title']);
$system->xorg->smarty->assign("robots", $pageInfo['robots']);
$system->xorg->smarty->assign("googleAuthor", $pageInfo['author']);
$system->xorg->smarty->assign("center", $content);

################################
# Contact Form                 #
################################
//$system->xorg->smarty->assign("contactUs", $system->xorg->smarty->fetch($settings[commonTpl] . 'sendMessage' . $settings['ext4']));

################################
# Links                        #
################################
//$system->xorg->smarty->assign("links", $system->xorg->smarty->fetch($settings[commonTpl] . "links". $settings['ext4']));

################################
# Copyright                    #
################################
//$system->xorg->smarty->assign("copyright", $system->xorg->smarty->fetch($settings[commonTpl] . 'copyright' . $settings['ext4']));

################################
# Footer                       #
################################
//$system->xorg->smarty->assign("footer", $system->xorg->smarty->fetch($settings[commonTpl] . 'footer' . $settings['ext4']));

################################
# Browser                      #
################################
$browser = $system->utility->browserDetector->whatBrowser();
$sysVar[browserType] = $browser[browsertype];
$sysVar[browserVersion] = $browser[version];
$sysVar[platform] = $browser[platform];

?>