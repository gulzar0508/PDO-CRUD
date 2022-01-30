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

$vName = isset($data['vName'])?$data['vName']:"";
$vUserName = isset($data['vUserName'])?$data['vUserName']:"";
$vPassword = isset($data['vPassword'])?$data['vPassword']:"";
$vPic = isset($data['vPic'])?$data['vPic']:"";
$vRole = isset($data['vRole'])?$data['vRole']:"";
$vDetail = isset($data['vDetail'])?$data['vDetail']:"";
$vFB_link = isset($data['vFB_link'])?$data['vFB_link']:"";
$vGoogle_link = isset($data['vGoogle_link'])?$data['vGoogle_link']:"";
$vInsta_link = isset($data['vInsta_link'])?$data['vInsta_link']:"";
$vLinkedIn_link = isset($data['vLinkedIn_link'])?$data['vLinkedIn_link']:"";
$dtLastLogin = isset($data['dtLastLogin'])?$data['dtLastLogin']:"";
$vLastLoginIP = isset($data['vLastLoginIP'])?$data['vLastLoginIP']:"";

$profile_pic = DEFAULT_AVATAR;
if(IsExistFile($vPic, PROFILE_UPLOAD))
	$profile_pic = PROFILE_PATH.$vPic;

if(isset($_POST['mode']) && $_POST['mode']=='UPDATE')
{
	// update here;
	$txtname = isset($_POST['txtname'])?db_input($_POST['txtname']):"";
	$txtrole = isset($_POST['txtrole'])?db_input($_POST['txtrole']):"";
    $txtdetail = isset($_POST['txtdetail'])?db_input($_POST['txtdetail']):"";
    $txtfb_link = isset($_POST['txtfb_link'])?db_input($_POST['txtfb_link']):"";
    $txtgoogle_link = isset($_POST['txtgoogle_link'])?db_input($_POST['txtgoogle_link']):"";
    $txtinsta_link = isset($_POST['txtinsta_link'])?db_input($_POST['txtinsta_link']):"";
    $txtli_link = isset($_POST['txtli_link'])?db_input($_POST['txtli_link']):"";

    $member = [
    	'memid'=>$sess_user_id,
    	'name'=>$txtname,
    	'role'=>$txtrole,
    	'detail'=>$txtdetail,
    	'fb_link'=>$txtfb_link,
    	'google_link'=>$txtgoogle_link,
    	'insta_link'=>$txtinsta_link,
    	'li_link'=>$txtli_link
    ];

    $sql = 'UPDATE member
            SET vName = :name,
            vRole = :role,
            vDetail = :detail,
            vFB_link = :fb_link,
            vGoogle_link = :google_link,
            vInsta_link = :insta_link,
            vLinkedIn_link = :li_link
            WHERE iMemID = :memid';

    // prepare statement
    $statement = $CON->prepare($sql);

    // bind params
    $statement->bindParam(':memid', $member['memid'], PDO::PARAM_INT);
    $statement->bindParam(':name', $member['name']);
    $statement->bindParam(':role', $member['role']);
    $statement->bindParam(':detail', $member['detail']);
    $statement->bindParam(':fb_link', $member['fb_link']);
    $statement->bindParam(':google_link', $member['google_link']);
    $statement->bindParam(':insta_link', $member['insta_link']);
    $statement->bindParam(':li_link', $member['li_link']);
    
    // execute the UPDATE statment
    if ($statement->execute()) {
    	$_SESSION[PROJ_SESSION_ID]->success_info = "Profile details updated successfully";
    }
    // DFA($_FILES);
    if(is_uploaded_file($_FILES["file_pic"]["tmp_name"]))
    {
      $uploaded_pic = $_FILES["file_pic"]["name"];
      $name = basename($_FILES['file_pic']['name']);
      $file_type = $_FILES['file_pic']['type'];
      $size = $_FILES['file_pic']['size'];
      $extension = substr($name, strrpos($name, '.') + 1);    

      if(IsValidFile($file_type, $extension, 'P') && $size<=3000000)
      {
        $pic_name = GetXFromYID('select vPic from member where iMemID='.$sess_user_id);

        if(!empty($pic_name))
          DeleteFile($pic_name, PROFILE_UPLOAD);

        $pic_name = $sess_user_id.'-user-'.$extension;

        // $tmp_name = "TMP_". $pic_name;
        $dir = opendir(PROFILE_UPLOAD);
        copy($_FILES["file_pic"]["tmp_name"], PROFILE_UPLOAD.$pic_name);
        closedir($dir);   // close the directory

        $q = "update member set vPic='$pic_name' where iMemID=$sess_user_id"; 
        $r = sql_query($q);
        // echo $q;
        // exit;
      }
      else
      {
        if($size>3000000)
          $_SESSION[PROJ_SESSION_ID]->error_info = "Image Could Not Be Uploaded as the File Size is greate then 3MB";
        elseif(!in_array($extension,$IMG_TYPE))
          $_SESSION[PROJ_SESSION_ID]->error_info = "Please only upload files that end in types: ".implode(',',$IMG_TYPE).". Please select a new file to upload and submit again.";
      } 
    }

    header("location: editprofile.php");
    exit;
}

