<?php
class mysql{

	public $db_result;
	public $db_affected_rows;

	public $saved_results=array();
	public $results_saved=0;


	public function mysql($host, $user, $passwd, $db, $create=""){
		$this->db_name=$db;
		$this->db_user=$user;
		$this->db_passwd=$passwd;
		$this->db_host=$host;
			
		$this->db_link_ptr=@mysql_connect($host,$user,$passwd) or $this->error("",mysql_error(),mysql_errno());
		$this->dbhandler=@mysql_select_db($db);
		mysql_set_charset('utf8');
		if (!$this->dbhandler) {
			if ($create=="1")  {
				@mysql_create_db($db,$this->db_link_ptr) or $this->error("imposible crear la base de datos.",mysql_error(),mysql_errno());;
				$this->dbhandler=@mysql_select_db($db);
			}
		}
	}

	public function error($where="",$error,$errno) {
		global $system, $lang;

		//		die($system->watchDog->exception("e", "$lang[dataBaseProblem] $errno", mysql_real_escape_string("$error at $where")));
		echo "$where<br>";
		die($error."<br>".$errno);
		die();
	}

	public function error_msg() {
		return mysql_error();
	}

	public function PushResults() {
		$this->saved_results[$this->results_saved]=array($this->db_result,$this->db_affected_rows);
		$this->results_saved++;
	}

	public function PopResults() {
		$this->results_saved--;
		$this->db_result=$this->saved_results[$this->results_saved][0];
		$this->db_affected_rows=$this->saved_results[$this->results_saved][1];
	}

	public function reselect_db($db){
		$this->dbhandler=@mysql_select_db($db);
	}

	public function closeDB() {
		@mysql_close($this->db_link_ptr);
	}

	public function create_table($tblName,$tblStruct) {
		if (is_array($tblStruct)) $theStruct=implode(",",$tblStruct); else $theStruct=$tblStruct;
		@mysql_query("create table $tblName ($theStruct)") or $this->error("create table $tblName ($theStruct)",mysql_error(),mysql_errno());
	}

	public function drop_table($tblName) {
		@mysql_query("drop table if exists $tblName") or $this->error("drop table $tblName",mysql_error(),mysql_errno());
	}

	public function raw_query($sql_stat) {
		$this->db_result=@mysql_query($sql_stat) or $this->error($sql_stat,mysql_error(),mysql_errno());
		$this->db_affected_rows=@mysql_num_rows($this->db_result);
	}

	public function count_records($table,$filter="") {
// 		print "select count(*) as num from $table where $filter";
		$res = @mysql_query("select count(*) as num from $table".(($filter!="")?" where $filter" : ""));
		$xx=@mysql_result($res,0,"num");
		return $xx;
	}

	public function count_rows($result){
		return mysql_num_rows($result);
	}
	
	public function sum($table, $filter="", $filed){
		
		$res = @mysql_query("select sum($field) as sum from $table".(($filter!="")?" where $filter" : ""));
		$xx=@mysql_result($res,0,"sum");
		return $xx;
	}

