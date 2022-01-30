<?php
$NO_REDIRECT = 1;
include "includes/common.php";

if($_SERVER['REQUEST_METHOD']=="POST")
{	
	####################################################################################
	// First, make sure the form was posted from a browser.
	// For basic web-forms, we don't care about anything  other than requests from a browser:    
	if(!isset($_SERVER['HTTP_USER_AGENT']))
		ForceOut(5);
	
	// Make sure the form was indeed POST'ed: (requires your html form to use: action="post") 
	if(!$_SERVER['REQUEST_METHOD'] == "POST")
		ForceOut(5);

	#########################################################################################  
	if(isset($_POST["txtemail"]) && isset($_POST["txtpassword"])) // && isset($_POST["btnlogin"]))
	{	
		$username = db_input($_POST["txtemail"]);
		$password = htmlspecialchars_decode(db_input($_POST["txtpassword"]));		

		$ret=0; //error flag

		if($password=='')   
			ForceOut(8);
		elseif($username=='')   
			ForceOut(7);
		else
		{
			$u_id = 0;
			$q = "select iMemID, vName, vPassword, vPic from member where vUserName='".$username."' and cStatus='A' ";
			$r = sql_query($q);
			$row = sql_fetch_row($r);

			if(!empty($row) && count($row))
			{
				list($u_id, $u_name, $u_pass, $u_pic) = $row;
				$verify = password_verify($password, $u_pass);
				$ret = ($verify)? 1: -1;
			}
			else
				$ret=-2;	//No User Found

			if($ret == -1 || $ret == -2)
			{
				ForceOut(4);	
			}
			elseif($ret == 1)
			{			
				session_destroy();
				session_start();
				session_regenerate_id();
				${PROJ_SESSION_ID} = new userdat;
				
				$randomtoken = base64_encode(uniqid(rand(), true));
				
				$_SESSION[PROJ_SESSION_ID] = new userdat;
				$_SESSION[PROJ_SESSION_ID]->log_time = NOW;	
				$_SESSION[PROJ_SESSION_ID]->log_stat = "A";	
				$_SESSION[PROJ_SESSION_ID]->user_id = $u_id;	
				$_SESSION[PROJ_SESSION_ID]->user_pic = $u_pic;	
				$_SESSION[PROJ_SESSION_ID]->user_name = $u_name;	
				$_SESSION[PROJ_SESSION_ID]->sess = session_id();
				$_SESSION[PROJ_SESSION_ID]->rmadr = $_SERVER['REMOTE_ADDR'];
				$_SESSION[PROJ_SESSION_ID]->sess_token = $randomtoken;
				$_SESSION[PROJ_SESSION_ID]->sess_active = 'Y';

				$q = "update member set dtLastLogin='".NOW."', vLastLoginIP='".$_SERVER['REMOTE_ADDR']."', vSessionToken='$randomtoken' where iMemID=$u_id";
				$r = sql_query($q);
				// echo '1';exit;
				
				header("location:home.php");
			}
		}
	}
	else
		ForceOut(4);
}
else
{
	session_destroy(); // destroy all data in session
	die("Forbidden - You are not authorized to view this page");
	exit;
}
?>