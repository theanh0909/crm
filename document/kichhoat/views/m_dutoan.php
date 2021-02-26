<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
?>
<div id="rightcolumn">
    <h3 align="center"> Danh sách các đại lý phân phối key</h3>
    <?php
    $con = open_db();
    $sql = "select * from usergroup,user where user.type=usergroup.id and user.type!=1";
    $result = mysqli_query($con, $sql);
    $t = mysqli_num_rows($result);
    $count = 0;
    echo "<table id='listcheck' cellspacing = '0' cellpadding = '0' class = 'tbl_user' align = 'center'><tr><th><input type='checkbox' id='checkall' name='checkall' />All</th><th>STT</th><th width = '260'>Tên đại lý</th><th>Chức năng</th><th>Email</th><th>Sửa</th><th>Xóa</th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $tmp = sprintf("<td>%s</td><td>%d</td><td width = '60'>%s</td><td>%s</td><td align = 'center'>%s</td><td align = 'center'>%s</td><td>%s</td>", "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>",$count,  "<a href='detail_dtoan.php?id=$row[id]'>$row[username]</a>", $row['description'], $row['email'], "<a href = 'detail_dtoan.php?id=$row[id]'><img src = '../template/images/edit.png' width = '20' height = '20'></a>", "<a href = 'deleteuser.php?id=$row[username]'><img src = '../template/images/delete.png' width = '20' height = '20'></a>");
        echo $tmp;
        echo "</tr>";
        $count++;
    }
    echo "</tr>";
    echo "<tr>";
    echo '<td colspan="7" align="right" bgcolor="#FFFFFF">
        <a style="text-decoration:none;" href="createaccount.php"><input type="button" value="Tạo thêm đại lý"/></a>   
       <input name="delete" type="submit" id="delete" value="Xóa"></td>';
    echo "</tr>";
    if ($_POST['delete'] == "Xóa") {
        if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
            $t = $_POST['chkid'];
            foreach ($t as $key => $value) {
                $deleteSQL = "delete from user where id ='" . $value . "'";
                $Result = mysqli_query($deleteSQL, $con);
            }
            if ($Result) {
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=user.php\">";
            }
        }
    }
    echo "</tr>";
    echo "</table>";
    mysqli_close($con);
    ?>
    <p style="margin-bottom: 20px;"></p>
</div >
<?php require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>
