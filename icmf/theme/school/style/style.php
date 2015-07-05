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
	return $buffer;
}

// list CSS files to be included
include('global.css');
include('regional.css');
include('modules.css');
include('nivoSlider/themes/default/default.css');
include('nivoSlider/themes/nivo-slider.css');
include('nivoSlider/themes/style.css');
include('menu/style.css');
include('jqDock/style.css');
include('tipTip/tipTip.css');
include('newsTicker/style.css');
include('mcdropdown/jquery.mcdropdown.css');

if(extension_loaded('zlib')){ob_end_flush();}
?>