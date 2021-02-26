<?php ob_start(); ?>
<?php
session_start();
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";
$no_computers = isset($_POST['no_computers']) ? $_POST['no_computers'] : -1;
$created_date = isset($_POST['created_date']) ? $_POST['created_date'] : "";
$expire_date = isset($_POST['expire_date']) ? $_POST['expire_date'] : "";
$iser = isset($_POST['iduser']) ? $_POST['iduser'] : "";
$no_instace = isset($_POST['no_intances']) ? $_POST['no_intances'] : "";
$sta = isset($_POST['status']) ? $_POST['status'] : "";

if ($no_computers != -1) {
    $result = update_license1($id, $no_computers, $created_date, $iser, $no_instace, $sta, $expire_date);
    if ($result) {
        echo "<script language='JavaScript'> alert('Đã cập nhật thành công');</script>";
        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_key.php\">";
    }
}
$con = open_db();
$sql = "select * from license, user where license.id_user=user.id and license_serial = '$id'";
$result = mysqli_query($con, $sql);
$text = mysqli_fetch_array($result);
?>
<div id="rightcolumn">
    <form action = "" method = "post">
        <h3 align = "center" class = "gxdh2">Chỉnh sửa thông tin Key kích hoạt</h3>
        <table id = "edit" align = "center">
            <tr>
                <td><label>Mã Key</label></td>
                <td><input class = "ipt-t" size = "35" name = "license_serial" type = "text" readonly = "true" value = "<?php echo $text['license_serial'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Mã máy đăng ký</label></td>
                <td><input class = "ipt-t" size = "35" type = "text" readonly = "true" value = "<?php echo $text['hardware_id'] ?>" name = "hardware_id"/></td>
            </tr>
            <tr>
                <td><label>Ngày tạo key</label></td>
                <td><input class = "ipt" size = "25" type = "text" name = "created_date" value = "<?php echo $text['license_created_date'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Loại Key</label></td>
                <td><select name = "status" class="ipt">
                        <?php
                        if ($text['status'] == 1) {
                            $str = "Key thương mại";
                        } else {
                            $str = "Key dùng thử";
                        }
                        echo "<option class='ipt' value='$text[status]'>$str</option>";
                        if ($text['status'] == 1) {
                            echo "<option class='ipt' value='0'>Key dùng thử</option>";
                        } else {
                            echo "<option class='ipt' value='1'>Key thương mại</option>";
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td><label>Loại PM</label></td>
                <td><input class = "ipt" size = "30" type = "text" readonly = "true" value = "<?php echo $text['product_type'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Số máy sử dụng key</label></td>
                <td><input class = "ipt" size = "3" name = "no_computers" type = "text" value = "<?php echo $text['license_no_computers'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Số máy đã kích hoạt key</label></td>
                <td><input class = "ipt-t" size = "3" name = "no_intances" type = "text" readonly = "true" value = "<?php echo $text['license_no_instance'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Số ngày sử dụng key</label></td>
                <td><input class = "ipt" size = "5" name = "expire_date" type = "text" value = "<?php echo $text['type_expire_date'] ?>"/></td>
            </tr>
            <tr>
                <td><label>User</label></td>
                <td> 
                    <select name = "iduser" class="ipt">
                        <?php
                        echo "<option class='ipt' value='$text[id_user]'>$text[username]</option>";
                        $con = open_db();
                        $sql = "select * from user";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option class='ipt' value='$row[id]'> $row[username]</option>";
                        }
                        mysqli_close();
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class = "button" type = "submit" value = "Cập nhật"/></td>
            </tr>
            <tr>
                <?php
                if ($text['license_is_registered'] != 0) {
                    echo "<td> </td>";
                    echo "<td><h4 align='center'>Thông tin khách hàng đã kích hoạt key</h4></td>";
                    get_license_detail_info($id, $permarr);
                } else {
                    echo "<td> </td>";
                    echo "<td><h3 align='center'>Key chưa có khách hàng nào đăng ký</h3></td>";
                }
                ?>
            </tr>
        </table>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>