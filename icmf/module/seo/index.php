<?php
if (file_exists ( visor . ".php" ))
	require_once (visor . ".php");

switch ($sysVar [mode]) {
	
	// ##########################
	// Object (words) #
	// ##########################
	// List Object
	case "c_listObject" :
		$c_seo->c_listObject ( 'list', $_POST ['filter'] );
		break;
	case "v_siteMapGenerate" :
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/sitemapGenerate" . $settings ['ext4'] );
		break;
	case "c_siteMapGenerate" :
		require 'module/seo/model/siteMapGenerate.php';
		
		$siteMapGenerate = new siteMapGenerate($_POST['url']);
		$f = fopen("tmp/cache/sitemap.xml","w+");
		fwrite($f, $siteMapGenerate->generate());
		fclose($f);
		break;
	case "c_w3cValidate" :
		if (empty ( $_COOKIE ['digiseoAnalysis'] )) {
			set_time_limit ( 3600 );
			require_once 'module/seo/model/CurlObj.class.php';
			require_once 'module/seo/model/W3cValidator.class.php';
			$check = new W3cValidator ();
			$result = $check->fast_validate ( $_POST ['websiteUrl'] );
			
			// require_once 'kernel/lib/xorg/grabz/lib/GrabzItClient.class.php';
			// $grabzIt = new GrabzItClient("ZGZiMmRkZTE0NWIzNDY0MGE1Y2VkNTI1MTE3MmVjZTE=", "Pz8/WQg/Pz86Gz9+Aj8FPkc9WiF0PyJvEz8/Pww/PxY=");
			// $grabzIt->SetImageOptions($_POST['websiteUrl']);
			// $grabzIt->Save("http://$settings[domainName]/kernel/lib/xorg/grabz/handler.php");
			// $result['image'] = $filepath = 'tmp/cache/' . time() . '.jpg';
			// $grabzIt->SaveTo($filepath);
			
			$system->xorg->smarty->assign ( 'result', $result );
			setcookie ( 'digiseoAnalysis', 1, strtotime ( '+14 days' ) );
			$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/w3cValidator" . $settings ['ext4'] );
		} else {
			$system->watchDog->exception ( "e", $lang ['error'], $lang ['maxAnalysisRequest'] );
		}
		break;
	case "v_serp" :
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/serpForm" . $settings ['ext4'] );
		break;
	case "c_serp" :
		require_once 'module/seo/model/serp.php';
		
		$serp = new serp ();
		echo $serp->position($_POST['keyword'], $_POST['domain']);
		break;
	case "v_keywordSuggestion" :
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/keywordSuggestionForm" . $settings ['ext4'] );
		break;
	case "c_keywordSuggestion" :
		$c_seo->c_keywordSuggestion ( $_POST ['keyword'] );
		break;
	case "v_googleBacklink" :
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/googleBacklinkForm" . $settings ['ext4'] );
		break;
	case "c_googleBacklink" :
		$c_seo->c_googleBackLink ( $_POST ['domain'] );
		break;
	case "v_googleIndexPageCounter" :
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/googleIndexPageCounterForm" . $settings ['ext4'] );
		break;
	case "c_googleIndexPageCounter" :
		$c_seo->c_googleIndexPageCounter ( $_POST ['domain'] );
		break;
	case "v_pageSpeed":
		$system->xorg->smarty->display ( "$settings[moduleAddress]/$settings[moduleName]/$settings[viewAddress]/$settings[tplAddress]/object/pageSpeedForm" . $settings ['ext4'] );
		break;
	case "c_pageSpeed":
		require_once 'module/seo/model/pageSpeed.php';
		
		$pageSpeed = new pageSpeed();
		$pageSpeed->scan($_POST['url']);
		break;
	default :
		$system->xorg->smarty->display ( $settings [commonTpl] . "404" . $settings [ext4] );
		break;
}

?>