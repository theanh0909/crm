<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
require_once("Include/header.php");
require_once("Include/sidebar.php");

$_SESSION['id_user'] = check_id($_SESSION["username"], md5($_SESSION["password"]));
if(!isset($_SESSION["product"]) && !isset($_SESSION["key"])  && !isset($_SESSION["day_expired"]) ){
    $_SESSION["product"] = '';
    $_SESSION["key"] = '';
    $_SESSION["day_expired"]='365';
}
$email= '';
if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(!isset($_POST['key_1']) && !isset($_POST['day_expired']) ){
    $_POST['key_1'] = '';
    $_POST['day_expired'] = '365';
}
if(isset($_POST['loc'])){

    $_SESSION["product"] = $_POST['product_type'];    
    $_SESSION["key"] = $_POST['key_1'];
    $_SESSION["day_expired"] = $_POST['day_expired'];
}
if(isset($_GET['page'])){
    $_SESSION['page'] = $_GET['page'];
}
else {
        $_SESSION['page'] = '';
}
?>

<div id='rightcolumn'>
    <h3 align="center" id="td_java"> THÔNG TIN KEY PHẦN MỀM </h3>
    <form action = "" method = "post">
        <tr>
                <td>Loại Key:</td>
                <td>                    
                    <select class="key" name="product_type" >
                        
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product ";
                        $result = mysqli_query($con, $sql);
                         while ($row = mysqli_fetch_array($result)) {
                            ?>
                        <option <?php if( isset($_SESSION["product"]) && $_SESSION["product"]==$row['product_type']){ echo 'selected="selected"';$_SESSION["product_type"]=$row['name'];}?> value="<?php echo $row['product_type'] ?>"> <?php echo $row['name'] ?></option>           
                            <?php
                        }
                         ?>   
                    </select> 
                </td>
            </tr>  
            
             
            <tr><input type="submit" name="loc" value="Lọc >>"></tr>
    </form>
    <form action="send_mail.php" method="post">
        
        <?php
        $no_record_per_page = 25;
        $con = open_db();
        $total_record = array();
        $total_record = get_total_record_nv_mod($_SESSION["product"],$_SESSION['id_user']);
		$t = $total_record[1] + $total_record[2];
        echo  'Tổng số key được cấp: '.$total_record[0].'</br>'.'Số key đã bán: '.$t.'</br>'.'Số key đã kích hoạt: '.$total_record[1].'</br>'.'Số key còn lại: '.$total_record[3];
     
        $total_page = ceil($total_record[0] / $no_record_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        get_key_no_reg_mod(($page-1) * $no_record_per_page, $no_record_per_page, $iduser, $permarr,$_SESSION["product"],'1',$email,$_SESSION['id_user']);
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
        echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
        <?php require_once("../Include/footer.php");
        ?>
    </form></div>
<?php ob_flush(); ?>
