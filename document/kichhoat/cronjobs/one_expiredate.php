<?php

ob_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
require_once("../phpmailer/active_software.php");
get_infor_from_conf("../config/DB.conf");
$con = open_db();
$sqlr = "select * from seting where id=2";
$resultr = mysqli_query($con, $sqlr);
$row = mysqli_fetch_array($resultr);
$seting = $row['status'];
if ($seting != 0) {
    $t = time();
    $date = date('Y-m-d', ($t + 1 * 24 * 3600));
    $sql = "select * from registered where license_expire_date='$date'";
    $result = mysqli_query($con, $sql);
    $dbsql = "select * from email where id=16";
    $kq = mysqli_query($dbsql);
    $row1 = mysqli_fetch_array($kq);
    $a = $row1['subjects'];
    $content = $row1['content'];
    while ($row = mysqli_fetch_array($result)) {
        if ($row['product_type'] == 'DutoanGXD') {
            echo $b = "Phần mềm Dự toán GXD";
        } else {
            if ($row['product_type'] == 'DuthauGXD') {
                echo $b = "Phần mềm Dự thầu GXD";
            } else {
                if ($row['product_type'] == 'QuyettoanGXD') {
                    echo $b = "Phần mềm Quyết toán GXD";
                }
            }
        }
        $title = "$a-" . "$b";
        $sendemail = $row['customer_email'];
        $name = $row['customer_name'];
        send_email($sendemail, $name, $title, $content);
    }
    mysqli_close($con);
} else {
    die();
}
?>
<?php ob_flush(); ?>


