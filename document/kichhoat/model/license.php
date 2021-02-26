<?php
require_once("../config/dbconnect.php");

//***************** Insert key *****************
function add_license_to_db(
    $license_serial, 
    $license_key, 
    $license_is_registered, 
    $license_created_date, 
    $type_expire_date, 
    $hardware_id, 
    $license_no_instance, 
    $license_no_computers, 
    $product_type, 
    $iduser, 
    $tatus, 
    $key_email

) {
    $con = open_db();
    $sql = "INSERT INTO license (id,
    license_serial,
    license_key,
    license_is_registered,
    license_created_date,
    type_expire_date,
    hardware_id,
    license_no_instance,
    license_no_computers,
    product_type,
    id_user,
    status,
    stt_email
    )
    VALUES (NULL,
    '$license_serial',
    '$license_key',
    '$license_is_registered',
    '$license_created_date',
    '$type_expire_date',
    '$hardware_id',
    '$license_no_instance',
    '$license_no_computers',
    '$product_type',
    '$iduser',
    '$tatus',
	'$key_email'
    );
    ";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo "Cannot insert data into database";
    }
    mysqli_close($con);
}
//***************** Quản lý nhân viên *****************
function manager_nv($frompos, $norecords, $iduser, $per,$product_type,$thanhvien,$date_act) {
    $con = open_db();      
        $sql = "SELECT * FROM user,license,registered  WHERE user.id='$thanhvien' and registered.license_serial = license.license_serial and license.id_user=user.id and license.product_type ='$product_type' and license.status = '1' and registered.license_activation_date like '%$date_act%' ";    

    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày kích hoạt</th><th>Loại Key</th><th>Email khách hàng</th><th>Ngày hết hạn</th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_activation_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
        $email_db = '';
        if($row['stt_reg'] == 1){
			$sub = "<input name='submitagain$count' type='submit' value='Gửi Lại'/>";
                        $email_db = $row['email_cus'];
                        $email = "<input  name='mail$count' type='hidden' value= '$email_db'/>";
			
		}else
		{
                $sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
		$email="<input name='mail$count' type='text' value=''/>";
		}
        $id=$row['id'];
        $id_1 = "<input name='id$count' type='hidden' value='$id'/>";
       
        //$email="<input name='mail$count' type='text' value=''/>";
        $license_key=$row['license_key'];
        $key="<input name='key$count' type='hidden' value='$license_key'/> ";
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        
       
        
        $lk_1 = '';

        if ($row['status'] == 1) {
            $lk = "Key thương mại";
            $lk_1 = "<input name='lk$count' type='hidden' value='1'/>";
        } else {
            $lk = "Key dùng thử";
        }
        ?>

        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            if($email_db==''){
            $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email, $row['type_expire_date'], $sub,$key,$id_1,$lk_1);
            }
            else {
                    $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td class = 'target'>%s</td><td>%d</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email_db, $row['type_expire_date'],$sub,$key,$id_1,$email,$lk_1);
                }
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        
         echo'   <script>
            $(document).ready(function(){
                var divdbl = $( ".target" );
                divdbl.dblclick(function() {
                var pName = $(this).text();
                $(this).text("");
                //alert("<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />");
                var input= "<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />";
               $(this).prepend(input);
              
                
            })
            });
            </script>';
        if ($per['key']) {
           
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
                    
        }
        
             echo "</table>";
        mysqli_close($con);
    
}function get_key_no_reg_mod($frompos, $norecords, $iduser, $per,$product_type,$key,$email,$id) {
    $con = open_db();
   // if ($per['viewkey']) {
        if($email == ''){
        $sql = "SELECT * FROM user,license  WHERE license.id_user='$id' and license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key'  ORDER BY license.id DESC LIMIT $frompos, $norecords ";
        }
        else
        {
        $sql = "SELECT * FROM user,license  WHERE license.id_user='$id' and license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key' and email_cus like '%$email%' ORDER BY license.id DESC LIMIT $frompos, $norecords ";    
        }
        
   // } 
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th>Loại Key</th><th>Email khách hàng</th><th>Ngày hết hạn</th><th></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
        $email_db = '';
        if($row['stt_reg'] == 1){
			$sub = "<input name='submitagain$count' type='submit' value='Gửi Lại'/>";
                        $email_db = $row['email_cus'];
                        $email = "<input  name='mail$count' type='hidden' value= '$email_db'/>";
			
		}else
		{
                $sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
		$email="<input name='mail$count' type='text' value=''/>";
		}
        $id=$row['id'];
        $id_1 = "<input name='id$count' type='hidden' value='$id'/>";
        $license_key=$row['license_key'];
        $key="<input name='key$count' type='hidden' value='$license_key'/> ";
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        
       
        
        $lk_1 = '';
        if ($row['status'] == 1) {
            $lk = "Key thương mại";
            $lk_1 = "<input name='lk$count' type='hidden' value='1'/>";
        } else {
            $lk = "Key dùng thử";
        }
        ?>

        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php

            if($email_db==''){
            $tmp = sprintf("<td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email, $row['type_expire_date'],$sub,$key,$id_1,$lk_1);
            }
            else {
                    $tmp = sprintf("<td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td class = 'target'>%s</td><td>%s</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email_db, $row['type_expire_date'],$sub,$key,$id_1,$email,$lk_1);
                }
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        
         echo'   <script>
            $(document).ready(function(){
                var divdbl = $( ".target" );
                divdbl.dblclick(function() {
                var pName = $(this).text();
                $(this).text("");
                //alert("<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />");
                var input= "<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />";
               $(this).prepend(input);
              
                
            })
            });
            </script>';
        if ($per['key']) {
           
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";                     
        }
        
             echo "</table>";
        mysqli_close($con);
    
}
//***************** Hiển thị bảng quản lý dãy Key sinh ra *****************
function get_licenses_from_db_ranges($frompos, $norecords, $iduser, $per) {
    $con = open_db();
    if ($per['viewkey']) {
        $sql = "SELECT * FROM license, user WHERE license.id_user=user.id ORDER BY license.id DESC LIMIT $frompos, $norecords ";
    } else {
        $sql = "SELECT * FROM `license` WHERE iduser='$iduser' ORDER BY `id` DESC LIMIT $frompos, $norecords ";
    }
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th width='150'>Loại PM</th><th>Loại Key</th><th>User</th><th>Số ngày hết hạn</th><th></th><th></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        if ($row['status'] == 1) {
            $lk = "Key thương mại";
        } else {
            $lk = "Key dùng thử";
        }
        ?>
        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date, $row['product_type'], $lk, $row['username'], $row['type_expire_date'], $edit, $del);
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        if ($per['key']) {
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
            if ($_POST['delete'] == "Xóa") {
                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                    $t = $_POST['chkid'];
                    foreach ($t as $key => $value) {
                        $deleteSQL = "delete from license where id ='" . $value . "'";
                        $Result = mysqli_query($deleteSQL, $con);
                    }
                    if ($Result) {
                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_key.php\">";
                    }
                }
            }
        }
             echo "</table>";
        mysqli_close($con);
    }
	
	function get_key_create($frompos, $norecords, $iduser, $per,$day,$product) {
    $con = open_db();

        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.product_type ='$product' and  license.license_created_date='$day' ORDER BY license.id DESC LIMIT $frompos, $norecords ";
    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {
        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th>Loại Key</th><th>Ngày hết hạn</th><th></th><th></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
        //$sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
        $id=$row['id'];
       
        //$email="<input name='mail$count' type='text' value=''/>";
        $license_key=$row['license_key'];
        $key="<input name='key$count' type='hidden' value='$license_key'/> ";
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        
       
        
        $lk_1 = '';
        if ($row['status'] == 1) {
            $lk = "Key thương mại";
            $lk_1 = "<input name='lk$count' type='hidden' value='1'/>";
        } else {
            $lk = "Key dùng thử";
        }
        ?>

        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $row['type_expire_date'], $edit, $del,$key);
            echo $tmp;
            echo "</tr>";
}
        if ($per['key']) {
           
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
        }
        
             echo "</table>";
             

    

        mysqli_close($con);
}
//***************** Key chua dang ki *****************
function get_key_no_reg_1($frompos, $norecords, $iduser, $per,$product_type,$key) {
    $con = open_db();
    if ($per['viewkey']) {
        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key'  ORDER BY license.id DESC LIMIT $frompos, $norecords ";
    } 
  
//    else {
//        $sql = "SELECT * FROM `license` WHERE iduser='$iduser' ORDER BY `id` DESC LIMIT $frompos, $norecords ";
//    }

    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th>Loại Key</th><th>Email khách hàng</th><th>Ngày hết hạn</th><th></th><th></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
		if($row['stt_reg'] == 1){
			$sub = 'Đã Gửi';
			$email = $row['email_cus'];
		}else
		{
        $sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
		$email="<input name='mail$count' type='text' value=''/>";
		}
        $id=$row['id'];
        $id_1 = "<input name='id$count' type='hidden' value='$id'/>";

        

        $license_key=$row['license_key'];
        $key="<input name='key$count' type='hidden' value='$license_key'/> ";
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        if ($row['status'] == 1) {
            $lk = "Key thương mại";
        } else {
            $lk = "Key dùng thử";
        }
        ?>
        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email, $row['type_expire_date'], $edit, $del,$sub,$key,$id_1);
            echo $tmp;
            echo "</tr>";
            $count++;
        }
       
        if ($per['key']) {
           
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
//            if ($_POST['delete'] == "Xóa") {
//                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
//                    $t = $_POST['chkid'];
//                    foreach ($t as $key => $value) {
//                        $deleteSQL = "delete from license where id ='" . $value . "'";
//                        $Result = mysqli_query($deleteSQL, $con);
//                    }
//                    if ($Result) {
//                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_key.php\">";
//                    }
//                }
//            }
            
          
        }
        
             echo "</table>";
        mysqli_close($con);
    
}
function get_key_no_reg($frompos, $norecords, $iduser, $per,$product_type,$key,$email) {
    $con = open_db();
    if ($per['viewkey']) {
        if($email == ''){
        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key' and license.stt_email = 0  ORDER BY license.id DESC LIMIT $frompos, $norecords ";
        }
        else
        {
        $sql = "SELECT * FROM user,license  WHERE license.id_user=user.id and license.license_is_registered='0' and license.product_type ='$product_type' and license.status = '$key' and license.stt_email = 0 and email_cus like '%$email%' ORDER BY license.id DESC LIMIT $frompos, $norecords ";    
        }
    } 
  
//    else {
//        $sql = "SELECT * FROM `license` WHERE iduser='$iduser' ORDER BY `id` DESC LIMIT $frompos, $norecords ";
//    }

    $result = mysqli_query($con, $sql);
    $count = 0;
    if ($per['key']) {

        $delall = "<input type='checkbox' id='checkall' name='checkall' />";
    } else {
        $delall = "";
    }
    echo "<table cellspacing='0' cellpadding='0' class='table_license' align='center' ondblclick='hide_info_detail();'><tr><th>$delall</th><th>Mã License</th><th>Số máy</th><th>Đăng ký</th><th align='center'>Ngày tạo</th><th>Loại Key</th><th>Email khách hàng</th><th>Ngày hết hạn</th><th></th><th></th><tr>";
    while ($row = mysqli_fetch_array($result)) {
        $t1 = strtotime($row['license_created_date']);
        $key_created_date = date('d-m-Y', $t1);
        if ($per['changcekey']) {
            $edit = "<a title='Sửa key' href ='editlicense.php?id=$row[license_serial]'><img src='../template/images/edit.png' width='15' height = '15'></a>";
        } else {
            $edit = "";
        }
        $email_db = '';
        if($row['stt_reg'] == 1){
			$sub = "<input name='submitagain$count' type='submit' value='Gửi Lại'/>";
                        $email_db = $row['email_cus'];
                        $email = "<input  name='mail$count' type='hidden' value= '$email_db'/>";
			
		}else
		{
                $sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
		$email="<input name='mail$count' type='text' value=''/>";
		}
        //$sub = "<input name='submit$count' type='submit' value='Gửi Mail'/>";
        $id=$row['id'];
        $id_1 = "<input name='id$count' type='hidden' value='$id'/>";
       
        //$email="<input name='mail$count' type='text' value=''/>";
        $license_key=$row['license_key'];
        $key="<input name='key$count' type='hidden' value='$license_key'/> ";
        if ($per['key']) {
            $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
            $del = "<a title ='Xoa key' href = 'deletelicense.php?id=$row[license_serial]'>
                <img src='../template/images/delete.png' width='15' height = '15'></a>";
        } else {
            $del = "";
        }
        
       
        
        $lk_1 = '';
        if ($row['status'] == 1) {
            $lk = "Key thương mại";
			$lk_1 = "<input name='lk$count' type='hidden' value='1'/>";
        } else {
            $lk = "Key dùng thử";
        }
        ?>

        <tr id = '<?php echo $count; ?>' onclick="show_info_detail('<?php echo $row['license_key']; ?>');" onmouseover="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');" onmouseout="toggle(document.getElementById('<?php echo $count; ?>'), '#FFFFFF');">
            <?php
            if($email_db==''){
            $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email, $row['type_expire_date'], $edit, $del,$sub,$key,$id_1,$lk_1);
            }
            else {
                    $tmp = sprintf("<td>%s</td><td>%s</td><td >%s</td><td>%d</td><td>%s</td><td>%s</td><td class = 'target'>%s</td><td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td><td style='display:none;'>%s</td>", $delallr, $row['license_key'], $row['license_no_computers'], $row['license_is_registered'], $key_created_date,$lk , $email_db, $row['type_expire_date'], $edit, $del,$sub,$key,$id_1,$email,$lk_1);
                }
            echo $tmp;
            echo "</tr>";
            $count++;
        }
        //for ($i =0 ;$i < 25;$i++){
        
         echo'   <script>
            $(document).ready(function(){
                var divdbl = $( ".target" );
                divdbl.mousedown(function() {
                var pName = $(this).text();
                $(this).text("");
                //alert("<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />");
                var input= "<input name =" + "\'input\'" + " type =" + "\'text\'" + " value =" + "\'" + pName + "\'" + " />";
               $(this).prepend(input);
              
                
            })
            });
            </script>';
        //}
        if ($per['key']) {
           
            echo "<tr>";
            echo '<td colspan="11" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
            echo "</tr>";
//            if ($_POST['delete'] == "Xóa") {
//                if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
//                    $t = $_POST['chkid'];
//                    foreach ($t as $key => $value) {
//                        $deleteSQL = "delete from license where id ='" . $value . "'";
//                        $Result = mysqli_query($deleteSQL, $con);
//                    }
//                    if ($Result) {
//                        echo "<meta http-equiv = \"refresh\" content=\"0;URL=report_key.php\">";
//                    }
//                }
//            }
            
          
        }
        
             echo "</table>";
        mysqli_close($con);
    
}
//***************** Delete Key *****************
    function delete_license($license_serial) {
        $con = open_db();
        $sql = "select * from license where license_serial = '" . $license_serial . "'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);
            if ($row['license_is_registered'] > 0) {
                return false;
            }
        }
        $sql = "delete from license where license_serial = '" . $license_serial . "'";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo "Cannot delete data from database";
            return false;
        }
        mysqli_close($con);
        return true;
    }

