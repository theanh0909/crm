<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
 <?php require_once("../model/function.php");?>
 <?php require_once("../model/user.php");?>
<script type="text/javascript">
    $(function() {
        $('#btnRadio').click(function() {
            var checkedradio = $('[name="type"]:radio:checked').val();
            $('#sel').html('Selected value: ' + checkedradio);
        });
    });
</script>
<?php
if ($_GET['act'] == "do") {
    $username = isset($_POST['username']) ? $_POST['username'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $verify_password = isset($_POST['verify_password']) ? $_POST['verify_password'] : "";
    $type = isset($_POST['type']) ? $_POST['type'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    $tinhthanh = isset($_POST['tinhthanh']) ? $_POST['tinhthanh'] : "";
    $doanhthu = 0;
    $status = 0;
    if (!$username || !$password || !$verify_password) {
        echo "<script language='JavaScript'>
                    alert('Bạn phải nhập đầy đủ thông tin của user'); 
			</script>";
        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; URL=createaccount.php\">";
    } else {
        $exit = check_username_password($username,$password);
        if ($exit) {
            echo "<script language='JavaScript'>
                    alert('User này đã tồn tại. Bạn hãy nhập tên user khác'); 
			</script>";
            echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"5; URL=createaccount.php\">";
        } else {
            if ($password != $verify_password) {
                echo "<script language='JavaScript'>
                    alert('Mật khẩu không giống nhau'); 
                   			</script>";
                echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"5; URL=createaccount.php\">";
            } else {
                $chek = check_username_email($email);
                if ($chek) {
                    echo "<script language='JavaScript'>
                    alert('Email này đã tồn tại. Bạn hãy nhập tên email khác'); 
			</script>";
                    echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; URL=createaccount.php\">";
                } else {
                    $md5_pass = md5($password);
                    $a = add_account($username, $md5_pass, $email, $tinhthanh, $type);
                    if ($a) {
                        echo "<script language='JavaScript'> alert('Bạn thêm user thành công !^-^');
			window.location.replace('http://giaxaydung.vn/kichhoat/views/user.php');
			</script>";
                    } else {
                        echo "Có lỗi trong quá tạo tài khoản thành viên , Vui lòng nhập lại thông tin ";
                        echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; URL=createaccount.php\">";
                    }
                }
            }
            // Thông báo hoàn tất việc tạo tài khoản
        }
    }
}
?>
<div id="rightcolumn">
    <h3 align="center">TẠO ĐẠI LÝ BÁN HÀNG </h3>
    <form action = 'createaccount.php?act=do' method = 'post'>
        <div class="user" >
            <h3>Thông tin user</h3>
            <table id = "edit" align = "left">
                <tr>
                    <td><label>Tên thành viên </label></td>
                    <td><input class = "ipt" size = "35" name = "username" type = "text" /></td>
                </tr>
                <tr>
                    <td><label>Mật khẩu</label></td>
                    <td><input class = "ipt" size = "35" name = "password" type = "password" /></td>
                </tr>
                <tr>
                    <td><label>Xác nhận lại mật khẩu</label></td>
                    <td><input class = "ipt" size = "35" name = "verify_password" type = "password" /></td>
                </tr>
                <tr>
                    <td><label>Email </label></td>
                    <td><input class = "ipt" size = "45" name = "email" type = "text"  value = ""/></td>
                </tr>
            </table>
        </div>
        <div class="user" >
            <h3>Quyền hạn thành  viên</h3>
            <table id = "edit" align = "left">
                <?php
                $con = open_db();
                $sql = "select id, description from usergroup";
                $result = mysqli_query($con, $sql);
                while ($row1 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><input type="radio" name="type" <?php if ($row1['id']) echo "checked" ?> value="<?php echo $row1['id'] ?>"/><?php echo $row1['description']; ?> </td>
                    </tr>
                <?php } ?>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>

        </div>
        </br>
        <input class = "button" type = "submit" value = "Tạo tài khoản mới"/>
    </form>

    <?php
    $error = isset($_GET['error']) ? $_GET['error'] : "";
    echo "<div style='color:red; margin-left:20px'>" . $error . "</div>";
    ?>
</div>
<?php require_once("../Include/footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>
