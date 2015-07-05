<?php 

class treeElement extends htmlElements{
	
	private $leaf;
	
	function treeElement(){
		
	}
	
	public function treeTrace($table, $category=0, $level=0, $flag=0, $filter=null) {
		global $system, $lang, $settings;
				
		$pureFilter = $filter;
		$filter = (!empty($filter)) ? "AND $filter" : null;
		$result = mysql_query("SELECT `id`, `category`, `name` FROM `$table` WHERE `category` = $category $filter");
		if(!empty($result)){
			if($flag == 1)
			$this->leaf .= str_repeat("\t", $level+1) . "<ul>\n";
			while ($row = mysql_fetch_array($result)){
				$res = mysql_query("SELECT `id` FROM `$table` WHERE `category` = $row[id]");
				if(mysql_num_rows($res) > 0){
					$this->leaf .= str_repeat("\t", $level+2) . "<li id='$row[id]'>$row[name]\n";
					$this->treeTrace($table, $row['id'], $level+1, 1, $pureFilter);
					$this->leaf .= str_repeat("\t", $level+2) . "</li>\n";
				}else{
					$this->leaf .= str_repeat("\t", $level+2) . "<li id='$row[id]' rel='$row[id]'>$row[name]</li>\n";
				}
			}
			if($flag == 1)
			$this->leaf .= str_repeat("\t", $level+1) . "</ul>\n";
		}
		return $this->leaf;	
	}
	
	public function tree($table, $category, $id, $class, $filter=null){
		return "<ul id='$id' class='$class'>\n" . $this->treeTrace($table, $category, '', '', $filter) . "\n" . "</ul>";	
	}
	
	
}

?>