//***************** Cập nhật thông tin  key *****************
    function update_license1($id, $no_computers, $created_date, $iduser, $no_instace, $status, $expire_date) {
        $con = open_db();
        $sql = "update license set license_no_computers = '$no_computers',
    license_created_date = '$created_date',
    type_expire_date = '$expire_date',
    license_no_instance='$no_instance',
    id_user='$iduser',
    status='$status'
    where
    license_serial = '$id'";
        $result = mysqli_query($con, $sql);
        if (!$result) {
            echo "Cannot update key";
            return false;
        }
        mysqli_close($con);
        return true;
    }

//***************** Thông tin khách hàng kích hoạt *****************
    function get_license_detail_info($license_serial, $p) {
        $con = open_db();
        if ($p["viewallregistered"]) {
            $sql = "select registered.customer_name,registered.customer_cty, registered.customer_email, registered.customer_phone,
                registered.license_activation_date,registered.last_runing_date, registered.license_expire_date, product.icon,registered.id, registered.customer_address from registered, product where registered.product_type=product.product_type and registered.license_serial = '$license_serial'";
        }
        $result = mysqli_query($con, $sql);
        $count = 0;
        if ($p['deleteregistered']) {

            $delall = "<input type='checkbox' id='checkall' name='checkall' />";
        } else {
            $delall = "";
        }
        if ($result) {
            echo "<table id='listcheck' class='table_license' cellspacing='0' cellpadding='0' border='0' align='center'><tr><th>$delall</th><th width='150'>Tên khách hàng</th><th>Địa chỉ</th><th>Email</th><th>Tel</th><th width='100'>Ngày hết hạn</th><th width='50'></th><tr>";
            while ($row = mysqli_fetch_array($result)) {
                $st1 = $row['license_original'];
                $str1 = substr($st1, 0, 5);
                $str2 = substr($st1, 5, 5);
                $str3 = substr($st1, 10, 5);
                $str4 = substr($st1, 15, 5);
                $st = "$str1-" . "$str2-" . "$str3-" . "$str4";
                $expire_date = date("d-m-Y", strtotime($row['license_expire_date']));
                $active_date = date("d-m-Y", strtotime($row['license_activation_date']));
                $last_runing_date = date("d-m-Y", strtotime($row['last_runing_date']));
                if ($p['editregistered']) {
                    $edit = "<a title='Nhấp vào để sửa thông tin khách hàng' href ='../views/editlicensedetail.php?id=$row[id]'>$row[customer_name]</a>";
                } else {
                    $edit = $row[customer_name];
                }
                if ($p['deleteregistered']) {
                    $delallr = "<input name='chkid[]' id='chkid[]' type='checkbox' value='$row[id]'/>";
                    $del = "<a title='Xóa khách hàng' href ='../views/deletelicensedetail.php?id=$row[id]'><img src='../template/images/delete.png' width='15' height = '15'>";
                } else {
                    $del = "";
                }
                echo "<tr>";
                $tmp = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $delallr, $edit, $row['customer_address'], $row['customer_email'], $row['customer_phone'], $expire_date, "$del</a><a class='tooltip' href = '#'>
                <span><img class='callout' src='../template/img/callout_black.gif' /><strong>THÔNG TIN CHI TIẾT</strong><br /><b> Mã kích hoạt:</b>$st<br/> <b>Loại key:</b>$row[product_type]<br/> <b>Ngày kích hoạt:</b> $active_date<br/> <b>Ngày chạy cuối:</b> $last_runing_date<br/><b>Tỉnh thành:</b>$row[customer_cty] </span><img src='../template/images/detail.jpg' width='15' height = '15'></a>");
                echo $tmp;
                echo "</tr>";
            }
            if ($p['deleteregistered']) {
                echo "<tr>";

                echo '<td colspan="9" align="right" bgcolor="#FFFFFF"><input class="button" name="delete" type="submit" id="delete" value="Xoá"></td>';
                echo "</tr>";
                if ($_POST['delete'] == "Xóa") {
                    if ((isset($_POST['chkid'])) && ($_POST['chkid'] != "")) {
                        $t = $_POST['chkid'];
                        foreach ($t as $key => $value) {
                            $deleteSQL = "delete from registered where id ='" . $value . "'";
                            $Result = mysqli_query($deleteSQL, $con);
                        }
                        if ($Result) {
                            echo "<meta http-equiv = \"refresh\" content=\"0;URL=editlicense.php?id=$license_serial\">";
                        }
                    }
                }
            }
            echo "</table>";
        }
        mysqli_close($con);
    }
	
	function check_id($username, $password) {
    $con = open_db();
    $sql = "select * from user where username = '$username' and password='$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    if ($row['id']!='') {
        $fb = $row['id'];
    mysqli_close($con);

    return $fb;
}
else return 0;
}    