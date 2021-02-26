<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("Include/header.php");
require_once("Include/sidebar.php");
require_once("function.php");
$con = open_db();
//$t = time();
//$date = date('Y-m-d', ($t));
$no_record_per_page = 25;
//$con = open_db();
//$date = date('Y-m-d', ($t + 2 * 24 * 3600));
$date = 0;
if(isset($_POST['submit'])){
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }
	else $date=1;
}
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

mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<div id = "rightcolumn">
    <form action = "" method = "post" >
        Chọn số ngày: <select name="date">
            <option <?php if(isset($date) && $date == '1'){ echo 'selected';} ?> value="1">1 ngày</option>
            <option <?php if(isset($date) && $date == '2'){ echo 'selected';} ?>  value="2">2 ngày</option>
            <option <?php if(isset($date) && $date == '5'){ echo 'selected';} ?>  value="5">5 ngày</option>
            <option <?php if(isset($date) && $date == '7'){ echo 'selected';} ?>  value="7" >1 tuần</option>
          </select>
        <input name="submit" type="submit" value="Chọn">        
        <h3  align='center'>PHẦN MỀM ĐÃ HẾT HẠN <?php echo $date; ?> NGÀY </h3>
        <?php
        //echo "<p style='margin-left:10px; color: red'><b>Tổng số máy hết hạn: " . $total_record . " </b><a href='../extend/out_put_2ex.php'><img src='../template/images/print.jpg' width='22' height='22' /></a>
         //   <b>- Số key dự toán : " . $total_record1 . "  - Số key dự thầu : " . $total_record2 . "</b></p>";
        get_last_expire($date,$iduser, $permarr, $page * $no_record_per_page, $no_record_per_page);
      // echo '<a href="export_excel_1.php?&date='. $date.'" target="_blank"> xuất ra excel  </a>';
        //echo "<p align='center'><b>Tổng số máy sắp hết hạn: ".$total_record." </b></p>";
       // echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
         
        ?>
        
    </form>
   
    <?php
    require_once("../Include/footer.php");
    } 
    ?>
</div>
<?php ob_flush(); ?>
