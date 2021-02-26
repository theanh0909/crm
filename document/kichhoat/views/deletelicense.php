<?php ob_start(); ?>
<?php 
session_start();
require_once("../Include/header.php");
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");

if($id != "")
{
	$result = delete_license($id);
	if($result)
	{
		echo "<script language='JavaScript'> alert('Key đã được xóa');
			window.history.back(-1);
			</script>";
	}
	else
	{
		echo "<script language='JavaScript'> alert('Key đã được đăng ký, không thể xóa');
			window.history.back(-1);
			</script>";
		//header( 'Location: administrator.php' );
	}
}
?>
<?php ob_flush(); ?>