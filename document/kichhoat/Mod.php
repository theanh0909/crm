<?php
$config['dn2_dnp'] = 'GXD686868';
$config['mk2_dnp'] = 'GXD@12345#$%';
if ($_SERVER['PHP_AUTH_USER'] != $config['dn2_dnp'] || $_SERVER['PHP_AUTH_PW'] != $config['mk2_dnp']){
header('WWW-Authenticate: Basic realm="Hay khai bao thong tin yeu cau truoc khi duoc chuyen den bang dang nhap"');
header('HTTP/1.0 401 Unauthorized');
//Trang se hien thi khi thong tin khai bao sai. Ho tro HTML nen ban co the thiet ke mot trang dep hon
echo '<center>Ban khong the dang nhap vao day!</center>';
exit;
}
session_cache_expire(483840);
session_start();
require_once 'config/site.php';
require_once("model/function.php");
require_once("config/dbconnect.php");
get_infor_from_conf("config/DB.conf");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login Box HTML Code - www.PSDGraphics.com</title>
        <link href="<?php echo SITE_URL; ?>/template/css/login-box.css" rel="stylesheet" type="text/css" />
    </head>
    <body style='background: #e2e1e0'>       
        <?php
        $con = open_db();
        $sl = "select * from seting where id=1";
        $res = mysqli_query($sl, $con);
        $row = mysqli_fetch_array($res);
        $set = $row['status'];
        if ($set = 1) {
            $_SESSION['status'] = "";
            $_SESSION['username'] = "";
            $_SESSION['password'] = "";
            $_SESSION['id'] = "";
            $_SESSION['type'] = "";
            if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {  //??????????
                if ($_GET['act'] == "do") {
                    $username = mysqli_real_escape_string($_POST['username']) ? $_POST['username'] : "";
                    $password = mysqli_real_escape_string($_POST['password']) ? $_POST['password'] : "";
                    $nhopass = isset($_POST['nhopass']) ? $_POST['nhopass'] : "";
                    if (!empty($_REQUEST['captcha'])) {
                        if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
                            $captcha_message = "Invalid captcha";
                        } else {
                            $captcha_message = "Valid captcha";
                        }
                        $request_captcha = htmlspecialchars($_REQUEST['captcha']);
                        unset($_SESSION['captcha']);
                        if ($captcha_message == "Invalid captcha") {
                            $_SESSION['status'] = "";
                            header("Location: Mod.php?error=Sai mã kiểm tra");
                            die();
                        }
                    } else {
                        $_SESSION['status'] = "";
                        header("Location: Mod.php?error=Sai mã kiểm tra");
                        die();
                    }
                    $fb = check_username_password($username, md5($password));
                    if (!$fb) {
                        $_SESSION['status'] = "";
                        echo "<script language='JavaScript'> alert('Bạn hãy kiểm tra lại user hoặc password ');
			location.replace('/kichhoat/Mod.php')
			</script> ";
                    } else {
                        $_SESSION['status'] = "login";
                        $id = intval($_SESSION['id']);
                        $_SESSION['username'] = isset($_POST['username']) ? $_POST['username'] : "";
                        $_SESSION['password'] = isset($_POST['password']) ? $_POST['password'] : "";
                        if ($nhopass == "login") {
                            setcookie("status", $_SESSION['status'], time() + 7 * 24 * 60 * 60);
                            $_COOKIE["status"];
                            setcookie("username", $_SESSION['username'], time() + 7 * 24 * 60 * 60);
                            $_COOKIE["username"];
                            setcookie("password", $_SESSION['password'], time() + 7 * 24 * 60 * 60);
                            $_COOKIE["password"];
                        }
                        $chek_per = check_per($username, md5($password));
                        if($chek_per == 1 || $chek_per == 2 ){
						Log_info('1',$username);
                        echo						
                        "<script language='JavaScript'> alert('Chào mừng {$username}, Bạn đã đăng nhập vào phần quản lý Key phần mềm ');
			window.location.href ='views/administrator.php';
			</script>";
                        }
						//Log_info('1',$username);
                        else{
						Log_info('1',$username);
						echo						
                        "<script language='JavaScript'> alert('Chào mừng {$username}, Bạn đã đăng nhập vào phần quản lý Key phần mềm ');
			window.location.href ='Mod/show.php';
			</script>";}
                    }
                }
                ?>
                <div id="body">
                    <div id="login-box" style="text-align:center">
                        <div style="float:left; margin-left: -14px; margin-top: 20px;"><img src="template/img/dang_nhap.png"/></div>
                        <!--<div style="float:center">Công ty CP Giá Xây Dựng</div>-->
                        <form action="Mod.php?act=do" method="POST" style="margin-top: 80px">
                            <div id="login-box-name">Tài khoản:</div>
                            <div id="login-box-field">
							<table>
								<tr>
									<td>
									<input name="username" class="form-login" title="Username" value="<?php echo $_COOKIE['username'] ?>" maxlength="2048" />
									</td>
								</tr>
							</table>
							</div>
                            <div id="login-box-name">Mật khẩu:</div><div id="login-box-field"><table><tr><td><input name="password" type="password" class="form-login" title="Password" value="<?php echo $_COOKIE['password'] ?>" maxlength="2048" /></td></tr></table></div>
                            <br />
                            <span class="login-box-options"></span>
                            <div style="margin-left: 100px;margin-top: -10px">	
                                <table border="0">
                                    <tr>
                                        <td><input type="text" name = "captcha" id = "captchar-form" style="height:32px; width:130px; border: 1px solid #553F55;"></td>
                                        <td><img src="captcha.php" id="captcha" width="100" height="36"></td>
                                        <td align="right"><a href="#" onclick="
                                                            document.getElementById('captcha').src = 'captcha.php?' + Math.random();
                                                            document.getElementById('captcha-form').focus();"
                                                             id="change-image"><img src="template/img/refresh.jpg" width="25" height="25"/></a>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <div><input type= "checkbox" name="nhopass" value="login"/>Ghi nhớ thông tin
                            </div>
                            <button type= "submit" class = "login_submit_button" value="Login">Đăng nhập</button>
                        </form>
                        <?php
                        $error = isset($_GET['error']) ? $_GET['error'] : "";
                        echo "<div style='color:red; margin-left:20px'>" . $error . "</div>";
                    } else {
                        "<script language='JavaScript'> 
			location.replace('views/administrator.php');
			</script>";
                    }
                } else {
                    echo '<div id="login-box" style="text-align:center"><span style="font-size:15px; color: blue; font-weight:600; margin-top:20px;">Hệ thống đang đóng cửa để bảo dưỡng
                        bạn hãy quay lại sau</div>';
                    die();
                }
                ?>
            </div>
        </div>
    </body>
</html>
