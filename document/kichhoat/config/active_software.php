<?php
require_once("../config/dbconnect.php");
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
// file send.php
//Nhúng thư viện phpmailer
require_once 'class.phpmailer.php';

//Kđối tượng
function send_email($address, $name, $title, $content) {
    $mail = new PHPMailer();
    /* =====================================
     * THIET LAP THONG TIN GUI MAIL
     * ===================================== */
    $mail->IsSMTP(); // Gọi đến class xử lý SMTP
    $mail->Host = "smtp.gmail.com"; // tên SMTP server
    $mail->SMTPDebug = 2; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
    $mail->SMTPAuth = true; // Sử dụng đăng nhập vào account
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com"; // Thiết lập thông tin của SMPT
    $mail->Port = 465; // Thiết lập cổng gửi email của máy
    $mail->Username = "phanmem@giaxaydung.com"; // SMTP account username
    $mail->Password = "123456OSINcuaDzo"; // SMTP account password

    /* =====================================
     * DUA THONG TIN TU FORM GUI EMAIL VAO
     * ===================================== */
//Thiet lap thong tin nguoi gui va email nguoi gui
    $mail->SetFrom($mail->Username, "Phòng phần mềm Giá Xây Dựng");
//Thiết lập thông tin người nhận
    $mail->AddAddress($address, $name);

//Thiết lập email nhận email hồi đáp
//nếu người nhận nhấn nút Reply
    /* =====================================
     * THIET LAP NOI DUNG EMAIL
     * ===================================== */
//Thiết lập tiêu đề
    $mail->Subject = $title;
//Thiết lập định dạng font chữ
    $mail->CharSet = "utf-8";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
//Thiết lập nội dung chính của email
    $body = $content;
    $body = eregi_replace("[\]", '', $body);
    $mail->MsgHTML($body);
    $kq = $mail->Send();
//$mail->AddAttachment($dirUpload . $attach['name']);
    if (!kq) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message sent!";
        // unlink($dirUpload . $attach['name']);
    }
    return $kq;
}

function send_email_1($address, $id, $title, $content) {
    $con = open_db();
    $sql1 = 'SELECT * FROM `tbl_config_email` WHERE id= 1';
    $result1 = mysqli_query($sql1, $con);
    $row = mysqli_fetch_array($result1);
    $t = date("Y-m-d");
    $page_1 = $_SESSION['page'];
    $mail = new PHPMailer();
    /* =====================================
     * THIET LAP THONG TIN GUI MAIL
     * ===================================== */
    $mail->IsSMTP(); // Gọi đến class xử lý SMTP
    $mail->Host = $row['host']; // tên SMTP server
    $mail->SMTPDebug = 2; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
    $mail->SMTPAuth = true; // Sử dụng đăng nhập vào account
    $mail->SMTPSecure = "ssl";
    $mail->Host = $row['host']; // Thiết lập thông tin của SMPT
    $mail->Port = $row['port']; // Thiết lập cổng gửi email của máy
    $mail->Username = $row['SMTP_account']; // SMTP account username
    $mail->Password = $row['SMTP_pass']; // SMTP account password

    /* =====================================
     * DUA THONG TIN TU FORM GUI EMAIL VAO
     * ===================================== */
//Thiet lap thong tin nguoi gui va email nguoi gui
    $mail->SetFrom($row['Default_email'], "Phòng phần mềm Giá Xây Dựng");
//Thiết lập thông tin người nhận
    $mail->AddAddress($address, '');

//Thiết lập email nhận email hồi đáp
//nếu người nhận nhấn nút Reply
    /* =====================================
     * THIET LAP NOI DUNG EMAIL
     * ===================================== */
//Thiết lập tiêu đề
    $mail->Subject = $title;
//Thiết lập định dạng font chữ
    $mail->CharSet = "utf-8";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
//Thiết lập nội dung chính của email
    $body = $content;
    $body = eregi_replace("[\]", '', $body);
    $mail->MsgHTML($body);
    $kq = $mail->Send();
//$mail->AddAttachment($dirUpload . $attach['name']);
    if (!$kq) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message sent!";
        // unlink($dirUpload . $attach['name']);
        $con = open_db();
        
        $sql = "UPDATE `kichhoat`.`license` SET `stt_reg` = '1' ,`email_cus` = '$address',`Sell` = '$t' WHERE `id` = '$id'";
        //$sql = "UPDATE `kichhoat`.`license` SET `license_is_registered` = '1' WHERE `id` = '$id'";
        $result = mysqli_query($con, $sql);
//       echo $sql;
//        die();
        echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
         if($page_1 != ''){
                header('Location: ../views/key_no_reg.php?page='.$page_1);
               // echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php?page=$page_1\>";
                } 
                else header('Location: ../views/key_no_reg.php');
        
    }
    die();
    return $kq;
}

