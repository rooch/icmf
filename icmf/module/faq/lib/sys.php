<?php
/*###########################
#           Access          #
###########################*/
if (!defined('MODULE_FILE')){
    Define("CONF_FILE","config");
    require_once("../../../" . CONF_FILE . ".php");
    require_once("../../../" . LANGADDRESS . "/" . $settings[LANG] . EXT2);
    die ("<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><CENTER>$lang[YOUDONTHAVEPERMISSION]<CENTER>");
}
/*###########################
#        Functions          #
###########################*/
// View FAQ ********************************
function faq_view($id, $question, $answer){
    global $lang;
    $node = "<div id=\"dhtmlgoodies_q$id\" class=\"dhtmlgoodies_question\" ALIGN=\"RIGHT\" DIR=\"$lang[DIRECTION]\" style=\"width:90%;\"><STRONG>" . stripslashes($question) . "</STRONG></div>
	    <div id=\"dhtmlgoodies_a$id\" class=\"dhtmlgoodies_answer\" style=\"width:90%;\">
		<div id=\"dhtmlgoodies_ac$id\" ALIGN=\"RIGHT\" DIR=\"$lang[DIRECTION]\"><BR>" . stripslashes($answer) . "<BR><BR></div>
	    </div>";
    return $node;
}
// Fetch all FAQ from DB *******************
function faq_fetch($id=null){
    global $mydb, $lang;
    $filter = (!empty($id) ? "`id` = '$id' AND " : null);
    $mydb->select("*", "`mod_faq`", "$filter`aprove` = '1'");
    $faq = "<P CLASS=\"bodybigred\">$lang[MOD_FAQ_CLICK_PER_QUESTION]</P>";
    while($row = $mydb->fetch_array())
	$faq .= faq_view($row[id], $row[question], $row[answer]);
    $faq .= "<script type=\"text/javascript\">
		initShowHideDivs();
	    </script>";
    $faq .= "<BR>$lang[MOD_FAQ_ADD_NEW_QUESTION]<BR>";
    return $faq;
}
?>