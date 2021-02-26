<?php ob_start(); ?>
<?php
session_start();
require_once("../config/dbconnect.php");
require_once("../config/site.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");

$id = isset($_GET['id']) ? $_GET['id'] : "";

if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "Login để được truy cập<br>";
    die("<a href = 'index.php'>Login</a>");
} else {
        $user = $_SESSION['username'];
?>
        <div id="rightcolumn">
            <?php
                if (!isset($_GET["do"])){
                //If not isset -> set with dumy value
                $_GET["do"] = "undefine";
                } 

            if ($_GET['do'] == "changepass") {
                $passcu = md5(addslashes($_POST['passcu']));
                $pass = md5(addslashes($_POST['pass']));
                $repass = md5(addslashes($_POST['repass']));
                $sqlxpp = "select password from user where  `username` = '".$user."'";
                $saaapass = mysqli_query($sqlxpp);

                if ($saaapass) {
                    $rowp = mysqli_fetch_array($saaapass);
                    }
                    if ($passcu == $rowp ['password']) {
                        if ($_POST['pass'] == $_POST['repass'] && $_POST['pass'] != "") {
                            $sqlx = "UPDATE `user` SET `password` = '" . $pass . "' WHERE `username` = '".$user."'";
                            $suapass = mysqli_query($sqlx);
                            if ($suapass){
                                echo "<script language='JavaScript'> alert('Bạn đã đổi pass thành công');
                                location.replace('administrator.php');
                                </script>";
                            }
                            else
                                echo "<script language='JavaScript'> alert('Pass chưa được đổi');
                                location.replace('changepass.php');
                                </script>";
                        }
                        else
                            echo "<script language='JavaScript'> alert('Pass chưa được đổi. Bạn cần nhập đầy đủ thông tin');
                            location.replace('changepass.php');
                            </script>";
                    }
                    else
                        echo "<script language='JavaScript'> alert('Mật khẩu cũ không đúng. Bạn hãy kiểm tra lại ');
                        location.replace('changepass.php');
                        </script>";
                }
            else
                echo "<form method='POST' action='?do=changepass' style='margin-left:50px; padding:10px'>
                <label><strong>Password cũ:</strong></label><br/>
                <input class='ipt' type='password' name='passcu' size='35'/><br/>
                <label><strong>Password mới:</strong></label><br/>
                <input class='ipt' type='password' name='pass' size='35'/><br/>
                <label><strong>Nhập lại password Password:</strong></label><br/>
                <input class='ipt' type='password' name='repass' size='35'/><br/>
                <p ><input type='submit' value='Lưu'><input type='reset' value='Khôi phục' name='B2'></p>
                </form>";
        }
        ?>  
    </div>
<?php require_once("../Include/footer.php"); ?>

