<?php ob_start(); ?>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
//require_once("../views/header_key_no_reg.php");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$date = time();
$date_sb= date('d-m-Y', ($date - 0 * 24 * 3600));
	
	///////////////////////
	if(!isset($_SESSION["product"]) && !isset($_SESSION["date"])){
    $_SESSION["product"] = 'DutoanGXD';
    $_SESSION["date"] = '1';
}
if(isset($_POST['loc'])){
    $_SESSION["product"] = $_POST['product_type'];
    $_SESSION["date"] = $_POST['date'];
}
	$product = $_SESSION["product"];
	$day_creat = $_SESSION["date"]; 
if(isset($_GET['page'])){
    $_SESSION['page'] = $_GET['page'];
}
else {
        $_SESSION['page'] = '';
}
?>

<div id='rightcolumn'>
    <h3 align="center" id="td_java"> THÔNG TIN KEY ĐƯỢC TẠO </h3>
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
                                <option <?php if( isset($product) && $product==$row['product_type']){ echo 'selected="selected"';}?> value="<?php echo $row['product_type'] ?>"> <?php echo $row['name'] ?></option>           
                            <?php
                        }
                         ?>   
                    </select> 
                </td>
            </tr>  
            <tr>
                <td>Ngày tạo key:</td>
                <td>
                    
                    <select name="date">        
                        <?php
                            for ($i = 0; $i <= 10; $i++) {
                                $t = date('d-m-Y', ($date - $i * 24 * 3600));
                                if($t==$day_creat){

                                    echo '<option selected="selected" value="'.$t.'">'.$t.'';
                                }
                                else
                                echo '<option  value="'.$t.'">'.$t.'';
                            }
                        ?>
                        <!--<option  value="</option>-->
                    </select>
                </td>
            </tr>
            <tr><input type="submit" name="loc" value="Lọc >>"></tr>
    </form>
    <form action="send_mail.php" method="post">
        
        <?php
        $no_record_per_page = 25;
        $con = open_db();
        $date1=    date("Y-m-d", strtotime($day_creat));

        $total_record = get_total_record_create($product,$date1);

        $total_page = ceil($total_record / $no_record_per_page);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        echo "<p  style='color:red;font-size:17px;' align='left'> TỔNG SỐ KEY TẠO TRONG NGÀY ".$day_creat.":    " . $total_record . "</p>";
        get_key_create(($page-1) * $no_record_per_page, $no_record_per_page, $iduser, $permarr,$date1,$product);
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
        echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
        <?php require_once("../Include/footer.php");
        ?>
    </form></div>
<?php ob_flush(); ?>
