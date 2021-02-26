<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../config/dbconnect.php"); ?>
<?php require_once("../config/bitfield.php"); ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<div id="rightcolumn">
    <div style="margin: 20px; padding: 10px"> 
        <h3 align="center">Nhóm thành viên</h3>
        <?php
        $con = open_db();
        $sql = "select * from usergroup";
        $result = mysqli_query($con, $sql);
        echo "<table id='listcheck' cellspacing = '0' cellpadding = '0' class = 'tbl_user' align = 'center'><tr><th><input type='checkbox' id='checkall' name='checkall' />All</th><th>STT</th><th width = '260'>Tên nhóm thành viên</th><th>Sửa</th><th>Xóa</th><th></th><tr>";
        while ($row = mysqli_fetch_array($result)) {
            $tmp = sprintf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td>", "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>", $count, $row['description'], "<a href = 'editgroup.php?id=$row[id]'><img src = '../template/images/edit.png' width = '20' height = '20'></a>", "<a href = 'deletegroup.php?id=$row[username]'><img src = '../template/images/delete.png' width = '20' height = '20'></a>");
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        echo "</tr>";
        echo "<tr>";
        echo '<td colspan="5" align="right" bgcolor="#FFFFFF">
        <a style="text-decoration:none;" href="addgroup.php"><input type="button" value="Tạo nhóm"/></a>   
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