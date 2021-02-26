<?php ob_start(); ?>
<?php
session_start();
require_once("global.php");
require_once("dbconnect.php");
get_infor_from_conf("DB.conf");
require_once("Include/header.php");?>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "Login để được truy cập<br>";
    die("<a href = 'index.php'>Login</a>");
} else {
    $user_id = isset($_SESSION['status']);
    $con = open_db();
    $sql = "SELECT * FROM user WHERE id='{$user_id}'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
}
echo "<div id='user'>
        <ul>
		  <li class='moreitem1'><a  href='#'>{$row['username']}</a>	
		      <div class='moredropdown1'>
			  <div><a href='changepass.php'>Đổi mật khẩu</a></div>
				<div><a href='thoat.php'>Log out</a></div>
	      </li>
		 </ul>
	 </div>	
	 ";
?>
<div class="report_left">
    <div class="left">
        <p > Tổng số key Dự thầu đã sinh : <b style="color:#FF00FF"><?php
                $con = open_db();
                $sql = "select count(*) as tmp from license where product_type='DuthauGXD'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $count = $row['tmp'];
                mysqli_close($con);
                echo "$count";
                ?></b>
        </p>	
    </div>
    <div class="right">
        <p > Tổng số key Dự thầu đã kích hoạt : <b style="color:#FF00FF"><?php
                $con = open_db();
                $sql = "select count(*) as tmp from registered where product_type='DuthauGXD'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                $count = $row['tmp'];
                mysqli_close($con);
                echo "$count";
                ?></b>
        </p>	
    </div>      
</div>
<div id ="sidebar">
    <h3> <img src="img/manager.png" width="20" height="20">  Quản lý</h3>
    <p><img src="img/khachhang.jpg" width="20" height="20"> <a href="manager/dtoan_date.php">Key kích hoạt ngày</a></p>
    <p><img src="img/key_dtoan.png" width="23" height="23"> <a href="manager/dtoan_month.php">Key kích hoạt tháng</a></p>
    <p><img src="img/key_dthau.jpg" width="23" height="23"> <a href="manager/report_date.php">Key kích họa tuần</a></p>
    <p><img src="img/key_tqt.jpg" width="23" height="23"> <a href="manager/report_date.php">Key sắp hết hạn</a></p>
</div>
<h2 align="center" class="gxdh2">Key được kích hoạt trong ngày</h2>
<?php

function get_registered_from_db_ranges_dtoan($frompos, $norecords) {
    $con = open_db();
    $date = date("Y-m-d");
    $sql = "select * from registered, license where registered.license_serial=license.license_serial and license.product_type='DuthauGXD' and license_activation_date='$date' LIMIT $frompos, $norecords ";
    $result = mysqli_query($con, $sql);
    $count1 = 1;
    if ($result) {
        ?>
        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['customer_name']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            echo "<table class='table_license' cellspacing='0' cellpadding='0' border='0'><tr><th>Tên khách hàng</th><th>Địa chỉ</th><th>Tel</th><th>Email</th><th>Mã kích hoạt</th>
                <th>Loại Key</th><th>Ngày hết hạn</th><tr>";
            while ($row = mysqli_fetch_array($result)) {
                $st1 = $row['license_original'];
                $str1 = substr($st1, 0, 5);
                $str2 = substr($st1, 5, 5);
                $str3 = substr($st1, 10, 5);
                $str4 = substr($st1, 15, 5);
                $st = "$str1-" . "$str2-" . "$str3-" . "$str4";

                echo "<tr>";

                $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row['customer_name'], $row['customer_address'], $row['customer_phone'], $row['customer_email'], $st, $row['product_type'], $row['license_expire_date'], "<a href ='editlicense.php?id=$row[license_serial]'><img src='images/edit.png' width='20' height = '20'></a>", "<a href = 'deletelicensedetail.php?id=$row[license_serial]'><img src='images/delete.png' width='20' height = '20'></a>");
                echo $tmp;
                echo "</tr>";
            } echo "</table>";
        }
        mysqli_close($con);
    }

    $no_record_per_page = 25;
    $con = open_db();
    $date = date("Y-m-d");
    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_activation_date='$date' and product_type='DuthauGXD'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    mysqli_close($con);
    $total_page = ceil($total_record / $no_record_per_page);
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    get_registered_from_db_ranges_dtoan($page * $no_record_per_page, $no_record_per_page);
    echo phantrang($page, $total_page, '?&page=%s', $no_record_per_page);
    ?>
    <?php require_once("Include/footer.php");
    ?>
    <?php ob_flush(); ?>
