<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>

<?php
if($iduser != 1){
	echo '<script> alert("Bạn không có quyền truy cập vào đây")
	 window.location.replace("http://giaxaydung.vn/kichhoat/");	
	 
	</script>';
	die();
}
require_once("../config/dbconnect.php");
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
if(isset($_POST['submit'])){
    if($_POST['name'] != '' && $_POST['product'] != '' && $_POST['makhoa'] != '' && $_POST['tel'] != '' && $_POST['email'] != '' && $_POST['address'] != '' && $_POST['key_created_date'] != ''){
        $date=date_create($_POST['key_created_date']);
        $date = date_format($date,"Y-m-d");
        add_client_info_to_db('', $_POST['makhoa'], 'KHOACUNG', $_POST['name'], $_POST['tel'], $_POST['email'], $_POST['address'], $date, '', '', $_POST['product'], '');
        echo '<script>
				alert("Lưu thành công");
				</script>';
		
    }
    else die('Bạn chưa điền đủ thông tin');
}
?>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2">THÔNG TIN KHÁCH HÀNG SỬ DỤNG KHÓA CỨNG</h2>

    <form action = "" method = "post">
        <table cellspacing="15" align="center" border="0" style="font-size: 14px; border:thick 0px; margin-top:25px;">
            <tr>
                <td >Ngày tạo khóa:</td>
                <td><input class="ipt" id="key_created_date" name="key_created_date" type="text" size="25" value="<?php echo date("d-m-Y") ?>"><a href="javascript:NewCal('key_created_date','ddMMyyyy',true,24)"><img src="../template/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
            </tr>
            <tr>
                <td>Tên khách hàng:</td>
                <td>
                    <input type="text" name="name" value=""/>
                </td>
            </tr> 
            <tr>
                <td><label>Phần mềm:</label></td>
                <td>
                        <select name="product">
                        
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <option value="<?php echo $row['product_type'] ?>"/><?php echo $row['name'] ?> </option>
                            <?php
                        }
                        mysqli_close();
                        ?>
                            </select>
                </td>
            </tr>
            <tr>
                <td>Mã khóa:</td>
                <td><input type = "text" name = "makhoa" value = ""/>
                </td>
            </tr>
            <tr>
                <td>Số điện thoại:</td>
                <td><input type = "text" name = "tel" value = ""/>
                </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type = "text" name = "email" value = ""/>
                </td>
            </tr>
           <tr>
                <td>Địa chỉ:</td>
                <td><input type = "text" name = "address" value = ""/>
                </td>
            </tr>
            <tr>
                <td></td>
                <td width="210"><input class="button" name="submit" type = "submit" value = "Lưu thông tin"/>  
                </td>
            </tr>
        </table>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>
