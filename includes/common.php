<?php
include "config.inc.php";
include "define.inc.php";
include "sql.inc.php";
include "common.inc.php";
include "userdat.php";

$CON = GetConnected();

$logged = 0;
$_file_name = basename($_SERVER["SCRIPT_NAME"]);
if(!isset($NO_REDIRECT))
{
	// DFA($_SESSION);
	if(isset($_SESSION[PROJ_SESSION_ID]->log_stat)) // if the session variable has been set...
	{	
		if($_SESSION[PROJ_SESSION_ID]->log_stat == "A")
		{
			$logged = 1;
			$sess_user_id = $_SESSION[PROJ_SESSION_ID]->user_id;
			$sess_user_name = $_SESSION[PROJ_SESSION_ID]->user_name;
			$sess_user_sess = $_SESSION[PROJ_SESSION_ID]->sess;
			$sess_user_pic = $_SESSION[PROJ_SESSION_ID]->user_pic;
			$sess_login_time = FormatDate($_SESSION[PROJ_SESSION_ID]->log_time, "d M Y h:i A");
			$sess_user_token = $_SESSION[PROJ_SESSION_ID]->sess_token;
			$sess_user_active = $_SESSION[PROJ_SESSION_ID]->sess_active;
		}
	}
	else
	{
		header("location: logout.php");
		exit;	
	}
}

if($logged)
{
	$sess_info = (isset($_SESSION[PROJ_SESSION_ID]->info))? NotifyThis($_SESSION[PROJ_SESSION_ID]->info, 'info'): '';
	$sess_success_info = (isset($_SESSION[PROJ_SESSION_ID]->success_info))? NotifyThis($_SESSION[PROJ_SESSION_ID]->success_info, 'success'): '';
	$sess_error_info = (isset($_SESSION[PROJ_SESSION_ID]->error_info))? NotifyThis($_SESSION[PROJ_SESSION_ID]->error_info, 'error'): '';
	$sess_alert_info = (isset($_SESSION[PROJ_SESSION_ID]->alert_info))? NotifyThis($_SESSION[PROJ_SESSION_ID]->alert_info, 'alert'): '';

	$sess_info_str = $sess_info . $sess_success_info . $sess_error_info . $sess_alert_info;

	$lbl_display = ($sess_info!="")? '': 'none';
	$_SESSION[PROJ_SESSION_ID]->info="";
	$_SESSION[PROJ_SESSION_ID]->success_info="";
	$_SESSION[PROJ_SESSION_ID]->error_info="";
	$_SESSION[PROJ_SESSION_ID]->alert_info="";	// */
}

function NotifyThis($text, $mode='alert')
{
	if($mode == 'success') $mode_str = 'alert-success';
	else if($mode == 'error') $mode_str = 'alert-danger';
	else if($mode == 'info') $mode_str = 'alert-warning';
	else $mode_str = 'alert-warning';

	if($mode == 'success') $mode_icon = 'fa fa-check-circle';
	else if($mode == 'error') $mode_icon = 'fa fa-times-circle';
	else if($mode == 'info') $mode_icon = 'fa fa-exclamation-circle';
	else $mode_icon = 'fa fa-question-circle';

	
	$text = trim($text);
	return ($text!='')?'<div class="alert '.$mode_str.' alert-dismissible fade show" role="alert"><button type="button" class="close" aria-label="Close"><spanaria-hidden="true">×</span></button><i class="'.$mode_icon.' mr-1 text-muted opacity-6"></i>'.$text.'</div>':'';
}
?>