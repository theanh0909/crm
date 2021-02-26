<?php

require_once("../config/global.php");
require_once("../config/dbconnect.php");
$rootdir = "./PKI";
$passphrase = "bachkhoa12";
$key_created_date = isset($_POST['key_created_date']) ? $_POST['key_created_date'] : "";
$type_expire_date = isset($_POST['type_expire_date']) ? $_POST['type_expire_date'] : "";
$no_computers = isset($_POST['no_computers']) ? $_POST['no_computers'] : "";
$no_instances = isset($_POST['no_instances']) ? $_POST['no_instances'] : "";
$product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
$total_keys = isset($_POST['no_keys']) ? $_POST['no_keys'] : "";
$iduser = isset($_POST['iduser']) ? $_POST['iduser'] : "1";
$status = isset($_POST['status']) ? $_POST['status'] : "0";
$t1 = strtotime($key_created_date);
$key_created_date = date('Y-m-d H:i:s', $t1);
$address = isset($_POST['email']) ? $_POST['email'] : "";

get_infor_from_conf("../config/DB.conf");
//get private key
$path = sprintf("../%s/private/server.key", $rootdir);
$fp = fopen($path, "r");
$private_key = fread($fp, 8192);
fclose($fp);
$max_id = get_last_id();
//echo "<b> Ngày tạo " . $key_created_date . "</b><br>";
for ($i = 0; $i < $total_keys; $i++) {
//key = ngaytao+ngayhethan+somaydung+sothehien+STT
    $key = sprintf("hiephv%s%s%d%d%d", $key_created_date, $key_expire_date, $no_computers, $no_instances, $max_id + $i + 1);
    $key = md5($key);
    $res = openssl_get_privatekey($private_key, $passphrase);
    if (!$res) {
        openssl_error_string();
        return;
    }
//sign data with private key
    $crypted_key = "";
    openssl_private_encrypt($key, $crypted_key, $res);

//change to HEX format which can be read by user
    $hexkey = strToHex($crypted_key); //day ma dai 256 ky tu hexa
//extract the first 20 characters which used to write down to card
    $cardkey = substr($hexkey, 0, 20);
    $cardkey = strtoupper($cardkey);

    $splitcardkey = str_split($cardkey, 5);
    $key = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];
    $md5cardkey = md5($cardkey); //hash with md5 before storing into database
//store data into database
    try {
        add_license_to_db($md5cardkey, $key, 0, $key_created_date, 30, 'NA', $no_instances, $no_computers, $product_type, $iduser, $status);
        require_once '../phpmailer/class.phpmailer.php';

//Kđối tượng
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
        $mail->Username = "dutoangxd@giaxaydung.com"; // SMTP account username
        $mail->Password = "AnhThai1234567@gxdjscA"; // SMTP account password

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
        $body = "key dùng thử của bạn: " . $key . "<br/>
<p>Công ty Giá Xây Dựng xin gửi anh chị bộ cài phần mềm Dự toán GXD:</p>

<a href='http://www.mediafire.com/download/dvj8c777k57jkgw/SetupDutoanGXD8chu%E1%BA%A9n.exe'>Kích vào đây để tải file.</a><br/>


Phần mềm dùng thử có thời hạn trong 30 ngày.<br/>

Bạn chạy bộ cài phần mềm, sau đó copy cả key dự toán (20 số) vào bảng đăng ký phần mềm của bạn.<br/>

Các anh chị tham khảo video này để đăng ký cũng như lấy dữ liệu đơn giá các tỉnh làm Dự toán: <a href='http://www.youtube.com/watch?feature=player_embedded&v=u4mE8a_pIiQ'>Kích vào đây để xem.</a><br/>

Hãy sử dụng phần mềm bản quyền GXD để được đăng nhập vào <a href='http://dutoangxd.vn'>www.dutoanGXD.vn</a> đó chính là kho công cụ lấy dữ liệu của phần mềm về sử dụng khi làm việc.<br/>

Quá trình khách hàng cài đặt sảy ra lỗi bạn có thể xem ở đây: http://dutoangxd.vn/forumdisplay.php?f=283<br/>


Hướng dẫn sử dụng dự toán<br/>

<a href='http://www.mediafire.com/view/11f0hdbhh5w9ktx/H%C6%B0%E1%BB%9Bng_d%E1%BA%ABn_s%E1%BB%AD_d%E1%BB%A5ng_ph%E1%BA%A7n_m%E1%BB%81m_D%E1%BB%B1_to%C3%A1n_GXD.pdf'>Kích vào đây để tải file.</a><br/>


Phần mềm hỗ trợ trực tuyến TeamViewer:<br/>

<a href='http://www.mediafire.com/download/wi28qfm4wmushtm/TeamViewer_Setup_vi.exe'> Kích vào đây để tải file.</a>

";
        $body = eregi_replace("[\]", '', $body);
        $mail->MsgHTML($body);
        $kq = $mail->Send();
//$mail->AddAttachment($dirUpload . $attach['name']);
        if (!kq) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "<script language='JavaScript'> alert('Key dùng thử đã được gửi vào email của bạn. Bạn hãy kiểm tra email để lấy key');
			location.replace('http://gxd.vn')
			</script> ";
//echo "Message sent!";
// unlink($dirUpload . $attach['name']);
        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}