	public function select($fields,$tables,$where="",$order_by="",$group_by="",$having="",$limit="", $distinct="") {
		global $system, $lang;

		if($distinct == 1){
			$sql_stat=" SELECT DISTINCT $fields FROM $tables ";
		}else{
			$sql_stat=" SELECT $fields FROM $tables ";
		}

		if ($_SESSION[uid] != 1){
			if(strstr($tables, ",")){
				if(!empty($where)){
					$sql_stat.="WHERE (`base`.`owner` = $_SESSION[uid] AND `base`.`or` = 1 AND $where) OR (`base`.`group` IN ($_SESSION[gid]) AND `base`.`gr` = 1 AND $where) OR (`base`.`tr` = 1 AND $where) OR (`base`.`ur` = 1 AND $where) ";
				}else{
					$sql_stat.="WHERE (`base`.`owner` = $_SESSION[uid] AND `base`.`or` = 1) OR (`base`.`group` IN ($_SESSION[gid]) AND `base`.`gr` = 1) OR (`base`.`tr` = 1) OR (`base`.`ur` = 1) ";
				}
			}else{
				if(!empty($where)){
					$sql_stat.="WHERE (`owner` = $_SESSION[uid] AND `or` = 1 AND $where) OR (`group` IN ($_SESSION[gid]) AND `gr` = 1 AND $where) OR (`tr` = 1 AND $where) OR (`ur` = 1 AND $where) ";
				}else{
					$sql_stat.="WHERE (`owner` = $_SESSION[uid] AND `or` = 1) OR (`group` IN ($_SESSION[gid]) AND `gr` = 1) OR (`tr` = 1) OR (`ur` = 1) ";
				}
			}
		}else{
			if(!empty($where)){
				$sql_stat.= "WHERE $where ";
			}
		}

		if (!empty($group_by)) $sql_stat.="GROUP By $group_by ";
		if (!empty($order_by)) $sql_stat.="ORDER BY $order_by ";
		if (!empty($having)) $sql_stat.="HAVING $having ";
		if (!empty($limit)) $sql_stat.="LIMIT $limit ";
			
//		echo $sql_stat . "<br><br>";
		$this->db_result=@mysql_query($sql_stat) or $this->error($sql_stat,mysql_error(),mysql_errno());
		//		$this->db_affected_rows=@mysql_num_rows($this->db_result);
		//		if($this->db_affected_rows == 0){
		//			$this->error(null, $lang[thereIsNoEntry], null);
		//		}

		return $this->db_result;
	}

	public function list_tables() {
		$this->db_result=@mysql_list_tables($this->db_name);
		$this->db_affected_rows=@mysql_num_rows($this->db_result);
		return $this->db_result;
	}

	public function describe($tablename) {
		$this->result=@mysql_query("describe $tablename");
	}

	public function table_exists($tablename) {
		$this->pushresults();
		$description=$this->describe($tablename);
		$this->popresults();
		if ($description) $exists=true; else $exists=false;
		return $exists;
	}

	public function tablename($tables, $tbl) {
		return mysql_tablename($tables,$tbl);
	}

	public function insert_id() {
		return mysql_insert_id();
	}

	public function insert($table,$fields="",$values="") {
		$sql_stat="insert into $table ";

		if (is_array($fields)) $theFields=implode(",",$fields); else $theFields=$fields;
		if (is_array($values)) $theValues="'".implode("','",$values)."'"; else $theValues=$values;

		//		if(!is_array($values)){
		//			if(strstr($values, "', '")){
		//				explode("', '", $values);
		//			}elseif(strstr($values, "','")){
		//				explode("','", $values);
		//			}
		//		}
		//		foreach ($values as $key=>$value){
		//			$arr[] = mysql_real_escape_string($value);
		//		}
		//		$theValues="'" . implode("','",$arr) . "'";

		$theValues=str_replace("'now()'","now()",$theValues);

		if (!empty($theFields)) $sql_stat.="($theFields) ";
		$sql_stat.="values ($theValues)";
		return @mysql_query($sql_stat) or $this->error($sql_stat,mysql_error(),mysql_errno());
	}

	public function update($table,$newvals,$where="") {
		if (is_array($newvals)) $theValues=implode(",",$newvals); else $theValues=$newvals;

		$sql_stat="update $table set $theValues";

		if (!empty($where)) $sql_stat.=" where $where";
		@mysql_query($sql_stat) or $this->error($sql_stat,mysql_error(),mysql_errno());
	}

	public function delete($table,$where="") {

		$sql_stat="delete from $table ";

		if (!empty($where)) $sql_stat.="where $where ";

		$db_result2=@mysql_query($sql_stat) or $this->error($sql_stat,mysql_error(),mysql_errno());
		$this->db_affected_rows=@mysql_affected_rows($this->db_result2);
	}

	public function free() {
		@mysql_free_result($this->db_result) or $this->error("",mysql_error(),mysql_errno());
	}

