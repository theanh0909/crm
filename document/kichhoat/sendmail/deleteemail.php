<?php ob_start(); ?>
<?php 
session_start();
require_once("../Include/header.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
if($id != "")
{
	$result = delete_email($id);
		echo "<script language='JavaScript'>
			window.history.back(-1);
			</script>";
	
}
?>
<?php ob_flush(); ?>
