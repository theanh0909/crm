<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$month = isset($_POST['month']) ? $_POST['month'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
?>
<div id="rightcolumn">
    <div style="background:  whitesmoke; width:auto; height: 40px; padding: 5px; margin: 10px;">
        <form method="post" action="" >
            <label> Tình trạng bán hàng trong tháng</label>
            <select name="month" class="ipt" >
                <option  value="<?php echo $month ?>">Tháng <?php echo $month ?></option>
                <option value="1">Tháng 1</option>
                <option value="2">Tháng 2</option>
                <option value="3">Tháng 3</option>
                <option value="4">Tháng 4</option>
                <option value="5">Tháng 5</option>
                <option value="6">Tháng 6</option>
                <option value="7">Tháng 7</option>
                <option value="8">Tháng 8</option>
                <option value="9">Tháng 9</option>
                <option value="10">Tháng 10</option>
                <option value="11">Tháng 11</option>
                <option value="12">Tháng 12</option>
            </select>
            <select name="year" class="ipt">
                <option  value="<?php echo $year ?>"> Năm <?php echo $year ?></option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2016</option>
                <option value="2018">2017</option>
                <option value="2019">2018</option>
                <option value="2020">2019</option>
                <option value="2021">2020</option>
                <option value="2022">2021</option>
                <option value="2023">2022</option>
                <option value="2024">2023</option>
            </select>
            <input type="submit" class="button" value="Hiển thị "/>
        </form>
    </div>
    <?php
    echo "<h3 align='center'>KHÁCH HÀNG CỦA ĐẠI LÝ TRONG THÁNG $month/$year</h3>";
    if ($permarr["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, registered.last_runing_date, product.icon,registered.id, product.price, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and YEAR(license_activation_date)='$year' and license.status=1 ORDER BY registered.id ASC";
    } else {
        if ($permarr['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, , product.price, registered.license_expire_date, registered.last_runing_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and YEAR(license_activation_date)='$year' and registered.license_serial=license.license_serial and license.id_user='$iduser' and license.status=1 ";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 1;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>STT</th><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
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
                $img = "<a title='$row[name]' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
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
            $tmp = sprintf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $count, $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
            $doanhthu = $doanhthu + $pri;
            $count++;
        }
        if ($permarr['deleteregistered']) {
            echo "<tr>";
            echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
            if ($_POST['delete'] == "Xóa") {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                    $t = $_POST['chkid'];
                    foreach ($t as $key => $value) {
                        $deleteSQL = "delete from registered where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=status_banhang.php\">";
                    }
                }
            }
        }
    }
    echo "</table>";
    mysqli_close();
    ?>
</div>
<div style="border: 1px silver solid; background:  mintcream;width: auto;padding: 5px">
    <p>Tổng số máy đăng ký: <strong><?php echo $count ?></strong></p>
    <p>Tổng doanh thu trong tháng: <strong><?php echo"" . number_format($doanhthu, 0, ',', '.') . " VNĐ"; ?></strong></p>
</div>
<?php
$sqlu = "select type,stat from user where id=$iduser";
$resultu = mysqli_query($sqlu, $con);
$rowu = mysqli_fetch_array($resultu);
if ($rowu['type'] != 1) {
    if ($doanhthu = 0) {
        if ($rowu['stat'] == 0) {
            ?>
            <a href="../views/lienhe.php"><img algin="right" width="150" height="35" src="../template/img/yeucauthanhtoan.png"/></a>
            <?php
        } else {

            if ($rowu['stat'] == 1) {
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
<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>