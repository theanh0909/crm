<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("function.php");
get_infor_from_conf("../config/DB.conf");
require_once("/Include/header.php");
require_once("/Include/sidebar.php");
$con = open_db();
$t = time();
$date = date('Y-m-d', ($t + 7 * 24 * 3600));
?>
<?php
//require_once("Include/search_kh.php");
//echo '<p align="right"><a  href="../extend/out_put_ew.php"><img src="../template/images/print.jpg" width="20" height="20" /></a></p>';
$no_record_per_page = 25;
$con = open_db();
$date = date('Y-m-d', ($t + 7 * 24 * 3600));
if ($permarr['expire_1']) {
    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DutoanGXD'";
    $result1 = mysqli_query($sql1, $con);
    $row1 = mysqli_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DuthauGXD'";
    $result2 = mysqli_query($sql2, $con);
    $row2 = mysqli_fetch_array($result2);
    $total_record2 = $row2['tmp'];
}
mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<div id="rightcolumn">
    <form action="" method="post">
        <h3  align='center' class ='gxdh2'>PHẦN MỀM CÒN 1 TUẦN LÀ HẾT HẠN </h3>
        <?php
        echo "<p style='margin-left:10px; color:red'><b>Tổng số máy: " . $total_record . " </b><a href='../extend/out_put_ew.php'><img src='../template/images/print.jpg' width='22' height='22' /></a>
        <b>- Số key dự toán : " . $total_record1 . "  - Số key dự thầu : " . $total_record2 . "</b></p>";
        get_expire_week($iduser, $permarr, $page * $no_record_per_page, $no_record_per_page);
        echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
        ?>
    </form>
    <?php
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
