<?php ob_start(); ?>
<?php session_start() ?>
<?php require_once("../Include/header.php"); ?>
<?php require_once("../Include/sidebar.php"); ?>
<?php require_once("../model/product.php"); ?>
<?php
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
if(isset($_POST['submit'])){
    $host = isset($_POST['host']) ? $_POST['host'] : "";
    $Port = isset($_POST['Port']) ? $_POST['Port'] : "";
    $account = isset($_POST['account']) ? $_POST['account'] : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $sender = isset($_POST['sender']) ? $_POST['sender'] : "";
    $con = open_db();
    $sql = 'UPDATE `tbl_config_email` SET `host`="'.$host.'",`port`='.$Port.',`SMTP_account`="'.$account.'",`SMTP_pass`="'.$password.'",`Default_email`="'.$sender.'" WHERE id = 1';

    $result = mysqli_query($sql, $con);
    
}
$con = open_db();
    $sql1 = 'SELECT * FROM `tbl_config_email` WHERE id= 1';
    $result1 = mysqli_query( $con, $sql1);
    $row = mysqli_fetch_array($result1);
?>
<div id="rightcolumn">
    <h2 align="center" class="gxdh2"> CẤU HÌNH EMAIL </h2>

    <form action = "" method = "post">
        <table cellspacing="15" align="center" border="0" style="font-size: 14px; border:thick 0px; margin-top:25px;">
            <tr>
                <td >Host:</td>
                <td><input type="text" name ="host" value="<?php echo $row['host']; ?>" size="35" ></td>
            </tr>
            <tr>
                <td >Port:</td>
                <td><input type="text" name ='Port' value="<?php echo $row['port']; ?>" size="35" ></td>
            </tr>
            <tr>
                <td >SMTP account username:</td>
                <td><input type="text" name ="account" value="<?php echo $row['SMTP_account']; ?>" size="35" ></td>
            </tr>
            <tr>
                <td >SMTP account password:</td>
                <td><input type="text" name ="password" value="<?php echo $row['SMTP_pass']; ?>" size="35" ></td>
            </tr>
            <tr>
                <td >Default email sender name:</td>
                <td><input type="text" name ="sender" value="<?php echo $row['Default_email']; ?>" size="35" ></td>
            </tr>
            <tr>
                <td></td>
                <td width="210"><input class="button" type = "submit" name ='submit' value = "Thực hiện"/>  
                </td>
            </tr>
        </table>
    </form>
</div>
<?php require_once("../Include/footer.php"); ?>
</body>
</html>
<?php ob_flush(); ?>
