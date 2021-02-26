<?php ob_start(); ?>
<?php session_start() ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Giá xây dựng - License</title>
        <?php require_once("../Include/header.php"); ?>
    </head>
    <body>
        <h2 align="center" class="gxdh2">DANH SÁCH THÀNH VIÊN  </h1>
            <div class="gxdlicense">
                <?php
                if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
                    die("Login để chạy trang này");
                }
                require_once("../config/global.php");
                require_once("../config/dbconnect.php");
                $username = isset($_POST['username']) ? $_POST['username'] : "";
                $password = isset($_POST['password']) ? $_POST['password'] : "";
                $type = isset($_POST['type']) ? $_POST['type'] : "";
                $email = isset($_POST['email']) ? $_POST['email'] : "";
                $crypted_password = "";

                $md5_password = md5($password);

//luu vao co so du lieu
                get_infor_from_conf("../config/DB.conf");
                $con = open_db();
                $sql = "select * from user";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                if ($username == $row['username']) {
                    echo "Tài khoản hoặc mật khẩu bạn vừa nhập đã tồn tại 
		<p align='center'><a href='createaccount.php'>Bạn vui lòng bấm vào đây để nhập lại</a> </p>";
                } else {
                    add_account($username, $md5_password, $email, $type);
                    echo "Tạo account thành công";
                    echo "<a href = 'user.php'>Danh sách thành viên</a>";
                }
                ?>
            </div>
            <?php require_once("../Include/footer.php"); ?>
    </body>
</html>
<?php ob_flush(); ?>