if(isset($_GET['mode']) && $_GET['mode']=='DELPIC')
{
  $txtid = $sess_user_id;
	$file_name = GetXFromYID("select vPic from member where iMemID=$txtid");
	if(!empty($file_name))
		DeleteFile($file_name, PROFILE_UPLOAD);

	sql_query("update member set vPic='' where iMemID=$txtid");

	$_SESSION[PROJ_SESSION_ID]->success_info = "Image Deleted Successfully";
	header("location: editprofile.php");
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
		    <form method="post" action="editprofile.php" name="editprofile" enctype="multipart/form-data">
		    	<input type="hidden" name="mode" id="mode" value="UPDATE" />
		    <div class="row">
		        <?php require '_profileimg.php'; ?>
		        <div class="col-xl-8">
		            
		            <div class="card mb-4">
		                <div class="card-header">Account Details</div>
		                <div class="card-body">
		                        <!-- Form Group (username)-->
		                        <div class="mb-3">
		                            <label class="small mb-1" for="">Email (you cannot change this)</label>
		                            <input class="form-control" type="text" value="<?php echo $vUserName; ?>" disabled />
		                        </div>
		                        <!-- Form Row-->
		                        <div class="row gx-3 mb-3">
		                            <!-- Form Group (first name)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtname">Name</label>
		                                <input class="form-control" name="txtname" id="txtname" type="text" placeholder="Enter your name" value="<?php echo $vName; ?>">
		                            </div>
		                            <!-- Form Group (last name)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtrole">Role/Designation</label>
		                                <input class="form-control" name="txtrole" id="txtrole" type="text" placeholder="Enter your role" value="<?php echo $vRole; ?>">
		                            </div>
		                        </div>
		                        <div class="row gx-3 mb-3">
		                        	<div class="col-md-12">
		                                <label class="small mb-1" for="txtdetail">Something about yourself</label>
		                                <textarea class="form-control" name="txtdetail" id="txtdetail" ><?php echo $vDetail; ?></textarea>
		                            </div>
		                        </div>
		                        <!-- Form Row        -->
		                        <div class="row gx-3 mb-3">
		                            <!-- Form Group (organization name)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtfb_link">Facebook Link</label>
		                                <input class="form-control" name="txtfb_link" id="txtfb_link" type="text" value="<?php echo $vFB_link; ?>">
		                            </div>
		                            <!-- Form Group (location)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtgoogle_link">Google Link</label>
		                                <input class="form-control" name="txtgoogle_link" id="txtgoogle_link" type="text" value="<?php echo $vGoogle_link; ?>">
		                            </div>
		                        </div>

		                        <div class="row gx-3 mb-3">
		                            <!-- Form Group (organization name)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtinsta_link">Instagram Link</label>
		                                <input class="form-control" name="txtinsta_link" id="txtinsta_link" type="text" value="<?php echo $vInsta_link; ?>">
		                            </div>
		                            <!-- Form Group (location)-->
		                            <div class="col-md-6">
		                                <label class="small mb-1" for="txtli_link">Linked In Link</label>
		                                <input class="form-control" name="txtli_link" id="txtli_link" type="text" value="<?php echo $vLinkedIn_link; ?>">
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
			function confirm_delete()
			{
				var msg = "Delete Image ?";
				if(confirm(msg))
				{
					window.location.href = "editprofile.php?mode=DELPIC";
				}
			}
		</script>
	</body>
</html>