<html>  
<head>  
<title>Export to excel in php</title>  
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>  
<style type="text/css">  
.myClass  
{  
font-family:verdana;  
font-size:11px;  
}  
</style>  
</head>  
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<body>  
    <?php
    require_once("../config/global.php");
	require_once("../model/registered.php");
	get_infor_from_conf("../config/DB.conf");
    require_once("../config/dbconnect.php");
//     $con = open_db();
     $product=$_GET['product'];
     $cty=$_GET['cty'];
//     $sql ="SELECT * FROM n_registered where  product_type = '$pro' ";
       
	$con = open_db();
    //$sql ="SELECT * FROM `registered` WHERE customer_cty LIKE '%$cty%' AND product_type = '$product'";
	if($cty != 'Tất cả'){
     $sql ="SELECT * FROM `registered` WHERE customer_cty LIKE '%$cty%' AND product_type = '$product'";
     
     }
     else{
     $sql ="SELECT * FROM `registered` WHERE product_type = '$product'";    
     }
    $sql1 ="SELECT * FROM `product` WHERE product_type = '$product'";
    $result = mysqli_query($con, $sql);
    $result1 = mysqli_query($sql1, $con);
    while ($row1=mysqli_fetch_array($result1)) { 
        $name_pro=$row1['name'];
    }
    if (!$result) {
        echo 'không tìm thấy cơ sở dữ liệu';
    }
    //$row = mysqli_fetch_array($result);
    mysqli_close($con);
   
    
    
    ?>
<form action="exporttoexcel.php" method="post"   
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>  
  <table id="ReportTable" width="900" cellpadding="2" cellspacing="2" class="myClass">  
      
      <tr><th colspan="3">  Danh sách những người sử dụng phần mềm <?php echo $name_pro; ?> tại <?php echo $cty; ?> </th></tr>
    <tr>  
      <th>Tên</th>  
      <th>Số điện thoại</th>  
      <th>Email</th>  
	  <th>Tỉnh thành</th> 
      <th>Ngày hết hạn</th> 
    </tr>  
    <?php while ($row=mysqli_fetch_array($result)) { ?>
    <tr>  
      <td><center>  
          <?php echo $row['customer_name']; ?>  
        </center></td>  
      
      <td><center>  
          <?php echo $row['customer_phone']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['customer_email']; ?>  
        </center></td>  
		<td><center>  
          <?php echo $row['customer_cty']; ?>  
        </center></td> 
        <td><center>  
          <?php echo $row['license_expire_date']; ?>  
        </center></td> 
    </tr>  
    
    <?php } ?>
  </table>  
  <table width="600px" cellpadding="2" cellspacing="2" border="0">  
    <tr>  
      <td>&nbsp;</td>  
    </tr>  
    <tr>  
      <td align="center"><input type="hidden" id="datatodisplay" name="datatodisplay">  
        <input type="submit" value="Export to Excel">  
      </td>  
    </tr>  
  </table>  
</form>  
</body>  
</html>  