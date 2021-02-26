<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../config/dbconnect.php"); ?>
<?php require_once("../config/bitfield.php"); ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<div id="rightcolumn">
    <?php
    if ($_GET['act'] == "do") {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $description = isset($_POST['usergroup']) ? $_POST['usergroup'] : "";
        $perms = new bitmask();
        //Chăm sóc khách hàng
        $perms->permissions["editregistered"] = isset($_POST['editregistered']) ? $_POST['editregistered'] : "";
        $perms->permissions["deleteregistered"] = isset($_POST['deleteregistered']) ? $_POST['deleteregistered'] : "";
        $perms->permissions["writeemail"] = isset($_POST['writeemail']) ? $_POST['writeemail'] : "";
        $perms->permissions["viewregistered"] = isset($_POST['viewregistered']) ? $_POST['viewregistered'] : "";
        $perms->permissions["viewallregistered"] = isset($_POST['viewallregistered']) ? $_POST['viewallregistered'] : "";
        $perms->permissions["expire_1"] = isset($_POST['expire_1']) ? $_POST['expire_1'] : "";
        $perms->permissions["expire"] = isset($_POST['expire']) ? $_POST['expire'] : "";
        $perms->permissions["editemail"] = isset($_POST['editemail']) ? $_POST['editemail'] : "";
        // Quản lý user và nhóm user
        $perms->permissions["user"] = isset($_POST['user']) ? $_POST['user'] : "";
        $perms->permissions["adduser"] = isset($_POST['adduser']) ? $_POST['adduser'] : "";
        $perms->permissions["edituser"] = isset($_POST['edituser']) ? $_POST['edituser'] : "";
        $perms->permissions["deleteuser"] = isset($_POST['deleteuser']) ? $_POST['deleteuser'] : "";
        $perms->permissions["viewuser"] = isset($_POST['viewuser']) ? $_POST['viewuser'] : "";
        $perms->permissions["addgroup"] = isset($_POST['addgroup']) ? $_POST['addgroup'] : "";
        $perms->permissions["editgroup"] = isset($_POST['editgroup']) ? $_POST['editgroup'] : "";
        //Quản lý key
        $perms->permissions["key"] = isset($_POST['delkey']) ? $_POST['delkey'] : "";
        $perms->permissions["addkey"] = isset($_POST['addkey']) ? $_POST['addkey'] : "";
        $perms->permissions["changcekey"] = isset($_POST['changcekey']) ? $_POST['changcekey'] : "";
        $perms->permissions["viewkey"] = isset($_POST['viewkey']) ? $_POST['viewkey'] : "";
        $perms->permissions["viewdutoan"] = isset($_POST['viewdutoan']) ? $_POST['viewdutoan'] : "";
        $perms->permissions["viewduthau"] = isset($_POST['viewduthau']) ? $_POST['viewduthau'] : "";
        $perms->permissions["viewtqt"] = isset($_POST['viewtqt']) ? $_POST['viewtqt'] : "";
        $perms->permissions["changekey"] = isset($_POST['changekey']) ? $_POST['changekey'] : "";
        $perms->permissions["viewproduct"] = isset($_POST['viewproduct']) ? $_POST['viewproduct'] : "";
        $perms->permissions["addproduct"] = isset($_POST['addproduct']) ? $_POST['addproduct'] : "";
        $perms->permissions["editproduct"] = isset($_POST['editproduct']) ? $_POST['editproduct'] : "";
        $perms->permissions["deleteproduct"] = isset($_POST['deleteproduct']) ? $_POST['deleteproduct'] : "";
		$perms->permissions["keydungthu"] = isset($_POST['keydungthu']) ? $_POST['keydungthu'] : "";
        $perms->permissions["change_permissions"] = false;
        $perms->permissions["admin"] = false;
        $bitmask = $perms->toBitmask();
        // converts to bitmask value to store in database or wherever
        if ($description != "") {
            $con = open_db();
            $sql = "UPDATE usergroup SET description = '$description',
                         permission='$bitmask' WHERE id='$id'";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script language='JavaScript'>
                    alert('Thông tin của nhóm đã được thay đổi'); 
			</script>";
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=viewgroup.php\">";
            } else {
                echo "<script language='JavaScript'>
                    alert('Việc chỉnh sửa đã sảy ra lỗi, bạn hãy thực hiện lại'); 
			</script>";
                echo "<meta http-equiv = \"refresh\" content=\"0;URL=editgroup.php\">";
            }
        }
        mysqli_close();
    }
    ?>
    <?php
    $con = open_db();
    $sql = "select * from usergroup where id='$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $perms = new bitmask();
    $a = $row['permission'];
    $permarr = $perms->getPermissions($a);
    ?>
    <form action = "editgroup.php?act=do" method = "post">
        <div>
            <h3 align = "center">Thông tin nhóm thành viên </h3>
            <table id = "edit">
                <tr style="display: none">
                    <td><label>ID</label></td>
                    <td><input class = "ipt-t" name = "id" size = "5" type = "text" readonly = "true" value = "<?php echo $row['id'] ?>"/></td>
                </tr>
                <tr>
                    <td><label>Nhóm thành viên </label></td>

                    <td><input class = "ipt" size = "35" name='usergroup' type="text" value="<?php echo $row['description']; ?>"</td>
                </tr>
                <tr>
                    <td><label>Quyền hạn của nhóm</label></td>
                </tr>
            </table>
        </div>
        <div >
            <table width="850px">
                <tr>
                    <td style="border: 1px solid #EEE ; background: #c1d2ee;padding: 5px" colspan="2" align="center">Chăm sóc khách hàng</td>
                </tr>
                <tr>
                    <td><label>Chỉnh sửa thông tin khách hàng</label></td>
                    <td><input type="checkbox" name="editregistered" <?php
                        if ($permarr["editregistered"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xóa khách hàng</label></td>
                    <td><input type="checkbox" name="deleteregistered" <?php
                        if ($permarr["deleteregistered"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Soạn email gửi khách hàng</label></td>
                    <td><input type="checkbox" name="writeemail" <?php
                        if ($permarr["writeemail"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Chỉ xem khách hàng của thành viên</label></td>
                    <td><input type="checkbox" name="viewregistered" <?php
                        if ($permarr["viewregistered"]) {
                            echo "checked";
                        }
                        ?>/> </td>
                </tr>
                <tr>
                    <td><label>Chỉ xem những khách hàng sắp hết hạn</label></td>
                    <td><input type="checkbox" name="expire_1" <?php
                        if ($permarr["expire_1"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Chỉ xem những khách hàng hết hạn</label></td>
                    <td><input type="checkbox" name="expire" <?php
                        if ($permarr["expire"]) {
                            echo "checked";
                        }
                        ?>/> </td>
                </tr>
                <tr>
                    <td><label>Xem toàn bộ danh sách khách hàng</label></td>
                    <td><input type="checkbox" name="viewallregistered" <?php
                        if ($permarr["viewallregistered"]) {
                            echo "checked";
                        }
                        ?>/> </td>
                </tr>
                <tr>
                    <td><label>Chỉnh sửa email tự động</label></td>
                    <td><input type="checkbox" name="editemail" <?php
                        if ($permarr["editemail"]) {
                            echo "checked";
                        }
                        ?>/> </td>
                </tr>
            </table>
            <table width="850px">
                <tr>
                    <td style="border: 1px solid #EEE ; background: #c1d2ee;padding: 5px" colspan="2" align="center">Quản lý thành viên và nhóm thành viên</td>
                </tr>
                <tr>
                    <td><label>Quản lý thông tin nhóm bán hàng</label></td>
<!--                    <td><input type="checkbox" name="user" <?php
//                        if ($permarr["user"]) {
//                            echo "checked";
//                        }
                        ?>/></td>-->
                </tr>
                <tr>
                    <td><label>Thêm mới user</label></td>
                    <td><input type="checkbox" name="adduser" <?php
                        if ($permarr["adduser"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Sửa thông tin user</label></td>
                    <td><input type="checkbox" name="edituser" <?php
                        if ($permarr["edituser"]) {
                            echo "checked";
                        }
                        ?> /></td>
                </tr>
                <tr>
                    <td><label>Xem bảng thông tin các user trong hệ thống</label></td>
                    <td><input type="checkbox" name="viewuser" <?php
                        if ($permarr["viewuser"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xóa thông tin user</label></td>
                    <td><input type="checkbox" name="deleteuser" <?php
                        if ($permarr["deleteuser"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Thêm nhóm thành viên</label></td>
                    <td><input type="checkbox" name="addgroup" <?php
                        if ($permarr["addgroup"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Sửa nhóm phân quyền thành viên</label></td>
                    <td><input type="checkbox" name="editgroup" <?php
                        if ($permarr["editgroup"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
            </table>
            <table width="850px">
                <tr>
                    <td style="border: 1px solid #EEE ; background: #c1d2ee;padding: 5px" colspan="2" align="center">Quản lý key phần mềm</td>
                </tr>
                <tr>
                    <td><label>Xóa Key</label></td>
                    <td><input type="checkbox" name="delkey" <?php
                        if ($permarr["key"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Tạo key mới </label></td>
                    <td><input type="checkbox" name="addkey" <?php
                        if ($permarr["addkey"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Chuyển key cho thành viên</label></td>
                    <td><input type="checkbox" name="changcekey" <?php
                        if ($permarr["changcekey"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng bán key của thành viên</label></td>
                    <td><input type="checkbox" name="viewkey" <?php
                        if ($permarr["viewkey"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key dự toán</label></td>
                    <td><input type="checkbox" name="viewdutoan" <?php
                        if ($permarr["viewdutoan"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key dự thầu</label></td>
                    <td><input type="checkbox" name="viewduthau" <?php
                        if ($permarr["viewduthau"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key thanh quyết toán</label></td>
                    <td><input type="checkbox" name="viewtqt" <?php
                        if ($permarr["viewtqt"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Cho phép đổi trạng thái key</label></td>
                    <td><input type="checkbox" name="changekey" <?php
                        if ($permarr["changekey"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Xem danh sách các phẩn mềm trong hệ thống</label></td>
                    <td><input type="checkbox" name="viewproduct" <?php
                        if ($permarr["viewproduct"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Sửa thông tin phần mềm</label></td>
                    <td><input type="checkbox" name="editproduct" <?php
                        if ($permarr["editproduct"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                
                <tr>
                    <td><label>Xóa thông tin của phần mềm</label></td>
                    <td><input type="checkbox" name="deleteproduct" <?php
                        if ($permarr["deleteproduct"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
                <tr>
                    <td><label>Thêm phần mềm mới</label></td>
                    <td><input type="checkbox" name="addproduct" <?php
                        if ($permarr["addproduct"]) {
                            echo "checked";
                        }
                        ?>/></td>
                </tr>
				<tr>
                    <td><label>Tạo key dùng thử 1 tuần</label></td>
                    <td><input type="checkbox" name="keydungthu" /></td>
                </tr>
            </table>
            <p align='center'><input  type="submit" value="Lưu lại"/></p>
        </div>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>