<?php
class db_oracle {
	var $classname="db_oracle";  
  	var $db_result;  
	var $db_affected_rows;  
  	var $saved_results=array();  
	var $results_saved=0; 
	
	function db_oracle($host, $user, $passwd, $db=null){
		$this->db_name=$db;  
		$this->db_user=$user;  
		$this->db_passwd=$passwd;  
		$this->db_host=$host;
		  
		$this->db_link_ptr=ora_logon("$user@$host",$passwd) or $this->error("",ora_error(),ora_errcode());  
		$this->dbhandler=@ora_select_db($db); 
	}
	
	function error($where="",$error,$errno) {  
			echo "$where<br>";  
			die($error."<br>".$errno);  
	}  
	
	/*function select($fields,$tables,$where="",$order_by="",$group_by="",$having=""){  
		$sql_stat=" select $fields from $tables "; 
		if (!empty($where)) $sql_stat.="where $where ";  
		if (!empty($group_by)) $sql_stat.="group by $group_by ";  
		if (!empty($order_by)) $sql_stat.="order by $order_by ";  
		if (!empty($having)) $sql_stat.="having $having ";  
		 
		$this->db_result=@mssql_query($sql_stat) or print("Error");  
		$this->db_affected_rows=@mssql_num_rows($this->db_result);  
		  
		return $sql_stat;  
	}  
	
	function fetch_array() {  
		$row=mssql_fetch_array($this->db_result);  
		return $row;  
	}*/
		
	function close(){
		ora_logoff($this->db_link_ptr);
	}
}