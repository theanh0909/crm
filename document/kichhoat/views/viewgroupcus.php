<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../config/dbconnect.php"); ?>
<?php require_once("../config/bitfield.php"); ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<div id="rightcolumn">
    <div style="margin: 20px; padding: 10px"> 
        <h3 align="center">NHÓM THÀNH VIÊN</h3>
        <?php
        $con = open_db();
        $sql = "select * from tbl_stt";
        $result = mysqli_query($con, $sql);
        echo "<table id='listcheck' cellspacing = '0' cellpadding = '0' class = 'tbl_user' align = 'center'><tr></th><th>STT</th><th width = '260'>Tên nhóm khách hàng</th><th>Sửa</th><th>Xóa</th><tr>";
        $count =1;
        while ($row = mysqli_fetch_array($result)) {
            $tmp = sprintf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td>", $count, $row['name'], "<a href = 'editgroupcus.php?id=$row[id]'><img src = '../template/images/edit.png' width = '20' height = '20'></a>", "<a href = 'editgroupcus.php?id1=$row[id]'><img src = '../template/images/delete.png' width = '20' height = '20'></a>");
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        echo "</tr>";
        echo "<tr>";
        echo '<td colspan="5" align="right" bgcolor="#FFFFFF">
        <a style="text-decoration:none;" href="group_cus.php"><input type="button" value="Tạo nhóm"/></a>   
       <input name="delete" type="submit" id="delete" value="Xóa"></td>';
        echo "</tr>";
        if ($_POST['delete'] == "Xóa") {
            if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                $t = $_POST['chkid'];
                foreach ($t as $key => $value) {
                    $deleteSQL = "delete from usergroup where id ='" . $value . "'";
                    $Result = mysqli_query($deleteSQL, $con);
                }
                if ($Result) {
                    echo "<meta http-equiv = \"refresh\" content=\"0;URL=viewuser.php\">";
                }
            }
        }
        echo "</tr>";

        echo "</table>";
        mysqli_close($con);
        ?>
    </div>
</div>
<?php require_once '../Include/footer.php'; ?>