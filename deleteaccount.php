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

	if(password_verify($txtoldpass, $txtcode))
	{
		$sql = 'DELETE FROM member
		        WHERE iMemID = :memid';

		// prepare the statement for execution
		$statement = $CON->prepare($sql);
		$statement->bindParam(':memid', $sess_user_id, PDO::PARAM_INT);

		// execute the UPDATE statment
		if ($statement->execute()) {
			$_SESSION[PROJ_SESSION_ID]->success_info = "Account deleted successfully";
			header("location:logout.php");
			exit;
		}
	}
	else
	{
    $_SESSION[PROJ_SESSION_ID]->error_info = "Old password does not match";
	}

	// exit;

  header("location: deleteaccount.php");
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
		    <form method="post" action="deleteaccount.php" name="deleteaccount" enctype="multipart/form-data" autocomplete="off">
		    	<input type="hidden" name="mode" id="mode" value="CHANGE" />
		    	<input type="hidden" name="code" id="code" value="<?php echo $vPassword; ?>" />
		    <div class="row">
		        <?php require '_profileimg.php'; ?>
		        <div class="col-xl-4">

		            <div class="card mb-4">
		                <div class="card-header">Delete Account</div>
		                <div class="card-body">
                      <div class="row gx-3 mb-3">
                          <div class="col-md-12">
                              <label class="small mb-1" for="txtoldpass">Account Password</label>
                              <input class="form-control" name="txtoldpass" id="txtoldpass" type="password" placeholder="Enter your account password" value="">
                          </div>
                      </div>

                      <!-- Save changes button-->
                      <button class="btn btn-danger" type="submit">Delete Account</button>
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
			  $("form[name='deleteaccount']").validate({
			    rules: {
			      txtoldpass: {
			        required: true,
			        minlength: 5
			      }
			    },
			    
			    messages: {
			      txtoldpass: {
			        required: "Please provide your password",
			        minlength: "Your password must be at least 5 characters long"
			      }
			    },

			    submitHandler: function(form) 
			    {
			    	var msg = "You are about to delete this account.\nThis change cannot be undone, continue ?";

			    	if(confirm(msg))
			    	{
		        	var old_pass = passwordify(txtoldpass.value);
		        	txtoldpass.value = old_pass;
		        	form.submit();
			    	}
			    }
			  });
			});
		</script>
	</body>
</html>