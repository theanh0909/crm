<?php
ob_start();
require_once("config/global.php");
require_once("config/dbconnect.php");
require_once("phpmailer/active_software.php");
get_infor_from_conf("config/DB.conf");
?>
<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Client Certification</title>
    </head>
    <body>
        <?php
            $client_key = isset($_REQUEST['client_key']) ? $_REQUEST['client_key'] : "";
            $hardware_id = isset($_REQUEST['client_hardware_id']) ? $_REQUEST['client_hardware_id'] : "";
            $customer_name = isset($_REQUEST['customer_name']) ? $_REQUEST['customer_name'] : "NA";
            $customer_phone = isset($_REQUEST['customer_phone']) ? $_REQUEST['customer_phone'] : "NA";
            $customer_email = isset($_REQUEST['customer_email']) ? $_REQUEST['customer_email'] : "NA";
            $customer_address = isset($_REQUEST['address']) ? $_REQUEST['address'] : "NA";
            $product = isset($_REQUEST['product']) ? $_REQUEST['product'] : "NA";
            $captcha = isset($_REQUEST['captcha']) ? $_REQUEST['captcha'] : "";
            $customer_cty = isset($_REQUEST['tinhthanh']) ? $_REQUEST['tinhthanh'] : "NA";
            $md5_key = md5(trim($client_key));
            $last_runing_date2 = date('Y-m-d H:i:s');
            $day = date('d/m/Y');
            $stringarr = serialize($_REQUEST);
            $fp = fopen("tmp/data.txt", "w");
            fwrite($fp, $stringarr);
            fclose($fp);
		//echo "11111111111111111";
		//die();
        if ($captcha == "Check_update") {
            $up = check_status_license($md5_key);
            if ($up) {
                echo "#BEGIN_RES#ACCESS_UPDATE#" . $client_key . "#END_RES#";
                die();
            } else {
                echo "#BEGIN_RES#NO" . $client_key . "#END_RES#";
                die();
            }
        }
		if ($captcha == "Check_info") {
			if($customer_address == "KHOACUNG"){
				// echo "#BEGIN_RES#ASSS|Bạn đang dùng khóa cứng|..............................." . $client_key . "#END_RES#";
				echo "#BEGIN_RES#" . check_info_KC($product ).  "#END_RES#";
			} else
               // echo "#BEGIN_RES#ASSS|ASASSS|FFFFFKH" . $client_key . "#END_RES#";
				echo "#BEGIN_RES#" . check_info($md5_key, $hardware_id, $client_key ).  "#END_RES#";
				//echo "aaaaaaaaaaaaa";
                die();
        }
		if ($captcha == "Check_resetup") {	
				//resetup:
            if($hardware_id != '' && $product!=''){
            echo Check_resetup($hardware_id, $product,$customer_email );
            }
            die();
        }
		if ($customer_email == "Check_resetup") {				
            if($hardware_id != '' && $product!=''){
            echo Check_resetup_1($hardware_id, $product );
            }
            die();
        }
        if ($captcha == "CheckExpire") {	
            $fb = check_registered_expire_ed($md5_key,$hardware_id);	
            if (!$fb) {
				//false khong cho đăng kí
				//goto resetup;
				$day = get_expireday($md5_key,$hardware_id);
                echo "#BEGIN_RES#KEY_EXPIRED#" . $client_key.'|'.$day ."#END_RES#";
				die();
            } else {					
                echo "#BEGIN_RES#KEY_VALID#" . $client_key . "#END_RES#";
				//echo "#BEGIN_RES#KEY_NOTVALID#" . $client_key . "#END_RES#";
                update_last_runing_date($md5_key, $last_runing_date2, $hardware_id);
                die();
            }
        } else { //kiem tra captcha
            if (!empty($_REQUEST['captcha'])) {
                if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
                    get_infor_from_conf("config/DB.conf");
                    $con = open_db();
                    $client_ip = $_SERVER["REMOTE_ADDR"];
                    $sql = "select * from captcha where ip_address = '$client_ip'";
                    $result = ;
                    $row = mysqli_fetch_array($result);
                    if (!strstr($row['captcha_text'], $_REQUEST['captcha'])) {
                        $captcha_message = "Invalid captcha";
                    } else {
                        $captcha_message = "Valid captcha";
                    }
                    mysqli_close($con);
                } else {
                    $captcha_message = "Valid captcha";
                }
                $request_captcha = htmlspecialchars($_REQUEST['captcha']);

                unset($_SESSION['captcha']);

                if ($captcha_message == "Invalid captcha") {
                    echo "#BEGIN_RES#CAPTCHA_NOTVALID#" . $client_key . "#END_RES#";
                    die();
                }
            } else {
                echo "#BEGIN_RES#CAPTCHA_EMPTY#" . $client_key . "#END_RES#";
                die();
            }
        }

        
		 //------------------
        insert_n_product($product,$customer_email,$customer_phone,$customer_name,$customer_address,$client_key,$customer_cty,$hardware_id);
        
        //-------------------

        if ($client_key == "KHOACKHOACKHOACKHOAC") {
            echo "#BEGIN_RES#REGIS_SUCCESS#" . $client_key . "#END_RES#";
            $md5_keykc = md5($client_key);
            add_client_info_to_db($md5_keykc, $client_key, $hardware_id, $customer_name, $customer_phone, $customer_email, $customer_address, date("Y-m-d"), date("Y-m-d"), date("Y-m-d"), $product, $customer_cty);
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $size = strlen($chars);
            for ($i = 0; $i < 8; $i++) {
                $password.= $chars[rand(0, $size - 1)];
            }
            for ($i = 0; $i < 30; $i++) {
                $salt .= chr(rand(33, 126));
            }
            for ($i = 0; $i < 3; $i++) {
                $name_user.= chr(rand(3, $size - 1));
            }
            $con = open_db();
            $email = strtolower($customer_email);
            $md5_pas = md5(md5($password) . $salt);
            $conn = mysqli_connect("localhost", "giaxaydung_dtoan", "ur2cfzNLJTp3m44M") or die("can't connect this database");
            mysqli_select_db("giaxaydung_dtoan", $conn);
            $sqluser = "select * from user where usernamelogin='" . $email . "' or email='" . $email . "'";

            $queryuser = mysqli_query($sqluser, $conn);
            if ($queryuser) {
                $title = "Chúc mừng bạn đã đăng ký thành công phần mềm GXD";
                $content = "Chào bạn !<br/>
Chúc mừng bạn đã đăng ký thành công phần mềm của công ty Giá Xây Dựng.<br/>
Bạn đã quyết định đúng. Chúng tôi tin tưởng rằng phần mềm sẽ mang lại cho bạn nhiều hiệu quả và lợi ích.<br/>
Bạn hãy đăng ký vào trang Hội dự toán nhà nghề Việt Nam có địa chỉ http://dutoangxd.vn để tải dữ liệu csv, các tài liệu và nhận sự trợ giúp từ các chuyên gia dự toán, các bạn đồng nghiệp.<br/>
Mời bạn xem các video hướng dẫn trực quan với thuyết minh cặn kẽ tại kênh http://youtube.com/giaxaydung hoặc tại mục Video hướng dẫn của diễn đàn.<br/>
Email của bạn đã được sử dụng trong trang http://dutoangxd.vn. <br/> Bạn hãy sử dụng tài khoản đó để đăng nhập diễn đàn. 
Chúc bạn luôn thành công.<br/>
Cảm ơn bạn đã lựa chọn GXD. Chúng tôi sẽ luôn luôn nỗ lực để phục vụ bạn tốt hơn";

                send_email($email, $customer_name, $title, $content);
                die();
            } else {
                $sql_user = "select * from user where username='" . $customer_name . "'";
                $query_user = mysqli_query($sqluser, $conn);
                if ($query_user) {
                    $name_kh = $customer_name . $name_user;
                    $sqluser2 = "insert into user(userid,usergroupid,username,usernamelogin,password,passworddate,email,
                                    styleid,showvbcode, showbirthday, customtitle, reputation, reputationlevelid, timezoneoffset,
                                    salt, money)
                                   values(NULL,'2','" . $name_kh . "','" . $email . "','" . $md5_pas . "','" . $last_runing_date2 . "','" . $email . "',
                                   '0','2','2','0','10',4,'7','" . $salt . "','50')";
                    $queryuser2 = mysqli_query($sqluser2, $conn);
                    if ($queryuser2) {
                        $sid = "SELECT userid FROM `user` WHERE username='.$customer_name.'";
                        $r = mysqli_query($sid, $conn);
                        if ($r) {
                            $rowid = mysqli_fetch_array($r);
                            $userid_re = $rowid['userid'];
                            $sl = " INSERT INTO `userfield` (
                                `userid` ,
                                `temp` ,
                                `field9` ,
                                `field10` ,
                                `field11` ,
                                `field14` ,
                                `field15` ,
                                `field18`
                                )
                                VALUES (
                                    ' $userid_re', NULL , '', '', '', '', '', ''
                                )";
                            $re = mysqli_query($sl, $conn);
                        }
                        $tk = "Tên đăng nhập: <b>$email</b><br/>
                               Mật khẩu: <b>$password</b><br/>
                               Đây là quyền lợi của bạn từ việc mua phần mềm.<br/>
                               Chúc bạn luôn thành công.<br/>
                               Cảm ơn bạn đã lựa chọn GXD. Chúng tôi sẽ luôn luôn nỗ lực để phục vụ bạn tốt hơn.";
                        $dbsql = "select * from email where id=21";
                        $result1 = mysqli_query($dbsql, $con);
                        $row1 = mysqli_fetch_array($result1);
                        $a = $row1['subjects'];
                        $content = $row1['content'] . "$tk";
                        $title = "$a";
                        send_email($email, $customer_name, $title, $content);
                    }
                } die();
            }
        }
				
                	//------------------------      
        if ($client_key != "" && $hardware_id != "") {
            //***Kiểm tra key đã được tạo hay chưa 
            $exist = check_license_exist($md5_key, $product);

            if ($exist) {
                // Cho phép đăng ký mới 
				
				 //Đăng kí lại ============================
                    if (check_key_agian($client_key) == 1){
                        $check_ud= update_registered_hw($client_key, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date2, $customer_cty);
						if($check_ud == TRUE ){
							echo "#BEGIN_RES#KEY_VALID#" . $client_key . "#END_RES#";
						}
						else echo "#BEGIN_RES#KEY_NOTVALID#" . $client_key . "#END_RES#";
						die();
                    }
						//echo "#BEGIN_RES#KEY_NOTVALID#" . $client_key . "#END_RES#";
						//die();
                $no_computers_registered = check_no_computers_resgistered($md5_key, $hardware_id);
                if ($no_computers_registered != -1) {
                    $upsr = check_status_license($md5_key);
                    //Tính ngày hết hạn của máy
                    $con = open_db();
                    $sql = "select * from license where license_serial = '$md5_key' ";
                    $result = mysqli_query($con, $sql);
                    $row = mysqli_fetch_array($result);
                    $license_activation_date = time();
                    $date = $row['type_expire_date'];
                    if ($upsr) {
                        $license_expire_date = date('Y-m-d H:i:s', ($license_activation_date + $date * 24 * 3600));
                    } else {
                        $license_created_date = time($row['license_created_date']);
                        $license_expire_date = date('Y-m-d H:i:s', ($license_created_date + $date * 24 * 3600));
                    }
					
					//---------------------
                    $no_computers_registered += 1;
                    //Trả thông tin kích hoạt 
                    echo "#BEGIN_RES#KEY_VALID#" . $client_key . "#END_RES#";
                    $last_runing_date = date('Y-m-d H:i:s');
                    $license_activation_date = date('Y-m-d H:i:s');
                    update_license($md5_key, $hardware_id, $no_computers_registered);




                    add_client_info_to_db(
                        $md5_key, 
                        $client_key, 
                        $hardware_id, 
                        $customer_name, 
                        $customer_phone, 
                        $customer_email, 
                        $customer_address, 
                        $license_activation_date, 
                        $last_runing_date, 
                        $license_expire_date, 
                        $product, 
                        $customer_cty
                    );




					del_n_product($product, $customer_email);
                    if ($upsr) {
                        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                        $size = strlen($chars);
                        for ($i = 0; $i < 8; $i++) {

                            $password.= $chars[rand(0, $size - 1)];
                        }
                        for ($i = 0; $i < 30; $i++) {
                            $salt .= chr(rand(33, 126));
                        }
                        for ($i = 0; $i < 3; $i++) {
                            $name_user.= chr(rand(3, $size - 1));
                        }

                        $con = open_db();
                        $email = strtolower($customer_email);
                        $md5_pas = md5(md5($password) . $salt);
                        $conn = mysqli_connect("localhost", "giaxaydung_dtoan", "ur2cfzNLJTp3m44M") or die("can't connect this database");
                        mysqli_select_db("giaxaydung_dtoan", $conn);
                        $sqluser = "select * from user where usernamelogin='" . $email . "' or email='" . $email . "'";
                        $queryuser = mysqli_query($sqluser, $conn);
                        if ($queryuser) {
                            $title = "Chúc mừng bạn đã đăng ký thành công phần mềm GXD";
                            $content = "Chào bạn !<br/>";

                            send_email($email, $customer_name, $title, $content);
                            die();
                        } else {
                            $sql_user = "select * from user where username='" . $customer_name . "'";
                            $query_user = mysqli_query($sqluser, $conn);
                            if ($query_user) {
                                $name_kh = $customer_name . $name_user;
                                $sqluser2 = "insert into user(userid,usergroupid,username,usernamelogin,password,passworddate,email,
                                    styleid,showvbcode, showbirthday, customtitle, reputation, reputationlevelid, timezoneoffset,
                                    salt, money)
                                   values(NULL,'2','" . $name_kh . "','" . $email . "','" . $md5_pas . "','" . $last_runing_date2 . "','" . $email . "',
                                   '0','2','2','0','10',4,'7','" . $salt . "','50')";
                                $queryuser2 = mysqli_query($sqluser2, $conn);
                                if ($queryuser2) {
                                    $sid = "SELECT userid FROM `user` WHERE username='.$customer_name.'";
                                    $r = mysqli_query($sid, $conn);
                                    if ($r) {
                                        $rowid = mysqli_fetch_array($r);
                                        $userid_re = $rowid['userid'];
                                        $sl = " INSERT INTO `userfield` (
`userid` ,
`temp` ,
`field9` ,
`field10` ,
`field11` ,
`field14` ,
`field15` ,
`field18`
)
VALUES (
'  $userid_re', NULL , '', '', '', '', '', ''
)";
                                        $re = mysqli_query($sl, $conn);
                                    }
                                    $tk = "Tên đăng nhập: <b>$email</b><br/>
                                     Mật khẩu: <b>$password</b><br/>
                                     Đây là quyền lợi của bạn từ việc mua phần mềm.<br/>
                                     Chúc bạn luôn thành công.<br/>
                                    Cảm ơn bạn đã ủng hộ. Chúng tôi sẽ luôn luôn nỗ lực để phục vụ bạn tốt hơn. ";
                                    $dbsql = "select * from email where id=21";
                                    $result1 = mysqli_query($dbsql, $con);
                                    $row1 = mysqli_fetch_array($result1);
                                    $a = $row1['subjects'];
                                    $content = $row1['content'] . "$tk";
                                    $title = "$a";
                                    send_email($email, $customer_name, $title, $content);
                                }
                            } die();
                        }
                    } else {
                        $con = open_db();
                        $dbsql = "select * from email where id=43";
                        $result1 = mysqli_query($dbsql, $con);
                        $row1 = mysqli_fetch_array($result1);
                        $a = $row1['subjects'];
                        $content = $row1['content'];
                        $title = "$a-" . "$product";
                        send_email($email, $customer_name, $title, $content);
                    }
                } else {
                    // Kiểm tra hạn của key ===================
					
                    $fb = check_registered_expire($md5_key);
                    if (!$fb) {
                        echo "#BEGIN_RES#KEY_EXPIRED#" . $client_key.'|'.$day ."#END_RES#";
                    } else {
                        // Cho phép đăng ký lại 
                        $con = open_db();
                        $sql = "SELECT * FROM registered WHERE license_serial = '$md5_key' AND hardware_id = '$hardware_id' and product_type= '$product' ";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row > 0) {
                            echo "#BEGIN_RES#KEY_VALID#" . $client_key . "#END_RES#";
                            update_registered($md5_key, $customer_name, $hardware_id, $customer_phone, $customer_email, $customer_address, $last_runing_date2, $customer_cty);
							del_n_product($product, $customer_email);
                        } else {
                            echo "#BEGIN_RES#KEY_NOTVALID#" . $client_key . "#END_RES#";
                        }
                    }
                }
                // }
            } else {
                echo "#BEGIN_RES#KEY_NOTVALID#" . $client_key . "#END_RES#";
            }
        } else {
            echo "Wellcome";
        }
        ?> 
    </body>
</html>
<?php ob_flush(); ?>
