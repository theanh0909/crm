<?php
session_start();

if(!isset($_SESSION["product"]) && !isset($_SESSION["key"])){
    $_SESSION["product"] = '';
    $_SESSION["key"] = '';
    die();
}
else $product_name= $_SESSION['product_type'];
$page_1 = $_SESSION['page'];
require_once("../config/dbconnect.php");
require_once("../phpmailer/active_software_1.php");
    require_once("../config/global.php");
	
	get_infor_from_conf("../config/DB.conf");
 $con = open_db();
if (isset($_POST['delete'])) {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                  
                    $t = $_POST['chkid'];
                    foreach ($t as $key => $value) {
                        
                        $deleteSQL = "delete from license where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                        echo $value;
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
                    }
                }
            }
            
// file send.php
//Nhúng thư viện phpmailer
//require_once 'class.phpmailer.php';
$n=0;
$str="";
$mail="";
$key="";
for($n;$n<25;$n++)
{
$str="submit".$n;
$stragain="submitagain".$n;

$str_email="mail".$n;
$str_id="id".$n;
$str_key="key".$n;
$mail='';
$stlk_1="lk".$n;
$key='';
$id='';
if(isset($_POST[$stragain])){
    if(isset($_POST['input'])){
       $mail=$_POST['input'];
    }else
    if($_POST[$str_email]!=""){
    $mail=$_POST[$str_email];
    }
	    if(isset($_POST[$stlk_1])){
        $text_lk='bản khóa mềm';
    }
    else $text_lk ='bản dùng thử';
    $key=$_POST[$str_key];
    $id=$_POST[$str_id];
    $title = "Công ty Cổ phần Giá Xây Dựng kính gửi Quý khách phần mềm  $product_name $text_lk";
    $content = "<div class = 'content' style='font-family:verdana,sans-serif;'>
    <b>Kính chào Quý khách!</b><br/>
    <br/>
Công ty Cổ phần Giá Xây Dựng kính gửi Quý khách phần mềm <b style='color:red' >$product_name $text_lk</b><br/>
    <br/>
  <div align='center'>  
<table style='border:1px solid black;border-collapse:collapse;'>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><b><span style='font-size:12pt;color:red'>Key kích hoạt</span></b></td>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt'>$key</span></td>
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Bộ cài khóa mềm </span><b><span style='font-size:12pt;color:red'>$product_name</span></b></td>
        <td rowspan='3'> <a href='https://www.fshare.vn/folder/1SPTPTS7BN6K' target='_blank'><span lang='EN-US' style='font-size:14pt'>Kích vào đây để tải về</span></a></td>
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Tài liệu Hướng dẫn sử dụng phần mềm</span></td>
        
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Phần mềm hỗ trợ khách hàng GXD</span></td>
        
    </tr>

</table>
</div>
<p><b><span style='font-size:12pt;color:red'>Hướng dẫn cài đặt</span></b>: Kích đúp vào file <b>Setup…</b> để bắt đầu cài đặt, bấm <b>Đi tiếp</b> đến khi <b>Hoàn tất</b> sẽ có hộp thoại điền thông tin và mã key kích hoạt. Quý khách điền chính xác thông tin cá nhân và <b>Copy/Paste</b> key kích hoạt trên (gồm 20 ký tự) vào ô mã kích hoạt. Sau đó nhập mã ảnh kiểm tra bên cạnh và bấm <b>Đăng ký</b>. Hộp thoại báo <b><span style='font-size:12pt;color:red'>Đăng ký thành công</b></span> hiện ra, Quý khách có thể bắt đầu sử dụng phần mềm.</p>
<p>Website <a href = 'http://www.dutoangxd.vn/' target = '_blank'><span color:blue'>http://www.dutoangxd.vn/</span></a> giúp Quý khách tải các bộ CSDL đơn giá các địa phương, các định mức chuyên ngành; thắc mắc góp ý với GXD; trao đổi chuyên môn nghiệp vụ với các thành viên khác; cũng như các tài liệu khác phục vụ công việc lập dự toán dự thầu… Quý khách đăng ký một tài khoản thành viên với các thông tin vừa đăng ký phần mềm, sau khi đăng ký thành công. Quý khách vui lòng gửi các thông tin vừa đăng ký được vào email phanmem@giaxaydung.com hoặc liên hệ 04.35682.482 để yêu cầu được kích hoạt.</p>
</br>
Một số tiện ích khác:<br/>
<br/>
-         Hướng dẫn sử dụng phần mềm, bài giảng nghiệp vụ kinh tế xây dựng qua video: Kích vào đây để xem<br/>

-         Học và thi trắc nghiệm online về các nghiệp vụ kỹ sư định giá:  Kích vào đây để học online<br/>
<br/>
 Khi cần hỗ trợ, giải đáp các thắc mắc trong quá trình cài đặt, sử dụng phần mềm  Quý khách vui lòng phản hồi về email: phanmem@giaxaydung.com hoặc liên hệ trực tiếp với bộ phận hỗ trợ khách hàng:<br/>
 

    - Mr. Toàn 0947.892.293 - Email: vantoan@giaxaydung.com<br/>
    - Mr. Thắng 0967.787.166 - Email: phamthang@giaxaydung.com<br/>
    - Mr. Đức 0983.039.791 - Email: minhduc@giaxaydung.com<br/>
    <br/>
Chúc Quý khách làm việc hiệu quả với phần mềm GXD.
<br/>
<p>
Trân trọng!"
        . "</p></div>";

send_email_1($mail,$id ,$title, $content);
}
else{
    if($page_1 != ''){
        header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php?page='.$page_1);
    } else header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php');
}
if(isset($_POST[$str]))
{
if($_POST[$str_email]!=""){
$mail=$_POST[$str_email];
$stlk_1="lk".$n;
$key=$_POST[$str_key];
$id=$_POST[$str_id];

    if(isset($_POST[$stlk_1])){
        $text_lk='bản khóa mềm';
    }
    else $text_lk ='bản dùng thử';
	
$title = "Công ty Cổ phần Giá Xây Dựng kính gửi Quý khách phần mềm  $product_name $text_lk";
$content = "<div class = 'content' style='font-family:verdana,sans-serif;'>
    <b>Kính chào Quý khách!</b><br/>
    <br/>
Công ty Cổ phần Giá Xây Dựng kính gửi Quý khách phần mềm <b style='color:red' >$product_name $text_lk</b><br/>
    <br/>
  <div align='center'>  
<table style='border:1px solid black;border-collapse:collapse;'>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><b><span style='font-size:12pt;color:red'>Key kích hoạt</span></b><span style='font-size:12pt'> dùng cho 1 máy/ 1 năm</span></td>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt'>$key</span></td>
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Bộ cài khóa mềm </span><b><span style='font-size:12pt;color:red'>$product_name</span></b></td>
        <td rowspan='3'> <a href='https://www.fshare.vn/folder/1SPTPTS7BN6K' target='_blank'><span lang='EN-US' style='font-size:14pt'>Kích vào đây để tải về</span></a></td>
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Tài liệu Hướng dẫn sử dụng phần mềm</span></td>
        
    </tr>
    <tr>
        <td width='336' style='width:252pt;border:1pt solid windowtext;padding:0cm 5.4pt;height:18pt'><span style='font-size:12pt;color:black'>Phần mềm hỗ trợ khách hàng GXD</span></td>
        
    </tr>

</table>
</div>
<p><b><span style='font-size:12pt;color:red'>Hướng dẫn cài đặt</span></b>: Kích đúp vào file <b>Setup…</b> để bắt đầu cài đặt, bấm <b>Đi tiếp</b> đến khi <b>Hoàn tất</b> sẽ có hộp thoại điền thông tin và mã key kích hoạt. Quý khách điền chính xác thông tin cá nhân và <b>Copy/Paste</b> key kích hoạt trên (gồm 20 ký tự) vào ô mã kích hoạt. Sau đó nhập mã ảnh kiểm tra bên cạnh và bấm <b>Đăng ký</b>. Hộp thoại báo <b><span style='font-size:12pt;color:red'>Đăng ký thành công</b></span> hiện ra, Quý khách có thể bắt đầu sử dụng phần mềm.</p>
<p>Website <a href = 'http://www.dutoangxd.vn/' target = '_blank'><span color:blue'>http://www.dutoangxd.vn/</span></a> giúp Quý khách tải các bộ CSDL đơn giá các địa phương, các định mức chuyên ngành; thắc mắc góp ý với GXD; trao đổi chuyên môn nghiệp vụ với các thành viên khác; cũng như các tài liệu khác phục vụ công việc lập dự toán dự thầu… Quý khách đăng ký một tài khoản thành viên với các thông tin vừa đăng ký phần mềm, sau khi đăng ký thành công. Quý khách vui lòng gửi các thông tin vừa đăng ký được vào email phanmem@giaxaydung.com hoặc liên hệ 04.35682.482 để yêu cầu được kích hoạt.</p>
</br>
Một số tiện ích khác:<br/>
<br/>
-         Hướng dẫn sử dụng phần mềm, bài giảng nghiệp vụ kinh tế xây dựng qua video: Kích vào đây để xem<br/>

-         Học và thi trắc nghiệm online về các nghiệp vụ kỹ sư định giá:  Kích vào đây để học online<br/>
<br/>
 Khi cần hỗ trợ, giải đáp các thắc mắc trong quá trình cài đặt, sử dụng phần mềm  Quý khách vui lòng phản hồi về email: phanmem@giaxaydung.com hoặc liên hệ trực tiếp với bộ phận hỗ trợ khách hàng:<br/>
 

    - Mr. Toàn 0947.892.293 - Email: vantoan@giaxaydung.com<br/>
    - Mr. Thắng 0967.787.166 - Email: phamthang@giaxaydung.com<br/>
    - Mr. Đức 0983.039.791 - Email: minhduc@giaxaydung.com<br/>
    <br/>
Chúc Quý khách làm việc hiệu quả với phần mềm GXD.
<br/>
<p>
Trân trọng!"
        . "</p></div>";

send_email_1($mail,$id ,$title, $content);
}
}
else{
    //echo "<meta http-equiv = \"refresh\" content=\"0;URL=key_no_reg.php\">";
     if($page_1 != ''){
        header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php?page='.$page_1);
    } else header('Location: http://giaxaydung.vn/kichhoat/views/key_no_reg.php');
}
}
