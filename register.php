<?php
$NO_REDIRECT = 1;
include "includes/common.php";

if(isset($_POST['mode']) && $_POST['mode']=='REGISTER')
{
	$firstname = isset($_POST['firstname'])?$_POST['firstname']:"";
	$email = isset($_POST['email'])?$_POST['email']:"";
	$password = isset($_POST['password'])?$_POST['password']:"";

	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	// echo "select count(*) from member where vUserName ='".$email."' ";	
	$chkUserExists = GetXFromYID("select count(*) from member where vUserName ='".$email."' ");

	if(empty($chkUserExists))
	{
		// new user
		$mem_id = NextID( "iMemID", "member");
		$q = "INSERT INTO member(iMemId, vName, vUserName, vPassword,  cStatus) VALUES ($mem_id , '$firstname', '$email', '$password_hash', 'A')";
		$r = sql_query($q);
		$rows_affected = $r->rowCount();

		if($rows_affected)
		{
			$q = "select iMemID, vName, vPassword, vPic from member where vUserName='".$email."' and cStatus='A' ";
			$r = sql_query($q);
			$num = sql_fetch_row($r);

			$txtpassword = password_hash($password, PASSWORD_DEFAULT);
			if(isset($num) && count($num))
			{
				list($u_id, $u_name, $u_pass, $u_pic) = $num;
				$ret = ($u_pass==($txtpassword))? 1: -1;	// 1 - txtpassword Matches ::  -1 - txtpassword MisMatch

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

				// DFA($_SESSION);
				header("location: home.php");
				exit;
			}
			else
				$ret=-2;	//No User Found;
		}
	}
	else
	{
		// user already exists
		// echo "email id already exists..";
		$_SESSION[PROJ_SESSION_ID]->error_info = "Email Id already exists";
		header("location:index.php");
		exit;
	}
}
else
{
	header("location:index.php");
	exit;
}
?>