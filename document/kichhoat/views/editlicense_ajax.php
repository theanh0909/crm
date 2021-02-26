<?php ob_start(); ?>
<?php 
session_start();
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");

$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
if($id != "")
{
	get_license_detail_info($id);
}

?>
<?php ob_flush(); ?>