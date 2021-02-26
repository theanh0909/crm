<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
?>
<div id="rightcolumn">
    <?php
    $con = open_db();
    $today = date("Y-m-d");
    $month = date('m');
    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and license.id_user='$iduser' and license.status=1";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $totadl_record = $row['tmp'];
    $no_record_per_page = 10;
    $total_page = ceil($totadl_record / $no_record_per_page);
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $a = $no_record_per_page * $page;
    $s = "SELECT sum(product.price) as total from registered, license, product where product.product_type=registered.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and license.id_user='$iduser' and license.status=1";
    $rst = mysqli_query($s, $con);
    $row = mysqli_fetch_array($rst);
    $doanhthu = $row['total'];

    echo "<h3 align='center'>KHÁCH HÀNG ĐĂNG KÝ TRONG THÁNG</h3>";
    echo "<b style='color:blue; margin:20px;'>Tổng số khách hàng trong tháng: $totadl_record</b>";
    $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, registered.last_runing_date, product.icon,registered.id, product.price, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and registered.license_serial=license.license_serial and license.id_user='$iduser' and license.status=1 LIMIT $a, $no_record_per_page";
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($permarr['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Ngày kích hoạt</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($permarr["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($permarr['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($permarr['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $pri = $row['price'];
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $row['license_activation_date'], $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
            $count++;
        }

        mysqli_close();
    }
    ?>
    <tr>
        <td colspan="10"><strong>Tổng doanh thu trong tháng: <strong><?php echo"" . number_format($doanhthu, 0, ',', '.') . "VNĐ"; ?></strong></td>
    </tr>
</table>
<?php
echo "<p align='center'> " . phantrang($page, $total_page, '?&month=' . $month . '&page=%s', $no_record_per_page) . "";
$sqlu = "select type,stat from user where id=$iduser";
$resultu = mysqli_query($sqlu, $con);
$rowu = mysqli_fetch_array($resultu);
if ($rowu['type'] != 1) {
    if ($doanhthu_thang = 0) {
        if ($rowu['status'] == 0) {
            ?>
            <a href="../views/lienhe.php"><img algin="right" width="150" height="35" src="../template/img/yeucauthanhtoan.png"/></a>
            <?php
        } else {

            if ($rowu['status'] == 1) {
                echo '<img algin="right" width="150" height="35" src="../template/img/dayeucautt.png"/>';
            }
        }
    }
} else {
    $sqly = "select type,stat from user where id=$id";
    $resulty = mysqli_query($sqly, $con);
    $rowy = mysqli_fetch_array($resulty);
    if ($rowy['stat'] == 1) {
        ?>
        <a href="../views/guilienhe.php"><img algin="right" width="150" height="35" src="../template/img/chothanhtoan.png"/></a>
        <?php
    } else {
        if ($rowu['stat'] == 0) {
            
        }
    }
}
?>
</div>
<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>