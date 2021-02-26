<?php ob_start(); ?>
<?php
session_start();
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
$date = date("Y-m-d");
$no_record_per_page = 30;
$con = open_db();
if ($permarr['viewallregistered']) {
    $sql = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.license_serial=license.license_serial";
    $result = mysql_query($sql, $con);
    $row = mysql_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DutoanGXD' and registered.license_serial=license.license_serial";
    $result1 = mysql_query($sql1, $con);
    $row1 = mysql_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DuthauGXD' and registered.license_serial=license.license_serial";
    $result2 = mysql_query($sql2, $con);
    $row2 = mysql_fetch_array($result2);
    $total_record2 = $row2['tmp'];
	
	$sql3 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='QuyettoanGXD' and registered.license_serial=license.license_serial";
    $result3 = mysql_query($sql3, $con);
    $row3 = mysql_fetch_array($result3);
    $total_record3 = $row3['tmp'];
	
	$sql4 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='qlclGXD' and registered.license_serial=license.license_serial";
    $result4 = mysql_query($sql4, $con);
    $row4 = mysql_fetch_array($result4);
    $total_record4 = $row4['tmp'];
	
	$sql5 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='gcm' and registered.license_serial=license.license_serial";
    $result5 = mysql_query($sql5, $con);
    $row5 = mysql_fetch_array($result5);
    $total_record5 = $row5['tmp'];
	
	$sql6 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DutoanVKT' and registered.license_serial=license.license_serial";
    $result6 = mysql_query($sql3, $con);
    $row6 = mysql_fetch_array($result3);
    $total_record6 = $row6['tmp'];
	
} else {
    if ($permarr['viewregistered']) {
        $sql = "select count(*) as tmp from registered, license where last_runing_date='$date' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result = mysql_query($sql, $con);
        $row = mysql_fetch_array($result);
        $total_record = $row['tmp'];
        $sql1 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DutoanGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result1 = mysql_query($sql1, $con);
        $row1 = mysql_fetch_array($result1);
        $total_record1 = $row1['tmp'];
        $sql2 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DuthauGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result2 = mysql_query($sql2, $con);
        $row2 = mysql_fetch_array($result2);
        $total_record2 = $row2['tmp'];
		
		$sql3 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='QuyettoanGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result3 = mysql_query($sql3, $con);
        $row3 = mysql_fetch_array($result3);
        $total_record3 = $row3['tmp'];
		
		$sql4 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='qlclGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result4 = mysql_query($sql4, $con);
        $row4 = mysql_fetch_array($result4);
        $total_record4 = $row4['tmp'];
		
		$sql5 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='gcm' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result5 = mysql_query($sql5, $con);
        $row5 = mysql_fetch_array($result5);
        $total_record5 = $row5['tmp'];
		
		$sql6 = "select count(*) as tmp from registered, license where last_runing_date='$date' and registered.product_type='DutoanVKT' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result6 = mysql_query($sql6, $con);
        $row6 = mysql_fetch_array($result6);
        $total_record6 = $row6['tmp'];
    }
}
mysql_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<div id="rightcolumn">
    <form action="" method="">
        <h3 align="center"> THÔNG TIN KHÁCH HÀNG ĐANG SỬ DỤNG PHẦN MỀM</h3>
        <?php echo "<p style='margin-left:20px; color:red'><b>Tổng số máy đang sử dụng trong ngày: " . $total_record . ". </b>
        <b>Trong đó: Dự toán: " . $total_record1 . ", Dự thầu: " . $total_record2 . " - QT: " . $total_record3 . " - QLCL: " . $total_record4 . " - GCM: " . $total_record5 . " - DTVKT: " . $total_record6 . "</b>"; ?>
        <?php
        get_last_runing_date($iduser, $permarr, ($page-1) * $no_record_per_page, $no_record_per_page);
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
		 echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
    </form>
</div>
<?php
require_once("../Include/footer.php");
ob_flush();
?>
