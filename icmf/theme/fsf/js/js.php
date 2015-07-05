<?php
function compress($string) {

	// remove comments
	$string = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $string);
	// Remove whitespace
	//	$string = str_replace(array("\r\n", "\r", "\n", "\t", 'Â  ', 'Â Â Â  ', 'Â Â Â  '), '', $string);

	return $string;
}

function loadFiles(){

	$files = array(
		'../../../kernel/lib/xorg/modernizr/modernizr.custom.33475.js',
	//'../../../kernel/lib/xorg/respond/src/respond.js',
		'../../../kernel/lib/xorg/jQuery/jquery-ui-1.11.2/external/jquery/jquery.min.1.10.js',
		'../../../kernel/lib/xorg/jQuery/jquery-ui-1.11.2/jquery-ui.min.js',
		'../../../kernel/lib/xorg/jQuery/jquery-migrate-1.0.0.min.js',
		'../../../kernel/lib/xorg/global/global.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/address/jquery.address-1.5.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/showLoading/jquery.showLoading.min.js',
		'../../../kernel/lib/xorg/ajax/ajax.js',
		'../../../kernel/lib/xorg/jQuery/plugin/layerSlider/layerslider.kreaturamedia.jquery-min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/scrollTo/jquery.scrollTo-1.4.3.1-min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/modal/modal.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/tipTip/jquery.tipTip.minified.js',
		'../../../kernel/lib/xorg/jQuery/plugin/sharrre/jquery.sharrre-1.3.4.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/sharrre/start.js',
		'../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.mcdropdown.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/mcdropdown/jquery.bgiframe.js',
		'../../../kernel/lib/xorg/jQuery/plugin/masonry/masonry.pkgd.min.js',
	//'../../../kernel/lib/xorg/jQuery/plugin/isotope/jquery.isotope.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/hoverDir/jquery.hoverdir.js',
		'../../../kernel/lib/xorg/jQuery/plugin/elevateZoom/jquery.elevateZoom-3.0.8.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/showPassword/jquery.showpassword.min.js',
		'../../../kernel/lib/xorg/jQuery/plugin/countdown/jquery.countdown.min.js',
		'custom.js',
		'startUp.js',
	//'../../../kernel/lib/xorg/respond/prefixfree/prefixfree.min.js',	
	);

	foreach ($files as $file){
		$string .= file_get_contents($file);
	}

	return compress($string);
}

if(extension_loaded('zlib')){
	ob_start('ob_gzhandler');
}

header ('content-type: text/javascript; charset: UTF-8');
header ('cache-control: must-revalidate');
$offset = 168 * 60 * 60;
$expire = 'expires: ' . gmdate ('D, d M Y H:i:s', time() + $offset) . ' GMT';
header ($expire);
ob_start();

if(file_exists('../../../tmp/cache/js.js')){
	if(filemtime('../../../tmp/cache/js.js') < (time()-2592000)){
		file_put_contents('../../../tmp/cache/js.js', loadFiles());
	}
}else{
	file_put_contents('../../../tmp/cache/js.js', loadFiles());
}
include ('../../../tmp/cache/js.js');
if(extension_loaded('zlib')){ob_end_flush();}
?>