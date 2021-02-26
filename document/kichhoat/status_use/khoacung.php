<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
if($iduser != 1){
	echo '<script> alert("Bạn không có quyền truy cập vào đây")
	 window.location.replace("http://giaxaydung.vn/kichhoat/");	
	 
	</script>';
	die();
}
$con = open_db();
$t = time();
$date = date('Y-m-d', ($t + 2 * 24 * 3600));
$no_record_per_page = 25;
$con = open_db();
$date = date('Y-m-d', ($t + 2 * 24 * 3600));
if ($permarr['viewallregistered']) {
    $sql = "select count(*) as tmp from registered where hardware_id='KHOACUNG'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DutoanGXD'";
    $result1 = mysqli_query( $con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DuthauGXD'";
    $result2 = mysqli_query($con, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $total_record2 = $row2['tmp'];
} 
mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<div id = "rightcolumn">
    <form action = "" method = "post" >
        <h3  align='center'>Khách hàng sử dụng khóa cứng</h3>
        <?php 
        get_KC($iduser, $permarr, $page * $no_record_per_page, $no_record_per_page);
        //echo "<p align='center'><b>T?ng s? m�y s?p h?t h?n: ".$total_record." </b></p>";
		echo '<a href="export_excel_1.php?&date='. $date.'" target="_blank"> xuất ra excel  </a>';
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
		echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
		<!-- <a href="export_excel_1.php?&date=<?php echo $date; ?>" target="_blank"> xu?t ra excel  </a>-->
    </form>
    <?php
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
