<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
require_once("../extend/php-excel.class.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$month = isset($_POST['month']) ? $_POST['month'] : "";
$year = isset($_POST['year']) ? $_POST['year'] : "";
?>
<div id="rightcolumn">
    <div style="background: #8f8f73; width: 970px; height: 60px; border-radius: 6px; padding: 5px; margin: 10px;">
        <form method="post" action="fill_registered.php?act=do" >
            <label> Thông tin khách hàng đăng ký trong các tháng</label>
            <select name="month" class="ipt" select="<?php echo $month ?>">
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
            <select name="year" class="ipt" select="<?php echo $year ?>">
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
            <input type="submit" value="Xem"/>
        </form>
    </div>
    <?php
    if ($_GET['act'] = "do") {
        $con = open_db();
        $month = isset($_POST['month']) ? $_POST['month'] : "";
        $year = isset($_POST['year']) ? $_POST['year'] : "";
        echo "<h3 align='center'>Khách hàng đăng ký trong tháng $month/$year</h3>";
        if ($type = 1) {
            $sql = "select * from registered, license where registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' ORDER BY customer_name ASC";
        } else {
            $sql = "select * from registered, license where registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' and id_user='$iduser' ORDER BY customer_name ASC";
        }$result = mysqli_query($con, $sql);
        $count = 0;
        echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'>
      <tr><th>STT</th><th>Tên khách hàng</th><th>Loại</th><th>Email</th><th align='center'>Điện thoại</th><th>Ngày kích hoạt</th><th>Ngày hết hạn</th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $t1 = strtotime($row['license_created_date']);
            $key_created_date = date('d-m-Y', $t1);
            if ($permarr["changcekey"]) {
                if ($row['product_type'] == 'DutoanGXD') {
                    $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='../template/img/DutoanGXD.ico'/></a>";
                } else {
                    if ($row['product_type'] == 'DuthauGXD') {
                        $img = "<a title='DuthauGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='../template/img/DuthauGXD.ico'/></a>";
                    } else {
                        if ($row['product_type'] == 'QuyettoanGXD') {
                            $img = "<a title='QuyettoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='../template/img/QuyettoanGXD.ico'/></a>";
                        } else {
                            $img = "<a title='GiacamayGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='../template/img/GiacamayGXD.ico'/></a>";
                        }
                    }
                }
            } else {
                if ($row['product_type'] == 'DutoanGXD') {
                    $img = "<img width='20' height = '20' src='../template/img/DutoanGXD.ico'/>";
                } else {
                    if ($row['product_type'] == 'DuthauGXD') {
                        $img = "<img width='20' height = '20' src='../template/img/DuthauGXD.ico'/>";
                    } else {
                        if ($row['product_type'] == 'QuyettoanGXD') {
                            $img = "<img width='20' height = '20' src='../template/img/QuyettoanGXD.ico'/>";
                        } else {
                            $img = "<img width='20' height = '20' src='../template/img/GiacamayGXD.ico'/>";
                        }
                    }
                }
            }
            $tmp = sprintf("<td>%d</td><td >%s</td><td >%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $count, $row['customer_name'], $img, $row['customer_email'], $row['customer_phone'], $row['license_activation_date'], $row['license_expire_date']);
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        echo "</table>";
    }
    ?>
</div>
<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>