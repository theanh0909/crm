<?php

// file send.php
//Nhúng thư viện phpmailer
require_once('../phpmailer/class.phpmailer.php');
//Khởi tạo đối tượng
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
$mail->Username = "ngocbich@giaxaydung.com"; // SMTP account username
$mail->Password = "121824532"; // SMTP account password
/* =====================================
 * DUA THONG TIN TU FORM GUI EMAIL VAO
 * ===================================== */
//Thiet lap thong tin nguoi gui va email nguoi gui
$mail->SetFrom($mail->Username, "Phòng phần mềm Giá Xây Dựng");
//Thiết lập thông tin người nhận
$mail->AddAddress($arrParam['email'], $arrParam['name']);
//Thiết lập email nhận email hồi đáp
//nếu người nhận nhấn nút Reply
//$mail->AddReplyTo($arrParam['email'], $arrParam['name']);
/* =====================================
 * THIET LAP NOI DUNG EMAIL
 * ===================================== */
//Thiết lập tiêu đề
$mail->Subject = $arrParam['title'];
//Thiết lập định dạng font chữ
$mail->CharSet = "utf-8";
$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
//Thiết lập nội dung chính của email
$body = $arrParam['message'];
$body = eregi_replace("[\]", '', $body);
$mail->MsgHTML($body);
$mail->AddAttachment($dirUpload . $attach['name']);
if (!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
    unlink($dirUpload . $attach['name']);
}