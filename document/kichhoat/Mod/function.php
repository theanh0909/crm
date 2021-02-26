<?php
require_once("../config/dbconnect.php");
require_once("../model/pagination.php");

function get_running($iduser, $p, $frompos, $norecords, $date_sb, $product) {
    $con = open_db();
    //$date = date("Y-m-d");
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, registered.last_runing_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.product_type='$product' and registered.license_serial=license.license_serial and registered.last_runing_date='$date_sb' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id,registered.last_runing_date, registered.customer_address from registered,license, product where last_runing_date='$date_sb' and registered.product_type='$product' and registered.license_serial=license.license_serial and license.id_user='$iduser' and product.product_type=registered.product_type
              LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=last_running_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng sử dụng trong ngày key thử nghiệm và key thương mại***********************************
function get_last_runing_date($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $date = date("d-m-Y");
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, registered.last_runing_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.last_runing_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id,registered.last_runing_date, registered.customer_address from registered,license, product where last_runing_date='$date' and registered.license_serial=license.license_serial and license.id_user='$iduser' and product.product_type=registered.product_type
              LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=last_running_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//=====================================================================================================================
function get_123($product) {
    $con = open_db();
    $date = date("Y-m-d");

    $date = time();
    $t = date('Y-m-d', ( $date - 300 * 24 * 3600));
    $date = $t;
    $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and  registered.license_serial=license.license_serial and registered.license_activation_date='$date'";
    $result = mysqli_query($sql);
    $count = mysqli_num_rows($result);
    return $count;
}

//*************************Hiển thị thông tin khách hàng đăng ký mới nhất trong ngày***********************************
function get_registered_from_db_ranges_lastdate($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $icon = "../views/files/product/" . $pr['icon'];
    $date = date("Y-m-d");

    $date = time();
    $t = date('Y-m-d', ( $date - 300 * 24 * 3600));
    $date = $t;

    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and  registered.license_serial=license.license_serial and registered.license_activation_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original,registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$date' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    echo $sql;
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//=====================================================================================================================
//------------------------------------------------
function get_n_registered_from_db_ranges($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $icon = "../views/files/product/" . $pr['icon'];
    $date = date("Y-m-d");
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and  registered.license_serial=license.license_serial and registered.license_activation_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original,registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$date' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//------------------------------------------------
//------------------------------------------------------
function get_n_registered($product, $tab, $date) {
    $con = open_db();

    // $icon = "../views/files/product/" . $pr['icon'];
    //$date = date("Y-m-d");

    $sql = "SELECT * FROM n_registered where  product_type = '$product' and date1 = '$date'";

    $result = mysqli_query($con, $sql);

    //$row = @mysqli_num_rows($result);

    $count = 0;


    $delall = "<input type='checkbox' id='checkall' name='checkall' />";

    
    if ($result) {
        $sql1='SELECT `id`, `registered`, `user`, `key`, `note`, `time`, `status`, `email` FROM `tbl_note` ';
        $result1=mysqli_query($sql1, $con);
        if ($result1){
            $arr = array();
            $arr1 = array();
            $i=0;
            while ($row1 = mysqli_fetch_array($result1)) {
                
                $a=$row1['key'];
                $str1 = substr($a, 0, 5);
                $str2 = substr($a, 5, 5);
                $str3 = substr($a, 10, 5);
                $str4 = substr($a, 15, 5);
                $arr[$i] = "$str1-" . "$str2-" . "$str3-" . "$str4";
                $arr1[$i] = $row1['email'];
                $i++;
            }
        }
        echo '<table id="ReportTable" class="table_license" cellspacing="0" cellpadding="0" border="0" align="center"><tr><th width="150">Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th>Ngày kích hoạt</th><th width="100">Ghi chú</th><th width="50"></th><tr>';
        while ($row = mysqli_fetch_array($result)) {
            $kt = 0;
            for($j=0;$j<=$i;$j++){
               
                if( $row['key1'] == $arr[$j] && $row['email'] == $arr1[$j]){
                   $kt =1;
                }
            }
            if($kt == 0){
            $sup = '<input id="'.$row["id"].'" type="textarea" value = "">';
            $str =    trim( str_replace('-','',$row['key1']));
            $stt = '<input name="" class="checkbox" type="checkbox" onclick="Call(\'' . $row['name'] . '\',\'' . $row['address'] . '\',\'' . $row['email'] . '\',\'' . $row['tel'] . '\',\''.$str.'\',\''.$date.'\',\'' . $row['id'] . '\',1)" value = "">';
            $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/edit_n_registered.php?id=$row[id]'>$row[name]</a>";
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]&st=1&tab=tab$tab'><img src='../template/images/delete.png' width='15' height = '15'>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $edit, $row['address'], $row['email'], $row['tel'], $row['product_type'],$date,$sup, $stt);
            echo $tmp;
            echo "</tr>";
            }
        }
        echo "<tr>";

        echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input class="button" name="delete' . $tab . '" type="submit" id="delete" value="Xoá"></td>';
        echo "</tr>";

        echo '</table>';
        echo '<script type="text/javascript">  
                           function Call(a,b,c,d,e,f,g,i){
                                
                                var note = jQuery("#"+g).val();
                
                                var person = confirm("Bạn đã hỗ trợ "+a);
                                 if(person == false){                                    
                                     die();
                                 }
                                $.post("demo_test.php",{customer_name:a,address:b,email:c,phone:d,key:e,date:f,note:note,registered:i}, function(data, status){
                                        alert("Data: " + data + "\nStatus: " + status);
                                    });
                                }
                           </script>';
        if ($_POST['delete' . $tab . '']) {
            if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                $t = $_POST['chkid'];
                foreach ($t as $value) {
                    $deleteSQL = "delete from n_registered where id ='" . $value . "'";
                    $Result = mysqli_query($deleteSQL, $con);
                }
                header("Location: ../status_use/khachhangchuakh.php#tab$tab");
            }
        }
        // include_once 'test_excel.php'; 
        //$nametable = 'n_registered';
        //echo "<p align='center'> " . $Pagination->listPages() . "";
    }
    mysqli_close($con);
}

//====================export excel
//*************************Hiển thị thông tin khách hàng đăng ký mới nhất trong ngày***********************************
function get_registered_from_db_ranges($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $icon = "../views/files/product/" . $p['icon'];
    $date = date("Y-m-d");
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and  registered.license_serial=license.license_serial and registered.license_activation_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original,registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$date' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng đăng ký mới nhất trong ngày dùng key thương mại***********************************
function get_registered_from_db_ranges_tm($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $icon = "../views/files/product/" . $pr['icon'];
    $date = date("Y-m-d");
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=1 and registered.product_type=product.product_type and  registered.license_serial=license.license_serial and registered.license_activation_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng đăng ký trong 1 ngày trước***********************************
function get_registered_last_date($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $date = date("Y-m-d");
    $date = time();
    $t = date('Y-m-d', ( $date - 1 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status= 0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_activation_date='$t' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where product.product_type='$product' and license.status= 0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser' 
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_last_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng đăng ký trong 1 ngày trước dùng key thương mại***********************************
function get_registered_last_date_tm($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $date = date("Y-m-d");
    $date = time();
    $t = date('Y-m-d', ( $date - 1 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and product.product_type='$product' and license.status= 1 and registered.license_serial=license.license_serial and registered.license_activation_date='$t' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where registered.product_type=product.product_type and product.product_type='$product' and license.status= 1 and registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser' 
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_last_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng đăng ký trong 1 ngày trước***********************************
function get_registered_1last_date($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $date = date("Y-m-d");
    $date = time();
    $t = date('Y-m-d', ( $date - 2 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_activation_date='$t' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_2last_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin khách hàng đăng ký trong 2 ngày trước***********************************
function get_registered_2last_date($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $date = date("Y-m-d");
    $date = time();
    $t = date('Y-m-d', ( $date - 2 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_activation_date='$t' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_activation_date='$t' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_2last_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

/* * ******************************** HIển thị thông tin đăng ký dùng thử  trong tuần ******************************************************************* */

function get_registered_in_week($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $date = date('Y-m-d');

    while (date('w', strtotime($date)) != 1) {
        $tmp = strtotime('-1 day', strtotime($date));
        $date = date('Y-m-d', $tmp);
        $year = date("Y");
    }
    $week = date('W', strtotime($date));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' and YEAR(license_activation_date)='$year' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered,license, product where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and WEEKOFYEAR(license_activation_date)='$week' and registered.license_serial=license.license_serial and license.id_user='$iduser' and YEAR(license_activation_date)='$year' LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_week.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

/* * ******************************** HIển thị thông tin đăng ký key thương mại trong tuần ******************************************************************* */

function get_registered_in_week_tm($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $date = date('Y-m-d');

    while (date('w', strtotime($date)) != 1) {
        $tmp = strtotime('-1 day', strtotime($date));
        $date = date('Y-m-d', $tmp);
    }
    $week = date('W', strtotime($date));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=1 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and WEEKOFYEAR(license_activation_date)='$week' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered,license, product where product.product_type='$product' and license.status=1 and registered.product_type=product.product_type and WEEKOFYEAR(license_activation_date)='$week' and registered.license_serial=license.license_serial and license.id_user='$iduser' LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_week.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

/** * ******************************** HIển thị thông tin đăng ký dùng thử trong tháng  ******************************************************************* */
function get_registered_in_month($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $today = date("Y-m-d");
    $month = date('m');
//        $t2 = strtotime($row['license_activation_date']);
//        $license_activation_month = date('m', $t2);
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered,license, product where product.product_type='$product' and license.status=0 and registered.product_type=product.product_type  and MONTH(license_activation_date)='$month' and registered.license_serial=license.license_serial and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);

            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_month.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

/** * ******************************** HIển thị thông tin đăng ký key thương mại trong tháng  ******************************************************************* */
function get_registered_in_month_tm($iduser, $p, $product, $frompos, $norecords) {
    $con = open_db();
    $today = date("Y-m-d");
    $month = date('m');
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where product.product_type='$product' and license.status=1 and registered.product_type=product.product_type and registered.license_serial=license.license_serial and MONTH(license_activation_date)='$month' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered,license, product where product.product_type='$product' and license.status=1 and registered.product_type=product.product_type  and MONTH(license_activation_date)='$month' and registered.license_serial=license.license_serial and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $row['id'], $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_month.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin key còn hai ngày nữa hết hạn***********************************
function get_expire_date($d,$iduser, $p, $frompos, $norecords,$city,$product_type) {
    $con = open_db();
    $t = time();
	$sql = 'SELECT * FROM `tbl_city` WHERE type = "'.$city.'"';
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $date = date('Y-m-d', ($t + $d * 24 * 3600));
    if ($p["expire_1"]) {
//        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
//            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where  registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
       $sql = "select * from registered where  registered.product_type='$product_type' and registered.license_expire_date='$date' and registered.customer_cty = '$name'";
//        echo $sql;
//        die();
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
   
    if ($result) {
        $sql1='SELECT `id`, `registered`, `user`, `key`, `note`, `time`, `status`, `email` FROM `tbl_note` ';
        $result1=mysqli_query($sql1, $con);
        if ($result1){
            $arr = array();
            $arr1 = array();
            $i=0;
            while ($row1 = mysqli_fetch_array($result1)) {
                $arr[$i] = $row1['key'];
                $arr1[$i] = $row1['email'];
                $i++;
            }
        }  
        }
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Email</th><th>Tel</th><th width='100'>Ngày hết hạn</th><th width='100'>Ghi chú</th><th width='10'>Trạng thái</th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $kt = 0;
            for($j=0;$j<=$i;$j++){
                if( $row['license_original'] == $arr[$j] && $row['customer_email'] == $arr1[$j]){
                   $kt =1;
                }
            }
            if($kt == 0){
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
           // if ($row['status'] == 1) {
             //   $l = "Key thương mại";
           // } else {
            //    $l = "Key dùng thử";
            //}
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
			
			
			$sql11 = "SELECT * FROM `license` WHERE `license_key` = '$st'";
            $result11 = mysqli_query($sql11, $con);
            $row11 = mysqli_fetch_array($result11);
            $status1 = $row11['status'];
            if ($status1 == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
			
			
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../Mod/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
			$sql2='SELECT * FROM `tbl_stt` ORDER BY id DESC';
            $result2=mysqli_query($sql2, $con);
            $op='';
             while ($row2 = mysqli_fetch_array($result2)) {
                $op= '<option>'.$row2['name'].'</option>'.$op;
            }
               $select='<SELECT id="taskOption">'.$op.'<SELECT>';
            $sup = '<input id="'.$row["id"].'" type="textarea" value = "">';

            $stt = '<input name="" class="checkbox" type="checkbox" onclick="Call(\'' . $row['customer_name'] . '\',\'' . $row['customer_address'] . '\',\'' . $row['customer_email'] . '\',\'' . $row['customer_phone'] . '\',\'' . $row['license_original'] . '\',\'' . $expire_date . '\',\'' . $row['id'] . '\',0)" value = "">';
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_email'], $row['customer_phone'], $expire_date, $sup,$select, $stt, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo '<script type="text/javascript">  
                           function Call(a,b,c,d,e,f,g,i){
                                var select=jQuery("#taskOption").val();
                                var note = jQuery("#"+g).val();
                
                                var person = confirm("Bạn đã hỗ trợ "+a);
                                 if(person == false){                                    
                                     die();
                                 }
                                $.post("demo_test.php",{customer_name:a,address:b,email:c,phone:d,key:e,date:f,note:note,registered:i,select:select}, function(data, status){
                                        alert("Data: " + data + "\nStatus: " + status);
                                    });
                                }
                           </script>';
            echo $tmp;
            echo "</tr>";
        }
        }
        if ($p['deleteregistered']) {
            echo "<tr>";

            echo '<td colspan="10" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
            if ($_POST['delete'] == "Xóa") {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                    $t = $_POST['chkid'];
                    foreach ($t as $key => $value) {
                        $deleteSQL = "delete from registered where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=expire_date.php\">";
                    }
                }
            }
        
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin key còn ba ngày nữa hết hạn***********************************

function get_expire_four_date($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $t = time();
    $date = date('Y-m-d', ($t + 3 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from  registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial license_expire_date='$date' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=expire_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin key còn 1 tuần nữa hết hạn***********************************

function get_expire_week($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $t = time();
    $date = date('Y-m-d', ($t + 7 * 24 * 3600));
    if ($p["expire_1"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=expire_week.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin key đã hết hạn  1 ngày***********************************

function get_last_expire($d,$iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $t = time();
    $date = date('Y-m-d', ($t - $d * 24 * 3600));
    if ($p["expire_1"]) {
//        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
//            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where  registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product, license where  registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ";
//        echo $sql;
//        die();
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
   
    if ($result) {
        $sql1='SELECT `id`, `registered`, `user`, `key`, `note`, `time`, `status`, `email` FROM `tbl_note` ';
        $result1=mysqli_query($sql1, $con);
        if ($result1){
            $arr = array();
            $arr1 = array();
            $i=0;
            while ($row1 = mysqli_fetch_array($result1)) {
                $arr[$i] = $row1['key'];
                $arr1[$i] = $row1['email'];
                $i++;
            }
        }  
        }
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th width='200'>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='100'>Ghi chú</th><th width='10'>Khách hàng</th><th width='10'>Trạng thái</th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $kt = 0;
            for($j=0;$j<=$i;$j++){
                if( $row['license_original'] == $arr[$j] && $row['customer_email'] == $arr1[$j]){
                   $kt =1;
                }
            }
            if($kt == 0){
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            
            $sql2='SELECT * FROM `tbl_stt` ORDER BY id DESC';
            $result2=mysqli_query($sql2, $con);
            $op='';
             while ($row2 = mysqli_fetch_array($result2)) {
                $op= '<option>'.$row2['name'].'</option>'.$op;
            }
               $select='<SELECT id="taskOption">'.$op.'<SELECT>';
            
            $sup = '<input id="'.$row["id"].'" type="textarea" value = "">';

            $stt = '<input name="" class="checkbox" type="checkbox" onclick="Call(\'' . $row['customer_name'] . '\',\'' . $row['customer_address'] . '\',\'' . $row['customer_email'] . '\',\'' . $row['customer_phone'] . '\',\'' . $row['license_original'] . '\',\'' . $expire_date . '\',\'' . $row['id'] . '\')" value = "">';
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, $sup,$select, $stt, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo '<script type="text/javascript">  
                           function Call(a,b,c,d,e,f,g){
                                var select=jQuery("#taskOption").val();

                                var note = jQuery("#"+g).val();
                               
                                var person = confirm("Bạn đã hỗ trợ "+a);
                                 if(person == false){                                    
                                     die();
                                 }
                                $.post("demo_test.php",{customer_name:a,address:b,email:c,phone:d,key:e,date:f,note:note,select:select}, function(data, status){
                                        alert("Data: " + data + "\nStatus: " + status);
                                    });
                                }
                           </script>';
            echo $tmp;
            echo "</tr>";
        }
        }
//        if ($p['deleteregistered']) {
//            echo "<tr>";
//
//            echo '<td colspan="10" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
//            echo "</tr>";
//            if ($_POST['delete'] == "Xóa") {
//                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
//                    $t = $_POST['chkid'];
//                    foreach ($t as $key => $value) {
//                        $deleteSQL = "delete from registered where id ='" . $value . "'";
//                        $Result = mysqli_query($deleteSQL, $con);
//                    }
//                    if ($Result) {
//                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=expire_date.php\">";
//                    }
//                }
//            }
//        
//        echo "</table>";
//    }
    mysqli_close($con);
}

//*************************Hiển thị thông tin key đã hết hạn 5 ngày***********************************

function get_flast_expire($iduser, $p, $frompos, $norecords) {
    $con = open_db();
    $t = time();
    $date = date('Y-m-d', ($t - 5 * 24 * 3600));
    if ($p["viewallregistered"]) {
        $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address,registered.last_runing_date from registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and registered.license_expire_date='$date' ORDER BY registered.id ASC LIMIT $frompos, $norecords";
    } else {
        if ($p['viewregistered']) {
            $sql = "select registered.license_original, registered.last_runing_date, license.license_serial,registered.customer_name,registered.customer_cty,registered.customer_email, registered.customer_phone,
            license.status, license.product_type,registered.license_activation_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address, registered.last_runing_date from  registered, product, license where registered.product_type=product.product_type and registered.license_serial=license.license_serial and license_expire_date='$date' and license.id_user='$iduser'
LIMIT $frompos, $norecords";
        }
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($p['deleteregistered']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    if ($result) {
        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Loại Key</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $icon = "../files/product/" . $row['icon'];
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            if ($row['status'] == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
            $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
            $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
            if ($p["changcekey"]) {
                $img = "<a title='DutoanGXD' href='../views/editlicense.php?id=$row[license_serial]'><img width='20' height = '20' src='$icon'/></a>";
            } else {
                $img = "<img width='20' height = '20' src='$icon'/>";
            }
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $l, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
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
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=expire_tlast_date.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*************************** Hiển thị thông tin khách hàng đăng ký ***********************************************
function get_registered_detail_info($customer_name) {
    $con = open_db();
    $sql = "select * from registered where customer_name = '$customer_name'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<table class = 'table_license' cellspacing = '0' cellpadding = '0' border = '1' align = 'center'><tr><th bgcolor = '#888888'>id</th><th bgcolor = '#888888'>Địa chỉ</th><th bgcolor = '#888888'>Phone</th><th th bgcolor = '#888888'>Email</th><tr>";
        $count = 0;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            $tmp = sprintf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row ['id'], $row['customer_address'], $row['customer_phone'], $row['customer_email'], "<a href = '../views/editlicensedetail.php?id=$row[id]  '><img src = '../template/images/edit.png' width = '25' height = '25'></a>", "<a href = '../views/deletelicensedetail.php?id=$row[id]&license_serial=$row[license_serial]'><img src = '../template/images/delete.png' width = '18' height = '18'></a>");
            echo $tmp;
            echo "</tr>";
            $count++;
        }
    } else {
        echo "Không có thông tin chi tiết";
    }

    mysqli_close($con);
}

//**********************************Tìm kiếm thông tin khách hàng*******************************************
function search_license($iduser, $p, $keyword) {
    $st1 = $keyword;
    $str1 = substr($st1, 0, 5);
    $str2 = substr($st1, 6, 5);
    $str3 = substr($st1, 12, 5);
    $str4 = substr($st1, 18, 5);
    $st = "$str1" . "$str2" . "$str3" . "$str4";
    $st1 = md5($st);
    $con = open_db();
    $tmp = "select * from registered where 1 = 1";
    if ($p["viewallregistered"]) {
        $tmp1 = " and license_serial in (select license_serial from license where 1 = 1";
    } else {
        if ($p["viewregistered"]) {
            $tmp1 = " and license_serial in (select license_serial from license where 1 = 1 and id_user='$iduser'";
        }
    }
    if ($keyword != "") {
        $tmp = $tmp . " and license_expire_date = '" . $keyword . "'or license_serial = '" . $st1 . "' 
or customer_name like '%" . $keyword . "%' or customer_email like '%" . $keyword . "%' or customer_cty like '%" . $keyword . "%'";
    }
    $sql = $tmp . $tmp1 . ") order by id desc";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        return;
    } else {
        $count = 0;
        if ($p['deleteregistered']) {

            $delall = "<input type='checkbox' id='checkall' name='checkall' />";
        } else {
            $delall = "";
        }
        if ($result) {
            if (mysqli_num_rows($result) == 0) {
                $sql = "SELECT * FROM `license` WHERE `license_key` = '$keyword'";
                $result = mysqli_query($con, $sql);
                if (!$result) {
                    return;
                }
                echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th>Loại Key</th><th>Email khách hàng</th><th>Loại phần mềm</th><th>Ngày hết hạn</th><tr>";
                while ($row = mysqli_fetch_array($result)) {
                    $t1 = strtotime($row['license_created_date']);
                    $key_created_date = date('d-m-Y', $t1);
                    if ($per['changcekey']) {
                        $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
                    } else {
                        $edit = "";
                    }
                    $email_db = '';
//                            if($row['stt_reg'] == 1){
//                                            $sub = "<input name='submitagain$count' type='submit' value='Gửi Lại'/>";
//                                            $email_db = $row['email_cus'];
//                                            $email = "<input  name='mail$count' type='hidden' value= '$email_db'/>";
//
//                                    }else
//                                    {
//                                    $sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
//                                    $email="<input name='mail$count' type='hidden' value=''/>";
//                                    }
                    //$sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
                    $id = $row['id'];
                    $id_1 = "<input name='id$count' type='hidden' value='$id'/>";

                    //$email="<input name='mail$count' type='text' value=''/>";
                    $license_key = $row['license_key'];
                    $key = "<input name='key$count' type='hidden' value='$license_key'/> ";
                    if ($per['key']) {
                        $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                        $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                                    <img src='../template/images/delete.png' width='15' height = '15'></a>";
                    } else {
                        $del = "";
                    }



                    $lk_1 = '';
                    if ($row['status'] == 1) {
                        $lk = "Key thương mại";
                        $lk_1 = "<input name='lk$count' type='hidden' value='1'/>";
                    } else {
                        $lk = "Key dùng thử";
                    }
                    $email = '';
                    if ($row['email_cus'] != '') {
                        $email = $row['email_cus'];
                    }
                    ?>

                    <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
                    <?php
                    $tmp = sprintf("<td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td>", $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date, $lk, $email, $row['product_type'], $row['type_expire_date']);

                    echo $tmp;
                    echo "</tr>";
                }
                die();
            }
            echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
            while ($row = mysqli_fetch_array($result)) {
                $st1 = $row['license_original'];
                $str1 = substr($st1, 0, 5);
                $str2 = substr($st1, 5, 5);
                $str3 = substr($st1, 10, 5);
                $str4 = substr($st1, 15, 5);
                if ($row['status'] == 1) {
                    $l = "";
                } else {
                    $l = "";
                }
                $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
                $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
                $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
                $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
                if ($p["changcekey"]) {
                    $img = "<a title='$row[prodcut_type]' href='../views/editlicense.php?id=$row[license_serial]'>$row[product_type]</a>";
                } else {
                    $img = "$row[product_type]";
                }
                if ($p['editregistered']) {
                    $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
                } else {
                    $edit = $row[customer_name];
                }
                if ($p['deleteregistered']) {
                    $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                    $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
                } else {
                    $del = "";
                }
                echo "<tr>";
                $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
                echo $tmp;
                echo "</tr>";
            }
            if ($p['deleteregistered']) {
                echo "<tr>";

                echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xóa"></td>';
                echo "</tr>";
                if ($_POST['delete'] == "Xóa") {
                    if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                        $t = $_POST['chkid'];
                        foreach ($t as $key => $value) {

                            $deleteSQL = "delete from registered where id ='" . $value . "'";
                            $Result = mysqli_query($deleteSQL, $con);
                        }
                        if ($Result) {
                            echo "Đã xóa ";
                            // echo "<meta http-equiv = \"refresh\" content=\"0\">";
                        }
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//**********************************Tìm kiếm thông tin khách hàng*******************************************
function search_license1($iduser, $p, $keyword) {
    $st1 = $keyword;
    $str1 = substr($st1, 0, 5);
    $str2 = substr($st1, 6, 5);
    $str3 = substr($st1, 12, 5);
    $str4 = substr($st1, 18, 5);
    $st = "$str1" . "$str2" . "$str3" . "$str4";
    $st1 = md5($st);
    $con = open_db();
    //phân quyền xem nhân viên của mình
    $tmp = "select * from registered where 1 = 1";
//    if ($p["viewallregistered"]) {
//        $tmp1 = " and license_serial in (select license_serial from license where 1 = 1";
//    } else {
//        if ($p["viewregistered"]) {
//            $tmp1 = " and license_serial in (select license_serial from license where 1 = 1 and id_user='$iduser'";
//        }
//    }hardware_id
    if ($keyword != "") {
        $tmp = $tmp . " and license_expire_date like '%" . $keyword . "%'or license_original like '%" . $st1 . "%' or hardware_id like '%" . $keyword . "%' 
or customer_name like '%" . $keyword . "%' or customer_email like '%" . $keyword . "%' or customer_cty like '%" . $keyword . "%'";
    }
    // $sql = $tmp . $tmp1 . ") order by id desc";
    $sql = $tmp . " order by id desc";

    $result = mysqli_query($con, $sql);
    if (!$result) {
        return;
    } else {
        $count = 0;
        if ($p['deleteregistered']) {

            $delall = "<input type='checkbox' id='checkall' name='checkall' />";
        } else {
            $delall = "";
        }
        if ($result) {
            echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
            while ($row = mysqli_fetch_array($result)) {
                $st1 = $row['license_original'];
                $str1 = substr($st1, 0, 5);
                $str2 = substr($st1, 5, 5);
                $str3 = substr($st1, 10, 5);
                $str4 = substr($st1, 15, 5);
                if ($row['status'] == 1) {
                    $l = "";
                } else {
                    $l = "";
                }
                $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
                $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
                $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
                $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));

                if ($p["changcekey"]) {
                    $img = "<a title='" . $row['product_type'] . "' href='../views/editlicense.php?id=$row[license_serial]'>$row[product_type]</a>";
                } else {
                    $img = "$row[product_type]";
                }
                if ($p['editregistered']) {
                    $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../Mod/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
                } else {
                    $edit = $row[customer_name];
                }
                if ($p['deleteregistered']) {
                    $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                    $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
                } else {
                    $del = "";
                }
                echo "<tr>";
                $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
                echo $tmp;
                echo "</tr>";
            }
            if ($p['deleteregistered']) {
                echo "<tr>";

                echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xóa"></td>';
                echo "</tr>";
                if (isset($_POST['delete']) && $_POST['delete'] == "Xóa") {
                    if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                        $t = $_POST['chkid'];
                        foreach ($t as $key => $value) {

                            $deleteSQL = "delete from registered where id ='" . $value . "'";
                            $Result = mysqli_query($deleteSQL, $con);
                        }
                        if ($Result) {
                            echo "Đã xóa ";
                            // echo "<meta http-equiv = \"refresh\" content=\"0\">";
                        }
                    }
                }
            }
        }
        echo "</table>";
    }
    mysqli_close($con);
}

//*******************************Tìm kiếm thông tin khách hàng đăng ký theo ngày, tháng, tuần****************
function search_license_date($iduser, $p, $date) {
    $con = open_db();
    $tmp = "select * from registered where 1 = 1";
    if ($p["viewallregistered"]) {
        $tmp1 = " and license_serial in (select license_serial from license where 1 = 1";
    } else {
        if ($p["viewregistered"]) {
            $tmp1 = " and license_serial in (select license_serial from license where 1 = 1 and id_user='$iduser'";
        }
    }
    if ($date != "") {
        $tmp = $tmp . " and license_activation_date = '" . $date . "'";
    }
    $sql = $tmp . $tmp1 . ") order by id desc";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        return;
    } else {
        $count = 0;
        if ($p['deleteregistered']) {

            $delall = "<input type='checkbox' id='checkall' name='checkall' />";
        } else {
            $delall = "";
        }

        echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th>ID</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th>Loại</th><th width='100'>Ngày hết hạn</th><th width='50'></th></tr>";
        while ($row = mysqli_fetch_array($result)) {
            $st1 = $row['license_original'];
            $str1 = substr($st1, 0, 5);
            $str2 = substr($st1, 5, 5);
            $str3 = substr($st1, 10, 5);
            $str4 = substr($st1, 15, 5);
            $last_runing_date = date(( "d-m-Y"), strtotime($row['last_runing_date']));
            $expire_date = date(( "d-m-Y"), strtotime($row['license_expire_date']));
            $active_date = date(( "d-m-Y"), strtotime($row['license_activation_date']));
            $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
            if ($p["changcekey"]) {
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
            if ($p['editregistered']) {
                $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
            } else {
                $edit = $row[customer_name];
            }
            if ($p['deleteregistered']) {
                $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
            } else {
                $del = "";
            }
            echo "<tr>";
            $tmp = sprintf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $row ['id'], $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $img, $expire_date, "$del</a><a class='tooltip' href = '#'>
        <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date <br/><b>Tỉnh thành:</b> $row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
            echo $tmp;
            echo "</tr>";
        }
        if ($p['deleteregistered']) {
            echo "<tr>";
            echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
            if ($_POST['delete'] == "Xóa") {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                    $t = $_POST['chkid'];

                    foreach ($t as $key => $value) {
                        $deleteSQL = "delete from registered where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"reload\" content=\"0;URL=manager_dtoan.php\">";
                    }
                }
            }
        }
        echo "</table>";
    }

    mysqli_close($con);
}
