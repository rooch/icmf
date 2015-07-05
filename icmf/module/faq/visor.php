<?php
Define("CONF_FILE","config");
if(file_exists(MODULEADDRESS . "/" . "faq" . "/" . CONF_FILE . EXT2)){
	require_once(MODULEADDRESS . "/" . "faq" . "/" . CONF_FILE . EXT2);
	if(file_exists(MODULEADDRESS . "/" . "faq" . "/" . LANGADDRESS . "/" . $settings[LANG] . EXT2)){
		require_once(MODULEADDRESS . "/" . "faq" . "/" . LANGADDRESS . "/" . $settings[LANG] . EXT2);
		$REQUIREMENT[LANG_FILE] = 1;
	}else
		$REQUIREMENT[LANG_FILE] = 0;
                
	if(file_exists(MODULEADDRESS . "/" . "faq" . "/" . FUNCADDRESS . "/" . "sys" . EXT2)){
		require_once(MODULEADDRESS . "/" . "faq" . "/" . FUNCADDRESS . "/" . "sys" . EXT2);
		$REQUIREMENT[SYS_FILE] = 1;
	}else
		$REQUIREMENT[SYS_FILE] = 0;
	$REQUIREMENT[CONF_FILE] = 1;
}else
	$REQUIREMENT[CONF_FILE] = 0;
// START TEST ******************************
//print ($REQUIREMENT[LANG_FILE] == 0 ? "LANG_FILE = Off<BR>" : "LANG_FILE = On<BR>");
//print ($REQUIREMENT[SYS_FILE] == 0 ? "SYS_FILE = Off<BR>" : "SYS_FILE = On<BR>");
// END TEST ********************************
if($REQUIREMENT[CONF_FILE] == 0)
    die(sticker(messenger, sprintf($lang[CONFIGFILENOTEXIST], 'faq'), "<A href=javascript:goback()>$lang[BACK]</A>") . hfmanager('footer'));
if($REQUIREMENT[LANG_FILE] == 0 || $REQUIREMENT[SYS_FILE] == 0)
    die(sticker(messenger, sprintf($lang[DRIVERDFILENOTEXIST], 'faq'), "<A href=javascript:goback()>$lang[BACK]</A>")  . hfmanager('footer'));
?>
