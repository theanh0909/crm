<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
$date = date("Y-m-d");
$date = time();
$t = date('Y-m-d', ($date - 2 * 24 * 3600));
//echo '<p align="right"><a href="out_put.php"><img src="images/print.jpg" width="30" height="30" /></a></p>';
$no_record_per_page = 25;
if ($permarr['viewallregistered']) {
    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DutoanGXD'";
    $result1 = mysqli_query($sql1, $con);
    $row1 = mysqli_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DuthauGXD'";
    $result2 = mysqli_query($sql2, $con);
    $row2 = mysqli_fetch_array($result2);
    $total_record2 = $row2['tmp'];
} else {
    if ($permarr['viewregistered']) {
        $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $total_record = $row['tmp'];
        $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DutoanGXD' and license.id_user='$iduser'";
        $result1 = mysqli_query($sql1, $con);
        $row1 = mysqli_fetch_array($result1);
        $total_record1 = $row1['tmp'];
        $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$t' and registered.product_type='DuthauGXD'and license.id_user='$iduser'";
        $result2 = mysqli_query($sql2, $con);
        $row2 = mysqli_fetch_array($result2);
        $total_record2 = $row2['tmp'];
    }
}
mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<div id="rightcolumn">
    <form method="post" action="">
        <h3 class="gxdh2"  align="center"> THÔNG TIN KHÁCH HÀNG ĐĂNG KÝ HAI NGÀY TRƯỚC</h3>
        <?php require_once("../Include/search_kh.php"); ?>
        <?php
        echo "<p style='margin-left:10px; color:red'><b>Tổng số máy đăng ký hai ngày trước: " . $total_record . " </b>
        <b>- Số key dự toán : " . $total_record1 . "  - Số key dự thầu : " . $total_record2 . "</b></p>";
        get_registered_2last_date($iduser, $permarr, $page * $no_record_per_page, $no_record_per_page);
        echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
        ?>
    </form>
    <?php
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
