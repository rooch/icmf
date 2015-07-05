<?php
/*###########################
#           Access          #
###########################*/
if (!defined('MODULE_FILE')){
    Define("CONF_FILE","config");
    require_once("../../" . CONF_FILE . ".php");
    require_once("../../" . LANGADDRESS . "/" . $settings[LANG] . EXT2);
    die ("<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CENTER>$lang[YOUDONTHAVEPERMISSION]<CENTER>");
}
/*###########################
#            Main           #
###########################*/
Define("VISFILE","visor");
if(file_exists(MODULEADDRESS . "/" . "faq" . "/" . VISFILE . EXT2));
    require_once(MODULEADDRESS . "/" . "faq" . "/" . VISFILE . EXT2);
$smarty->assign("main", faq_fetch());
?>