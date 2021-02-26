<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<script language="javascript" type="text/javascript" src="datetimepicker.js">
</script>
<?php
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
if(isset($_POST['submit']) && isset($_POST['name_group'])){
    if($_POST['name_group'] != ''){
    $name_group=$_POST['name_group'];
    $comment = isset($_POST['comment']) ? $_POST['comment'] : "";  
    $con = open_db();
    $sql= 'SELECT `id`, `name`, `note`, `describe` FROM `tbl_stt` WHERE name = "'.$name_group.'"';
    $result = mysqli_query($con, $sql);
    $count= mysqli_num_rows($result);
    if($count == 0) {
    $sql='INSERT INTO `tbl_stt`(`name`,`describe`) VALUES ("'.$name_group.'","'.$comment.'")';
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo '<script language="javascript" type="text/javascript" >
                    alert("Bạn đã thêm thành công!");
                </script>';
    }
    }
    else echo '<script language="javascript" type="text/javascript" >
                    alert("Tên nhóm bị trùng lặp!");
                </script>';
    }
}
?>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2"> TẠO NHÓM KHÁCH HÀNG </h2>

    <form action = "" method = "post" id="usrform">
        <table cellspacing="15" align="center" border="0" style="font-size: 14px; border:thick 0px; margin-top:25px;">
            <tr>
                <td >Tên nhóm:</td>
                <td><input id="name_group" name="name_group" type="text" size="25" value=""></td>
            </tr>
            <tr>
                <td >Mô tả:</td>
                <td><textarea rows="4" cols="50" name="comment" form="usrform"></textarea></td>
            </tr>
            <tr>
                <td><input id='center' type="submit" value="lưu" name="submit"></td>
                
            </tr>
        </table>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>
