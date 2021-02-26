<?php ob_start(); ?>
<?php
session_start();
//require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$con = open_db();
//$date = date("Y-m-d");
$date = time();
$no_record_per_page = 30;
$con = open_db();
//-----------------------------------------------------------------------
$date_sb= date('d-m-Y', ($date - 0 * 24 * 3600));
$product='DutoanGXD';
if(isset($_POST['submit']) && $_POST['submit'] == 'lọc')
{
    $product = isset($_POST['product']) ? $_POST['product'] : $product;
    $date_sb = isset($_POST['date']) ? $_POST['date'] : $date_sb;
   
    $_SESSION['date']= $date_sb;
    $_SESSION['product']= $product;

}
if(isset($_SESSION['date']) && isset($_SESSION['product']) && !isset($_POST['submit'])){
    $date_sb=$_SESSION['date'];
    $product=$_SESSION['product'];
    
}
$date_1 = date("Y-m-d", strtotime($date_sb));
 $sql = "select count(*) as tmp from registered, license where registered.last_runing_date='$date_1' and registered.license_serial=license.license_serial and license.product_type = '$product'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
/*
if ($permarr['viewallregistered']) {
    $sql = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.license_serial=license.license_serial";
	echo $sql;
	die();
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DutoanGXD' and registered.license_serial=license.license_serial";
    $result1 = mysqli_query($sql1, $con);
    $row1 = mysqli_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DuthauGXD' and registered.license_serial=license.license_serial";
    $result2 = mysqli_query($sql2, $con);
    $row2 = mysqli_fetch_array($result2);
    $total_record2 = $row2['tmp'];
	
	$sql3 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='QuyettoanGXD' and registered.license_serial=license.license_serial";
    $result3 = mysqli_query($sql3, $con);
    $row3 = mysqli_fetch_array($result3);
    $total_record3 = $row3['tmp'];
	
	$sql4 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='qlclGXD' and registered.license_serial=license.license_serial";
    $result4 = mysqli_query($sql4, $con);
    $row4 = mysqli_fetch_array($result4);
    $total_record4 = $row4['tmp'];
	
	$sql5 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='gcm' and registered.license_serial=license.license_serial";
    $result5 = mysqli_query($sql5, $con);
    $row5 = mysqli_fetch_array($result5);
    $total_record5 = $row5['tmp'];
	
	$sql6 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DutoanVKT' and registered.license_serial=license.license_serial";
    $result6 = mysqli_query($sql3, $con);
    $row6 = mysqli_fetch_array($result3);
    $total_record6 = $row6['tmp'];
	
} else {
    if ($permarr['viewregistered']) {
        $sql = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        $total_record = $row['tmp'];
        $sql1 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DutoanGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result1 = mysqli_query($sql1, $con);
        $row1 = mysqli_fetch_array($result1);
        $total_record1 = $row1['tmp'];
        $sql2 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DuthauGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result2 = mysqli_query($sql2, $con);
        $row2 = mysqli_fetch_array($result2);
        $total_record2 = $row2['tmp'];
		
		$sql3 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='QuyettoanGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result3 = mysqli_query($sql3, $con);
        $row3 = mysqli_fetch_array($result3);
        $total_record3 = $row3['tmp'];
		
		$sql4 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='qlclGXD' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result4 = mysqli_query($sql4, $con);
        $row4 = mysqli_fetch_array($result4);
        $total_record4 = $row4['tmp'];
		
		$sql5 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='gcm' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result5 = mysqli_query($sql5, $con);
        $row5 = mysqli_fetch_array($result5);
        $total_record5 = $row5['tmp'];
		
		$sql6 = "select count(*) as tmp from registered, license where last_runing_date='$date_sb' and registered.product_type='DutoanVKT' and license.id_user='$iduser' and registered.license_serial=license.license_serial";
        $result6 = mysqli_query($sql6, $con);
        $row6 = mysqli_fetch_array($result6);
        $total_record6 = $row6['tmp'];
    }
}-->*/
//mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$i=0;

?>
<div id="rightcolumn">
<h3 align="center"> THÔNG TIN KHÁCH HÀNG ĐANG SỬ DỤNG PHẦN MỀM</h3>
     <form align="center" action="" method="post">  
       
        <label>Lựa chọn ngày:  </label>
        <select name="date">        
            <?php
                for ($i = 0; $i <= 5; $i++) {
                    $t = date('d-m-Y', ($date - $i * 24 * 3600));
                    
                    if($t==$date_sb){
                       
                        echo '<option selected="selected" value="'.$t.'">'.$t.'';
                    }
					else
                    echo '<option  value="'.$t.'">'.$t.'';
                }
            ?>
            <!--<option  value="</option>-->
        </select>
        <label>Lựa chọn phần mềm: </label>
        <select name="product">
            <?php
            $sql1 = "select name,product_type from product";
            $result1 = mysqli_query($con, $sql1);
           
            while ($row1 = mysqli_fetch_array($result1)) {
                
                $name1 = $row1['name'];
                $product_type1=$row1['product_type'];
                
                ?>
                <option <?php if($product_type1 == $product){echo 'selected="selected"';} ?> value="<?php echo $product_type1; ?>"><?php echo $name1; ?></option>
             <?php } ;
             mysqli_close($con);
             ?>
        
        </select>
        
        <input type="submit" name="submit" value="lọc">
    </form> 
    
    <form action="" method="">
        
        <?php echo "<p align='center' style='margin-left:20px; color:red'><b>Tổng số máy đang sử dụng phần mềm trong ngày ".$date_sb.": </b>" . $total_record 
        ; ?>
        <?php


        get_running($iduser, $permarr, ($page-1) * $no_record_per_page, $no_record_per_page,$date_sb,$product);
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
		echo "<p id= 'phantrang' align='center'> " . phantrang_test($total_page,$page) . "";
        ?>
    </form>
</div>
<?php
require_once("../Include/footer.php");
ob_flush();
?>
