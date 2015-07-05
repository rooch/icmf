<?php
	mysql_connect("localhost", "root", "jyu88y");
	mysql_select_db("icmf");
	mysql_set_charset('utf8');
	$result = mysql_query("SELECT `id`, `description` FROM `postObject`");
	
	while($row = mysql_fetch_array($result)){
		
		$content = mb_convert_encoding($row['description'], 'HTML-ENTITIES', 'UTF-8');
		$dom = new DOMDocument('1.0', 'UTF-8');
		@$dom->loadHTML($content);
		$xpath = new DOMXPath($dom);
		$tags = $xpath->evaluate('//p');
		$p = $tags->item(0);
		$brief = trim($p->nodeValue);
		
		if(mysql_query("UPDATE `postObject` SET `brief`='$brief' WHERE `id` = $row[id]")){
			echo "Brief Number $row[id] inserted with $brief content<br>";
		}
		
	}
	mysql_close();
?>
