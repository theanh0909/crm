<?php ob_start(); ?>
<?php session_start() ?>

<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<script type="text/javascript">
    $(function() {
        $('#btnRadio').click(function() {
            var checkedradio = $('[name="type_expire_date"]:radio:checked').val();
            $('#sel').html('Selected value: ' + checkedradio);
        });
    });
</script>
<?php
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
?>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2">TẠO KHÓA KÍCH HOẠT PHẦN MỀM GXD</h2>

    <form action = "../views/gxdlicense.php" method = "post">
        <table cellspacing="15" align="center" border="0" style="font-size: 14px; border:thick 0px; margin-top:25px;">
            <tr>
                <td >Ngày tạo khóa:</td>
                <td><input class="ipt" id="key_created_date" name="key_created_date" type="text" size="25" value="<?php echo date("d-m-Y H:i:s") ?>"><a href="javascript:NewCal('key_created_date','ddMMyyyy',true,24)"><img src="../template/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
            </tr>
            <tr>
                <td>Loại key:</td>
                <td>
                    <input type="radio" name="status" value="0"/>Key thử nghiệm
                    <input type="radio" name="status" value="1" checked/>Key thương mại
                </td>
            </tr>
            <tr>
                <td>Thời gian sử dụng key:</td>
                <td>                    
                    <select class="ipt" name="type_expire_date" >
                        <option value="365"> 12 tháng</option>
						
                        <option value="7"> 7 ngày</option>
                        <option value="30"> 1 tháng</option>
                        <option  value="60"> 2 tháng</option>
                        <option value="90"> 3 tháng</option>
                        <option value="120"> 4 tháng</option>
                        <option value="150"> 5 tháng</option>
                        <option value="180"> 6 tháng</option>
                        <option value="210"> 7 tháng</option>
                        <option value="240"> 8 tháng</option>
                        <option value="270"> 9 tháng</option>
                        <option value="300"> 10 tháng</option>
                        <option value="330"> 11 tháng</option>
						<option value="730"> 2 năm </option>
						<option value="1095"> 3 năm </option>
						<option value="1460"> 4 năm </option>
						<option value="1852"> 5 năm </option>
						<option value="3650"> 10 năm </option>
                    </select> 
                </td>
            </tr>  
            <tr>
                <td><label>Phần mềm:</label></td>
                <td>
                    <div style="border:#E9E9E9 solid 1px; border-radius: 5px; width: 600px; padding: 8px;">
                        <input type="radio" name="product_type" checked value="DutoanGXD"/> Dự toán GXD
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product where id != 2";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <input type="radio" name="product_type" value="<?php echo $row['product_type'] ?>"/>
                            <?php echo $row['name'] ?>
                            <?php
                        }
                        
//                        mysqli_close();
                        ?>
                        <hr></hr>
                        <a align="right" href="../views/addproduct.php">Tạo sản phẩm mới</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Số dãy mã cần tạo:</td>
                <td><input class="ipt" size="3" type = "text" id = "no_keys" name = "no_keys" value = "1"/>
                </td>
            </tr>
            <tr>
                <td>Số lượng máy sử dụng:</td>
                <td><input class="ipt" size="3"  type = "text" id = "no_computers" name = "no_computers" value = "1"/>
                </td>
            </tr>
            <tr>
                <td>Số bản được cài trên 1 máy:</td>
                <td><input class="ipt" size="3" type = "text" id = "no_instances" name = "no_instances" value = "1"/>
                </td>
            </tr>
            <tr>
                <td><p>Chuyển key cho user</p></td>
                <td><select name = "iduser" class="ipt">
                        <?php
                        echo "<option class='ipt' value='71'>phanmem</option>";
                        $con = open_db();
                        $sql = "select * from user";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option class='ipt' value='$row[id]'> $row[username]</option>";
                        }
                        mysqli_close();
                        ?>
                    </select></td>
            </tr>
			<tr>
                <td>Gửi key bằng email:</td>
                <td><input type = "checkbox" id = "key_email" name = "key_email" value = ""/>
                </td>
            </tr>
            <tr>
                <td></td>
                <td width="210"><input class="button" type = "submit" value = "Sinh mã"/>  
                </td>
            </tr>
        </table>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>
