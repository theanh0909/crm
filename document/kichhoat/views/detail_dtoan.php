<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$username = isset($_REQUEST['username']) ? $_REQUEST['username'] : "";

$today = date("Y-m-d");
$month = date('m');
?>
<div id="rightcolumn">
    <?php
    $con = open_db();
    $sql1 = "select count(*) as tmp from registered, license, product where registered.product_type=product.product_type and registered.license_serial=license.license_serial and id_user='$id' and license.status=1 ";
    $result1 = mysqli_query($con, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $so1 = $row1['tmp'];
    /*     * *******************Tính tổng doanh thu **************** */
    $s = "SELECT sum(product.price) as total FROM license, registered, product where id_user='$id' and license.license_serial=registered.license_serial and license.status=1 and product.product_type=registered.product_type";
    $rs = mysqli_query($con, $s);
    $row = mysqli_fetch_array($rs);
    $doanhthu = $row['total'];
    /*     * *******************Tính doanh thu theo tháng **************** */
    $s = "SELECT sum(product.price) as total FROM license, registered, product where id_user='$id' and license.license_serial=registered.license_serial and license.status=1 and product.product_type=registered.product_type and MONTH(license_activation_date)='$month'";
    $rst = mysqli_query($con, $s);
    $row = mysqli_fetch_array($rst);
    $doanhthu_thang = $row['total'];

    $sql = "select count(*) as tmp from registered, license, product where registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and id_user='$id'and license.status=1 ";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $count_dtm = $row['tmp'];
    $no = 10;
    $tong1 = ceil($so1 / $no);
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $a1 = $page * $no;
    $b1 = $no;
    echo "<h3 align='center'>KHÁCH HÀNG CỦA ĐẠI LÝ CỦA ĐẠI LÝ</h3>";
    echo "<b style='color:blue; margin:20px;'>Tổng số khách hàng đã sử dụng: $so1</b>";
    $sql = "SELECT license_key, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon 
            FROM license, registered, product where id_user='$id' and license.license_serial=registered.license_serial and license.status=1 and product.product_type=registered.product_type
            LIMIT $a1, $b1";
    $result = mysqli_query($con, $sql);
    $count = 0;
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'>
      <tr><th>Key kích hoạt</th><th>Tên khách hàng</th><th>Loại</th><th>Email</th><th align='center'>Điện thoại</th><th>Ngày kích hoạt</th><th>Ngày hết hạn</th><th>Tỉnh thành</th></tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        $icon = "../files/product/" . $row['icon'];
        if ($permarr["changcekey"]) {
            $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
        } else {
            $img = "<img width='20' height = '20' src='$icon'/>";
        }
        $tmp = sprintf("<tr><td>%s</td><td>%s</td><td >%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>", $row['license_key'], $row['customer_name'], $img, $row['customer_email'], $row['customer_phone'], $row['license_activation_date'], $row['license_expire_date'], $row['customer_cty']);
        echo $tmp;
        $count++;
    }
    ?>
    <tr>
        <td colspan="9" align="left">Tổng doanh thu của đại lý: <strong><?php echo"" . number_format($doanhthu, 0, ',', '.') . "VNĐ"; ?></strong></td>
    </tr><tr>
        <td colspan="9" align="left">Tổng doanh thu trong tháng: <strong><?php echo"" . number_format($doanhthu_thang, 0, ',', '.') . "VNĐ"; ?></strong></td>
    </tr>
    <tr><td colspan="9" style="background: white"align="left"><?php echo "<span align='center'> " . phantrang($page, $tong1, '?id=' . $id . '&page=%s', $no1) . "</span>"; ?></td></tr>
</table>

<?php
$sql1 = "select count(*) as tmp from registered,license where registered.license_serial=license.license_serial and id_user='$id' and license.status=0 ";
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($result1);
$so = $row1['tmp'];
$no = 10;
$tong = ceil($so / $no);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$a = $page * $no;
$b = $no;
echo "<h3 align='center'>KHÁCH HÀNG DÙNG THỬ CỦA ĐẠI LÝ</h3>";
echo "<b style='color:blue; margin:20px;'>Tổng số Key dùng thử: $so</b>";
$sql = "SELECT license_key, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon 
            FROM license, registered, product where id_user='$id' and license.license_serial=registered.license_serial and license.status=0 and product.product_type=registered.product_type LIMIT $a, $b ";
