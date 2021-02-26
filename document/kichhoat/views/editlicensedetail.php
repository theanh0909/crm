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

if(isset($_POST['doikey'])){
    $hardware_id = 'EDIT_ID_HARDWARE';
}
else $hardware_id = isset($_POST['hardware_id']) ? $_POST['hardware_id'] : "";

if(isset($_POST['doikey'])){
   $result = update_registered_info($id, $customername, 'EDIT_ID_HARDWARE', $customerphone, $customeremail, $customeraddress, $lastruningdate, $licenseactivationdate, $licenseexpiredate);
    if ($result) {  
        header('http://localhost/kichhoat/views/editlicensedetail.php?id='.$id);
			
    }
}

if ($customername != "") {
    $result = update_registered_info($id, $customername, $hardware_id, $customerphone, $customeremail, $customeraddress, $lastruningdate, $licenseactivationdate, $licenseexpiredate);
    if ($result) {
		Log_info('2',$_SESSION['username']);
        echo "<script language='JavaScript'>window.history.go(-1);
			</script>";
    }
}
$con = open_db();
$sql = "select * from registered where id='$id'";
$result = mysqli_query($con, $sql);
$text = mysqli_fetch_array($result);
$st1 = $text['license_original'];
$str1 = substr($st1, 0, 5);
$str2 = substr($st1, 5, 5);
$str3 = substr($st1, 10, 5);
$str4 = substr($st1, 15, 5);
$st = "$str1-" . "$str2-" . "$str3-" . "$str4";

$sql1 = "SELECT * FROM `license` WHERE `license_key` = '$st'";
$result1 = mysqli_query($sql1, $con);
$row1 = mysqli_fetch_array($result1);
$status = $row1['status'];
if ($status == 1) {
                $l = "Key thương mại";
            } else {
                $l = "Key dùng thử";
            }
			
$dbsql = "select * from email where id=36";
$kq = mysqli_query($dbsql);
$row1 = mysqli_fetch_array($kq);
$a = $row1['subjects'];
$content = $row1['content'];
$dbsql1 = "select * from email where id=37";
$kq1 = mysqli_query($dbsql1);
$row = mysqli_fetch_array($kq1);
$a1 = $row['subjects'];
$content1 = $row['content'];

$title = "$a-" . "$b";
$title1 = "$a1-" . "$b";
if ($email == "1") {
    send_email($customeremail, $customername, $title, $content);
} else {
    if ($email == "0") {
        send_email($customeremail, $customername, $title1, $content1);
    } else {
        if ($email == "2") {
            
        }
    }
}
?>
<div id="rightcolumn">
    <form action = "editlicensedetail.php" method = "post">
        <h3 align = "center" class = "gxdh2">Chỉnh sửa thông tin khách hàng đăng ký</h3>
        <table id = "edit" align = "center">
            <tr>
                <td><label>ID</label></td>
                <td><input class = "ipt-t" name = "id" size = "5" type = "text" readonly = "true" value = "<?php echo $text['id'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Mã kích hoạt</label></td>
                <td><input class = "ipt-t" name = "license_original" size = "25" type = "text" readonly = "true" value = "<?php echo $st ?>"/></td>
            </tr>
            <tr>
                <td><label>Mã máy đăng ký</label></td>
                <td><input class = "ipt" name = "hardware_id" size = "25" type = "text"  value = "<?php echo $text['hardware_id'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Loại Key</label></td>
                <td><input class = "ipt-t" name = "product_type" size = "25" type = "text" readonly = "true" value = "<?php echo $text['product_type'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Tên khách hàng</label></td>
                <td><input class = "ipt" size = "30" name = "customername" type = "text" value = "<?php echo $text['customer_name'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Phone</label></td>
                <td><input class = "ipt" size = "10" name = "customerphone" type = "text" value = "<?php echo $text['customer_phone'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Địa chỉ</label></td>
                <td><input class = "ipt" size = "60" name = "customeraddress" type = "text"  value = "<?php echo $text['customer_address'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Email</label></td>
                <td><input class = "ipt" size = "40" name = "customeremail" type = "text"  value = "<?php echo $text['customer_email'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Ngày kích hoạt</label></td>
                <td><input class = "ipt" size = "11" name = "licenseactivationdate" type = "text"  value = "<?php echo $text['license_activation_date'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Ngày hết hạn</label></td>
                <td><input class = "ipt" size = "11" name = "licenseexpiredate" type = "text" value = "<?php echo $text['license_expire_date'] ?>"/></td>
            </tr>
            <tr>
                <td><label>Ngày chạy cuối </label></td>
                <td><input class = "ipt" size = "11" name = "lastruningdate" type = "text"  value = "<?php echo $text['last_runing_date'] ?>"/></td>
            </tr>
			 <tr>
                <td><label>Loại key</label></td>
                <td><input class = "ipt" size = "12" name = "key" type = "text" readonly = "true" value = "<?php echo $l ?>"/></td>
            </tr>
			<tr>
                <td><label>Số lần đổi key: </label></td>
                <td><input class = "ipt" size = "11" name = "solan" type = "text" readonly = "true" value = "<?php echo $text['n'] ?>"/></td>
            </tr>
            <tr>
                <td><input type ="radio" name="email" value="1">Gửi mail gia hạn thành công</td>
                <td><input type ="radio" name="email" value="0">Gửi mail không thể gia hạn</td>
                <td><input type ="radio" name="email" value="2" checked>Không gửi mail</td>
            </tr>
             <tr>
                <td></td>
                <td><input class = "button" type = "submit" value = "Thực hiện"/>    <input class = "button" type = "submit" name="doikey" value = "Đổi key"/></td>
                
            </tr>
        </table>
    </form>
</div>

<?php require_once("../Include/footer.php"); ?>
<?php ob_flush(); ?>
