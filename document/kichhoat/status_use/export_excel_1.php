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
	session_start();
    require_once("../config/global.php");
require_once("../model/registered.php");
get_infor_from_conf("../config/DB.conf");
    require_once("../config/dbconnect.php");
//     $con = open_db();
     
//     $sql ="SELECT * FROM n_registered where  product_type = '$pro' ";
    $date=$_GET['date'];
        $result = get_expire($date);


    
    ?>
<form action="exporttoexcel.php" method="post"   
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>  
  <table id="ReportTable" width="800" cellpadding="2" cellspacing="2" class="myClass">  
      <input type="hidden" name="name_table" value="PHẦN MỀM HẾT HẠN NGÀY <?php echo $date; ?>"  >
    <tr>  PHẦN MỀM HẾT HẠN NGÀY <?php echo $date; ?></tr>
    <tr>  
      <th>Tên</th>  
      <th>Số điện thoại</th>  
      <th>Địa chỉ</th>  
      <th>Email</th>  
      <th>Loại</th>
      <th>key</th>
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
          <?php echo $row['customer_cty']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['customer_email']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['name']; ?>  
        </center></td>  
        <td><center>  
          <?php if($row['status'] == 1){ echo 'key thương mại'; }
                elseif ($row['status'] == 0) {echo 'key dùng thử';}
          ?>  
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