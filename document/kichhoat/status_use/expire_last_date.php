<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
$t = time();
if(isset($_POST['submit'])){
	if(isset($_POST['date'])){
		$k = $_POST['date'];
	}
}
else $k = 1;
$date = date('Y-m-d', ($t - $k * 24 * 3600));
?>
<?php
$no_record_per_page = 25;
$con = open_db();
$date = date('Y-m-d', ($t - $k * 24 * 3600));
if ($permarr['viewallregistered']) {
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
} else {
    if ($permarr['viewregistered']) {
        $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and license.id_user='$iduser'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $total_record = $row['tmp'];
        $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DutoanGXD' and license.id_user='$iduser'";
        $result1 = mysqli_query($sql1, $con);
        $row1 = mysqli_fetch_array($result1);
        $total_record1 = $row1['tmp'];
        $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DuthauGXD'and license.id_user='$iduser'";
        $result2 = mysqli_query($sql2, $con);
        $row2 = mysqli_fetch_array($result2);
        $total_record2 = $row2['tmp'];
    }
}
mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<div id="rightcolumn">
    <form action="" method="post">
	<label>Chọn số ngày: </label>
		<select name="date">
		  <option <?php if($_POST['date'] == 1){echo 'selected="selected"';} ?> value="1">1</option>
		  <option <?php if($_POST['date'] == 2){echo 'selected="selected"';} ?> value="2">2</option>
		  <option <?php if($_POST['date'] == 3){echo 'selected="selected"';} ?> value="3">3</option>
		</select>
		<input type="submit" name = "submit" value="Chọn"/>
        <h3  align='center' class ='gxdh2'>PHẦN MỀM ĐÃ HẾT HẠN <?php echo $k; ?> NGÀY </h3>
        <?php
        echo "<p style='margin-left:10px; color:red'><b>Tổng số máy: " . $total_record . " </b><a href='../extend/out_put_eld.php'><img src='../template/images/print.jpg' width='22' height='22' /></a>
        <b>- Số key dự toán : " . $total_record1 . "  - Số key dự thầu : " . $total_record2 . "</b></p>";
        get_last_expire($iduser, $permarr, ($page-1) * $no_record_per_page, $no_record_per_page, $k);
		echo '<a href="export_excel_1.php?&date='. $date.'" target="_blank"> xuất ra excel  </a>';
        echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
    </form>

    <?php
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
