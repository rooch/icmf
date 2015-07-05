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
	// Remove space after colons
	//	$buffer = str_replace(array("= ", " = "), '=', $buffer);
	// Remove whitespace
	//	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}

// list JS files to be included
include('../../../kernel/lib/xorg/modernizr/modernizr.custom.33475.js');
include('../../../kernel/lib/xorg/respond/src/respond.js');
include('../../../kernel/lib/xorg/jQuery/jquery-1.7.1.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/jqueryUI/jquery-ui-1.8.21.custom.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/address/jquery.address-1.4.min.js');
include('../../../kernel/lib/xorg/global/global.js');
include('../../../kernel/lib/xorg/jQuery/plugin/showLoading/jquery.showLoading.min.js');
include('../../../kernel/lib/xorg/ajax/ajax.js');
include('../../../kernel/lib/xorg/jQuery/plugin/iosSlider/jquery.iosslider.js');
include('../../../kernel/lib/xorg/jQuery/plugin/scrollTo/jquery.scrollTo-1.4.3.1-min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/modal/modal.js');
include('../../../kernel/lib/xorg/jQuery/plugin/tipTip/jquery.tipTip.minified.js');
include('../../../kernel/lib/xorg/jQuery/plugin/sharrre/jquery.sharrre-1.3.4.js');
include('../../../kernel/lib/xorg/jQuery/plugin/sharrre/start.js');
include('../../../kernel/lib/xorg/jQuery/plugin/easing/jquery.easing.1.3.js');
include('../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.mcdropdown.js');
include('../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.bgiframe.js');
include('../../../kernel/lib/xorg/jQuery/plugin/masonry/masonry.pkgd.min.js');
//include('../../../kernel/lib/xorg/jQuery/plugin/isotope/jquery.isotope.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/elevateZoom/jquery.elevateZoom-3.0.8.min.js');
include('../../../kernel/lib/xorg/jQuery/plugin/showPassword/jquery.showpassword.js');
include('../../../kernel/lib/xorg/jQuery/plugin/simpleTreeMenu/jquery-simpleTreeMenu-1.2.0.js');
include('custom.js');
include('startUp.js');
//include('../../../kernel/lib/xorg/respond/prefixfree/prefixfree.min.js');

if(extension_loaded('zlib')){ob_end_flush();}
?>