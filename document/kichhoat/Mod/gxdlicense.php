<?php ob_start(); ?>
<?php session_start() ?>
<?php 
require_once("Include/header.php");
require_once("Include/sidebar.php");
 ?>
<?php if ($permarr['keydungthu']) { ?>
<script type="text/javascript">
//<![CDATA[
    function OpenPopup(Url, WindowName, width, height, extras, scrollbars) {
        var wide = width;
        var high = height;
        var additional = extras;
        var top = (screen.height - high) / 2;
        var leftside = (screen.width - wide) / 2;
        newWindow = window.open('' + Url +
                '', '' + WindowName + '', 'width=' + wide + ',height=' + high + ',top=' +
                top + ',left=' + leftside + ',features=' + additional + '' +
                ',scrollbars=1');
        newWindow.focus();
    }
//]]>
</script>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2">DANH SÁCH KEY SINH RA </h1>
        <table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'>
            <tr><th>Mã License</th>
                <th>Số máy</th>
                <th>Ngày tạo</th>
                <th >Loại Key</th>
                <th >Loại PM</th>
                <th>Số ngày hết hạn</th>
                <th>User</th>
				 
                <th>                        
                </th>
            </tr>
            <?php
            require_once("../config/global.php");
            require_once("../model/license.php");
            $rootdir = "./PKI";
            $passphrase = "bachkhoa12";
            $key_created_date = isset($_POST['key_created_date']) ? $_POST['key_created_date'] : "";
            $type_expire_date = isset($_POST['type_expire_date']) ? $_POST['type_expire_date'] : "";
            $no_computers = isset($_POST['no_computers']) ? $_POST['no_computers'] : "";
            $no_instances = isset($_POST['no_instances']) ? $_POST['no_instances'] : "";
            $product_type = isset($_POST['product_type']) ? $_POST['product_type'] : "";
            $total_keys = isset($_POST['no_keys']) ? $_POST['no_keys'] : "";
            $status = isset($_POST['status']) ? $_POST['status'] : "";
            $t1 = strtotime($key_created_date);
            $key_created_date = date('Y-m-d H:i:s', $t1);
			$key_email = isset($_POST['key_email']) ? TRUE : FALSE;
            if($key_email == TRUE){
                $key_email = 1;
            }
            else $key_email = 0;

            get_infor_from_conf("../config/DB.conf");
//get private key
            $path = sprintf("../%s/private/server.key", $rootdir);
            $fp = fopen($path, "r");
            $private_key = fread($fp, 8192);
            fclose($fp);
            $max_id = get_last_id();
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
                if ($status == 1) {
                    $str = "<b>Key thương mại</b></br>";
                } else {
                    $str = "<b>Key thử nghiệm</b></br>";
                }
                $splitcardkey = str_split($cardkey, 5);
                $splitcardkey = $splitcardkey[0] . "-" . $splitcardkey[1] . "-" . $splitcardkey[2] . "-" . $splitcardkey[3];
                $md5cardkey = md5($cardkey);
                ?>

                <tr>
                    <td><?php echo $splitcardkey; ?></td>
                    <td><?php echo $no_computers; ?></td>
                    <td><?php echo $key_created_date; ?></td>
                    <td><?php echo $str; ?></td>
                    <td><?php echo $product_type; ?></td>
                    <td><?php echo $type_expire_date; ?></td>
					
                    <td><?php
                        $con = open_db();
                        $sql = "select username from user where id='$iduser'";
                        $r = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($r);
                        echo $row['username'];
                        ?></td>
						
                    <td><a title='Sửa key' href ='<?php echo "editlicense.php?id=$md5cardkey" ?>'><img src='../template/images/edit.png' width='15' height = '15'></a>
                        <a title ='Xóa key' href = '<?php echo "deletelicense.php?id=$md5cardkey" ?>'>
                            <img src='../template/images/delete.png' width='15' height = '15'></a></td>

                </tr>

                <?php
                //hash with md5 before storing into database
                //store data into database
                try {
                    add_license_to_db($md5cardkey, $splitcardkey, 0, $key_created_date, $type_expire_date, 'NA', $no_instances, $no_computers, $product_type, $iduser, $status, $key_email
                    );
                } catch (Exception $e) {
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                }
            }
            ?>
			<tr><td colspan="8" align="right"><a href="export_excel_key.php?n=<?php echo $total_keys; ?>&stt=<?php echo $status; ?>" target="_blank"> xuất ra excel  </a></td></tr>
        </table>
        <a title="Về trang chủ" href="../views/administrator.php"><img width="30" height="30" src="../template/img/home.jpg"/></a>
<!--<a title ="Chuyển key" href="javascript: void(0);" onclick=" javascript:OpenPopup('http://giaxaydung.vn/kichhoat/views/changcekey.php', 'WindowName', '510', '280', 'scrollbars=1');"><img width="30" height="30" src="../template/img/send.jpg"/></a>-->

</div>

<?php require_once("../Include/footer.php"); ?>

</body>
</html>
<?php ob_flush(); }?>
