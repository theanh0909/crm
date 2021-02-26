<?php ob_start(); ?>
<style>
	#listcheck {
		width: 1100px;
}
</style>
<?php
session_start();
require_once("../config/global.php");
require_once("../config/dbconnect.php");
get_infor_from_conf("../config/DB.conf");
require_once("Include/header.php");
require_once("Include/sidebar.php");
require_once("function.php");
$con = open_db();
$t = time();
$date = date('Y-m-d', ($t + 2 * 24 * 3600));
$no_record_per_page = 25;
//$con = open_db();
//$date = date('Y-m-d', ($t + 2 * 24 * 3600));
$date1 = 2;
$product_type = 'DuthauGXD';
if(isset($_POST['submit'])){
    if(isset($_POST['date'])){
        $date1 = $_POST['date'];
    }
	if(isset($_POST['product_type'])){
        $product_type = $_POST['product_type'];
    }
	if(isset($_POST['city'])){
         $city = $_POST['city'];
    }
}
if ($permarr['expire_1']) {
    $sql = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $total_record = $row['tmp'];
    $sql1 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DutoanGXD'";
    $result1 = mysqli_query($sql1, $con);
    $row1 = mysqli_fetch_array($result1);
    $total_record1 = $row1['tmp'];
    $sql2 = "select count(*) as tmp from registered, license where registered.license_serial=license.license_serial and license_expire_date='$date' and registered.product_type='DuthauGXD'";
    $result2 = mysqli_query($sql2, $con);
    $row2 = mysqli_fetch_array($result2);
    $total_record2 = $row2['tmp'];
	     $sql4 = "SELECT * FROM `user` WHERE username = '".$_SESSION['username']."'";
    $result4 = mysqli_query($sql4, $con);
    $row4 = mysqli_fetch_array($result4);
 
mysqli_close($con);
$total_page = ceil($total_record / $no_record_per_page);
$page = isset($_GET['page']) ? $_GET['page'] : 0;
?>
<div id = "rightcolumn">
    <form action = "" method = "post" >
        Chọn số ngày: <select name="date">
            <option <?php if(isset($date1) && $date1 == '2'){ echo 'selected';} ?> value="2">2 ngày</option>
            <option <?php if(isset($date1) && $date1 == '3'){ echo 'selected';} ?>  value="3">3 ngày</option>
            <option <?php if(isset($date1) && $date1 == '5'){ echo 'selected';} ?>  value="5">5 ngày</option>
            <option <?php if(isset($date1) && $date1 == '7'){ echo 'selected';} ?>  value="7" >1 tuần</option>
          </select>
		  Chọn phần mềm:<select class="key" name="product_type" >
                        
                        <?php
                        $con = open_db();
                        $sql = "select product_type, name from product ";
                        $result = mysqli_query($con, $sql);
                         while ($row = mysqli_fetch_array($result)) {
                            ?>
            <option <?php if(isset($_POST['product_type']) && $_POST['product_type'] == $row['product_type']){ECHO 'selected="selected"';} ?> value="<?php echo $row['product_type'] ?>" > <?php echo $row['name'] ?></option>           
                            <?php
                        }
                         ?>   
                    </select> 
        <input name="submit" type="submit" value="Chọn">        
        <h3  align='center'>PHẦN MỀM CÒN <?php echo $date1; ?> NGÀY NỮA HẾT HẠN </h3>
		
		<?php
        $con = open_db();
            $sql3='SELECT * FROM `tbl_city`';
            $result3=mysqli_query($sql3, $con);
            if ($result3){             
                echo 'Chọn tỉnh: <select name = "city">';
                while ($row3 = mysqli_fetch_array($result3)) {
                    //$name = $row1['type'];
                    $name = $row3['type'].'-';

                    if(strpos($row4['permission'],$name) != FALSE){  
                    if($row3['type'] == $city){
                    echo '<option selected value ='.$row3['type'].'>'.$row3['name'].'</option>';
                    }
                    else echo '<option value ='.$row3['type'].'>'.$row3['name'].'</option>';
                    }
                    
                }
                echo '</select>';
            }  
            ?>
		
        <?php
        //echo "<p style='margin-left:10px; color: red'><b>Tổng số máy hết hạn: " . $total_record . " </b><a href='../extend/out_put_2ex.php'><img src='../template/images/print.jpg' width='22' height='22' /></a>
          //  <b>- Số key dự toán : " . $total_record1 . "  - Số key dự thầu : " . $total_record2 . "</b></p>";
		 if(isset($city)){
        get_expire_date($date1,$iduser, $permarr, $page * $no_record_per_page, $no_record_per_page,$city,$product_type);
		}
       //echo '<a href="export_excel_1.php?&date='. $date.'" target="_blank"> xuất ra excel  </a>';
        //echo "<p align='center'><b>Tổng số máy sắp hết hạn: ".$total_record." </b></p>";
        //echo "<p align='center'> " . phantrang($page, $total_page, '?&page=%s', $no_record_per_page) . "";
         
        ?>
        
    </form>
   
    <?php
    }
    require_once("../Include/footer.php");
    ?>
</div>
<?php ob_flush(); ?>
