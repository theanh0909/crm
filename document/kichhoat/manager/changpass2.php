<?php
$fp = fopen("../tmp/pass.txt", "r");
$pass_1= fread($fp,filesize("../tmp/pass.txt"));
fclose($fp);

session_start();
require_once("../config/dbconnect.php");
require_once("../config/site.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$id = isset($_GET['id']) ? $_GET['id'] : "";
$do = isset($_GET['do']) ? $_GET['do'] : "";
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    echo "Login để được truy cập<br>";
    die("<a href = 'index.php'>Login</a>");
} else {
    $user = $_SESSION['username'];
    ?>
    <div id="rightcolumn">
        <?php
        if ($do == "changepass") {
            $passcu = md5($_POST['passcu']);
            $pass = md5($_POST['pass']);
            $repass = md5($_POST['repass']);
		
				
            if ($passcu == $pass_1) {
                if ($_POST['pass'] == $_POST['repass'] && $_POST['pass'] != "") {
                    $fp = fopen("../tmp/pass.txt", "w");
                    $pass_1= fwrite($fp,$pass);
                    fclose($fp);
                    if ($pass_1 == FALSE)
                        echo "<script language='JavaScript'> alert('Pass chưa được đổi');
			location.replace('changepass2.php');
			</script>";                        
                    else
                        echo "<script language='JavaScript'> alert('Bạn đã đổi pass thành công');
			location.replace('/views/administrator.php');
			</script>";
                }
                else
                    echo "<script language='JavaScript'> alert('Pass chưa được đổi. Bạn cần nhập đầy đủ thông tin');
			location.replace('changepass2.php');
			</script>";
            }
            else
                echo "<script language='JavaScript'> alert('Mật khẩu cũ không đúng. Bạn hãy kiểm tra lại ');
			location.replace('changepass2.php');
			</script>";
        }
        else
            echo"
<form method='POST' action='?do=changepass' style='margin-left:50px; padding:10px'>
<label><strong>Password cũ:</strong></label><br/>
<input class='ipt' type='password' name='passcu' size='35'/><br/>
<label><strong>Password mới:</strong></label><br/>
<input class='ipt' type='password' name='pass' size='35'/><br/>
<label><strong>Nhập lại password Password:</strong></label><br/>
<input class='ipt' type='password' name='repass' size='35'/><br/>
<p ><input type='submit' value='Lưu'><input type='reset' value='Khôi phục' name='B2'></p>
</form>
";
    }
    ?>  
</div>
<?php require_once("../Include/footer.php"); ?>

