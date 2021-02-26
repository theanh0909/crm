<?php ob_start(); ?>
<?php

session_start();
require_once("../Include/header.php");
require_once("../model/user.php");
get_infor_from_conf("../config/DB.conf");
if ($id != "") {
    $result = delete_user($id);
    echo "<script language='JavaScript'> alert('User đã được xóa ');
			window.history.back(-1);
			</script>";
}
?>
<?php ob_flush(); ?>
