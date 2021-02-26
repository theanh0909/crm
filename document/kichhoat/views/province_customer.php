<?php ob_start(); ?>
<?php
session_start();
require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
require_once("../Include/header.php");
require_once("../Include/sidebar.php");
$cty='';
$product='';
if(isset($_POST['submit']))
{
    $product = isset($_POST['product']) ? $_POST['product'] : "";
    $cty = isset($_POST['cty']) ? $_POST['cty'] : "";
   
    $_SESSION['cty']= $cty;
    $_SESSION['product']= $product;
    
}
if(isset($_SESSION['cty']) && isset($_SESSION['product']) && !isset($_POST['submit'])){
    $cty=$_SESSION['cty'];
    $product=$_SESSION['product'];
}


    if ($_POST['deleteall']) {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                    $t = $_POST['chkid'];
                    foreach ($t as $value) {
                        $deleteSQL = "delete from registered where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                        
                    }
                   //header("Location: ../views/province_customer.php");
                }
                if ((isset($_POST['chkid1'])) && ($_POST['chkid1'] != "")) {
                    $t1 = $_POST['chkid1'];
                    foreach ($t1 as $value) {
                        $deleteSQL = "delete from n_registered where id ='" . $value . "'";
                        
                        $Result = mysqli_query($deleteSQL, $con);
                      
                    }
                    
                }
             
                header("Location: ../views/province_customer.php");
            }
 
            
$tinh = '';
$tinh = array("An Giang", "Bắc Cạn", "Bạc Liêu", "Bắc Ninh", "Bắc Giang",
        "Bến Tre", "Bình Dương", "Bình Phước", "Bình Định", "Bình Thuận", "Cà Mau",
        "Cao Bằng", "Cần Thơ", "Đắk Lắk", "Đắk Nông", "Đà Nẵng", "Điện Biên", "Đồng Nai",
        "Đồng Tháp", "Gia Lai", "Hà Giang", "Hải Dương", "Hải Phòng", "Hà Nam",
        "Hà Nội", "Hà Tĩnh", "Hậu Giang", "Hòa Bình", "Hồ Chí Minh", "Huế",
        "Hưng Yên", "Khánh Hòa", "Kiên Giang", "Kon Tum", "Lai Châu", "Lâm Đồng",
        "Lạng Sơn", "Lào Cai", "Long An", "Nam Định", "Nghệ An", "Ninh Bình",
        "Ninh Thuận", "Phú Thọ", "Phú Yên", "Quảng Bình", "Quảng Nam", "Quảng Ngãi",
        "Quảng Trị", "Quảng Ninh", "Sóc Trăng", "Sơn La", "Tây Ninh", "Thái Bình",
        "Thái Nguyên", "Thanh Hóa", "Tiền Giang", "Trà Vinh", "Tuyên Quang",
        "Vĩnh Long", "Vũng Tàu", "Yên Bái", "Tỉnh Khác","Tất cả");
?>
<div id="rightcolumn">
    <form action="" method="post">  
        
        <label>Lựa chọn tỉnh thành: </label>
        <select name="cty">
            <?php
            foreach ($tinh as $key => $value) {
                    
                    ?>
             <option <?php if($value == $cty){echo 'selected="selected"';} ?> value="<?php echo $value ?>"><?php echo $value ?></option>
            <?php } ?>
        </select>
        <label>Lựa chọn phần mềm: </label>
        <select name="product">
            <?php
            $sql1 = "select name,product_type from product";
            $result1 = mysqli_query($sql1, $con);           
            while ($row1 = mysqli_fetch_array($result1)) {
                $name1 = $row1['name'];
                $product_type1=$row1['product_type'];
                
                ?>
                <option <?php if($product_type1 == $product){echo 'selected="selected"';} ?> value="<?php echo $product_type1 ?>"><?php echo $name1; ?></option>
             <?php } ?>
        
        </select>
        
        <input type="submit" name="submit" value="lọc">
    </form> 
    
    <p>Thống kê khách hàng:</p>
    <form method="POST">
        <table class="table">
        <tr>
            <td style="width: 10%"></td>
            <td style="width: 25%">Tên khách hàng</td>
            <td style="width: 25%">email</td>
            <td style="width: 5%">Số điện thoại</td>
            <td style="width: 10%">trạng thái</td>
            <td style="width: 5%">ngày hết hạn</td>
            
            <td style="width: 5%">xóa</td>
            
            
        </tr>
        <?php
           // $sql = "select * from registered where customer_cty =".$cty." and product_type = ".$product." ";
           // $sql = "SELECT * FROM `registered` WHERE customer_cty LIKE '%$cty%' AND product_type = '$product'";
		   if($cty == 'Tất cả'){
            $sql = "SELECT * FROM `registered` WHERE product_type = '$product'";
        } else{
            $sql = "SELECT * FROM `registered` WHERE customer_cty LIKE '%$cty%' AND product_type = '$product'";
        }
            $result = mysqli_query($con, $sql);           
           $row1=  mysqli_num_rows($result);
            while ($row = mysqli_fetch_array($result)) {
                
                $id= $row['id'];
                $name = $row['customer_name'];                
                $email=$row['customer_email'];
                $phone=$row['customer_phone'];     
                $status='kích hoạt';  
                $day=$row['license_expire_date'];
                ?>
        <tr>
            <td style="width: 10%"><input name='chkid[]' id='chkid[]' type='checkbox' value='<?php echo $id; ?>'/></td>
            <td style="width: 25%"><?php echo $name ?></td>
            <td style="width: 25%"><?php echo $email ?></td>
            <td style="width: 10%"><?php echo $phone ?></td>
            <td style="width: 10%"><?php echo $status ?></td>
            <td style="width: 10%"><?php echo $day ?></td>
            <td><a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=<?php echo $id;?>&st=2'><img src='../template/images/delete.png' width='15' height = '15'></td>
            
        </tr>
        
        <?php } ?>
        
        <!--------------------------->
        <?php
         $n_sql1 = "SELECT * FROM `n_registered` WHERE customer_cty LIKE '%$cty%' AND product_type = '$product'";
            $n_result1 = mysqli_query($n_sql1, $con);           
           $n_row1=  mysqli_num_rows($n_result1);
            while ($n_row = mysqli_fetch_array($n_result1)) {
                
                $n_id= $n_row['id'];
                $n_name = $n_row['name'];                
                $n_email=$n_row['email'];
                $n_phone=$n_row['tel'];     
                $n_status='chưa kích hoạt';  
                ?>
        <tr>
            <td style="width: 10%"><input name='chkid1[]' id='chkid1[]' type='checkbox' value='<?php echo $n_id; ?>'/></td>
            <td style="width: 25%"><?php echo $n_name ?></td>
            <td style="width: 25%"><?php echo $n_email ?></td>
            <td style="width: 10%"><?php echo $n_phone ?></td>
            <td style="width: 10%"><?php echo $n_status ?></td>
            <td style="width: 10%"></td>
            <td><a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=<?php echo $n_id;?>&st=3'><img src='../template/images/delete.png' width='15' height = '15'></td>
            
        </tr>
        
        <?php } ?>
        
        <tr><td colspan="3" align="right" bgcolor="#FFFFFF"><input class="button" name="deleteall" type="submit" id="delete" value="Xoá"></td></tr>
        <tr><td colspan="3" align="right"><a href="export_excel.php?product=<?php echo $product; ?>&cty=<?php echo $cty; ?>" target="_blank"> xuất ra excel  </a></td></tr>
    </table>
    </form>
</div>
<?php
require_once("../Include/footer.php");
?>
<?php ob_flush(); ?>