<?php ob_start(); ?>
<style>
#table1 tr, th {    
    border: 1px solid #ddd;
    text-align: left;
}

#table1 {
    border-collapse: collapse;
    width: 100%;
}

#table1 tr, th {
    padding: 5px;
}
#table1 tr, th {
    font-weight: normal;
}
</style>
<?php
session_start();
require_once("../model/license.php");
get_infor_from_conf("../config/DB.conf");
require_once("../views/header_key_no_reg.php");
require_once("../config/dbconnect.php");
require_once("../Include/sidebar.php");
$con = open_db();
if(isset($_POST['Xóa']) && $_POST['Xóa'] == 'Xóa'){
     if ((isset($_POST['history'])) && ($_POST['history'] != "")) {
          foreach($_POST['history'] as $check) {
              if($check == 'All'){
                  $sql = "DELETE FROM `log_info`";
                  
              }else
              $sql = "DELETE FROM `log_info` WHERE id = '$check'";
                $result = mysqli_query($con, $sql);          
          }
         
     }
     }

$sql = "select * from action_log,log_info where log_info.id_action = action_log.id ORDER BY log_info.id DESC";
$result = mysqli_query($con, $sql);                        
?>
<meta name="copyright" http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<h3 align="center" id="td_java"> LỊCH SỬ </h3>
<form method ="POST">
    <table style="width:700px" id="table1">
        <tr>
    <th width = '10%'><input name='history[]' id= "history[]" type='checkbox' value='All'/> </th>
    <th width = '15%'>Người dùng</th>
    <th width = '30%'>Ngày sử dụng</th>
    <th width = '45%'>Hành động</th>
    </tr>
    <?php
            while ($row = mysqli_fetch_array($result)) {
        ?>
                <tr>        
                <th class="history" width = '10%'><input name='history[]' type='checkbox' value='<?php echo $row['id']; ?>'/> </th>
                <th class="history" width = '15%'><?php echo $row['user']; ?></th>
                <th class="history" width = '15%'><?php echo $row['time']; ?></th>
                <th class="history" width = '60%'><?php echo $row['name']; ?></th>
                </tr>
            <?php } ?>
                
    
    </table>
    <center><input type="submit" name ="Xóa" value="Xóa" ></center>
</form>