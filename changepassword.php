<?php
include "includes/common.php";
if(empty($sess_user_id))
{
	header("location:logout.php");
	exit;
}

$q = "SELECT * from member where iMemID=$sess_user_id";
$r = sql_query($q);
$data = $r->fetch(PDO::FETCH_ASSOC);
// DFA($data);
// exit;

$vPassword = isset($data['vPassword'])?$data['vPassword']:"";
$vPic = isset($data['vPic'])?$data['vPic']:"";

$profile_pic = DEFAULT_AVATAR;
if(IsExistFile($vPic, PROFILE_UPLOAD))
	$profile_pic = PROFILE_PATH.$vPic;

if(isset($_POST['mode']) && $_POST['mode']=='CHANGE')
{
	// update here;
	$txtcode = isset($_POST['code'])?$_POST['code']:"";
	$txtoldpass = isset($_POST['txtoldpass'])?htmlspecialchars_decode(db_input($_POST['txtoldpass'])):"";
	$txtnewpass = isset($_POST['txtnewpass'])?$_POST['txtnewpass']:"";
	$txtcnfpass = isset($_POST['txtcnfpass'])?$_POST['txtcnfpass']:"";

	// $enc_b64 = base64_encode('gulzar123');
	// $enc_pwd = password_hash($enc_b64, PASSWORD_DEFAULT);
	// echo $enc_pwd;
	// echo 'verify: '.password_verify($enc_b64, $enc_pwd).'<br/>';
	// echo $txtcode.'<br/>';
	// echo $txtoldpass.'<br/>';
	// echo '==>'.password_verify($txtoldpass, $txtcode);
	if(password_verify($txtoldpass, $txtcode))
	{
		// echo '1';
		$member = [
			'memid'=>$sess_user_id,
			'password'=>password_hash($txtnewpass, PASSWORD_DEFAULT)
		];

		$sql = 'UPDATE member
		        SET vPassword = :password
		        WHERE iMemID = :memid';
		// prepare statement
		$statement = $CON->prepare($sql);

		// bind params
		$statement->bindParam(':memid', $member['memid'], PDO::PARAM_INT);
		$statement->bindParam(':password', $member['password']);
		
		// execute the UPDATE statment
		if ($statement->execute()) {
			$_SESSION[PROJ_SESSION_ID]->success_info = "Password changed successfully";
		}
	}
	else
	{
    $_SESSION[PROJ_SESSION_ID]->error_info = "Old password does not match";
	}

	// exit;

  header("location: changepassword.php");
  exit;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title></title>
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
		<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="assets/css/style2.css" />
	</head>
	<body>
		<div class="container-xl px-4 mt-4">
		    <!-- Account page navigation-->
		    <?php require "_header_nav.php"; ?>
		    <hr class="mt-0 mb-4">
		    <?php echo $sess_info_str; ?>
		    <form method="post" action="changepassword.php" name="changepassword" enctype="multipart/form-data" autocomplete="off">
		    	<input type="hidden" name="mode" id="mode" value="CHANGE" />
		    	<input type="hidden" name="code" id="code" value="<?php echo $vPassword; ?>" />
		    <div class="row">
		        <?php require '_profileimg.php'; ?>
		        <div class="col-xl-4">

		            <div class="card mb-4">
		                <div class="card-header">Change Password</div>
		                <div class="card-body">
                      <div class="row gx-3 mb-3">
                          <div class="col-md-12">
                              <label class="small mb-1" for="txtoldpass">Old Password</label>
                              <input class="form-control" name="txtoldpass" id="txtoldpass" type="password" placeholder="Enter your old password" value="">
                          </div>
                          <div class="col-md-12">
                              <label class="small mb-1" for="txtnewpass">New Password</label>
                              <input class="form-control" name="txtnewpass" id="txtnewpass" type="password" placeholder="Enter your new password" value="">
                          </div>
                          <div class="col-md-12">
                              <label class="small mb-1" for="txtcnfpass">Confirm Password</label>
                              <input class="form-control" name="txtcnfpass" id="txtcnfpass" type="text" placeholder="Confirm new password" value="">
                          </div>
                      </div>

                      <!-- Save changes button-->
                      <button class="btn btn-primary" type="submit">Save changes</button>
		                </div>
		            </div>
		        </div>
		    </div>
		    </form>
		</div>
		<!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/js-md5@0.7.3/src/md5.min.js"></script>
		<script type="text/javascript" src="assets/js/common.js"></script>
		<script type="text/javascript">
			$(function() {
			  $("form[name='changepassword']").validate({
			    rules: {
			      txtoldpass: {
			        required: true,
			        minlength: 5
			      },
			      txtnewpass: {
			        required: true,
			        minlength: 5
			      },
			      txtcnfpass: {
			        required: true,
			        minlength: 5
			      }
			    },
			    
			    messages: {
			      txtoldpass: {
			        required: "Please provide your old password",
			        minlength: "Your password must be at least 5 characters long"
			      },
			      txtnewpass: {
			        required: "Please provide new password",
			        minlength: "Your password must be at least 5 characters long"
			      },
			      txtcnfpass: {
			        required: "Please confirm new password",
			        minlength: "Your password must be at least 5 characters long"
			      }
			    },

			    submitHandler: function(form) 
			    {
			    	if(txtnewpass.value!==txtcnfpass.value)
			    	{
			    		alert('Password mismatch');
			    		return false;
			    	}

		        var old_pass = passwordify(txtoldpass.value);
		        var new_pass = passwordify(txtnewpass.value);
		        txtoldpass.value = old_pass;
		        txtnewpass.value = new_pass;
		        form.submit();
			    }
			  });
			});
		</script>
	</body>
</html>