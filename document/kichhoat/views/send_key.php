<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
require_once("../phpmailer/active_software.php");
if(isset($_POST['submit'])){
    if(isset($_POST['email']) && $_POST['email'] != '' && isset($_POST['product_type']) && isset($_POST['key_1']) && isset($_POST['n_key'])){
		$email_user = $_POST['email_user'];
        $email = $_POST['email'];
        $product = $_POST['product_type'];
        $key = $_POST['key_1'];
        $n_key = $_POST['n_key'];
        $n = $n_key;
        //sendemail($email,$product_type,$key_1,$n_key);
		$con = open_db(); 
		$t = date("Y-m-d");
		if(isset($_POST['stt_sell']) && $_POST['stt_sell'] == TRUE){
            $stt_sell = 0;
        }
        else {
            $stt_sell= 1;
        }
        //$sql = "SELECT * FROM `license` WHERE product_type = '".$product."' and status='".$key."' and type_expire_date=365 ORDER BY id DESC;";
		$sql = "SELECT * FROM `license` WHERE product_type = '".$product."' and license_is_registered = '0' and status='".$key."' and type_expire_date=365 and license_no_computers = '1' and email_cus = '' and license.stt_email = 0 ORDER BY license_created_date DESC";
        $result = mysqli_query($con, $sql);
		
			$count = mysqli_num_rows($result);
			if($count == 0){
				echo 'Bạn đã hết key trong kho!';
				die();
			}
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            if($row['license_key'] != ''){
                $arr[$i] = $row['license_key'];
				
                $i++;         
            }

            if($i == $n){
                break;
            }
        }
       echo  $sql = 'SELECT * FROM `email`,`product` WHERE product.product_type = "'.$product.'" and product.product_type = email.product';

        $result = mysqli_query($con, $sql);
        $count=  mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        if($count == 0){
            echo '<script type="text/javascript" charset="UTF-8">  
                               alert("Bạn cần thêm email mặc định cho phần mềm này");
                               </script>';
            die();
        }
        else{
            $id1=$row['email'];
            $sql = 'SELECT * FROM `email` WHERE id = '.$id1;
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            $title = $row['subjects'];
            $content = $row['content'];
            $st='';
            //for($j=0;$j<$n;$j++){
             //   $st = $arr[$j].'<br>'.$st;
            //}
			if($n == 1){
                $st = $arr[0];
										// $id = $row['id'];
						$sql1 = "UPDATE `license` SET `stt_reg` = '1' ,`email_cus` = '$email',`Sell` = '$t',`stt_sell` = $stt_sell  WHERE `license_key` = '$st'";
						  
						//$sql = "UPDATE `kichhoat`.`license` SET `license_is_registered` = '1' WHERE `id` = '$id'";
						$result1 = mysqli_query($con,$sql1);
            }
            else{
                for($j=0;$j<$n_key;$j++){
                    if($j == 0){
                        $st = $arr[$j];
						// $id = $row['id'];
						$sql1 = "UPDATE `license` SET `stt_reg` = '1' ,`email_cus` = '$email',`Sell` = '$t',`stt_sell` = $stt_sell  WHERE `license_key` = '$arr[$j]'";
						  
						//$sql = "UPDATE `kichhoat`.`license` SET `license_is_registered` = '1' WHERE `id` = '$id'";
						$result1 = mysqli_query($sql1, $con);
                    }
                    else 
					{
						$st = $st.'<br>'.'<br>'.$arr[$j];
						$sql1 = "UPDATE `license` SET `stt_reg` = '1' ,`email_cus` = '$email',`Sell` = '$t',`stt_sell` = $stt_sell  WHERE `license_key` = '$arr[$j]'";
						  
						//$sql = "UPDATE `kichhoat`.`license` SET `license_is_registered` = '1' WHERE `id` = '$id'";
						$result1 = mysqli_query($sql1, $con);
					}
                }
            }
            $content1 = str_replace( 'PASTE_KEY', $st, $content );
            $arr = Array();
            $arr[0]= $email;
			
			if($email_user != ''){
				$arr[1] = $email_user;
			};
			
            send_email_3($arr,$title, $content1,2);
        }
    }
}
?>

<div id='rightcolumn'>
 
    <form action="" method="post">
        
       <meta charset="UTF-8">
            <table width="600" style="margin:115px auto; background:#f8f8f8; border:1px solid #eee; padding:20px 0 25px 0;"> 
            <tr><td colspan="2" style="font:bold 21px arial; text-align:center; border-bottom:1px solid #eee; padding:5px 0 10px 0;">
            Gửi key kích hoạt GXD</td></tr>
            <tr><td colspan="2" style="font:bold 15px arial;border-bottom:1px solid #eee; text-align:center; padding:5px 0 10px 0;"><input type="text" name="email" size="40" placeholder="Nhập email khách hàng " value="" ></td></tr>
            
			<tr>
            <td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Email nhân viên:</td>
            <td width="50%" style=" padding:5px;"><select class="key" name="email_user" >
                        <option value=""> </option>
                        <?php
                        $con = open_db();
                        $sql = "select * from user ";
                        $result = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
								<option value="<?php echo $row['email'] ?>"> <?php echo $row['username'] ?></option>  
                            <?php
                        }
                        ?>   
                    </select> </td>
            </tr>
			
			<tr>
            <td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Chọn phần mềm:</td>
            <td width="50%" style=" padding:5px;"><select class="key" name="product_type" >
                        
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product ";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <option <?php if($row['product_type'] == 'DutoanGXD'){echo 'selected';} ?> value="<?php echo $row['product_type'] ?>"> <?php echo $row['name'] ?></option>           
                            <?php
                        }
                    ?>   
                    </select> </td>
            </tr>
            <tr>
            <td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Loại key:</td>
            <td width="50%" style=" padding:5px;"><select class="key_1" name="key_1" >
                        <option selected="selected"  value="1"> Key thương mại</option>
                        <option value="0"> Key thử nghiệm</option>
                    </select> 
            </tr>
            <tr>
            <td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Số key cần gửi:</td>
            <td width="50%" style=" padding:5px;"><input type="text" size="1" name="n_key" value="<?php if(isset($_POST['n_key'])){ echo $_POST['n_key'];}else echo 1; ?>">
            </tr>
			<tr>
            <td style="font:bold 12px tahoma, arial, sans-serif; text-align:right; padding:5px 10px 5px 0px; border-right:1px solid #eee;">Khách hàng đã thanh toán:</td>
            <td width="50%" style=" padding:5px;"><input type="checkbox" id ="stt_sell" name="stt_sell" checked onclick="Call_fun()"></td>
            </tr>
            <tr>
            
            <td colspan="2" style="font:bold 15px arial;border-bottom:1px solid #eee; text-align:center; padding:5px 0 10px 0;"><input type="submit" name="submit" /></td>
            </tr>
            </table>
    </form></div>
<?php ob_flush(); ?>
