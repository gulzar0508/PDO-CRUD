<?php
$NO_REDIRECT = 1;
require_once('includes/common.php');

session_destroy();
header('location:index.php');
exit;
?>