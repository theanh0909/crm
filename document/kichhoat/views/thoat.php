<?php
session_start();
require_once '../config/site.php';
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
header('Content-Type: text/html; charset=UTF-8');
echo '<title>Quản lý phần mềm GXD</title>';
Log_info(3,$_SESSION['username']);
if (session_destroy()) 
	echo "<script language='JavaScript'> alert('Bạn đã thoát thành công !^-^');
			window.location.replace('/kichhoat');
			</script>";
else
	echo "Không thể thoát được, có lỗi trong việc hủy session.";
?>
