<?php
if(extension_loaded('zlib')){
	ob_start('ob_gzhandler');
}
header ('content-type: text/css; charset: UTF-8');
header ('cache-control: must-revalidate');
$offset = 168 * 60 * 60;
$expire = 'expires: ' . gmdate ('D, d M Y H:i:s', time() + $offset) . ' GMT';
header ($expire);
ob_start('compress');
function compress($buffer) {
	
	// remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// Remove space after colons
	$buffer = str_replace(array(": ", " : "), ':', $buffer);
 	// Remove whitespace
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	
	return $buffer;
}

// list CSS files to be included
include('reset.css');
include('global.css');
include('regional.css');
include('responsive.css');
include('modules.css');
include('iosSlider/style.css');
include('tipTip/tipTip.css');
include('newsTicker/style.css');
include('spasticNav/style.css');
include('mcdropdown/jquery.mcdropdown.css');

if(extension_loaded('zlib')){ob_end_flush();}
?>