function send_emailbcc($address, $name, $title, $content) {
    $mail = new PHPMailer();
    /* =====================================
     * THIET LAP THONG TIN GUI MAIL
     * ===================================== */
    $mail->IsSMTP(); // Gọi đến class xử lý SMTP
    $mail->Host = "smtp.gmail.com"; // tên SMTP server
    $mail->SMTPDebug = 2; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
    $mail->SMTPAuth = true; // Sử dụng đăng nhập vào account
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com"; // Thiết lập thông tin của SMPT
    $mail->Port = 465; // Thiết lập cổng gửi email của máy
    $mail->Username = "phanmem@giaxaydung.com"; // SMTP account username
    $mail->Password = "123456OSINcuaDzo"; // SMTP account password
    /* =====================================
     * DUA THONG TIN TU FORM GUI EMAIL VAO
     * ===================================== */
//Thiet lap thong tin nguoi gui va email nguoi gui
    $mail->SetFrom($mail->Username, "Phòng phần mềm Giá Xây Dựng");
//Thiết lập thông tin người nhận
    $mail->AddBCC($address, $name);
//Thiết lập email nhận email hồi đáp
//nếu người nhận nhấn nút Reply
    /* =====================================
     * THIET LAP NOI DUNG EMAIL
     * ===================================== */
//Thiết lập tiêu đề
    $mail->Subject = $title;
//Thiết lập định dạng font chữ
    $mail->CharSet = "utf-8";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
//Thiết lập nội dung chính của email
    $body = $content;
    $body = eregi_replace("[\]", '', $body);
    $mail->MsgHTML($body);
    $kq = $mail->Send();
//$mail->AddAttachment($dirUpload . $attach['name']);
    if (!kq) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        // echo "Message sent!";
        // unlink($dirUpload . $attach['name']);
    }
    return $kq;
}

function send_email_2($address, $title, $content,$n) {
    $con = open_db();
    $sql1 = 'SELECT * FROM `tbl_config_email` WHERE id= 1';
    $result1 = mysqli_query($sql1, $con);
    $row = mysqli_fetch_array($result1);
    $mail = new PHPMailer();
    /* =====================================
     * THIET LAP THONG TIN GUI MAIL
     * ===================================== */
    $mail->IsSMTP(); // Gọi đến class xử lý SMTP
    $mail->Host = $row['host']; // tên SMTP server
    $mail->SMTPDebug = 2; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
    $mail->SMTPAuth = true; // Sử dụng đăng nhập vào account
    $mail->SMTPSecure = "ssl";
    $mail->Host = $row['host']; // Thiết lập thông tin của SMPT
    $mail->Port = $row['port']; // Thiết lập cổng gửi email của máy
    $mail->Username = $row['SMTP_account']; // SMTP account username
    $mail->Password = $row['SMTP_pass']; // SMTP account password

    /* =====================================
     * DUA THONG TIN TU FORM GUI EMAIL VAO
     * ===================================== */
//Thiet lap thong tin nguoi gui va email nguoi gui
    $mail->SetFrom($row['Default_email'], "Phòng phần mềm Giá Xây Dựng");


//Thiết lập email nhận email hồi đáp
//nếu người nhận nhấn nút Reply
    /* =====================================
     * THIET LAP NOI DUNG EMAIL
     * ===================================== */
//Thiết lập tiêu đề
    $mail->Subject = $title;
//Thiết lập định dạng font chữ
    $mail->CharSet = "utf-8";
    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
//Thiết lập nội dung chính của email
    $body = $content;
    $body = eregi_replace("[\]", '', $body);
    $mail->MsgHTML($body);
    //Thiết lập thông tin người nhận
    $i=0;
    for($i=0;$i<$n;$i++){
            $mail->AddAddress($address[$i], '');
            $kq = $mail->Send();
    }

//    if (!$kq) {
//        echo "Mailer Error: " . $mail->ErrorInfo;
//    } else {
//        echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
//         if($page_1 != ''){
//                header('Location: http://localhost/kichhoat/views/key_no_reg.php?page='.$page_1);
//               // echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php?page=$page_1\>";
//                } 
//                else header('Location: http://localhost/kichhoat/views/key_no_reg.php');
//    }
    die();
    return $kq;
}