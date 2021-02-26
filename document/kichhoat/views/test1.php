<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Generate Keys</title>
    <script language="javascript" type="text/javascript" src="../template/js/datetimepicker.js">
    </script>
    <script type = "text/javascript" >
        $(function() {
            $('#btnRadio').click(function() {
                var checkedradio = $('[name="type_expire_date"]:radio:checked').val();
                $('#sel').html('Selected value: ' + checkedradio);
            });
        });
    </script>
    <style>
        /* Mask for background, by default is not display */
        #mask {
            display: none;
            background: #000; 
            position: fixed; left: 0; top: 0; 
            z-index: 10;
            width: 100%; height: 100%;
            opacity: 0.8;
            z-index: 999;
        }

        /* You can customize to your needs  */
        .login-popup{
            display:none;
            background: #333;
            padding: 10px;     
            border: 2px solid #ddd;
            float: left;
            font-size: 1.2em;
            color:  #fff;
            position: fixed;
            top: 50%; left: 50%;
            z-index: 99999;
            box-shadow: 0px 0px 20px #999; /* CSS3 */
            -moz-box-shadow: 0px 0px 20px #999; /* Firefox */
            -webkit-box-shadow: 0px 0px 20px #999; /* Safari, Chrome */
            border-radius:3px 3px 3px 3px;
            -moz-border-radius: 3px; /* Firefox */
            -webkit-border-radius: 3px; /* Safari, Chrome */
        }

        img.btn_close { Position the close button
                        float: right; 
                        margin: -28px -28px 0 0;
        }

        fieldset { 
            border:none; 
        }

        form.signin .textbox label { 
            display:block; 
            padding-bottom:7px; 
        }

        form.signin .textbox span { 
            display:block;
        }

        form.signin p, form.signin span { 
            color:#999; 
            font-size:11px; 
            line-height:18px;
        } 

        form.signin .textbox input { 
            background:#666666; 
            border-bottom:1px solid #333;
            border-left:1px solid #000;
            border-right:1px solid #333;
            border-top:1px solid #000;
            color:#fff; 
            border-radius: 3px 3px 3px 3px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            font:13px Arial, Helvetica, sans-serif;
            padding:6px 6px 4px;
            width:200px;
        }

        form.signin input:-moz-placeholder { color:#bbb; text-shadow:0 0 2px #000; }
        form.signin input::-webkit-input-placeholder { color:#bbb; text-shadow:0 0 2px #000;  }

        .button { 
            background: -moz-linear-gradient(center top, #f3f3f3, #dddddd);
            background: -webkit-gradient(linear, left top, left bottom, from(#f3f3f3), to(#dddddd));
            background:  -o-linear-gradient(top, #f3f3f3, #dddddd);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorStr='#f3f3f3', EndColorStr='#dddddd');
            border-color:#000; 
            border-width:1px;
            border-radius:4px 4px 4px 4px;
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            color:#333;
            cursor:pointer;
            display:inline-block;
            padding:6px 6px 4px;
            margin-top:10px;
            font:12px; 
            width:214px;
        }
        .button:hover { background:#ddd; } 
    </style>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>  
    <script type="text/javascript">
        $(document).ready(function() {
            $('a.login-window').click(function() {

                //Getting the variable's value from a link 
                var loginBox = $(this).attr('href');

                //Fade in the Popup
                $(loginBox).fadeIn(300);

                //Set the center alignment padding + border see css style
                var popMargTop = ($(loginBox).height() + 24) / 2;
                var popMargLeft = ($(loginBox).width() + 24) / 2;

                $(loginBox).css({
                    'margin-top': -popMargTop,
                    'margin-left': -popMargLeft
                });

                // Add the mask to body
                $('body').append('<div id="mask"></div>');
                $('#mask').fadeIn(300);

                return false;
            });
            // When clicking on the button close or the mask layer the popup closed
            $('a.close, #mask').live('click', function() {
                $('#mask , .login-popup').fadeOut(300, function() {
                    $('#mask').remove();
                });
                return false;
            });
        });

    </script>
    <?php
    require_once("../config/dbconnect.php");
    get_infor_from_conf("../config/DB.conf");
    if ($_GET["act"] == "do") {

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
        echo "<b> Ngày tạo " . $key_created_date . "</b><br>";
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
            $md5cardkey = md5($cardkey);
            //hash with md5 before storing into database
            //store data into database
            try {
                add_license_to_db($md5cardkey, $key, 0, $key_created_date, $type_expire_date, 'NA', $no_instances, $no_computers, $product_type, $iduser, $status);
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
                $mail->Password = "dominhtien"; // SMTP account password

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
			location.replace('http://giaxaydung.vn')
			</script> ";
                    //echo "Message sent!";
                    // unlink($dirUpload . $attach['name']);
                }
            } catch (Exception $e) {
                //echo 'Caught exception: ', $e->getMessage(), "\n";
            }
        }
    }
    ?>
<a href="#login-box" class="login-window">Nhấn đây để tạo key dùng thử</a> 
<div id="login-box" class="login-popup">
    <a href="#" class="close"><img src="../template/images/icon_close.jpg" width='20' height='20'class="btn_close" title="Close Window" alt="Close" /></a>
    <h4 align="center" class="gxdh2"> TẠO KEY GXD </h4>
    <form action = "test1.php?act=do" method = "post">
        <table align="center" border="0" style="border:thick 0px; margin-top:25px; color:  #f3f3f3; font-family:  sans-serif">
            <tr style=" display: none" >
                <td width="120">Ngày tạo khóa:</td>
                <td width="210"><input id="key_created_date" name="key_created_date" type="text" size="25" value="<?php echo date("d-m-Y H:i:s") ?>"><a href="javascript:NewCal('key_created_date','ddMMyyyy',true,24)"><img src="../template/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td>
            </tr>
            <tr>
                <td width="120">Email của bạn</td>
                <td width="210"><input class="ipt" id="key_created_date" name="email" type="text" size="35" value=""></td>
            </tr>
            <tr>
                <td>Thời gian dùng thử:</td>
                <td>
                    <input style="display: none" type="radio" name="type_expire_date" value="15"/> 30 Ngày
                </td>
            </tr>
            <tr>
                <td>Phần mềm:</td>
                <td width="210"><select class="ipt" size="1" name="product_type">
                        <option selected="selected" value="DutoanGXD">Dự toán GXD</option>
                        <option value="DuthauGXD">Dự thầu GXD</option>
                        <option value="QuyettoanGXD">Thanh quyết toán </option>
                    </select>  
                </td>
            </tr>
            <tr style="display: none">
                <td>Số lượng máy sử dụng:</td>
                <td width="210"><input type = "text" id = "no_computers" name = "no_computers" value = "1"/>  
                </td>
            </tr>
            <tr style="display: none">
                <td>Số bản được cài trên 1 máy:</td>
                <td width="210"><input type = "text" id = "no_instances" name = "no_instances" value = "1"/>  
                </td>
            </tr>
            <tr style="display: none">
                <td>Số dãy mã cần tạo:</td>
                <td width="210"><input type = "text" id = "no_keys" name = "no_keys" value = "1"/>  
                </td>
            </tr>

            <tr>
                <td></td>
                <td><button class='button' type = "submit" value = "">Sinh mã </button>  
                </td>
            </tr>
        </table>
    </form>
</div> 
