<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Dự toán GXD</title>
<?php
require_once("global.php");
require_once("dbconnect.php");
get_infor_from_conf("DB.conf");
	require_once("Include/header.php");
//Kiem tra email co hop le hay ko
function check_email($email) {
	if (strlen($email) == 0) return false;
	if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) return true;
	return false;
}
if ( $_GET['act'] == "do" )
{
	// Dùng hàm addslashes() để tránh SQL injection, dùng hàm md5() để mã hóa password
	$username = addslashes( $_POST['username'] );
	$password = md5( addslashes( $_POST['password'] ) );
	if ( ! $username || ! $_POST['password'] || ! $_POST['verify_password'])
	{
		print "Xin vui lòng nhập đầy đủ các thông tin. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	// Kiểm tra username nay co nguoi dung chua
	if ( mysqli_num_rows("SELECT username FROM tbl_account WHERE username='$username'")>0)
	{
		print "Username này đã có người dùng, Bạn vui lòng chọn username khác. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	// Kiểm tra email nay co hop le ko
	//if (!check_email($email))
	//{
	//	print "Email này ko hợp lệ. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
	//	exit;
//	}
	//if (!ereg("^[0-9]+/[0-9]+/[0-9]{2,4}",$sinhnhat))
	//{
	//	print "Ngày tháng năm sinh ko hợp lệ. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
	//	exit;
	//}
	// Kiểm tra email nay co nguoi dung chua
//	if ( mysqli_num_rows(mysqli_query("SELECT email FROM members WHERE email='$email'"))>0)
	//{
		//print "Email này đã có người dùng, Bạn vui lòng chọn Email khác. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		//exit;
	//}
	// Kiểm tra mật khẩu, bắt buộc mật khẩu nhập lúc đầu và mật khẩu lúc sau phải trùng nhau
	if ( $password != $verify_password )
	{
		print "Mật khẩu không giống nhau, bạn hãy nhập lại mật khẩu. <a href='javascript:history.go(-1)'>Nhấp vào đây để quay trở lại</a>";
		exit;
	}
	// Tiến hành tạo tài khoản
	@$a=mysqli_query("INSERT INTO tbl_account (username, password) VALUES ('{$username}', '{$password}')");
	// Thông báo hoàn tất việc tạo tài khoản
	if ($a)
		print "Tài khoản {$username} đã được tạo. <a href='login.php'>Nhấp vào đây để đăng nhập</a>";
	else
		print "Có lỗi trong quá trình đăng kí, Vui lòng liên hệ BQT";
}
else
{
// Form đăng ký
print <<<EOF
<form action="register.php?act=do" method="post">
	<table align="center" border="0" width="600" cellspacing="0" style="border-collapse: collapse" bordercolor="#C0C0C0">
		<tr>
			<td>Tên truy nhập:</td>
			<td><input type="text" name="username" value=""></td>
		</tr>
		<tr>
			<td>Mật khẩu:</td>
			<td><input type="password" name="password" value=""></td>
		</tr>
		<tr>
			<td>Xác nhận mật khẩu:</td>
			<td><input type="password" name="verify_password" value=""></td>
		</tr>
			<tr>
			<td><input type="submit" name="submit" value="Đăng ký tài khoản"></td>
			<td><Font size="5"> Dutoangxd.vn</Font></td>
		</tr>
	</table>
</form>
EOF;
}
	require_once("Include/footer.php");
?>
