<?php
class session extends system{

	public $gid;
	public $host;
	public $ip;
	public $reffer;
	public $agent;
	public $table = "session";
	public $uid;
	public $op;
	public $mode;

	function session(){

		$this->table = $this->tablePrefix . $this->table;
		$this->ip = mysql_real_escape_string($_SERVER[REMOTE_ADDR]);
		$this->host = mysql_real_escape_string(gethostbyaddr($_SERVER[REMOTE_ADDR]));
		$this->reffer = mysql_real_escape_string($_SERVER[HTTP_REFERER]);
		$this->agent = mysql_real_escape_string($_SERVER[HTTP_USER_AGENT]);
		$this->op = $_POST[op];
		$this->mode = $_POST[mode];
			
	}
	public function start($uid, $uType = 1, $gid){
		global $system;

		$timeStamp = time();
		$_SESSION['uid'] = intval($uid);
		$_SESSION['uType'] = intval($uType);
		$_SESSION['gid'] = $gid;
		$_SESSION['firstName'] = '';
		$_SESSION['lastName'] = '';
		$_SESSION['email'] = '';		
		$_SESSION['timeStamp'] = $timeStamp;
		$_SESSION['periodTime'] = 60 * rand(10, 30);

		$system->dbm->db->insert("`$this->table`", "`active`, `timeStamp`, `owner`, `group`, `or`, `ow`, `ox`, `gr`, `uid`, `uType`, `agent`, `reffer`, `ip`, `host`, `op`, `mode`", "1, $timeStamp, 1, 5, 1, 1, 1, 1, $_SESSION[uid], $_SESSION[uType], '$this->agent', '$this->reffer', '$this->ip', '$this->host', '$this->op', '$this->mode'");
	}
	public function kill($uid){
		global $system;

		$system->dbm->db->delete("`$this->table`", "`uid` = $uid");
		session_unset();
		session_destroy();
	}
	public function check($uid){
		if($system->dbm->db->count_records("`$this->table`", "`uid` = $uid") > 0 && session_is_registered('uid'))
		return true;
		else
		return false;
	}
	public function read($field=null){
		global $system;

		$system->dbm->db->select("*", "`$this->table`", "`ip` = '$_SERVER[REMOTE_ADDR]'");
		$sessData = $system->dbm->db->fetch_array();

		if(!empty($field)){
			return $sessData[$field];
		}else{
			return array(
				'uid', $_SESSION[uid],
				'gid', $_SESSION[gid],
				'ip', $sessData[ip],
				'host', $sessData[host],
				'time', $sessData[time],
				'reffer', $sessData[reffer]
			);
		}
	}
	public function update($uid, $uType, $gid, $firstName=null, $lastName=null, $email=null){
		global $system;

		$timeStamp = time();
		$_SESSION['uid'] = intval($uid);
		$_SESSION['uType'] = intval($uType);
		$_SESSION['gid'] = $gid;
		$_SESSION['firstName'] = $firstName;
		$_SESSION['lastName'] = $lastName;
		$_SESSION['email'] = $email;
		$_SESSION[timeStamp] = time();
		
		$system->dbm->db->update("`$this->table`", "`timeStamp` = '$timeStamp', `op` = '$this->op', `mode` = '$this->mode'", "`uid` = $uid");
	}

	public function delete(){
		global $settings, $system;

		$timeStamp = time();
		$offsetTime = $timeStamp - $settings[sessionTimeOut];
		$system->dbm->db->delete($this->table, "`timeStamp` < $offsetTime");
	}

	public function manager($uid=null, $uType=null, $gid=null, $firstName=null, $lastName=null, $email=null){
		global $system;

		session_start();
		$this->delete();
		if(empty($_SESSION['uid']) && empty($_SESSION['uType'])){
			$uid = empty($uid) ? $system->dbm->db->find_auto_inc($this->table) : $uid;
			$uType = 1;
			$gid = empty($gid) ? 3 : $gid;
			$this->start($uid, $uType, $gid);
		}elseif(!empty($_SESSION['uid']) && $_SESSION['uType'] == 1){
			$uid = empty($uid) ? $_SESSION['uid'] : $uid;
			$uType = empty($uType) ? 1 : $uType;
			$gid = empty($gid) ? 3 : $gid;
			$firstName = empty($firstName) ? null : $firstName;
			$lastName = empty($lastName) ? null : $lastName;
			$email = empty($email) ? null : $email;
			$this->update($uid, $uType, $gid, $firstName, $lastName, $email);
		}
	}
}
?>
