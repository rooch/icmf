<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADVANCED */

define('SET_SESSION_NAME','');			// Session name
define('DO_NOT_START_SESSION','0');		// Set to 1 if you have already started the session
define('DO_NOT_DESTROY_SESSION','1');	// Set to 1 if you do not want to destroy session on logout
define('SWITCH_ENABLED','1');		
define('INCLUDE_JQUERY','1');	
define('FORCE_MAGIC_QUOTES','0');
define('ADD_LAST_ACTIVITY','1');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* DATABASE */

include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . '/application/libraries/OFC/JSON.php';

if( !defined('_ENGINE_R_MAIN') ) {
  define('_ENGINE_R_CONF', true);
  define('_ENGINE_R_INIT', true);
  include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'index.php';
}
$db = include dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."application/settings/database.php";

// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW
// DO NOT EDIT DATABASE VALUES BELOW

define('DB_SERVER',					$db['params']['host']);
define('DB_PORT',					'3306');
define('DB_USERNAME',				$db['params']['username']);
define('DB_PASSWORD',				$db['params']['password']);
define('DB_NAME',					$db['params']['dbname']);
define('TABLE_PREFIX',				$db['tablePrefix']);
define('DB_USERTABLE',				'users');
define('DB_USERTABLE_NAME',			'displayname');
define('DB_USERTABLE_USERID',		'user_id');
define('DB_USERTABLE_LASTACTIVITY',	'lastactivity');





/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* FUNCTIONS */

function getUserID() {
    $userid = 0;
    
    if (!empty($_COOKIE['PHPSESSID'])) {
        $session_id =  session_id();

        $sql = "SELECT user_id from ".TABLE_PREFIX."core_session where id = '".mysql_real_escape_string($session_id)."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $userid = $row[0];
    }

    return $userid;
}

function getFriendsList($userid,$time) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,(select storage_path from ".TABLE_PREFIX."storage_files where parent_file_id is null and file_id = ".TABLE_PREFIX.DB_USERTABLE.".photo_id) avatar, ".TABLE_PREFIX.DB_USERTABLE.".username link, cometchat_status.message, cometchat_status.status from   ".TABLE_PREFIX."user_membership join ".TABLE_PREFIX."users  on ".TABLE_PREFIX."user_membership.user_id = ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".user_id = cometchat_status.userid where ".TABLE_PREFIX."user_membership.resource_id = '".mysql_real_escape_string($userid)."' and active = 1 order by username asc");

	if (defined('DISPLAY_ALL_USERS') && DISPLAY_ALL_USERS == 1) {
		$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_NAME." username, ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." lastactivity,(select storage_path from ".TABLE_PREFIX."storage_files where parent_file_id is null and file_id = ".TABLE_PREFIX.DB_USERTABLE.".photo_id) avatar, ".TABLE_PREFIX.DB_USERTABLE.".username link, cometchat_status.message, cometchat_status.status from   ".TABLE_PREFIX."users   left join cometchat_status on ".TABLE_PREFIX.DB_USERTABLE.".user_id = cometchat_status.userid where ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." <> '".mysql_real_escape_string($userid)."' and ('".$time."'-".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_LASTACTIVITY." < '".((ONLINE_TIMEOUT)*2)."') order by username asc");

	}

	return $sql;
}

function getUserDetails($userid) {
	$sql = ("select ".TABLE_PREFIX.DB_USERTABLE.".".DB_USERTABLE_USERID." userid, ".TABLE_PREFIX."users.".DB_USERTABLE_NAME." username, ".TABLE_PREFIX."users.".DB_USERTABLE_LASTACTIVITY." lastactivity,  ".TABLE_PREFIX.DB_USERTABLE.".username link, (select storage_path from ".TABLE_PREFIX."storage_files where parent_file_id is null and file_id = ".TABLE_PREFIX.DB_USERTABLE.".photo_id) avatar, cometchat_status.message, cometchat_status.status from ".TABLE_PREFIX."users left join cometchat_status on ".TABLE_PREFIX."users.user_id = cometchat_status.userid where ".TABLE_PREFIX."users.user_id = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function updateLastActivity($userid) {
	$sql = ("update `".TABLE_PREFIX.DB_USERTABLE."` set ".DB_USERTABLE_LASTACTIVITY." = '".getTimeStamp()."' where ".DB_USERTABLE_USERID." = '".mysql_real_escape_string($userid)."'");
	return $sql;
}

function getUserStatus($userid) {
	 $sql = ("select ".TABLE_PREFIX."users.status message, cometchat_status.status from ".TABLE_PREFIX."users left join cometchat_status on ".TABLE_PREFIX."users.user_id = cometchat_status.userid where ".TABLE_PREFIX."users.user_id = '".mysql_real_escape_string($userid)."'");
	 return $sql;
}

function getLink($link) {
	return BASE_URL."../profile/".$link;
}

function getAvatar($image) {
	if (is_file(dirname(dirname(__FILE__))."/".$image)) {
		return BASE_URL."../".$image;
	} else {
		return BASE_URL."../application/modules/User/externals/images/nophoto_user_thumb_icon.png";
	}
}


function getTimeStamp() {
	return time();
}

function processTime($time) {
	return $time;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* HOOKS */

function hooks_statusupdate($userid,$statusmessage) {
	$sql = ("update ".TABLE_PREFIX."users set status = '".mysql_real_escape_string($statusmessage)."', status_date = '".date("Y-m-d H:i:s",getTimeStamp())."' where user_id = '".mysql_real_escape_string($userid)."'");
 	$query = mysql_query($sql);
}

function hooks_forcefriends() {
	
}

function hooks_activityupdate($userid,$status) {

}

function hooks_message($userid,$unsanitizedmessage) {
	
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* LICENSE */
// nulled by ahmadfauz1992

$p_ = 4;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
