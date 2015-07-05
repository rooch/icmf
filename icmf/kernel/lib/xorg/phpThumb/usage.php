<?php
require_once 'ThumbLib.inc.php';

$fileName = (isset($_GET['file'])) ? urldecode($_GET['file']) : '../../../../theme/eBay/img/default.jpg';
$pathParts = @pathinfo($_GET['file']);

try {
	$thumb = @PhpThumbFactory::create($fileName);
}catch(Exception $e){
	$thumb = @PhpThumbFactory::create('../../../../theme/eBay/img/default.jpg');
}

if(isset($_GET['width']) || isset($_GET['height'])) $thumb->resize(urldecode($_GET['width']), urldecode($_GET['height']));
if(isset($_GET['cropSize'])) $thumb->cropFromCenter(urldecode($_GET['cropSize']));
if(isset($_GET['rotateDegrees'])) $thumb->rotateImageNDegrees(urldecode($_GET['rotateDegrees']));
$thumb->save("../../../../tmp/cache/img/$pathParts[filename]-$_GET[width]-$_GET[height].$pathParts[extension]", urldecode($pathParts[extension]));

//$thumb->show();

?>