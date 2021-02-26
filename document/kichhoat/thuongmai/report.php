<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/searchbar.php");
?>
<?php
$con = open_db();
$sql = "select count(*) as tmp from license where product_type='DutoanGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dtoan = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$sql = "select count(*) as tmp from registered where product_type='DutoanGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_kh = $row['tmp'];
mysqli_close($con);
?>	
<?php
$con = open_db();
$date = date("Y-m-d");
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$date' and registered.product_type='DutoanGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_khd = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$date = date('Y-m-d');
while (date('w', strtotime($date)) != 1) {
    $tmp = strtotime('-1 day', strtotime($date));
    $date = date('Y-m-d', $tmp);
}

$week = date('W', strtotime($date));
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and  WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DutoanGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_khw = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$today = date("Y-m-d");
$month = date('m');
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and registered.product_type='DutoanGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_khm = $row['tmp'];
mysqli_close($con);
?>

<?php
$con = open_db();
$sql = "select count(*) as tmp from license where product_type='DuthauGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dthau = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$sql = "select count(*) as tmp from registered where product_type='DuthauGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dtkh = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$date = date("Y-m-d");
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$date' and registered.product_type='DuthauGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dtkhd = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$date = date('Y-m-d');
while (date('w', strtotime($date)) != 1) {
    $tmp = strtotime('-1 day', strtotime($date));
    $date = date('Y-m-d', $tmp);
}

$week = date('W', strtotime($date));
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and  WEEKOFYEAR(license_activation_date)='$week' and registered.product_type='DuthauGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dtkhw = $row['tmp'];
mysqli_close($con);
?>
<?php
$con = open_db();
$today = date("Y-m-d");
$month = date('m');
$sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and registered.product_type='DuthauGXD'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$count_dtkhm = $row['tmp'];
mysqli_close($con);
?>
<h3 align="center"> Tình trạng sử dụng key</h3>
<table class="table_key" cellspacing="0" cellpadding="0" align="center" >
    <tr> 
        <th>&nbsp;</th>
        <th>Dự toán</th>
        <th>Dự thầu</th>
        <th>Thanh quyết toán</th>
        <th>Tư vấn giám sát</th>
    </tr>
    <tr>
        <th>Tổng Key đã sinh ra</th>
        <td><?php echo $count_dtoan ?></td>
        <td><?php echo $count_dthau ?></td>
        <td><?php echo $count_qt ?></td>
    </tr>
    <tr>
        <th>Tổng key đã kích hoạt</th>
        <td><?php echo $count_kh ?></td>
        <td><?php echo $count_dtkh ?></td>
        <td><?php echo $count_qtkh ?></td>
    </tr>
    <tr>
        <th>Tổng key đã kích hoạt trong ngày</th>
        <td><?php echo $count_khd ?></td>
        <td><?php echo $count_dtkhd ?></td>
        <td><?php echo $count_qtkhd ?></td>
    </tr>
    <tr>
        <th>Tổng key đã kích hoạt trong tuần</th>
        <td><?php echo $count_khw ?></td>
        <td><?php echo $count_dtkhw ?></td>
        <td><?php echo $count_qtkhw ?></td>
    </tr>
    <tr>
        <th bgcolor="#E9E9E9">Tổng key đã kích hoạt trong tháng</th>
        <td><?php echo $count_khm ?></td>
        <td><?php echo $count_dtkhm ?></td>
        <td><?php echo $count_qtkhm ?></td>
    </tr>
</table>
<h3 align="center"> Key đã sinh ra</h3>
 <?php
 $no_record_per_page = 25;
$con = open_db();
$total_record = get_total_record();
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
get_licenses_from_db_ranges($page * $no_record_per_page,$no_record_per_page );
echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
 ?>
<div id="search_advanced">
</div>
<?php require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>
