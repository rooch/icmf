<?php

function compress($string) {

	// remove comments
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	// Remove space after colons
	$string = str_replace(array(": ", " : ", " :"), ':', $string);
	// Remove whitespace
	$string = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $string);

	return $string;
}

function loadFiles(){
	
	$files = array(
		'../../../kernel/lib/xorg/jQuery/jquery-ui-1.11.2/jquery-ui.min.css',
		'reset.css',
		'global.css',
		'regional.css',
		'responsive.css',
		'modules.css',
		'layerSlider/layerSlider.css',
// 		'hoverDir/style.css',
		'animate/animate.css',
// 		'sharrre/style.css',
		'tipTip/tipTip.css',
		//'leanPlayer/leanbackPlayer.default.css',
		//'newsTicker/style.css',
		'mcdropdown/jquery.mcdropdown.css',
		//'carousel/carousel.css',
// 		'pureCssSlider/style.css',
// 		'pureCssSlider/animation.css',
// 		'countdown/countdown.css',
		'awesomeFont/font-awesome.css'
	);
	
	foreach ($files as $file){
		$string .= file_get_contents($file);
	}
	
	return compress($string);
}

if(extension_loaded('zlib')){
	ob_start('ob_gzhandler');
}

header ('content-type: text/css; charset: UTF-8');
header ('cache-control: must-revalidate');
$offset = 168 * 60 * 60;
$expire = 'expires: ' . gmdate ('D, d M Y H:i:s', time() + $offset) . ' GMT';
header ($expire);
ob_start();

if(file_exists('../../../tmp/cache/style.css')){
	if(filemtime('../../../tmp/cache/style.css') < (time()-2592000)){
		file_put_contents('../../../tmp/cache/style.css', loadFiles());		
	}
}else{
	file_put_contents('../../../tmp/cache/style.css', loadFiles());
}
include ('../../../tmp/cache/style.css');
if(extension_loaded('zlib')){ob_end_flush();}

?>