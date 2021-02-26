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
     $con = open_db();
     $pro=$_GET['product'];
	 $date=$_GET['date'];
     $sql ="SELECT * FROM n_registered where  product_type = '$pro' and date1 = '$date' ";
        
    $result = mysqli_query($con, $sql);
     //$result = get_aaa($pro);
    
    
    ?>
<form action="exporttoexcel.php" method="post"   
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>  
  <table id="ReportTable" width="600" cellpadding="2" cellspacing="2" class="myClass">  
    <tr><th colspan="4"><h4>  Danh sách những người chưa kích hoạt được phần mềm <?php echo $_GET['name']; ?> </h4></th></tr>
    <tr>  
      <th>Tên</th>  
      <th>Số điện thoại</th>  
      <th>Địa chỉ</th>  
      <th>Email</th>  
	  <th>Ngày đăng kí</th>
	  <th>key kích hoạt</th>
    </tr>  
	
    <?php while ($row=mysqli_fetch_array($result)) { ?>
	
    <tr>  
	
      <td><center>  
          <?php echo $row['name']; ?>  
        </center></td>  
      <td><center>  
          <?php echo $row['tel']; ?>  
        </center></td>  
      <td><center>  
          <?php echo $row['address']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['email']; ?>  
        </center></td> 
		<td><center>  
          <?php echo $row['date1']; ?>  
        </center></td> 	
		<td><center>  
          <?php echo $row['key1']; ?>  
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