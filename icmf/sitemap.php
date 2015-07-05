<?php 

require_once 'kernel/lib/sitemap/sitemap.php';
$sitemap = new sitemap();
echo $sitemap->generate('http://digiseo.ir');

?>