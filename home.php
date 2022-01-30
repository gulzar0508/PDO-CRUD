<?php
include "includes/common.php";

if(empty($sess_user_id))
{
	header("location: logout.php");
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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home Page</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
</head>
<body>
<div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card p-3 py-4">
                <div class="text-center"> 
                    <img src="<?php echo $profile_pic; ?>" width="100" class="rounded-circle"> 
                </div>
                <div class="text-center mt-3">
                    <h5 class="mt-2 mb-0"><?php echo $vName; ?></h5> 
                    <span><?php echo $vRole; ?></span>
                    <div class="px-4 mt-1">
                        <p class="fonts"><?php echo $vDetail; ?></p>
                    </div>
                    <ul class="social-list">
                        <?php
                        if(!empty($vFB_link))
                            echo '<li><a href="'.$vFB_link.'" target="_blank"><i class="fa fa-facebook"></i></a></li>';

                        if(!empty($vGoogle_link))
                            echo '<li><a href="'.$vGoogle_link.'" target="_blank"><i class="fa fa-google"></i></a></li>';

                        if(!empty($vInsta_link))
                            echo '<li><a href="'.$vInsta_link.'" target="_blank"><i class="fa fa-instagram"></i></a></li>';

                        if(!empty($vLinkedIn_link))
                            echo '<li><a href="'.$vLinkedIn_link.'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';

                        ?>
                    </ul>
                    <div class="buttons"> 
                    	<a href="editprofile.php" class="btn btn-outline-primary px-4">Edit Detail</a> 
                    	<a href="logout.php" class="btn btn-primary px-4 ms-3">Logout</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>