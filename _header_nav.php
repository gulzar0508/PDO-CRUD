<?php
$home = ($_file_name=='home.php')?"active ms-0":"";
$profile = ($_file_name=='editprofile.php')?"active ms-0":"";
$password = ($_file_name=='changepassword.php')?"active ms-0":"";
$del_acc = ($_file_name=='deleteaccount.php')?"active ms-0":"";
?>
<nav class="nav nav-borders">
	<a class="nav-link <?php echo $home; ?>" href="home.php">Home</a>
	<a class="nav-link <?php echo $profile; ?>" href="editprofile.php">Profile</a>
	<a class="nav-link <?php echo $password; ?>" href="changepassword.php">Change Password</a>
	<a class="nav-link <?php echo $del_acc; ?>" href="deleteaccount.php">Delete Account</a>
</nav>