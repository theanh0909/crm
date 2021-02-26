<?php ob_start(); ?>
<?php

session_start();
require_once("php-excel.class.php");
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");

//lay du lieu tu bang "registerd"
$con = open_db();
$expire_days = isset($_POST['txt_expire_days']) ? $_POST['txt_expire_days'] : "";
$tmp = "select * from registered where 1 = 1";
$tmp1 = " and license_serial in (select license_serial from license where 1 = 1";
if ($expire_days != "") {
    $tmp = $tmp . " and license_expire_date = '" . $expire_days . "'";
}
$sql = $tmp . $tmp1 . ") order by id desc";

$result = mysqli_query($con, $sql);
if (!$result) {
    return;
}
$count = 1;
//Khai bao bien mang, gan tieu de
$data = array(array('STT', 'Tên khách hàng', 'Địa chỉ', 'Tel', 'Email', 'Mã kích hoạt', 'Loại Key', 'Ngày hết hạn'));
while ($row = mysqli_fetch_array($result)) {
    $st1 = $row['license_original'];
    $str1 = substr($st1, 0, 5);
    $str2 = substr($st1, 5, 5);
    $str3 = substr($st1, 10, 5);
    $str4 = substr($st1, 15, 5);
    $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
    //lay gia tri tu csdl gan cho mang
    $data[] = array($count++, $row['customer_name'], $row['customer_address'], $row['customer_phone'], $row['customer_email'], $st, $row['product_type'], $row['license_expire_date']);
}
$xls = new Excel_XML('UTF-8', false, 'Sheet 1');
$xls->addArray($data);
$xls->generateXML('Key_da_het_han');
?>