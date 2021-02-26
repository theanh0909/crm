<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
//require_once("../Include/header.php");
require_once("../views/header_key_no_reg.php");
require_once("../Include/sidebar.php");
if(!isset($_SESSION["product"]) && !isset($_SESSION["key"])){
    $_SESSION["product"] = 'DutoanGXD';
    $_SESSION["key"] = '1';
}
$email= '';
if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(isset($_POST['loc'])){

    $_SESSION["product"] = $_POST['product_type'];
    $_SESSION["key"] = $_POST['key_1'];
//     $product_type=$_POST['product_type'];
//     $key=$_POST['key_1'];
}
 if(isset($_GET['page'])){
    $_SESSION['page'] = $_GET['page'];
}
else {
        $_SESSION['page'] = '';
}
?>

<div id='rightcolumn'>
    <h3 align="center"> THÔNG TIN KEY PHẦN MỀM </h3>
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
            <tr>
                <td>Loại key:</td>
                <td>
                    
                    <select class="key_1" name="key_1" >
                        <option <?php if( isset($_SESSION["key"]) && $_SESSION["key"] == 1){ echo 'selected="selected"';}?>  value="1"> Key thương mại</option>  
                        <option <?php if( isset($_SESSION["key"]) && $_SESSION["key"] == 0){ echo 'selected="selected"';}?> value="0"> Key thử nghiệm</option>           
                        
                    </select> 
                </td>
            </tr>
            <tr><input type="submit" name="loc" value="Lọc >>"></tr>
    </form>
    <form action="send_mail_new.php" method="post">
        
        <?php
        $no_record_per_page = 25;
        $con = open_db();
        //$total_record = get_total_record();
		 $total_record = get_total_record_1($_SESSION["product"],$_SESSION["key"],$email);
        $total_page = ceil($total_record / $no_record_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        get_key_no_reg(($page-1) * $no_record_per_page, $no_record_per_page, $iduser, $permarr,$_SESSION["product"],$_SESSION["key"],$email);
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
		echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
        <?php require_once("../Include/footer.php");
        ?>
    </form></div>
<?php ob_flush(); ?>
