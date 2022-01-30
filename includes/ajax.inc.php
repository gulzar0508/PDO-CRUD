<?php
$NO_REDIRECT = 1;
include "common.php";

$result = "";
if(isset($_GET['response'])) $response = $_GET['response'];
else if(isset($_POST['response'])) $response = $_POST['response'];
else $response = false;

if($response == 'UNIQUE_EMAIL')
{
	$email = isset($_POST['email'])?$_POST['email']:"";
	$ref_id = isset($_POST['ref_id'])?$_POST['ref_id']:"";

	if(!empty($email))
	{
		$cond = !empty($ref_id)?"and iMemID<>'$ref_id' ":"";
		$result = GetXFromYID("select count(*) from member where vUserName='".$email."' $cond");
	}
}
else if($response == 'PASSWORDIFY')
{
	$password = isset($_POST['pass_str'])?$_POST['pass_str']:"";

	if(!empty($password))
	{
		$txtpassword = htmlspecialchars_decode(db_input($password));
		$result = base64_encode($txtpassword);

	}	
}

echo $result;
exit;
?>