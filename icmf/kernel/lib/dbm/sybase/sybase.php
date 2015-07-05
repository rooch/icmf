<?php
class db_sybase {
	var $classname="db_sybase";  
  	var $db_result;  
	var $db_affected_rows;  
  	var $saved_results=array();  
	var $results_saved=0; 
	
	function db_sybase($host, $user, $passwd, $db=null){
		$this->db_name=$db;  
		$this->db_user=$user;  
		$this->db_passwd=$passwd;  
		$this->db_host=$host;
		  
		$this->db_link_ptr=sybase_connect($host,$user,$passwd) or die("Couldn't connect to Sybase Server on $host");  
		$this->dbhandler=@sybase_select_db($db); 
	}
	
	function select($fields,$tables,$where="",$order_by="",$group_by="",$having=""){  
		$sql_stat=" select $fields from $tables "; 
		if (!empty($where)) $sql_stat.="where $where ";  
		if (!empty($group_by)) $sql_stat.="group by $group_by ";  
		if (!empty($order_by)) $sql_stat.="order by $order_by ";  
		if (!empty($having)) $sql_stat.="having $having ";  
		 
		$this->db_result=@sybase_query($sql_stat) or print("Error");  
		$this->db_affected_rows=@sybase_num_rows($this->db_result);  
		  
		return $sql_stat;  
	}  
	
	function fetch_array() {  
		$row=sybase_fetch_array($this->db_result);  
		return $row;  
	}
		
	function close(){
		sybase_close($this->db_link_ptr);
	}
}