	public function fetch_row() {
		$row=mysql_fetch_row($this->db_result);
		return $row;
	}

	public function fetch_assoc() {
		$row=mysql_fetch_assoc($this->db_result);
		return $row;
	}

	public function result($recno,$field) {
		return mysql_result($this->db_result,$recno,$field);
	}

	public function num_fields(){
		return mysql_num_fields($this->db_result);
	}

	public function fetch_array() {
		//		if(isset($this->db_result)){
		$row=mysql_fetch_array($this->db_result, MYSQL_ASSOC);
		return $row;
		//		}else{
		//			return "There is no entry";
		//		}
	}

	public function fetch_field() {
		$row=mysql_fetch_field($this->db_result);
		return $row;
	}

	public function max_auto_inc($table){
		$ret = mysql_fetch_row(mysql_query("SELECT max(`id`) FROM `$table`"));
		return $ret[0];
	}
	
	public function find_auto_inc($table){
		$ret = mysql_fetch_array(mysql_query("SHOW TABLE STATUS LIKE '$table'"));
		return $ret['Auto_increment'];
	}

	public function findMax($table, $field){

		$result = mysql_query("SELECT max($field) FROM $table");
		if($result){
			$ret = mysql_fetch_row($result);
			return $ret[0];
		}else{
			return 0;
		}
	}

	public function informer($table, $filter, $field=null, $sort='ASC'){
		global $lang;

// 		print "SELECT * FROM $table WHERE $filter ORDER BY `id` $sort<br>";
		$res = mysql_query("SELECT * FROM $table WHERE $filter ORDER BY `id` $sort");
		if(!empty($res)){
			$row = mysql_fetch_array($res, MYSQL_ASSOC);
			if(!empty($row)){
				if(!empty($field)){
					return $row[$field];
				}else{
					return $row;
				}
			}else{
				return null;
			}
		}else{
			return null;
		}
	}

	public function lookup($table, $filter=null){
		global $system;


		if(!empty($filter))
		$this->select("`id`, `name`", $table, $filter);
		else
		$this->select("`id`, `name`", $table);
		while($row = $this->fetch_array()){
			$result[$row[id]] = $row[name];
		}
		return $result;
	}

	public function hashLister($fields, $tables, $where=null, $order_by=null, $group_by=null, $having=null, $limit=null, $distinct=null){

		if(!empty($fields) && !empty($tables)){
			$this->select($fields, $tables, $where, $order_by, $group_by, $having, $limit, $distinct);
		}

		$count = 1;
		while ($row = $this->fetch_array()){
			$entityList[$count][count] = $count;
			foreach ($row as $key => $value){
				$entityList[$count][$key] = $value;
			}
			$count++;
		}
		return $entityList;
	}

	public function arrayLister($fields, $tables, $where=null, $order_by=null, $group_by=null, $having=null, $limit=null, $distinct=null){

		if(!empty($fields) && !empty($tables)){
			$this->select($fields, $tables, $where, $order_by, $group_by, $having, $limit, $distinct);
		}

		while ($row = $this->fetch_array()){
			foreach ($row as $value){
				$entityList[] = $value;
			}
		}
		return $entityList;
	}

	public function anyCol ($table, $needle){

		$denyField = array('or', 'ow', 'ox', 'gr', 'gw', 'gx', 'tr', 'tw', 'tx', 'ur', 'uw', 'ux', 'mor', 'mow', 'mox', 'mgr', 'mgw', 'mgx', 'mtr', 'mtw', 'mtx', 'mur', 'muw', 'mux');
		$result = mysql_query("SHOW COLUMNS FROM `$table`");
		if ($result) {
			if (mysql_num_rows($result) > 0) {
				while ($row = mysql_fetch_assoc($result)) {
					if(!in_array($row['Field'], $denyField)){
						$out .= "`$row[Field]` LIKE '%$needle%' OR "; 
					}
				}
				return substr($out, 0, -4);
			}
		} else {
			die(mysql_error());
		}
	}

}
?>
