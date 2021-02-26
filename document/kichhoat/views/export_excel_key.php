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
     $n=$_GET['n'];    
     $status=$_GET['stt'];
     if($status == 1){
         $str = "<b>Key thương mại</b></br>";
     }
     else {
                    $str = "<b>Key thử nghiệm</b></br>";
                }
     $con = open_db();
    $sql ="SELECT * FROM `license` ORDER BY id DESC LIMIT $n ";  
    $result = mysqli_query($con, $sql);
    //$row = mysqli_fetch_array($result);
    ?>
<form action="exporttoexcel.php" method="post"   
onsubmit='$("#datatodisplay").val( $("<div>").append( $("#ReportTable").eq(0).clone() ).html() )'>  
  <table id="ReportTable" width="1200" cellpadding="2" cellspacing="2" class="myClass">  
      
      <tr><th colspan="9">  Danh sách key vừa tạo</th></tr>
    <tr>  
      <th>license_serial</th>
      <th>Mã License</th>  
      <th>Số máy đã đăng kí</th>  
      <th>Ngày tạo</th>  
      <th>type_expire_date</th>
      <th>Loại phần mềm</th>
      <th>license_no_computers</th>
      <th>license_no_instance</th>
      <th>status</th>
      
      <th>id_user</th>
    </tr>  
    <?php while ($row=mysqli_fetch_array($result)) { ?>
    <tr>  
        <td><center>  
          <?php echo $row['license_serial']; ?>  
        </center></td> 
      <td><center>  
          <?php echo $row['license_key']; ?>  
        </center></td>  
      
      <td><center>  
          <?php echo $row['license_is_registered']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['license_created_date']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['type_expire_date']; ?>  
        </center></td>  
        <td><center>  
          <?php echo $row['product_type']; ?>  
        </center></td>  
          <td><center>  
          <?php echo $row['license_no_computers']; ?>  
        </center></td>   
         <td><center>  
          <?php echo $row['license_no_instance']; ?>  
        </center></td>  
         <td><center>  
          <?php echo $row['status']; ?>  
        </center></td> 
       <td><center>  
          <?php echo $row['id_user']; ?>  
        </center></td>  
    </tr>  
    
    <?php } ?>
  </table>  
    <?php     mysqli_close($con); ?>
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