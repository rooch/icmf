<?php
if(extension_loaded('zlib')){
	ob_start('ob_gzhandler');
}
header ('content-type: text/javascript; charset: UTF-8');
header ('cache-control: must-revalidate');
$offset = 168 * 60 * 60;
$expire = 'expires: ' . gmdate ('D, d M Y H:i:s', time() + $offset) . ' GMT';
header ($expire);
ob_start('compress');
function compress($buffer) {
	// remove comments
	$buffer = str_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	return $buffer;
}

// list JS files to be included
include('../../../kernel/lib/xorg/global/global.js');
include('../../../kernel/lib/xorg/jQuery/jquery-1.7.1.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/jqueryUI/jquery-ui-1.8.21.custom.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/address/jquery.address-1.4.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/showLoading/jquery.showLoading.min.js');
include('../../../kernel/lib/xorg/ajax/ajax.js');
include('../../../kernel/lib/xorg/jQuery/plugin/bgFull/jquery.fullbg.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/cycle/jquery.cycle.all.js');
include('../../../kernel/lib/xorg/jQuery/plugin/scrollTo/jquery.scrollTo-1.4.3.1-min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/modal/modal.js');
include('../../../kernel/lib/xorg/jQuery/plugin/tipTip/jquery.tipTip.minified.js');
include('../../../kernel/lib/xorg/jQuery/plugin/newsTicker/jquery.newsTicker.js');
include('../../../kernel/lib/xorg/jQuery/plugin/sharrre/jquery.sharrre-1.3.4.js');
include('../../../kernel/lib/xorg/jQuery/plugin/sharrre/start.js');
include('../../../kernel/lib/xorg/jQuery/plugin/easing/jquery.easing.1.3.js');
include('../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.mcdropdown.js');
include('../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.bgiframe.js');
include('custom.js');
include('startUp.js');
//include('../../../kernel/lib/xorg/editor/ckeditor.js');
//include('../../../kernel/lib/xorg/finder/ckfinder.js');

if(extension_loaded('zlib')){ob_end_flush();}
?>