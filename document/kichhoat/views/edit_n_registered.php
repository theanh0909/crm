<?php ob_start(); ?>
<?php
session_start();
require_once("../phpmailer/active_software.php");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$customername = isset($_POST['customername']) ? $_POST['customername'] : "";
$hardware_id = isset($_POST['hardware_id']) ? $_POST['hardware_id'] : "";
$customerphone = isset($_POST['customerphone']) ? $_POST['customerphone'] : "";
$customeraddress = isset($_POST['customeraddress']) ? $_POST['customeraddress'] : "";
$customeremail = isset($_POST['customeremail']) ? $_POST['customeremail'] : "";
$licenseexpiredate = isset($_POST['licenseexpiredate']) ? $_POST['licenseexpiredate'] : "";
$licenseactivationdate = isset($_POST['licenseactivationdate']) ? $_POST['licenseactivationdate'] : "";
$lastruningdate = isset($_POST['lastruningdate']) ? $_POST['lastruningdate'] : "";
$licenseserial = isset($_POST['licenseserial']) ? $_POST['licenseserial'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
if ($customername != "") {
    $result = update_registered_info($id, $customername, $hardware_id, $customerphone, $customeremail, $customeraddress, $lastruningdate, $licenseactivationdate, $licenseexpiredate);
    if ($result) {
        echo "<script language='JavaScript'>window.history.go(-1);
			</script>";
    }
}
$con = open_db();
$sql = "select * from n_registered where id='$id'";
$result = mysqli_query($con, $sql);
$text = mysqli_fetch_array($result);


?>
<div id="rightcolumn">
    <form action = "editlicensedetail.php" method = "post">
        <h3 align = "center" class = "gxdh2">Thông tin khách hàng chưa đăng ký</h3>
        <table id = "edit" align = "center">
            <tr>
                <td><label>ID</label></td>
                <td><input class = "ipt-t" name = "id" size = "5" type = "text" readonly = "true" value = "<?php echo $text['id'] ?>"/></td>
            </tr>
            
            <tr>
                <td><label>Loại Key</label></td>
                <td><input class = "ipt-t" name = "product_type" size = "25" type = "text" readonly = "true" value = "<?php echo $text['product_type'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Tên khách hàng</label></td>
                <td><input class = "ipt" size = "30" name = "customername" type = "text" value = "<?php echo $text['name'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Phone</label></td>
                <td><input class = "ipt" size = "10" name = "customerphone" type = "text" value = "<?php echo $text['tel'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Địa chỉ</label></td>
                <td><input class = "ipt" size = "60" name = "customeraddress" type = "text"  value = "<?php echo $text['address'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Email</label></td>
                <td><input class = "ipt" size = "40" name = "customeremail" type = "text"  value = "<?php echo $text['email'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Ngày kích hoạt</label></td>
                <td><input class = "ipt" size = "11" name = "licenseactivationdate" type = "text"  value = "<?php echo $text['date'] ?>"/></td>
            </tr>
            
        </table>
    </form>
</div>

<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>