$result = mysqli_query($con, $sql);
$count = 0;
echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center'>
      <tr><th>Key kích hoạt</th><th>Tên khách hàng</th><th>Loại</th><th>Email</th><th align='center'>Điện thoại</th><th>Ngày kích hoạt</th><th>Ngày hết hạn</th><th>Tỉnh thành</th><tr>";
while ($row = mysqli_fetch_array($result)) {
    $t1 = strtotime($row['license_created_date']);
    $key_created_date = date('d-m-Y', $t1);
    $icon = "../files/product/" . $row['icon'];
    if ($permarr["changcekey"]) {
        $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
    } else {
        $img = "<img width='20' height = '20' src='$icon'/>";
    }
    $tmp = sprintf("<td>%s</td><td >%s</td><td >%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row['license_key'], $row['customer_name'], $img, $row['customer_email'], $row['customer_phone'], $row['license_activation_date'], $row['license_expire_date'], $row['customer_cty']);
    echo $tmp;
    echo "</tr>";
    $count++;
}
?>
<tr><td colspan="9" style="background: white"align="left"><?php echo "<span align='center'> " . phantrang($page, $tong, '?id=' . $id . '&page=%s', $no) . "</span>"; ?></td></tr>
</table>

<?php
$sql1 = "select count(*) as tmp from license where id_user='$id' and license_is_registered < license_no_computers ";
$result1 = mysqli_query($sql1, $con);
$row1 = mysqli_fetch_array($result1);
$so = $row1['tmp'];
$no = 10;
$tong = ceil($so / $no);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$a = $page * $no;
$b = $no;
echo "<h3 align = 'center'>BẢNG KEY CÒN TỒN TRONG KHO</h3>";
echo "<b style='color:blue; margin:20px;'>Tổng số Key còn tồn lại: $so</b>";
$sql = "SELECT * FROM `license` WHERE id_user='$id' and license_is_registered < license_no_computers ORDER BY id DESC LIMIT $a, $b ";
$result = mysqli_query($con, $sql);
$count = 0;
if ($permarr['key']) {

    $delall = "<input type='checkbox' id='checkall' name='checkall' />";
} else {
    $delall = "";
}
echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th width='150'>Loại PM</th><th>Loại Key</th><th>Số ngày hết hạn</th><th></th><th></th><tr>";
while ($row = mysqli_fetch_array($result)) {
    $t1 = strtotime($row['license_created_date']);
    $key_created_date = date('d-m-Y', $t1);
    if ($permarr['changcekey']) {
        $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
    } else {
        $edit = "";
    }
    if ($permarr['key']) {
        $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
        $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
    } else {
        $del = "";
    }
    if ($row['status'] == 1) {
        $lk = "Key thương mại";
    } else {
        $lk = "Key dùng thử";
    }
    $tmp = sprintf("<tr><td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date, $row['product_type'], $lk, $row['type_expire_date'], $edit, $del);
    echo $tmp;
    echo "</tr>";
    $count++;
}
if ($per['key']) {
    echo "<tr>";
    echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
    echo "</tr>";
    if ($_POST['delete'] == "Xóa") {
        if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
            $t = $_POST['chkid'];
            foreach ($t as $key => $value) {
                $deleteSQL = "delete from license where id ='" . $value . "'";
                $Result = mysqli_query($deleteSQL, $con);
            }
            if ($Result) {
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=detail_dtoan?id=$id.php\">";
            }
        }
    }
}
mysqli_close($con);
?>
<tr><td colspan="9" style="background: white"align="left"><?php echo "<span align='center'> " . phantrang($page, $tong1, '?id=' . $id . '&key=' . $b . '&page=%s', $no1) . "</span>"; ?></td></tr>
</table>
</div>
<?php require_once("../Include/footer.php"); ?>

<?php ob_flush(); ?>