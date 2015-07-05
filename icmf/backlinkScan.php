<?php
define ( "superVisor", "kernel/controller/superVisor" );
if (file_exists ( superVisor . ".php" ))
	require_once (superVisor . ".php");
date_default_timezone_set ( $settings ['timezone'] );
$system->security->session->manager ();

function scanValidation($backlinkCustomer) {
	
	$tag = $system->seo->findTag ( '//a[@href="$backlinkCustomer"]' );
	echo 'Href: ' . $tag->item ( 0 )->getAttribute ( 'href' ) . '<br>';
	echo 'Title: ' . $tag->item ( 0 )->getAttribute ( 'title' ) . '<br>';
	echo 'Rel: ';
	if (stristr ( $tag->item ( 0 )->getAttribute ( 'rel' ), 'nofollow' ))
		echo '<font color=red>' . $tag->item ( 0 )->getAttribute ( 'rel' ) . '</font>';
	else
		echo '<font color=green>' . $tag->item ( 0 )->getAttribute ( 'rel' ) . '</font>';
}

function addBacklink($backlinkCustomer){
	global $settings, $system;
	
	$tags = $system->seo->findTag ( '//a' );
	for($i = 0; $i < $tags->length; $i++){
		$href = $tags->item($i)->getAttribute('href');
		if(stristr($tags->item($i)->getAttribute('rel'), 'nofollow')){
			if($href != $backlinkCustomer && $system->dbm->db->count_records("`$settings[backlinkCategory]`", "`url` = '$href'") > 0){
				$system->dbm->db->insert("`$settings[backlinkObject]`", "`active`, `owner`, `group`, `or`, `ox`, `url`", "1, 1, 1, 1, 1, $href");
			}
		}
	}
}

function scan (){
	global $settings, $system;
	
	
	$system->seo->seo ( null, $system->utility->getContent->fetchUrl ( 'http://davidwalsh.name/curl-post' ) );
}

?>