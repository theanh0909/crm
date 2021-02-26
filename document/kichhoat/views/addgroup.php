<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../config/dbconnect.php"); ?>
<?php require_once("../config/bitfield.php"); ?>
<?php get_infor_from_conf("../config/DB.conf"); ?>
<?php
if ($_GET['act'] == "do") {
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
    $perms->permissions["manageruser"] = isset($_POST['manageruser']) ? $_POST['user'] : "";
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
    // converts to bitmask value to store in database or wherever
    $bitmask = $perms->toBitmask();
    echo $bitmask;
    //die();
//in this example it is 15
    $con = open_db();
    $sql = "insert into usergroup (id,description,permission) values(NULL,'$description','$bitmask')";
    $result = mysqli_query($con, $sql);
    if ($result) {
        echo "Đã tạo thành công nhóm ";
    } else {
        echo "Đã có lỗi xảy ra bạn hãy tạo lại nhóm";
    }
    mysqli_close();
}
?>
<div id="rightcolumn">
    <form action="addgroup.php?act=do" method="post">
        <div>
            <h3 align="center">Tạo nhóm thành viên </h3>
            <table  align = "center" >
                <tr>
                    <td><label>Nhóm thành viên </label></td>
                    <td><input class = "ipt" size = "35" name = "usergroup" type = "text" /></td>
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
                    <td><input type="checkbox" name="editregistered"/></td>
                </tr>
                <tr>
                    <td><label>Xóa khách hàng</label></td>
                    <td><input type="checkbox" name="deleteregistered"/></td>
                </tr>
                <tr>
                    <td><label>Soạn email gửi khách hàng</label></td>
                    <td><input type="checkbox" name="writeemail" value="4"/></td>
                </tr>
                <tr>
                    <td><label>Chỉ xem khách hàng của thành viên</label></td>
                    <td><input type="checkbox" name="viewregistered"/></td>
                </tr>
                <tr>
                    <td><label>Chỉ xem những khách hàng sắp hết hạn</label></td>
                    <td><input type="checkbox" name="expire_1"/></td>
                </tr>
                <tr>
                    <td><label>Chỉ xem những khách hàng hết hạn</label></td>
                    <td><input type="checkbox" name="expire"/></td>
                </tr>
                <tr>
                    <td><label>Xem toàn bộ danh sách khách hàng</label></td>
                    <td><input type="checkbox" name="viewallregistered"/></td>
                </tr>
                <tr>
                    <td><label>Chỉnh sửa email tự động</label></td>
                    <td><input type="checkbox" name="editemail"/></td>
                </tr>
            </table>
            <table width="850px" >
                <tr>
                    <td style="border: 1px solid #EEE ; background: #c1d2ee;padding: 5px" colspan="2" align="center">Quản lý thành viên và nhóm thành viên</td>
                </tr>
                <tr>
                    <td><label>Thêm mới user</label></td>
                    <td><input type="checkbox" name="adduser"/></td>
                </tr>
                <tr>
                    <td><label>Sửa thông tin user</label></td>
                    <td><input type="checkbox" name="edituser"/></td>
                </tr>
                <tr>
                    <td><label>Xem bảng thông tin các user trong hệ thống</label></td>
                    <td><input type="checkbox" name="viewuser"/></td>
                </tr>
                <tr>
                    <td><label>Xóa thông tin user</label></td>
                    <td><input type="checkbox" name="deleteuser" /></td>
                </tr>
                <tr>
                    <td><label>Thêm nhóm thành viên</label></td>
                    <td><input type="checkbox" name="addgroup"/></td>
                </tr>
                <tr>
                    <td><label>Sửa nhóm phân quyền thành viên</label></td>
                    <td><input type="checkbox" name="editgroup"/></td>
                </tr>
            </table>
            <table width="850px">
                <tr>
                    <td style="border: 1px solid #EEE ; background: #c1d2ee;padding: 5px" colspan="2" align="center">Quản lý key phần mềm</td>
                </tr>
                <tr>
                    <td><label>Tạo key mới </label></td>
                    <td><input type="checkbox" name="addkey"/></td>
                </tr>
                <tr>
                    <td><label>Xóa Key</label></td>
                    <td><input type="checkbox" name="delkey"/></td>
                </tr>
                <tr>
                    <td><label>Chuyển key cho thành viên</label></td>
                    <td><input type="checkbox" name="changcekey"/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng bán key của thành viên</label></td>
                    <td><input type="checkbox" name="viewkey"/></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key dự toán</label></td>
                    <td><input type="checkbox" name="viewdutoan" /></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key dự thầu</label></td>
                    <td><input type="checkbox" name="viewdutthau" /></td>
                </tr>
                <tr>
                    <td><label>Xem tình trạng của key thanh quyết toán</label></td>
                    <td><input type="checkbox" name="viewtqt" /></td>
                </tr>
                <tr>
                    <td><label>Cho phép đổi trạng thái key</label></td>
                    <td><input type="checkbox" name="changekey"/></td>
                </tr>
                <tr>
                    <td><label>Xem danh sách phần mềm</label></td>
                    <td><input type="checkbox" name="viewproduct"/></td>
                </tr>
                <tr>
                    <td><label>Thêm phần mềm mới </label></td>
                    <td><input type="checkbox" name="addproduct" /></td>
                </tr>
                <tr>
                    <td><label>Sửa thông tin phần mềm</label></td>
                    <td><input type="checkbox" name="editproduct" /></td>
                </tr>
                <tr>
                    <td><label>Xóa phần mềm</label></td>
                    <td><input type="checkbox" name="deleteproduct" /></td>
                </tr>
				<tr>
                    <td><label>Tạo key dùng thử 1 tuần</label></td>
                    <td><input type="checkbox" name="keydungthu" /></td>
                </tr>
            </table>
            <p align="center"><input  type="submit" value="Tạo nhóm mới"/>
            </p>
        </div>
    </form>
</div>
<?php require_once '../Include/footer.php'; ?>