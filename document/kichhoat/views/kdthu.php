<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Công ty CP Giá Xây Dựng</title>
    <script language="javascript" type="text/javascript" src="http://giaxaydung.vn/kichhoat/template/js/datetimepicker.js">
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
    ?>
<p>Chọn hình bên dưới để tạo khóa</p>
<a href="#login-box" class="login-window" align="center"><img src="http://giaxaydung.vn/kichhoat/template/img/download_pm.jpg"></a> 
<div id="login-box" class="login-popup">
    <a href="#" class="close"><img src="http://giaxaydung.vn/kichhoat/template/images/icon_close.jpg" width='20' height='20'class="btn_close" title="Close Window" alt="Close" /></a>
    <h4 align="center" class="gxdh2"> TẠO KEY GXD </h4>
    <form action = "http://giaxaydung.vn/product/v" method = "post">
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
