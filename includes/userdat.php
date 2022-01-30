<?php 
// data that needs to be rememberered...
class userdat
{
	var $log_time;		// time of login
	var $log_stat;		// log status - is the user logged in or not
	var $sess_id;		// session id
///////////////////////////////////////////////

	var $user_id;
	var $user_name;		// de user's name	
	var $user_pic;	//	
	var $user_lastlogin;	//	
	var $user_ip;	//	
	
	var $info;
	var $success_info;
	var $error_info;
	var $alert_info;
	var $sess_token;
	var $sess_active;
}

$sess_id = session_id();
if(empty($sess_id))
{
	ini_set('session.gc_maxlifetime', 3600);
	session_start();
}
?>